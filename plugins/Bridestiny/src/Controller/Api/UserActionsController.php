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
use Carbon\Carbon;
use EngageTheme\Functions\ThemeFunction;
use Bridestiny\Functions\GlobalFunctions;

class UserActionsController extends AppController
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

        Configure::load('Bridestiny.purple');

        $this->loadModel('Admins');
        $this->loadModel('Settings');

        $this->viewBuilder()->enableAutoLayout(false);
        

        $purpleGlobal = new PurpleProjectGlobal();
		$protocol     = $purpleGlobal->protocol();

        $data = [
            'baseUrl' => $protocol . $this->request->host() . $this->request->getAttribute("webroot")
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
    public function provincesList()
    {
        $error = NULL;

        $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
        $rajaongkirAccType = Configure::read('RajaOngkir.account');

        $globalFunction      = new GlobalFunctions();
        $rajaongkirProvinces = $globalFunction->rajaongkirProvinces($rajaongkirApiKey, $rajaongkirAccType);

        $return = [
            'status'    => 'ok',
            'total'     => count($rajaongkirProvinces),
            'provinces' => $rajaongkirProvinces,
            'error'     => $error
        ];

        $json = json_encode($return, JSON_PRETTY_PRINT);

        $this->response = $this->response->withType('json');
        $this->response = $this->response->withStringBody($json);

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }
    public function provinceDetail($id)
    {
        $error = NULL;

        if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
            $return = [
                'status' => 'error',
                'error'  => 'Province id is required and an integer value'
            ];   
        }
        else {
            $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
            $rajaongkirAccType = Configure::read('RajaOngkir.account');

            $globalFunction     = new GlobalFunctions();
            $rajaongkirProvince = $globalFunction->rajaongkirProvinceDetail($rajaongkirApiKey, $rajaongkirAccType, $id);

            $return = [
                'status'   => 'ok',
                'province' => $rajaongkirProvince,
                'error'    => $error
            ];
        }

        $json = json_encode($return, JSON_PRETTY_PRINT);
    
        $this->response = $this->response->withType('json');
        $this->response = $this->response->withStringBody($json);

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }
    public function citiesList($province)
    {
        $error = NULL;

        if (empty($province) || !filter_var($province, FILTER_VALIDATE_INT)) {
            $return = [
                'status' => 'error',
                'error'  => 'Province id is required and an integer value'
            ];   
        }
        else {
            $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
            $rajaongkirAccType = Configure::read('RajaOngkir.account');

            $globalFunction     = new GlobalFunctions();
            $rajaongkirCities    = $globalFunction->rajaongkirCities($rajaongkirApiKey, $rajaongkirAccType, $province);

            $return = [
                'status' => 'ok',
                'total'  => count($rajaongkirCities),
                'cities' => $rajaongkirCities,
                'error'  => $error
            ];
        }

        $json = json_encode($return, JSON_PRETTY_PRINT);
    
        $this->response = $this->response->withType('json');
        $this->response = $this->response->withStringBody($json);

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }
    public function cityDetail($id)
    {
        $error = NULL;

        if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
            $return = [
                'status' => 'error',
                'error'  => 'City id is required and an integer value'
            ];   
        }
        else {
            $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
            $rajaongkirAccType = Configure::read('RajaOngkir.account');

            $globalFunction     = new GlobalFunctions();
            $rajaongkirCity = $globalFunction->rajaongkirCityDetail($rajaongkirApiKey, $rajaongkirAccType, $id);

            $return = [
                'status' => 'ok',
                'city'   => $rajaongkirCity,
                'error'  => $error
            ];
        }

        $json = json_encode($return, JSON_PRETTY_PRINT);
    
        $this->response = $this->response->withType('json');
        $this->response = $this->response->withStringBody($json);

        $this->set(compact('json'));
        $this->set('_serialize', 'json');
    }
}