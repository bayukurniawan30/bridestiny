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

class NotificationsController extends AppController
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
            $this->loadModel('Bridestiny.BrideCustomers');
            $this->loadModel('Bridestiny.BrideNotifications');

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
    					'title'              => 'Bridestiny - Notifications | Purple CMS',
    					'pageTitle'          => 'Notifications',
    					'pageTitleIcon'      => 'mdi-bell',
    					'pageBreadcrumb'     => 'Bridestiny::Notifications',
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
        $notifications = $this->BrideNotifications->find('all')->order(['id' => 'DESC']);
        $this->set(compact('notifications'));

        $unread = $this->BrideNotifications->checkRead('0');
        $read   = $this->BrideNotifications->checkRead('1');

        $data = [
            "unread" => $unread,
            "read"   => $read,
        ];

        $this->set($data);
    }
    public function filter($filter) 
    {
        $filter = trim($filter);
        if ($filter == 'unread') {
            $isRead = '0';
        }
        elseif ($filter == 'read') {
            $isRead = '1';
        }

        $notifications = $this->BrideNotifications->find('byRead', ['read' => $isRead])->order(['id' => 'DESC']);
        $this->set(compact('notifications'));
    }
    public function detail($id)
    {
        $notification = $this->BrideNotifications->find('all')->where(['id' => $id])->limit(1);
        if ($notification->count() > 0) {
            $notification = $notification->first();
            $notification->is_read = '1';


            if ($this->BrideNotifications->save($notification)) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                /**
                 * Save user activity to histories table
                 * array $options => title, detail, admin_id
                 */

                $options = [
                    'title'    => 'Bridestiny(Plugin): Read a Notification',
                    'detail'   => ' read a notification.',
                    'admin_id' => $sessionID
                ];

                $this->loadModel('Histories');
                $saveActivity   = $this->Histories->saveActivity($options);
            }

            if ($notification->type == 'Vendors.new') {
                $relation = 'Vendors';
                $target   = $this->BrideVendors->get($notification->relation_id);
            }
            elseif ($notification->type == 'Customers.new') {
                $relation = 'Customers';
                $target   = $this->BrideCustomers->get($notification->relation_id);
            }

            $data = [
                'relation' => $relation,
                'target'   => $target,
            ];
            
            $this->set($data);
            $this->set('notification', $notification);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
    public function ajaxLoadBridestinyNotificationsBell()
    {
		$this->viewBuilder()->enableAutoLayout(false);

        $unread = $this->BrideNotifications->checkRead('0');
        $this->set('unread', $unread);
    }
}