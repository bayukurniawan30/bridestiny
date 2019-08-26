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
use Bridestiny\Form\Purple\CurrencyAddForm;
use Bridestiny\Form\Purple\CurrencyEditForm;
use Bridestiny\Form\Purple\CurrencyDeleteForm;
use Bridestiny\Form\Purple\CurrencyRestoreForm;

class CurrenciesController extends AppController
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
            $this->loadModel('Medias');

            $this->loadModel('Bridestiny.BrideCurrencies');

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
    					'title'              => 'Bridestiny - Currencies | Purple CMS',
    					'pageTitle'          => 'Currencies',
    					'pageTitleIcon'      => 'mdi-currency-usd',
    					'pageBreadcrumb'     => 'Bridestiny::Currencies',
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
        // Plugin Function
        $globalFunction    = new GlobalFunctions();
        $currencyConverter = $globalFunction->currencyConverter('USD', 'IDR', 1);

        $currencyDelete = new CurrencyDeleteForm();
        
        $currencies = $this->BrideCurrencies->find()->where(['status <>' => '2'])->order(["ordering" => "DESC"]);
        $this->set(compact('currencies'));

        $deletedCurrencies = $this->BrideCurrencies->countCurrenciesStatus('2');

        $data = [
            'deletedCurrencies' => $deletedCurrencies,
            'currencyDelete'    => $currencyDelete,
            'currencyConverter' => $currencyConverter
        ];

        $this->set($data);
    }
    public function removed()
    {
        $currencyRestore = new CurrencyRestoreForm();
        $currencies = $this->BrideCurrencies->find()->where(['status' => '2'])->order(["id" => "DESC"]);
        $this->set(compact('currencies'));
        $this->set('currencyRestore', $currencyRestore);
    }
    public function add()
    {
        $currencyAdd = new CurrencyAddForm();

        // Plugin Function
        $globalFunction      = new GlobalFunctions();
        $availableCurrencies = $globalFunction->availableCurrencies();

        $checkCurrencies = $this->BrideCurrencies->find();
        if ($checkCurrencies->count() > 0) {
            $newArray = [];
            foreach ($checkCurrencies as $check) {
                array_push($newArray, $check->code);
            }

            foreach ($newArray as $added) {
                if (array_key_exists($added, $availableCurrencies)) {
                    unset($availableCurrencies[$added]);
                }
            }
        }

		$data = [
            'pageTitle'      => 'Add Currency',
            'pageBreadcrumb' => $this->pluginName . '::Currency::Add',
            'currencyAdd'    => $currencyAdd,
            'options'        => $availableCurrencies
		];

		$this->set($data);
    }
    public function edit()
    {
        $currencyEdit = new CurrencyEditForm();

        $query = $this->BrideCurrencies->find()->where(['id' => $this->request->getParam('id')]);

        if ($query->count() == 1) {
            $currency = $query->first();
            
            // Plugin Function
            $globalFunction      = new GlobalFunctions();
            $availableCurrencies = $globalFunction->availableCurrencies();

            $data = [
                'pageTitle'      => 'Edit Currency',
                'pageBreadcrumb' => $this->pluginName . '::Currency::Edit',
                'currencyEdit'   => $currencyEdit,
                'currency'       => $currency,
                'options'        => $availableCurrencies
        ];

            $this->set($data);
        }
        else {
	        throw new NotFoundException(__('Page not found'));
        }
    }
    public function ajaxAdd()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $currencyAdd = new CurrencyAddForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($currencyAdd->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $findDuplicate = $this->BrideCurrencies->find()->where(['code' => $this->request->getData('code')]);
                if ($findDuplicate->count() >= 1) {
                    $json = json_encode(['status' => 'error', 'error' => "Can't save data due to duplication of data. Please try again."]);
                }
                else {
                    $currency = $this->BrideCurrencies->newEntity();
                    $currency = $this->BrideCurrencies->patchEntity($currency, $this->request->getData());

                    if ($this->BrideCurrencies->save($currency)) {
                        $recordId = $currency->id;
                        $currency = $this->BrideCurrencies->get($recordId);

                        /**
                         * Save user activity to histories table
                         * array $options => title, detail, admin_id
                         */

                        $options = [
                            'title'    => 'Purple Store(Plugin): Addition of New Currency',
                            'detail'   => ' add '.$currency->code.' as a new currency.',
                            'admin_id' => $sessionID
                        ];

                        $this->loadModel('Histories');
                        $saveActivity   = $this->Histories->saveActivity($options);

                        if ($saveActivity == true) {
                            $json = json_encode(['status' => 'ok', 'activity' => true]);
                        }
                        else {
                            $json = json_encode(['status' => 'ok', 'activity' => false]);
                        }
                    }
                    else {
                        $json = json_encode(['status' => 'error', 'error' => "Can't save data. Please try again."]);
                    }
                }
            }
			else {
				$errors = $currencyAdd->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
			}

			$this->set(['json' => $json]);
		}
    	else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
    public function ajaxUpdate()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $currencyEdit = new CurrencyEditForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($currencyEdit->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $findDuplicate = $this->BrideCurrencies->find()->where(['code' => $this->request->getData('code'), 'id <>' => $this->request->getData('id')]);
                if ($findDuplicate->count() >= 1) {
                    $json = json_encode(['status' => 'error', 'error' => "Can't save data due to duplication of data. Please try again."]);
                }
                else {
                    $currency = $this->BrideCurrencies->get($this->request->getData('id'));
                    $this->BrideCurrencies->patchEntity($currency, $this->request->getData());

                    if ($this->BrideCurrencies->save($currency)) {
                        $recordId = $currency->id;
                        $currency   = $this->BrideCurrencies->get($recordId);

                        /**
                         * Save user activity to histories table
                         * array $options => title, detail, admin_id
                         */

                        $options = [
                            'title'    => 'Purple Store(Plugin): Data Change of a Currency',
                            'detail'   => ' update '.$currency->code.' data from currencies.',
                            'admin_id' => $sessionID
                        ];

                        $this->loadModel('Histories');
                        $saveActivity   = $this->Histories->saveActivity($options);

                        if ($saveActivity == true) {
                            $json = json_encode(['status' => 'ok', 'activity' => true]);
                        }
                        else {
                            $json = json_encode(['status' => 'ok', 'activity' => false]);
                        }
                    }
                    else {
                        $json = json_encode(['status' => 'error', 'error' => "Can't save data. Please try again."]);
                    }
                }
            }
			else {
				$errors = $currencyEdit->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
			}

			$this->set(['json' => $json]);
		}
    	else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
    public function ajaxDelete()
	{
		$this->viewBuilder()->enableAutoLayout(false);

        $currencyDelete = new CurrencyDeleteForm();
        if ($this->request->is('ajax')) {
            if ($currencyDelete->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $currency     = $this->BrideCurrencies->get($this->request->getData('id'));
                $currencyCode = $currency->code;
                $currency     = $this->BrideCurrencies->patchEntity($currency, $this->request->getData());
                // Status = 2 => Removed
                $currency->status = "2";

                if ($this->BrideCurrencies->save($currency)) {
                    $recordId = $currency->id;
                    $currency   = $this->BrideCurrencies->get($recordId);
                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */
                    
                    $options = [
                        'title'    => 'Purple Store(Plugin): Deletion of a Currency',
                        'detail'   => ' delete '.$currencyCode.' from currencies.',
                        'admin_id' => $sessionID
                    ];

                    $this->loadModel('Histories');
                    $saveActivity   = $this->Histories->saveActivity($options);

                    if ($saveActivity == true) {
                        $json = json_encode(['status' => 'ok', 'activity' => true]);
                    }
                    else {
                        $json = json_encode(['status' => 'ok', 'activity' => false]);
                    }
                }
                else {
                    $json = json_encode(['status' => 'error', 'error' => "Can't delete data. Please try again."]);
                }
            }
            else {
            	$errors = $currencyDelete->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
            }

            $this->set(['json' => $json]);
        }
        else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
    public function ajaxRestore()
    {
        $this->viewBuilder()->enableAutoLayout(false);

        $currencyRestore = new CurrencyRestoreForm();
        if ($this->request->is('ajax')) {
            if ($currencyRestore->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $currency     = $this->BrideCurrencies->get($this->request->getData('id'));
                $currencyCode = $currency->code;
                $currency     = $this->BrideCurrencies->patchEntity($currency, $this->request->getData());
                // Status = 0 => Draft
                $currency->status = "0";

                if ($this->BrideCurrencies->save($currency)) {
                    $recordId = $currency->id;
                    $currency  = $this->BrideCurrencies->get($recordId);
                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */
                    
                    $options = [
                        'title'    => 'Purple Store(Plugin): Restoration of a Currency',
                        'detail'   => ' restore '.$currencyCode.' from deleted currencies.',
                        'admin_id' => $sessionID
                    ];
 
                    $this->loadModel('Histories');
                    $saveActivity   = $this->Histories->saveActivity($options);

                    if ($saveActivity == true) {
                        $json = json_encode(['status' => 'ok', 'activity' => true]);
                    }
                    else {
                        $json = json_encode(['status' => 'ok', 'activity' => false]);
                    }
                }
                else {
                    $json = json_encode(['status' => 'error', 'error' => "Can't delete data. Please try again."]);
                }
            }
            else {
            	$errors = $currencyRestore->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
            }

            $this->set(['json' => $json]);
        }
        else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
}