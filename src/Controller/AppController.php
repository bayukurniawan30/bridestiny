<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use App\Purple\PurpleProjectGlobal;
use Bridestiny\Form\VendorSignInForm;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'VendorDashboard',
                'action'     => 'index',
                'plugin'     => 'Bridestiny',
                'prefix'     => 'v/dashboard',
            ],
            'logoutRedirect' => [
                '_name' => 'home'
            ],
            'loginAction' => [
                '_name' => 'home'
            ],
            'unauthorizedRedirect' => false,
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'fields'    => ['username' => 'email', 'password' => 'password'],
                    'finder'    => 'auth',
                    'userModel' => 'Bridestiny.BrideVendors',
                ]
            ],
            'storage' => 'Session'
        ]);

        if ($this->request->getParam('prefix') == 'purple') {
            $this->Auth->allow();
        }

        $this->Auth->allow(['setClientTimezone']);

        if (!$this->Auth->user()) {
            $vendorSignIn = new VendorSignInForm();
            $this->set('vendorSignIn', $vendorSignIn);
            $this->set('userData', NULL);
        }
        else {
            $user = $this->Auth->user();
            $userType = $user['user_type'];
            $userData = NULL;

            if ($userType == 'vendor') {
                $this->loadModel('Bridestiny.BrideVendors');
                $query    = $this->BrideVendors->find()->where(['id' => $user['id'], 'email' => $user['email']])->limit(1)->first();
                $userData = $query;
            }
            elseif ($userType == 'customer') {
                $this->loadModel('Bridestiny.BrideCustomers');
                $query    = $this->BrideCustomers->find()->where(['id' => $user['id'], 'email' => $user['email']])->limit(1)->first();
                $userData = $query;
            }

            $data = [
                'userType' => $userType,
                'userData' => $userData,
            ];

            $this->set($data);
        }

        if ($this->request->getParam('controller') == 'Setup' || $this->request->getParam('controller') == 'Production') {

        }
        else {
            // Timezone
            $purpleGlobal      = new PurpleProjectGlobal();
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

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        // $this->loadComponent('Security');
    }
    public function setClientTimezone()
    {
    	$this->viewBuilder()->enableAutoLayout(false);
        if ($this->request->is('ajax') || $this->request->is('post')) {
            $this->loadModel('Settings');
            $session  = $this->getRequest()->getSession();
            $settingTimezone = $this->Settings->settingsTimeZone();
            $session->write('Purple.settingTimezone', $settingTimezone);

            $timezone = trim($this->request->getData('timezone'));
            $session->write('Purple.timezone', $timezone);
            if ($session->check('Purple.timezone')) {
                $json = json_encode(['status' => 'ok', 'timezone' => $timezone]);
            }
            else {
                $json = json_encode(['status' => 'error']);
            }
			$this->set(['json' => $json]);
        }
    	else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
}