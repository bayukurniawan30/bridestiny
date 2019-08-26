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
        $this->log($this->Auth->user(), 'debug');

        Configure::load('Bridestiny.purple');

        $this->loadModel('Settings');
        $this->loadModel('Admins');
        $this->loadModel('Menus');
        $this->loadModel('Visitors');
        $this->loadModel('Socials');

        $this->loadModel('Bridestiny.BrideVendors');
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
        $user = $this->Auth->user();
        $this->set('user', $user);
    }
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}