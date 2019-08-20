<?php

namespace Bridestiny\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use App\Purple\PurpleProjectGlobal;
use App\Purple\PurpleProjectSeo;
use App\Purple\PurpleProjectSettings;
use App\Purple\PurpleProjectApi;
use App\Form\SearchForm;
use Carbon\Carbon;
use Melbahja\Seo\Factory;
use EngageTheme\Functions\ThemeFunction;
use Bridestiny\Functions\GlobalFunctions;

class UserActionsController extends AppController
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
    public function initialize()
    {
        parent::initialize();

        Configure::load('Bridestiny.purple');

        $this->loadModel('Settings');
        $this->loadModel('Admins');
        $this->loadModel('Menus');
        $this->loadModel('Visitors');
        $this->loadModel('Socials');
    }
    public function ajaxLoadCities()
    {
        $this->viewBuilder()->enableAutoLayout(false);
        if ($this->request->is('ajax') || $this->request->is('post')) {
            $province = trim($this->request->getData('province'));

            $html = NULL;

            if (Configure::check('RajaOngkir.apikey') && Configure::check('RajaOngkir.account')) {
                $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
                $rajaongkirAccType = Configure::read('RajaOngkir.account');

                if ($rajaongkirApiKey != NULL && $rajaongkirAccType != NULL) {
                    $globalFunction   = new GlobalFunctions();
                    $rajaongkirCities = $globalFunction->rajaongkirCities($rajaongkirApiKey, $rajaongkirAccType, $province);

                    $html = '<option value="">Select City</option>';
                    $citiesArray = [];
                    foreach ($rajaongkirCities as $city) {
                        $citiesArray[$city['city_id']] = $city['city_name'];
                        $html .= '<option value="'.$city['city_id'].'">'.$city['city_name'].'</option>';
                    }
                }
            }

            $json = json_encode(['status' => 'ok', 'options' => $html]);

            $this->set(['json' => $json]);
        }
        else {
            throw new NotFoundException(__('Page not found'));
        }
    }
}