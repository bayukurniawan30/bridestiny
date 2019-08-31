<?php

namespace Bridestiny\Controller\Api;

use Bridestiny\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\ServerRequest;
use Cake\Utility\Text;
use Cake\Filesystem\File;
use App\Purple\PurpleProjectGlobal;
use App\Purple\PurpleProjectSeo;
use App\Purple\PurpleProjectSettings;
use App\Purple\PurpleProjectApi;
use Bridestiny\Api\BridestinyApi;
use Bridestiny\Validator\Api\VendorSignInValidator;
use Bridestiny\Validator\Api\VendorSignUpValidator;
use Bridestiny\Validator\Api\VendorVerifyValidator;
use Carbon\Carbon;
use EngageTheme\Functions\ThemeFunction;
use Bridestiny\Functions\GlobalFunctions;
use Bulletproof;
use Gregwar\Image\Image;
use \Gumlet\ImageResize;

class VendorsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $purpleGlobal = new PurpleProjectGlobal();
        $databaseInfo   = $purpleGlobal->databaseInfo();
        if ($databaseInfo == 'default') {
            throw new NotFoundException(__('Page not found'));
        }
        else {
            $purpleSettings = new PurpleProjectSettings();
            $maintenance    = $purpleSettings->maintenanceMode();
            $userLoggedIn   = $purpleSettings->checkUserLoggedIn();

            if ($maintenance == 'enable' && $userLoggedIn == false) {
                throw new NotFoundException(__('Page not found'));
            }
        }
    }
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Basic' => [
                    'fields'    => ['username' => 'email', 'password' => 'api_key'],
                    'finder'    => 'auth',
                    'userModel' => 'Bridestiny.BrideAuth',
                ],
            ],
            'authorize'            => 'Controller',
            'authError'            => 'Unauthorized access',
            'storage'              => 'Memory',
            'unauthorizedRedirect' => false
        ]);

        // Allow GET method
        $this->Auth->allow(['view', 'viewByCategory', 'detail', 'signUp', 'verify', 'signIn']);

        $this->loadModel('Admins');
        $this->loadModel('Settings');

        $this->loadModel('Bridestiny.BrideAuth');
        $this->loadModel('Bridestiny.BrideVendors');
        $this->loadModel('Bridestiny.BrideVendorAbout');
        $this->loadModel('Bridestiny.BrideVendorMedias');
        $this->loadModel('Bridestiny.BrideNotifications');
        $this->loadModel('Bridestiny.BrideSettings');

        $this->viewBuilder()->enableAutoLayout(false);

        $purpleGlobal = new PurpleProjectGlobal();
        $protocol     = $purpleGlobal->protocol();
        
        $globalFunction = new GlobalFunctions();
		$routePrefix    = $globalFunction->routePrefix();

        $data = [
            'baseUrl'     => $protocol . $this->request->host() . $this->request->getAttribute("webroot"),
            'routePrefix' => $routePrefix
        ];

        $this->set($data);

        // Timezone
        $productionKeyInfo = $purpleGlobal->productionKeyInfo();
        if ($productionKeyInfo == 'filled') {
            $session  = $this->getRequest()->getSession();

            $this->loadModel('Settings');
            $this->set('timeZone', $this->Settings->settingsTimeZone());
            if (!$session->check('Purple.timezone')) {
                $session->write('Purple.timezone', $this->Settings->settingsTimeZone());
            }

            if (!$session->check('Purple.settingTimezone')) {
                $session->write('Purple.settingTimezone', $this->Settings->settingsTimeZone());
            }
        }
    }
    public function isAuthorized($user)
    {
        // Only admins can access admin functions
        if (isset($user['level']) && $user['level'] == '1') {
            return true;
        }

        // Default deny
        return false;
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
    public function view() 
    {
        if ($this->request->is('get') && $this->request->hasHeader('X-Purple-Api-Key')) {
            // Check if paging and limit query string is exist
            $paging = $this->request->getQuery('paging');
            $limit  = $this->request->getQuery('limit');
            if ($paging !== NULL && $limit !== NULL) {
                $this->loadComponent('Paginator');
            }

            $apiKey = trim($this->request->getHeaderLine('X-Purple-Api-Key'));

            $apiAccessKey = $this->Settings->settingsApiAccessKey();

            $error = NULL;

            if ($apiAccessKey == $apiKey) {
                // Query string for additional condition
                $orderBy = $this->request->getQuery('order_by');
                $order   = $this->request->getQuery('order');
                if ($order !== NULL && $orderBy !== NULL) {
                    /**
                     * Order By : name
                     * Order : ASC, DESC
                     */
                    $availableOrderBy = ['name'];
                    $availableOrder   = ['asc', 'desc'];
                    
                    if (in_array($orderBy, $availableOrderBy) && in_array($order, $availableOrder)) {
                        $orderQuery = ['BrideVendors.' . $orderBy => strtoupper($order)];
                    }
                    else {
                        $orderQuery = ['BrideVendors.name' => 'ASC'];
                        $error      = "Invalid query string. Please read the documentation for available query string.";
                    }
                }
                else {
                    $orderQuery = ['BrideVendors.name' => 'ASC'];
                }

                $vendors = $this->BrideVendors->find('all', [
                    'order' => $orderQuery
                    ])
                    ->contain('BrideAuth', function (Query $q) {
                        return $q
                            ->select(['id', 'email', 'user_type', 'status']);  
                    })
                    ->contain('BrideVendorAbout', function (Query $q) {
                        return $q
                            ->select(['id', 'content', 'status', 'vendor_id']);  
                    })
                    ->where([
                        'BrideAuth.status'    => 1,
                        'BrideAuth.user_type' => 'vendor'
                    ]);

                if ($vendors->count() > 0) {
                    // Update of Modif entity
                    foreach ($vendors as $vendor) {
                        $vendor->phone         = $vendor->mobile_phone;
                        $vendor->province_name = $vendor->province_name;
                        $vendor->city_name     = $vendor->city_name;
                    }

                    $return = [
                        'status' => 'ok',
                        'total'  => $vendors->count(),
                        'error'  => $error
                    ];

                    if ($paging !== NULL && $limit !== NULL && filter_var($paging, FILTER_VALIDATE_INT) && filter_var($limit, FILTER_VALIDATE_INT)) {
                        $this->paginate = [
                            'limit' => $limit,
                            'page'  => $paging
                        ];
                        $vendorsList = $this->paginate($vendors);
                        $return['vendors'] = $vendorsList;
                        $return['page']   = $paging;
                        $return['limit']  = $limit;
                    }
                    else {
                        $return['vendors'] = $vendors;
                    }
                }
                else {
                    $return = [
                        'status'  => 'ok',
                        'total'   => 0,
                        'vendors' => NULL,
                        'error'   => $error
                    ];
                }
            }
            else {
                $return = [
                    'status' => 'error',
                    'error'  => 'Invalid access key'
                ];
            }

            $json = json_encode($return, JSON_PRETTY_PRINT);

            $this->response = $this->response->withType('json');
            $this->response = $this->response->withStringBody($json);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
        else {
	        throw new NotFoundException(__('Page not found'));
        }
    }
    public function viewByCategory()
    {

    }
    public function detail($slug)
    {
        if ($this->request->is('get') && $this->request->hasHeader('X-Purple-Api-Key')) {
            $apiKey = trim($this->request->getHeaderLine('X-Purple-Api-Key'));
            $slug   = trim($slug);

            $apiAccessKey = $this->Settings->settingsApiAccessKey();

            $error = NULL;

            if ($apiAccessKey == $apiKey) {
                $vendors = $this->BrideVendors->find('all', [
                    'order' => ['BrideVendors.name' => 'asc']
                    ])
                    ->contain('BrideAuth', function (Query $q) {
                        return $q
                            ->select(['id', 'email', 'user_type', 'status']);  
                    })
                    ->contain('BrideVendorAbout', function (Query $q) {
                        return $q
                            ->select(['id', 'content', 'status', 'vendor_id']);  
                    })
                    ->where([
                        'BrideAuth.status'    => 1,
                        'BrideAuth.user_type' => 'vendor',
                        'BrideVendors.user_id' => $slug
                    ]);

                if ($vendors->count() > 0) {
                    $vendorDetail = $vendors->first();

                    $return = [
                        'status' => 'ok',
                        'vendor' => $vendorDetail,
                        'error'  => $error
                    ];
                }
                else {
                    $return = [
                        'status' => 'ok',
                        'vendor' => NULL,
                        'error'  => 'Vendor not found'
                    ];
                }
            }
            else {
                $return = [
                    'status' => 'error',
                    'error'  => 'Invalid access key'
                ];
            }

            $json = json_encode($return, JSON_PRETTY_PRINT);

            $this->response = $this->response->withType('json');
            $this->response = $this->response->withStringBody($json);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
        else {
	        throw new NotFoundException(__('Page not found'));
        }
    }
    public function signUp()
    {
        if ($this->request->is('post') && $this->request->hasHeader('X-Purple-Api-Key')) {
            $apiKey = trim($this->request->getHeaderLine('X-Purple-Api-Key'));

            $apiAccessKey = $this->Settings->settingsApiAccessKey();

            $error = NULL;

            if ($apiAccessKey == $apiKey) {
                $validator = new VendorSignUpValidator();
                $errorValidate = $validator->validate()->errors($this->request->getData());
                if (empty($errorValidate)) {
                    if ($this->request->getData('termconditions')) {
                        if ($this->request->getData('password') != $this->request->getData('repeatpassword')) {
                            $return = [
                                'status' => 'error',
                                'error'  => "Password and repeat password is not match"
                            ];
                        }
                        else {
                            $userId = Text::slug(strtolower(trim($this->request->getData('name'))));
                            $find   = $this->BrideAuth->find()->where(['email' => trim($this->request->getData('email'))]);
                            if ($find->count() > 0) {
                                $return = [
                                    'status' => 'error',
                                    'error'  => 'Email is already used. Please use another email'
                                ];
                            }
                            else {
                                $findUserId = $this->BrideVendors->find()->where(['user_id' => $userId]);
                                $purpleApi = new PurpleProjectApi();
                                $verifyEmail = $purpleApi->verifyEmail($this->request->getData('email'));
        
                                if ($verifyEmail == true) {
        
                                    // Generate 6 digits code
                                    $code = rand(100000, 999999);
        
                                    $auth = $this->BrideAuth->newEntity();
                                    $auth = $this->BrideAuth->patchEntity($auth, $this->request->getData());
                                    $auth->user_type   = 'vendor';
                                    $auth->status      = 0;
                                    $auth->verify_code = $code;
                                    
                                    if ($this->BrideAuth->save($auth)) {
                                        $recordId = $auth->id;
                                        $vendor   = $this->BrideVendors->newEntity();
                                        $vendor   = $this->BrideVendors->patchEntity($vendor, $this->request->getData());
                                        $vendor->auth_id = $recordId;
                                        $vendor->ktp     = 'uploading';
                                        $vendor->npwp    = 'uploading'; 
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
        
                                            // Send Email to User to Notify user
                                            $hasher = new DefaultPasswordHasher();
                                            $key    = $hasher->hash('public-purple is awesome');
                                            $userData      = array(
                                                'sitename'    => $this->Settings->settingsSiteName(),
                                                'email'       => $auth->email,
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
                                                'domain' => $this->request->host()
                                            );
                                            $bridestinyApi = new BridestinyApi();
                                            $notifyUser    = $bridestinyApi->sendEmailVendorVerification($key, json_encode($userData), json_encode($siteData), json_encode($senderData));
        
                                            if ($notifyUser == true) {
                                                $emailNotification = true;
                                            }
                                            else {
                                                $emailNotification = false;
                                            }

                                            $return = [
                                                'status'         => 'ok',
                                                'auth_id'        => $auth->id,
                                                'vendor_id'      => $vendor->id,
                                                'code'           => $code,
                                                'dashboard_link' => NULL,
                                                'error'          => $error
                                            ];
                                        }
                                        else {
                                            $return = [
                                                'status' => 'error',
                                                'error'  => "Can't save data"
                                            ];
                                        }
                                    }
                                    else {
                                        $return = [
                                            'status' => 'error',
                                            'error'  => "Can't save data"
                                        ];
                                    }
                                }
                                else {
                                    $return = [
                                        'status' => 'error',
                                        'error'  => "Email is not valid"
                                    ];
                                }
                            }
                        }
                    }
                    else {
                        $return = [
                            'status' => 'error',
                            'error'  => "Please read and check our term and conditions"
                        ];
                    }
                }
                else {
                    $return = [
                        'status' => 'error',
                        'error'  => $errorValidate
                    ];
                }
            }
            else {
                $return = [
                    'status' => 'error',
                    'error'  => 'Invalid access key'
                ];
            }

            if (Configure::read('debug')) {
                $return['data'] = $this->request->getData();
            }

            $json = json_encode($return, JSON_PRETTY_PRINT);

            $this->response = $this->response->withType('json');
            $this->response = $this->response->withStringBody($json);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function verify()
    {
        if ($this->request->is('post') && $this->request->hasHeader('X-Purple-Api-Key')) {
            $apiKey = trim($this->request->getHeaderLine('X-Purple-Api-Key'));

            $apiAccessKey = $this->Settings->settingsApiAccessKey();

            $error = NULL;

            if ($apiAccessKey == $apiKey) {
                $code = trim($this->request->getData('code'));
                $auth = $this->BrideAuth->get($this->request->getData('id'));

                if ($auth->verify_code == $code) {
                    $auth->status = 3;
					if ($this->BrideAuth->save($auth)) {
                        /**
                         * Save data to Notifications Table
                         */
                        $vendor = $this->BrideVendors->find('all')->contain('BrideAuth')->where(['BrideVendors.auth_id' => $auth->id])->first();

                        $notification = $this->BrideNotifications->newEntity();
                        $notification->type        = 'Vendors.new';
                        $notification->content     = $vendor->name.' has registered to become a new vendor. Click to review the vendor.';
                        $notification->relation_id = $vendor->id;

                        // Send Email to User to Notify author
                        $admins = $this->Admins->find();
                        $key    = $this->Settings->settingsPublicApiKey();
                        $dashboardLink = $this->request->getData('dashboard_link');
                        
                        $vendorData    = array(
                            'name'   => $vendor->name,
                            'email'  => $vendor->bride_auth->email,
                            'phone'  => $vendor->mobile_phone,
                            'domain' => $this->request->host()
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

                        $return = [
                            'status' => 'ok',
                            'email'  => $auth->email
                        ];
                    }
                    else {
                        $return = [
                            'status' => 'error',
                            'error'  => "Can't verify your email"
                        ];
                    }
                }
                else {
                    $return = [
                        'status' => 'error',
                        'error'  => 'Invalid verification code'
                    ];    
                }
            }
            else {
                $return = [
                    'status' => 'error',
                    'error'  => 'Invalid access key'
                ];
            }

            if (Configure::read('debug')) {
                $return['data'] = $this->request->getData();
            }

            $json = json_encode($return, JSON_PRETTY_PRINT);

            $this->response = $this->response->withType('json');
            $this->response = $this->response->withStringBody($json);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function signIn()
    {
        if ($this->request->is('post') && $this->request->hasHeader('X-Purple-Api-Key')) {
            $apiKey = trim($this->request->getHeaderLine('X-Purple-Api-Key'));

            $apiAccessKey = $this->Settings->settingsApiAccessKey();

            $error = NULL;

            if ($apiAccessKey == $apiKey) {
                $validator     = new VendorSignInValidator();
                $errorValidate = $validator->validate()->errors($this->request->getData());
                if (empty($errorValidate)) {
                    $vendors = $this->BrideVendors->find('all')->contain('BrideAuth')->where(['BrideAuth.email' => trim($this->request->getData('email')), 'BrideAuth.user_type' => 'vendor', 'BrideAuth.status' => 1])->limit(1);
                
                    if ($vendors->count() > 0) {
                        $vendor = $vendors->first();
                        $getPassword   = $vendor->bride_auth->password;
                        $checkPassword = (new DefaultPasswordHasher())->check($this->request->getData('password'), $getPassword);

                        if ($checkPassword) {
                            $vendors = $this->BrideVendors->find('all', [
                                'order' => ['BrideVendors.name' => 'asc']
                                ])
                                ->contain('BrideAuth', function (Query $q) {
                                    return $q
                                        ->select(['id', 'email', 'user_type', 'status']);  
                                })
                                ->contain('BrideVendorAbout', function (Query $q) {
                                    return $q
                                        ->select(['id', 'content', 'status', 'vendor_id']);  
                                })
                                ->where([
                                    'BrideAuth.status'    => 1,
                                    'BrideAuth.user_type' => 'vendor',
                                    'BrideVendors.id'     => $vendor->id
                                ]);

                            $return = [
                                'status' => 'ok',
                                'vendor' => $vendors->first(),
                                'error'  => $error
                            ];
                        }
                        else {
                            $return = [
                                'status' => 'error',
                                'error'  => "Can't sign you in"
                            ];
                        }
                    }
                    else {
                        $return = [
                            'status' => 'error',
                            'error'  => "Invalid email address"
                        ];
                    }
                }
                else {
                    $return = [
                        'status' => 'error',
                        'error'  => $errorValidate
                    ];
                }
            }
            else {
                $return = [
                    'status' => 'error',
                    'error'  => 'Invalid access key'
                ];
            }

            if (Configure::read('debug')) {
                $return['data'] = $this->request->getData();
            }

            $json = json_encode($return, JSON_PRETTY_PRINT);

            $this->response = $this->response->withType('json');
            $this->response = $this->response->withStringBody($json);

            $this->set(compact('json'));
            $this->set('_serialize', 'json');
        }
        else {
	        throw new NotFoundException(__('Page not found'));
        }
    }
}