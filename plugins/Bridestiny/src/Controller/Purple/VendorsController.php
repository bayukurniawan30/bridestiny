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
            $vendor = $vendors->first();
            $this->set('vendor', $vendor);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
}