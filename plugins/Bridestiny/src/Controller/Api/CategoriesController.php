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

class CategoriesController extends AppController
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

        $this->loadModel('Admins');
        $this->loadModel('Settings');

        $this->loadModel('Bridestiny.BrideCategories');
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
    public function view() 
    {
        if ($this->request->is('get') && $this->request->hasHeader('X-Purple-Api-Key')) {
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
                        $orderQuery = ['BrideCategories.' . $orderBy => strtoupper($order)];
                    }
                    else {
                        $orderQuery = ['BrideCategories.name' => 'ASC'];
                        $error      = "Invalid query string. Please read the documentation for available query string.";
                    }
                }
                else {
                    $orderQuery = ['BrideCategories.name' => 'ASC'];
                }

                $categories = $this->BrideCategories->find('all', [
                    'order' => $orderQuery
                    ])
                    ->where([
                        'BrideCategories.status' => 1,
                    ]);

                if ($categories->count() > 0) {
                    $return = [
                        'status'     => 'ok',
                        'total'      => $categories->count(),
                        'categories' => $categories,
                        'error'      => $error
                    ];
                }
                else {
                    $return = [
                        'status'     => 'ok',
                        'total'      => 0,
                        'categories' => NULL,
                        'error'      => $error
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
}