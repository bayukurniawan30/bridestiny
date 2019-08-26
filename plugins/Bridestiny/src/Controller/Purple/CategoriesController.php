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
use Bridestiny\Form\Purple\CategoryAddForm;
use Bridestiny\Form\Purple\CategoryEditForm;
use Bridestiny\Form\Purple\CategoryDeleteForm;
use Bridestiny\Form\Purple\CategoryRestoreForm;

class CategoriesController extends AppController
{
    public $imagesLimit = 30;

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

            $this->loadModel('Bridestiny.BrideCategories');

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
            $medias          = $this->Medias->find('all', [
                'order' => ['Medias.id' => 'DESC']])->contain('Admins');

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
    					'title'              => 'Bridestiny - Categories | Purple CMS',
    					'pageTitle'          => 'Categories',
    					'pageTitleIcon'      => 'mdi-folder-multiple-outline',
    					'pageBreadcrumb'     => 'Bridestiny::Categories',
                        'appearanceFavicon'  => $queryFavicon,
                        'timeZone'           => $this->Settings->settingsTimeZone(),
                        'settingsDateFormat' => $queryDateFormat->value,
                        'settingsTimeFormat' => $queryTimeFormat->value,
                        'mediaImageTotal'    => $medias->count(),
					    'mediaImageLimit'    => $this->imagesLimit
    		    	];
                    $this->set($data);
                    
                    $this->paginate = [
                        'limit' => $this->imagesLimit,
                        'page'  => 1
                    ];
                    $browseMedias = $this->paginate($medias);
                    $this->set('browseMedias', $browseMedias);
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
        $categoryDelete = new CategoryAddForm();

        $categories = $this->BrideCategories->find('all')->where(['status <>' => '2']);
        $this->set(compact('categories'));

        $unpublishCategories = $this->BrideCategories->countCategoryStatus("0");
        $deletedCategory     = $this->BrideCategories->countCategoryStatus("2");

        $data = [
            "categoryDelete"      => $categoryDelete,
            "unpublishCategories" => $unpublishCategories,
            "deletedCategory"     => $deletedCategory
        ];

        $this->set($data);
    }
    public function removed()
    {
        $categoryRestore = new CategoryRestoreForm();

        $categories = $this->BrideCategories->find('all')->where(['status' => '2']);
        $this->set(compact('categories'));

        $data = [
            'pageTitle'       => 'Deleted Categories',
            'pageBreadcrumb'  => 'Bridestiny::Categories::Deleted',
            "categoryRestore" => $categoryRestore,
        ];

        $this->set($data);
    }
    public function add()
    {
        $categoryAdd = new CategoryAddForm();

        $parent   = $this->BrideCategories->selectBoxParent();
        $this->set(compact('parent'));

		$data = [
            'pageTitle'      => 'Add Category',
            'pageBreadcrumb' => 'Bridestiny::Categories::Add',
            'categoryAdd'     => $categoryAdd
		];

		$this->set($data);
    }
    public function edit()
	{
        $categoryEdit = new CategoryEditForm();

        $query = $this->BrideCategories->find()->where(['id' => $this->request->getParam('id')]);

        if ($query->count() == 1) {
        	$category = $query->first();
            $parent   = $this->BrideCategories->selectBoxParent();
            $this->set(compact('parent'));

            $data = [
                'pageTitle'      => 'Edit Category',
                'pageBreadcrumb' => 'Bridestiny::Categories::Edit',
                'categoryEdit'   => $categoryEdit,
                'category'       => $category,
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

        $categoryAdd = new CategoryAddForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($categoryAdd->execute($this->request->getData())) {
				$session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $slug = Text::slug(strtolower($this->request->getData('name')));
                $findDuplicate = $this->BrideCategories->find()->where(['slug' => $slug]);
                if ($findDuplicate->count() >= 1) {
                    $json = json_encode(['status' => 'error', 'error' => "Can't save data due to duplication of data. Please try again with another title."]);
                }
                else {
					$category = $this->BrideCategories->newEntity();
	                $category = $this->BrideCategories->patchEntity($category, $this->request->getData());

					if ($this->BrideCategories->save($category)) {
						$recordId = $category->id;
						$category = $this->BrideCategories->get($recordId);

						/**
						 * Save user activity to histories table
						 * array $options => title, detail, admin_id
						 */

						$options = [
							'title'    => 'Bridestiny(Plugin): Addition of New Category',
							'detail'   => ' add '.$category->name.' as a new category.',
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
				$errors = $categoryAdd->errors();
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

        $categoryEdit = new CategoryEditForm();
        if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($categoryEdit->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $slug = Text::slug(strtolower($this->request->getData('name')));
                $findDuplicate = $this->BrideCategories->find()->where(['slug' => $slug, 'id <>' => $this->request->getData('id')]);
                if ($findDuplicate->count() >= 1) {
                    $json = json_encode(['status' => 'error', 'error' => "Can't save data due to duplication of data. Please try again with another name."]);
                }
                else {
	                $category = $this->BrideCategories->get($this->request->getData('id'));
					$this->BrideCategories->patchEntity($category, $this->request->getData());

					if ($this->BrideCategories->save($category)) {
						$recordId = $category->id;
						$category = $this->BrideCategories->get($recordId);

						/**
						 * Save user activity to histories table
						 * array $options => title, detail, admin_id
						 */

						$options = [
							'title'    => 'Bridestiny(Plugin): Data Change of a Category',
							'detail'   => ' update '.$category->name.' data from categories.',
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
				$errors = $categoryEdit->errors();
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

        $categoryDelete = new CategoryDeleteForm();
        if ($this->request->is('ajax')) {
            if ($categoryDelete->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $category     = $this->BrideCategories->get($this->request->getData('id'));
                $categoryName = $category->name;
                $category     = $this->BrideCategories->patchEntity($category, $this->request->getData());
                // Status = 2 => Removed
                $category->status = "2";

                if ($this->BrideCategories->save($category)) {
                    $recordId = $category->id;
                    $category  = $this->BrideCategories->get($recordId);
                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */
                    
                    $options = [
                        'title'    => 'Bridestiny(Plugin): Deletion of a Category',
                        'detail'   => ' delete '.$categoryName.' from categories.',
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
            	$errors = $categoryDelete->errors();
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

        $categoryRestore = new CategoryRestoreForm();
        if ($this->request->is('ajax')) {
            if ($categoryRestore->execute($this->request->getData())) {
                $session   = $this->getRequest()->getSession();
                $sessionID = $session->read('Admin.id');

                $category     = $this->BrideCategories->get($this->request->getData('id'));
                $categoryName = $category->name;
                $category     = $this->BrideCategories->patchEntity($category, $this->request->getData());
                // Status = 0 => Draft
                $category->status = "0";

                if ($this->BrideCategories->save($category)) {
                    $recordId = $category->id;
                    $category = $this->BrideCategories->get($recordId);
                    /**
                     * Save user activity to histories table
                     * array $options => title, detail, admin_id
                     */
                    
                    $options = [
                        'title'    => 'Bridestiny(Plugin): Restoration of a Category',
                        'detail'   => ' restore '.$categoryName.' from deleted categories.',
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
            	$errors = $categoryRestore->errors();
                $json = json_encode(['status' => 'error', 'error' => $errors]);
            }

            $this->set(['json' => $json]);
        }
        else {
	        throw new NotFoundException(__('Page not found'));
	    }
    }
}