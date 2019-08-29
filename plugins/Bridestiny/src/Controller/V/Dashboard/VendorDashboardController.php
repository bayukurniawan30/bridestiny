<?php

namespace Bridestiny\Controller\V\Dashboard;

use Bridestiny\Controller\AppController;
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
use Bridestiny\Form\VendorProfileForm;
use Carbon\Carbon;
use Melbahja\Seo\Factory;
use EngageTheme\Functions\ThemeFunction;
use Bridestiny\Functions\GlobalFunctions;
use Bulletproof;
use Gregwar\Image\Image;
use \Gumlet\ImageResize;

class VendorDashboardController extends AppController
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
        $this->viewBuilder()->setLayout('EngageTheme.default');
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

        $this->loadModel('Bridestiny.BrideAuth');
        $this->loadModel('Bridestiny.BrideVendors');
        $this->loadModel('Bridestiny.BrideVendorAbout');
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
            'pageTitle'          => 'Dashboard',
            'breadcrumb'         => 'Home::Dashboard',
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
    public function index()
    {
        
    }
    public function profile()
    {
        $vendor = $this->BrideVendors->find('all')->contain('BrideAuth')->where(['BrideAuth.id' => $this->Auth->user('id'), 'BrideAuth.email' => $this->Auth->user('email')])->limit(1)->first();
        $about  = $this->BrideVendorAbout->find()->where(['vendor_id' => $vendor->id]);

        $vendorProfileForm = new VendorProfileForm();

        $provincesArray = NULL;

        if (Configure::check('RajaOngkir.apikey') && Configure::check('RajaOngkir.account')) {
            $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
            $rajaongkirAccType = Configure::read('RajaOngkir.account');

            if ($rajaongkirApiKey != NULL && $rajaongkirAccType != NULL) {
                $globalFunction      = new GlobalFunctions();
                $rajaongkirProvinces = $globalFunction->rajaongkirProvinces($rajaongkirApiKey, $rajaongkirAccType);
                $rajaongkirCities    = $globalFunction->rajaongkirCities($rajaongkirApiKey, $rajaongkirAccType, $vendor->province);

                $provincesArray = [];
                foreach ($rajaongkirProvinces as $province) {
                    $provincesArray[$province['province_id']] = $province['province'];
                }

                $citiesArray = [];
                foreach ($rajaongkirCities as $city) {
                    $citiesArray[$city['city_id']] = $city['city_name'];
                }
            }
            else {
                $provincesArray = NULL;
            }
        }

        $data = [
            'pageTitle'           => 'Dashboard - Profile',
            'breadcrumb'          => 'Home::Dashboard::Profile',
            'vendorProfileForm'   => $vendorProfileForm,
            'ipAddress'           => $this->request->clientIp(),
            'rajaongkirProvinces' => $provincesArray,
            'rajaongkirCities'    => $citiesArray
        ];

        if ($about->count() > 0) {
            $vendorAbout = $about->first();
            $data['vendorAbout'] = $vendorAbout->content;
        }
        else {
            $data['vendorAbout'] = NULL;
        }

        $this->set($data);
    }
    public function packages()
    {
        
    }
    public function projects()
    {
        
    }
    public function faqs()
    {
        
    }
    public function orders()
    {
        
    }
    public function wallet()
    {
        
    }
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    public function ajaxUpdateProfile()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $vendorProfileForm = new VendorProfileForm();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            if ($vendorProfileForm->execute($this->request->getData())) {
                $findEmail  = $this->BrideAuth->find()->where(['email' => trim($this->request->getData('email')), 'id <>' => $this->Auth->user('id')]);
                $findUserId = $this->BrideVendors->find()->where(['user_id' => trim($this->request->getData('user_id')), 'id <>' => $this->request->getData('id')]);
                if ($findEmail->count() > 0 ) {
                    $json = json_encode(['status' => 'error', 'error' => "Email is already used. Please use another email."]);
                }
                elseif ($findUserId->count() > 0 ) {
                    $json = json_encode(['status' => 'error', 'error' => "Vendor ID is already used. Please use another."]);
                }
                else {
                    $vendor = $this->BrideVendors->get($this->request->getData('id'));
                    $vendor = $this->BrideVendors->patchEntity($vendor, $this->request->getData());

                    if ($this->Auth->user('email') != $this->request->getData('email')) {
                        $auth = $this->BrideAuth->get($this->Auth->user('id'));
                        $auth->email = $this->request->getData('email');
                        $this->BrideAuth->save($auth);
                    }

                    if ($this->BrideVendors->save($vendor)) {
                        $findAbout = $this->BrideVendorAbout->find()->where(['vendor_id' => $this->request->getData('id')]);
                        if ($findAbout->count() > 0 ) {
                            $about = $this->BrideVendorAbout->get($findAbout->first()->id);
                        }
                        else {
                            $about = $this->BrideVendorAbout->newEntity();
                        }
                        $about = $this->BrideVendorAbout->patchEntity($about, $this->request->getData());
                        $about->content   = $this->request->getData('bride_vendor_about.content');
                        $about->vendor_id = $this->request->getData('id');
                        $this->BrideVendorAbout->save($about);

                        /**
                         * Save data to Notifications Table
                         */
                        $vendor = $this->BrideVendors->find('all')->contain('BrideAuth')->where(['BrideVendors.id' => $this->request->getData('id')])->first();

                        $notification = $this->BrideNotifications->newEntity();
                        $notification->type        = 'Vendors.profile';
                        $notification->content     = $vendor->name.' has updated it\'s profile. Click to view the vendor.';
                        $notification->relation_id = $vendor->id;

                        // Send Email to User to Notify author

                        if ($this->BrideNotifications->save($notification)) {
                            $notification = true;
                        }
                        else {
                            $notification = false;
                        }

                        $json = json_encode(['status' => 'ok', 'notification' => $notification]);
                    }
                    else {
                        $json = json_encode(['status' => 'error', 'error' => "Can't save data. Please try again."]);
                    }
                }
            }
            else {
                $errors = $vendorProfileForm->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors, 'error_type' => 'form']);
            }
            $this->set(['json' => $json]);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
}