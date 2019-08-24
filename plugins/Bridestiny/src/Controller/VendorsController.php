<?php

namespace Bridestiny\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;
use Cake\Filesystem\File;
use App\Purple\PurpleProjectGlobal;
use App\Purple\PurpleProjectSeo;
use App\Purple\PurpleProjectSettings;
use App\Purple\PurpleProjectApi;
use Bridestiny\Api\BridestinyApi;
use App\Form\SearchForm;
use Bridestiny\Form\VendorSignInForm;
use Bridestiny\Form\VendorSignUpForm;
use Bridestiny\Form\VendorCodeVerificationForm;
use Carbon\Carbon;
use Melbahja\Seo\Factory;
use EngageTheme\Functions\ThemeFunction;
use Bridestiny\Functions\GlobalFunctions;
use Bulletproof;
use Gregwar\Image\Image;
use \Gumlet\ImageResize;

class VendorsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $purpleGlobal = new PurpleProjectGlobal();
        $databaseInfo   = $purpleGlobal->databaseInfo();
        if ($databaseInfo == 'default') {
            return $this->redirect(
                ['prefix' => false, 'controller' => 'Setup', 'action' => 'index']
            );
        }
        else {
            $purpleSettings = new PurpleProjectSettings();
            $maintenance    = $purpleSettings->maintenanceMode();
            $userLoggedIn   = $purpleSettings->checkUserLoggedIn();

            if ($maintenance == 'enable' && $userLoggedIn == false) {
                return $this->redirect(
                    ['controller' => 'Maintenance', 'action' => 'index']
                );
            }
        }
    }
    public function beforeRender(\Cake\Event\Event $event)
    {
        $this->viewBuilder()->setTheme('EngageTheme');
        $credintialAction = ['signUp', 'signIn', 'verification', 'pendingAccount'];
        if (!in_array($this->request->getParam('action'), $credintialAction)) {
            $this->viewBuilder()->setLayout('EngageTheme.default');
        }
    }
    public function initialize()
    {
        parent::initialize();

        Configure::load('Bridestiny.purple');

        $this->loadModel('Settings');
        $this->loadModel('Admins');
        $this->loadModel('Menus');
        $this->loadModel('Visitors');
        $this->loadModel('Socials');

        $this->loadModel('Bridestiny.BrideVendors');
        $this->loadModel('Bridestiny.BrideVendorMedias');
        $this->loadModel('Bridestiny.BrideNotifications');
        $this->loadModel('Bridestiny.BrideSettings');

        $purpleSettings = new PurpleProjectSettings();
        $timezone       = $purpleSettings->timezone();
        $visitorDate    = Carbon::now($timezone);

        // Check visitor
        $purpleGlobal = new PurpleProjectGlobal();
        $browser      = $purpleGlobal->detectBrowser();
        $platform     = $purpleGlobal->detectOS();
        $device       = $purpleGlobal->detectDevice();
        $ip           = $this->request->clientIp();
        $checkVisitor = $this->Visitors->checkVisitor($ip, $visitorDate, $browser, $platform, $device);

        if ($checkVisitor == 0) {
        $visitor = $this->Visitors->newEntity();
            $visitor->ip       = $ip;
            $visitor->browser  = $browser;
            $visitor->platform = $platform;
            $visitor->device   = $device;

            $this->Visitors->save($visitor);
        }

        $isVisitorsEnough = $this->Visitors->isVisitorsEnough();

        if ($isVisitorsEnough) {
            $totalAllVisitors = $this->Visitors->totalAllVisitors();

            // Send Email to User to Notify user
            $users     = $this->Admins->find()->where(['username <> ' => 'creatifycore'])->order(['id' => 'ASC']);
            $totalUser = $users->count();

            $emailStatus = [];
            $counter = 0;
            foreach ($users as $user) {
                $key           = $this->Settings->settingsPublicApiKey();
                $userData      = array(
                    'sitename'    => $this->Settings->settingsSiteName(),
                    'email'       => $user->email,
                    'displayName' => $user->display_name,
                    'level'       => $user->level
                );
                $senderData   = array(
                    'total'   => $totalAllVisitors,
                    'domain'  => $this->request->domain()
                );
                $notifyUser = $purpleApi->sendEmailCertainVisitors($key, json_encode($userData), json_encode($senderData));

                if ($notifyUser == true) {
                    $counter++;
                    $emailStatus[$user->email] = true; 
                }
                else {
                    $emailStatus[$user->email] = false; 
                }
            }

            if ($totalUser == $counter) {
                $emailNotification = true;
            }
            else {
                $emailNotification = false;
            }

	        // Log::write('debug', $emailNotification);
        }

        $search = new SearchForm();

        if ($this->request->getEnv('HTTP_HOST') == 'localhost') {
            $cakeDebug    = 'on';
            $formSecurity = 'off';
        } 
        else {
            if (Configure::read('debug')) {
                $cakeDebug = 'on';
            }
            else {
                $cakeDebug = 'off';
            }
            $formSecurity  = 'on';
        }

        /**
         * Load Theme Global Function
         */

        $themeFunction = new ThemeFunction($this->request->getAttribute('webroot')); 
        $this->set('themeFunction', $themeFunction);

        $socials = $this->Socials->find('all')->order(['ordering' => 'ASC']);
        $this->set(compact('socials'));

        // Generate Schema.org ld+json
        $purpleSeo     = new PurpleProjectSeo();
        $websiteSchema = $purpleSeo->schemaLdJson('website');
        $orgSchema     = $purpleSeo->schemaLdJson('organization');

        $data = [
            'pageTitle'          => 'Vendor',
            'childPage'          => false,
            'siteName'           => $this->Settings->settingsSiteName(),
            'tagLine'            => $this->Settings->settingsTagLine(),
            'metaKeywords'       => $this->Settings->settingsMetaKeywords(),
            'metaDescription'    => $this->Settings->settingsMetaDescription(),
            'googleAnalytics'    => $this->Settings->settingsAnalyticscode(),
            'metaOgType'         => 'website',
            'metaImage'          => '',
            'favicon'            => $this->Settings->settingsFavicon(),
            'logo'               => $this->Settings->settingsLogo(),
            'menus'              => $this->Menus->fetchPublishedMenus(),
            'homepage'           => html_entity_decode($this->Settings->settingsHomepage()),
            'leftFooter'         => $this->Settings->settingsLeftFooter(),
            'rightFooter'        => $this->Settings->settingsRightFooter(),
            'dateFormat'         => $this->Settings->settingsDateFormat(),
            'timeFormat'         => $this->Settings->settingsTimeFormat(),
            'postsLimit'         => $this->Settings->settingsPostLimitPerPage(),
            'cakeDebug'          => $cakeDebug,
            'formSecurity'       => $formSecurity,
            'recaptchaSitekey'   => $this->Settings->settingsRecaptchaSitekey(),
            'recaptchaSecret'    => $this->Settings->settingsRecaptchaSecret(),
            'sidebarSearch'      => $search,
            'ldJsonWebsite'      => $websiteSchema,
            'ldJsonOrganization' => $orgSchema
        ];
        $this->set($data);
    }
    public function uploadImages($file, $id = 1)
	{
        if (!empty($file)) {
            $purpleSettings = new PurpleProjectSettings();
            $timezone       = $purpleSettings->timezone();
            $date           = Carbon::now($timezone);

            $uploadPath = TMP . 'uploads' . DS . 'images' . DS;
            $fileName   = $file['name'];

            $image = new Bulletproof\Image($file);
            $newName         = Text::slug($fileName, ['preserve' => '.']);
            $explodeNewName  = explode(".", $newName);
            $fileExtension   = end($explodeNewName);
            $fileOnlyName    = str_replace('.'.$fileExtension, '', $newName);
            $dateSlug        = Text::slug($date);
            $generatedName   = $fileOnlyName . '_' . $dateSlug . '.' . $fileExtension;

            $image->setName($generatedName)
                    ->setMime(array('jpeg', 'jpg', 'png'))
                    ->setSize(100, 3145728)
                    ->setLocation($uploadPath);
            if ($image->upload()) {
                $fullSizeImage              = WWW_ROOT . 'uploads' . DS .'images' . DS .'original' . DS;
                $uploadedThumbnailSquare    = WWW_ROOT . 'uploads' . DS .'images' . DS .'thumbnails' . DS . '300x300' . DS;
                $uploadedThumbnailLandscape = WWW_ROOT . 'uploads' . DS .'images' . DS .'thumbnails' . DS . '480x270' . DS;
                if (file_exists($image->getFullPath())) {
                    $readImageFile   = new File($image->getFullPath());
                    $imageSize       = $readImageFile->size();
                    
                    $fullSize = Image::open($image->getFullPath())->save($fullSizeImage . $generatedName, 'guess', 90);
                    
                    $thumbnailSquare = Image::open($image->getFullPath())
                                        ->zoomCrop(300, 300)
                                        ->save($uploadedThumbnailSquare . $generatedName, 'guess', 90);
                   
                    $thumbnailLandscape = Image::open($image->getFullPath())
                                        ->zoomCrop(480, 270)
                                        ->save($uploadedThumbnailLandscape . $generatedName, 'guess', 90);

                    $media = $this->BrideVendorMedias->newEntity();

                    $media->name      = $generatedName;
                    $media->type      = 'image';
                    $media->title     = $fileOnlyName;
                    $media->size      = $imageSize;
                    $media->vendor_id = $id;

                    if ($this->BrideVendorMedias->save($media)) {
                        $readImageFile   = new File($image->getFullPath());
                        $deleteImage     = $readImageFile->delete();

                        return $generatedName;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
	}
    public function signUp()
    {
        $this->viewBuilder()->setLayout('EngageTheme.credintial');

        $vendorSignUp = new VendorSignUpForm();

        $provincesArray = NULL;

        if (Configure::check('RajaOngkir.apikey') && Configure::check('RajaOngkir.account')) {
            $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
            $rajaongkirAccType = Configure::read('RajaOngkir.account');

            if ($rajaongkirApiKey != NULL && $rajaongkirAccType != NULL) {
                $globalFunction      = new GlobalFunctions();
                $rajaongkirProvinces = $globalFunction->rajaongkirProvinces($rajaongkirApiKey, $rajaongkirAccType);
    
                $provincesArray = [];
                foreach ($rajaongkirProvinces as $province) {
                    $provincesArray[$province['province_id']] = $province['province'];
                }
            }
            else {
                $provincesArray = NULL;
            }
        }

        $data = [
            'breadcrumb'          => 'Home::Vendor::Sign Up',
            'vendorSignUp'        => $vendorSignUp,
            'ipAddress'           => $this->request->clientIp(),
            'rajaongkirProvinces' => $provincesArray,
        ];

        $this->set($data);

        if ($this->request->is('ajax') || $this->request->is('post')) {

        }
    }
    public function verification()
    {
        $this->viewBuilder()->setLayout('EngageTheme.credintial');

        $vendorCodeVerification = new VendorCodeVerificationForm();

        $session         = $this->getRequest()->getSession();
        $sessionCode     = $session->read('Bridestiny.verificationcode');
        $sessionVendorId = $session->read('Bridestiny.vendorId');

        $data = [
            'breadcrumb'             => 'Home::Vendor::Verification',
            'vendorCodeVerification' => $vendorCodeVerification,
            'sessionCode'            => $sessionCode,
            'sessionVendorId'        => $sessionVendorId
        ];

        $this->set($data);
    }
    public function pendingAccount()
    {
        $this->viewBuilder()->setLayout('EngageTheme.credintial');

        $data = [
            'breadcrumb' => 'Home::Vendor::Pending Account',
        ];

        $this->set($data);
    }
    public function signOut()
    {
        $session = $this->getRequest()->getSession();
        if ($this->request->getEnv('HTTP_HOST') == $session->read('Bridestiny.host')) {
            $session->delete('Bridestiny.host');
            $session->delete('Bridestiny.vendorId');
            $session->delete('Bridestiny.vendorPassword');

            return $this->redirect(
                ['controller' => 'Pages', 'action' => 'home', 'plugin' => false]
            );
        }
    }
    public function ajaxSignUp()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $vendorSignUp = new VendorSignUpForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($vendorSignUp->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();

                $userId = Text::slug(strtolower(trim($this->request->getData('name'))));
                $find   = $this->BrideVendors->find()->where(['email' => trim($this->request->getData('email'))]);
                if ($find->count() > 0) {
                    $json = json_encode(['status' => 'error', 'error' => "Email is already used. Please use another email."]);
                }
                else {
                    $findUserId = $this->BrideVendors->find()->where(['user_id' => $userId]);
                    $purpleApi = new PurpleProjectApi();
                    $verifyEmail = $purpleApi->verifyEmail($this->request->getData('email'));

                    if ($verifyEmail == true) {

                        // Generate 6 digits code
                        $code = rand(100000, 999999);

                        $vendor = $this->BrideVendors->newEntity();
                        $vendor = $this->BrideVendors->patchEntity($vendor, $this->request->getData());
                        $vendor->ktp  = 'uploading';
                        $vendor->npwp = 'uploading'; 
                        if ($findUserId->count() > 0) {
                            $randomUserId = rand(100, 999);
                            $sluggedTitle = Text::slug(strtolower($this->request->getData('name').'-'.$randomUserId));
                            $vendor->user_id = $sluggedTitle; 
                        }
                        else {
                            $sluggedTitle = Text::slug(strtolower($this->request->getData('name')));
                            $vendor->user_id = $sluggedTitle;
                        }

                        if ($this->request->getData('country') != 'Indonesia') {
                            $vendor->province = 'none';
                            $vendor->city     = 'none';
                        }
                        $vendor->status = '0';

                        if ($this->BrideVendors->save($vendor)) {
                            $recordId = $vendor->id;

                            $vendor = $this->BrideVendors->get($recordId);
                            $uploadKtp  = $this->uploadImages($this->request->getData('ktp'), $recordId);
                            $uploadNpwp = $this->uploadImages($this->request->getData('npwp'), $recordId);

                            if ($uploadKtp != false && $uploadNpwp != false) {
                                $vendor->ktp  = $uploadKtp;
                                $vendor->npwp = $uploadNpwp;

                                $this->BrideVendors->save($vendor);
                            }

                            $session->write('Bridestiny.verificationcode', $code);
                            $session->write('Bridestiny.vendorId', $recordId);

                            // Send Email to User to Notify user
                            $hasher = new DefaultPasswordHasher();
                            $key    = $hasher->hash('public-purple is awesome');
                            $userData      = array(
                                'sitename'    => $this->Settings->settingsSiteName(),
                                'email'       => $vendor->email,
                                'code'        => $code
                            );

                            $purpleGlobal = new PurpleProjectGlobal();
                            $protocol     = $purpleGlobal->protocol();
                            
                            if ($this->Settings->settingsLogo() == '') {
                                $siteLogo = $protocol.$this->request->getEnv('HTTP_HOST').$this->request->getAttribute('webroot').'master-assets/img/logo.svg';
                            }
                            else {
                                $siteLogo = $protocol.$this->request->getEnv('HTTP_HOST').$this->request->getAttribute('webroot').'uploads/images/original/'.$this->Settings->settingsLogo();
                            }

                            $siteData = array(
                                'siteLogo'    => $siteLogo,
                                'siteName'    => $this->Settings->settingsSiteName(),
                                'siteTagline' => $this->Settings->settingsTagLine(),
                                'siteEmail'   => $this->Settings->settingsEmail(),
                                'siteAddress' => $this->Settings->settingsPhone(),
                                'sitePhone'   => $this->Settings->settingsAddress(),
                            );
                            $senderData   = array(
                                'domain' => $this->request->domain()
                            );
                            $bridestinyApi = new BridestinyApi();
                            $notifyUser    = $bridestinyApi->sendEmailVendorVerification($key, json_encode($userData), json_encode($siteData), json_encode($senderData));

                            if ($notifyUser == true) {
                                $emailNotification = true;
                            }
                            else {
                                $emailNotification = false;
                            }

                            $json = json_encode(['status' => 'ok', 'notification' => false, 'email' => $emailNotification]);
                        }
                        else {
                            $json = json_encode(['status' => 'error', 'error' => "Can't save data. Please try again."]);
                        }
                    }
                    else {
                        $json = json_encode(['status' => 'error', 'error' => "Email is not valid. Please use a real email."]);
                    }
                }
            }
			else {
				$errors = $vendorSignUp->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
			}

			$this->set(['json' => $json]);
		}
    	else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
    public function ajaxVerification()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $vendorCodeVerification = new VendorCodeVerificationForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
            if ($vendorCodeVerification->execute($this->request->getData())) {
                $code = trim($this->request->getData('code'));
                $session         = $this->getRequest()->getSession();
                $sessionCode     = $session->read('Bridestiny.verificationcode');
                $sessionVendorId = $session->read('Bridestiny.vendorId');

                if ($code == $sessionCode) {
                    $vendor = $this->BrideVendors->get($sessionVendorId);
					$vendor->status = '1';
					if ($this->BrideVendors->save($vendor)) {
                        /**
                         * Save data to Notifications Table
                         */
                        $notification = $this->BrideNotifications->newEntity();
                        $notification->type        = 'Vendors.new';
                        $notification->content     = $vendor->name.' has registered to become a new vendor. Click to review the vendor.';
                        $notification->relation_id = $sessionVendorId;

                        // Send Email to User to Notify author
                        $admins = $this->Admins->find();
                        $key    = $this->Settings->settingsPublicApiKey();
                        $dashboardLink = $this->request->getData('ds');
                        
                        $vendorData    = array(
                            'name'   => $vendor->name,
                            'email'  => $vendor->email,
                            'phone'  => $vendor->mobile_phone,
                            'domain' => $this->request->domain()
                        );

                        $bridestinyApi = new BridestinyApi();

                        $emailNotification = [];
                        foreach ($admins as $admin) {
                            if ($admin->username != 'creatifycore') {
                                $userData      = array(
                                    'sitename'    => $this->Settings->settingsSiteName(),
                                    'email'       => $admin->email,
                                    'displayName' => $admin->display_name,
                                    'level'       => $admin->level
                                );

                                $notifyUser = $bridestinyApi->sendEmailNewVendorToAdmin($key, $dashboardLink, json_encode($userData), json_encode($vendorData));

                                if ($notifyUser == true) {
                                    $emailNotification[$admin->email] = true;
                                }
                                else {
                                    $emailNotification[$admin->email] = false;
                                }
                            }
                        }

                        if ($this->BrideNotifications->save($notification)) {
                            $notification = true;
                        }
                        else {
                            $notification = false;
                        }
                        
                        $json = json_encode(['status' => 'ok', 'notification' => $notification, 'email' => $emailNotification]);
                    }
                    else {
                        $json = json_encode(['status' => 'error', 'error' => "Can't process your account. Please try again."]);
                    }
                }
                else {
                    $json = json_encode(['status' => 'error', 'error' => 'Wrong verification code.']);
                }
            }
            else {
                $errors = $vendorCodeVerification->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors, 'error_type' => 'form']);
            }
            $this->set(['json' => $json]);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
}