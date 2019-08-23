<?php

namespace Bridestiny\Controller\Purple;

use Bridestiny\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Utility\Text;
use Cake\Http\Exception\NotFoundException;
use App\Form\Purple\SearchForm;
use App\Purple\PurpleProjectGlobal;
use App\Purple\PurpleProjectSettings;
use App\Purple\PurpleProjectPlugins;
use App\Purple\PurpleProjectApi;
use Bridestiny\Api\BridestinyApi;
use Bridestiny\Functions\GlobalFunctions;
use Bridestiny\Form\Purple\VendorConfirmForm;
use Bridestiny\Form\Purple\VendorRejectForm;

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
    }
    public function initialize()
	{
        parent::initialize();
        $this->loadComponent('RequestHandler');
		$session = $this->getRequest()->getSession();
		$sessionHost     = $session->read('Admin.host');
		$sessionID       = $session->read('Admin.id');
		$sessionPassword = $session->read('Admin.password');

		if ($this->request->getEnv('HTTP_HOST') != $sessionHost || !$session->check('Admin.id')) {
			return $this->redirect(
	            ['plugin' => false, 'controller' => 'Authenticate', 'action' => 'login']
	        );
		}
		else {
            $this->viewBuilder()->setLayout('dashboard');
            
            $this->loadModel('Admins');
            $this->loadModel('Settings');

            $this->loadModel('Bridestiny.BrideVendors');
            $this->loadModel('Bridestiny.BrideVendorAbout');
            $this->loadModel('Bridestiny.BrideVendorFaqs');
            $this->loadModel('Bridestiny.BrideVendorMedias');
            $this->loadModel('Bridestiny.BrideVendorPosts');
            $this->loadModel('Bridestiny.BrideVendorServices');
            $this->loadModel('Bridestiny.BrideVendorCalendars');

            if (Configure::read('debug') || $this->request->getEnv('HTTP_HOST') == 'localhost') {
                $cakeDebug = 'on';
            } 
            else {
                $cakeDebug = 'off';
            }

			$queryAdmin      = $this->Admins->find()->where(['id' => $sessionID, 'password' => $sessionPassword])->limit(1);
            $queryFavicon    = $this->Settings->find()->where(['name' => 'favicon'])->first();
            $queryDateFormat = $this->Settings->find()->where(['name' => 'dateformat'])->first();
            $queryTimeFormat = $this->Settings->find()->where(['name' => 'timeformat'])->first();

			$rowCount = $queryAdmin->count();
            if ($rowCount > 0) {
                $adminData = $queryAdmin->first();

                $dashboardSearch = new SearchForm();

                // Plugins List
				$purplePlugins 	= new PurpleProjectPlugins();
				$plugins		= $purplePlugins->purplePlugins();
                $this->set('plugins', $plugins);
                
                // Bridestiny Function
                $globalFunction = new GlobalFunctions();
                $routePrefix    = $globalFunction->routePrefix();
                $this->set('routePrefix', $routePrefix);
                
                if ($adminData->level == 1) {
                    $data = [
                        'sessionHost'        => $sessionHost,
                        'sessionID'          => $sessionID,
                        'sessionPassword'    => $sessionPassword,
                        'cakeDebug'          => $cakeDebug,
                        'adminName'          => ucwords($adminData->display_name),
                        'adminLevel'         => $adminData->level,
                        'adminEmail'         => $adminData->email,
                        'adminPhoto'         => $adminData->photo,
                        'greeting'           => '',
                        'dashboardSearch'    => $dashboardSearch,
    					'title'              => 'Bridestiny - Vendors | Purple CMS',
    					'pageTitle'          => 'Vendors',
    					'pageTitleIcon'      => 'mdi-account-multiple-outline',
    					'pageBreadcrumb'     => 'Bridestiny::Vendors',
                        'appearanceFavicon'  => $queryFavicon,
                        'timeZone'           => $this->Settings->settingsTimeZone(),
                        'settingsDateFormat' => $queryDateFormat->value,
                        'settingsTimeFormat' => $queryTimeFormat->value,
    		    	];
                    $this->set($data);
                }
                else {
                    return $this->redirect(
                        ['plugin' => false, 'controller' => 'Dashboard', 'action' => 'index']
                    );
                }
			}
			else {
				return $this->redirect(
		            ['plugin' => false, 'controller' => 'Authenticate', 'action' => 'login']
		        );
			}
        }
    }
    public function index() 
    {
        $vendors = $this->BrideVendors->find('all')->order(['id' => 'DESC']);
        $this->set(compact('vendors'));

        $unverified = $this->BrideVendors->countVendorStatus("0");
        $verified   = $this->BrideVendors->countVendorStatus("1");
        $banned     = $this->BrideVendors->countVendorStatus("2");
        $active     = $this->BrideVendors->countVendorStatus("3");

        $data = [
            "unverified" => $unverified,
            "verified"   => $verified,
            "banned"     => $banned,
            "active"     => $active
        ];

        $this->set($data);
    }
    public function filter($filter) 
    {
        $filter = trim($filter);
        $availableFilter = ['unverified', 'verified', 'banned', 'active'];

        if (in_array($filter, $availableFilter)) {
            if ($filter == 'unverified') {
                $status = '0';
            }
            elseif ($filter == 'verified') {
                $status = '1';
            }
            elseif ($filter == 'banned') {
                $status = '2';
            }
            elseif ($filter == 'active') {
                $status = '3';
            }

            $vendors = $this->BrideVendors->find('all')->where(['status' => $status])->order(['id' => 'DESC']);
            $this->set(compact('vendors'));

            $unverified = $this->BrideVendors->countVendorStatus("0");
            $verified   = $this->BrideVendors->countVendorStatus("1");
            $banned     = $this->BrideVendors->countVendorStatus("2");
            $active     = $this->BrideVendors->countVendorStatus("3");

            $data = [
                "unverified" => $unverified,
                "verified"   => $verified,
                "banned"     => $banned,
                "active"     => $active
            ];

            $this->set($data);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function detail($id)
    {
        $vendors = $this->BrideVendors->find('all')->where(['id' => $id])->limit(1);
        if ($vendors->count() > 0) {
            $vendorConfirm = new VendorConfirmForm();
            $vendorReject  = new VendorRejectForm();

            $vendor = $vendors->first();
            $this->set('vendor', $vendor);
            $this->set('vendorConfirm', $vendorConfirm);
            $this->set('vendorReject', $vendorReject);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function detailPage($id, $page)
    {
        $vendors = $this->BrideVendors->find('all')->where(['id' => $id])->limit(1);
        if ($vendors->count() > 0) {
            $vendor = $vendors->first();
            $this->set('vendor', $vendor);

            $availablePage = ['documents', 'about', 'portfolios', 'faqs', 'products'];

            if (in_array($page, $availablePage)) {
                if ($page == 'documents') {
                    $ktp  = $this->BrideVendorMedias->find()->where(['name' => $vendor->ktp, 'vendor_id' => $vendor->id])->limit(1)->first();
                    $npwp = $this->BrideVendorMedias->find()->where(['name' => $vendor->npwp, 'vendor_id' => $vendor->id])->limit(1)->first();
                    
                    $data = [
                        'ktp'  => $ktp,
                        'npwp' => $npwp
                    ];

                    $this->set($data);
                }
            }
            else {
                throw new NotFoundException(__('Page not found'));
            }
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function ajaxConfirm()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $vendorConfirm = new VendorConfirmForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
            if ($vendorConfirm->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $vendor         = $this->BrideVendors->get($this->request->getData('id'));
                $vendorName     = $vendor->name;
                $vendor         = $this->BrideVendors->patchEntity($vendor, $this->request->getData());
                $vendor->status = '3';

                if ($this->BrideVendors->save($vendor)) {
                    $recordId = $vendor->id;
                    $vendor   = $this->BrideVendors->get($recordId);

                    // Send Email to User to Notify user
                    $key    = $this->Settings->settingsPublicApiKey();
                    $dashboardLink = $this->request->getData('ds');
                    $userData      = array(
                        'sitename'    => $this->Settings->settingsSiteName(),
                        'displayName' => $vendor->name,
                        'email'       => $vendor->email,
                    );

                    $purpleGlobal = new PurpleProjectGlobal();
                    $protocol     = $purpleGlobal->protocol();
                    
                    if ($this->Settings->settingsLogo() == '') {
                        $siteLogo = $protocol.$this->request->env('HTTP_HOST').$this->request->getAttribute('webroot').'master-assets/img/logo.svg';
                    }
                    else {
                        $siteLogo = $protocol.$this->request->env('HTTP_HOST').$this->request->getAttribute('webroot').'uploads/images/original/'.$this->Settings->settingsLogo();
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
                    $notifyUser    = $bridestinyApi->sendEmailVendorConfirmation($key, $dashboardLink, json_encode($userData), json_encode($siteData), json_encode($senderData));

                    if ($notifyUser == true) {
                        $emailNotification = true;
                    }
                    else {
                        $emailNotification = false;
                    }

                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */
                    
                    $options = [
                        'title'    => 'Bridestiny(Plugin): Confirmation of a Vendor Account',
                        'detail'   => ' confirm '.$vendorName.' account and make it\'s account active.',
                        'admin_id' => $sessionID
                    ];
 
                    $this->loadModel('Histories');
                    $saveActivity   = $this->Histories->saveActivity($options);

                    if ($saveActivity == true) {
                        $json = json_encode(['status' => 'ok', 'activity' => true, 'email' => $emailNotification]);
                    }
                    else {
                        $json = json_encode(['status' => 'ok', 'activity' => false, 'email' => $emailNotification]);
                    }
                }
                else {
                    $json = json_encode(['status' => 'error', 'error' => "Can't delete data. Please try again."]);
                }

            }
			else {
				$errors = $vendorConfirm->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
			}

			$this->set(['json' => $json]);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function ajaxDecline()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $vendorReject  = new VendorRejectForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
            if ($vendorReject->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $vendor         = $this->BrideVendors->get($this->request->getData('id'));
                $vendorName     = $vendor->name;
                $vendor         = $this->BrideVendors->patchEntity($vendor, $this->request->getData());
                $vendor->status = '4';

                if ($this->BrideVendors->save($vendor)) {
                    $recordId = $vendor->id;
                    $vendor   = $this->BrideVendors->get($recordId);
                    // Send Email to User to Notify user
                    $key    = $this->Settings->settingsPublicApiKey();
                    $userData      = array(
                        'sitename'    => $this->Settings->settingsSiteName(),
                        'displayName' => $vendor->name,
                        'email'       => $vendor->email,
                    );

                    if (empty($this->request->getData('decline_reason'))) {
                        $userData['reason'] = NULL;
                    }
                    else {
                        $userData['reason'] = strip_tags($this->request->getData('decline_reason'));
                    }

                    $purpleGlobal = new PurpleProjectGlobal();
                    $protocol     = $purpleGlobal->protocol();
                    
                    if ($this->Settings->settingsLogo() == '') {
                        $siteLogo = $protocol.$this->request->env('HTTP_HOST').$this->request->getAttribute('webroot').'master-assets/img/logo.svg';
                    }
                    else {
                        $siteLogo = $protocol.$this->request->env('HTTP_HOST').$this->request->getAttribute('webroot').'uploads/images/original/'.$this->Settings->settingsLogo();
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
                    $notifyUser    = $bridestinyApi->sendEmailVendorDeclined($key, json_encode($userData), json_encode($siteData), json_encode($senderData));

                    if ($notifyUser == true) {
                        $emailNotification = true;
                    }
                    else {
                        $emailNotification = false;
                    }

                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */

                    if (empty($this->request->getData('decline_reason'))) {
                        $reason = '';
                    }
                    else {
                        $reason = 'The reason is ' . $this->request->getData('decline_reason');
                    }
                    
                    $options = [
                        'title'    => 'Bridestiny(Plugin): Decline of a Vendor Account',
                        'detail'   => ' decline '.$vendorName.' account.' . $reason,
                        'admin_id' => $sessionID
                    ];
 
                    $this->loadModel('Histories');
                    $saveActivity   = $this->Histories->saveActivity($options);

                    if ($saveActivity == true) {
                        $json = json_encode(['status' => 'ok', 'activity' => true, 'email' => $emailNotification]);
                    }
                    else {
                        $json = json_encode(['status' => 'ok', 'activity' => false, 'email' => $emailNotification]);
                    }
                }
                else {
                    $json = json_encode(['status' => 'error', 'error' => "Can't delete data. Please try again."]);
                }

            }
			else {
				$errors = $vendorReject->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
			}

			$this->set(['json' => $json]);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
}