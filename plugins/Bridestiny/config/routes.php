<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Bridestiny\Functions\GlobalFunctions;

Router::plugin(
    'Bridestiny',
    ['path' => '/bridestiny'],
    function (RouteBuilder $routes) {
        // $routes->fallbacks(DashedRoute::class);

        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();

        $routes->prefix('api', function ($routes) use ($routePrefix) {
            $apiVersion     = 'v1';
            $apiVersionName = 'Version1';
            $routeName  	= $routePrefix . 'Api' . $apiVersion;

            /**
             * Vendors Routes
             */

            $routes->connect('/' . $apiVersion . '/vendor/login-api', 
                ['controller' => 'Vendors', 'action' => 'loginApi'], 
                ['_name' => $routeName . 'VendorLoginApi']);

            // Fetch All Vendors
            /**
             * Query String
             * order_by => name
             * order    => asc, desc
             * city (int)
             * paging (int)
             * limit (int)
             */
            $routes->connect('/' . $apiVersion . '/vendors/view', 
                ['controller' => 'Vendors', 'action' => 'view'], 
                ['_name' => $routeName . 'ViewVendors'])
            ->setMethods(['GET']);

            // Fetch All Vendors Specific Category
            /**
             * Query String
             * order_by => name
             * order    => asc, desc
             * city (int)
             * paging (int)
             * limit (int)
             */
            $routes->connect('/' . $apiVersion . '/vendors/:category/view', 
                ['controller' => 'Vendors', 'action' => 'viewByCategory'], 
                ['_name' => $routeName . 'ViewVendorsByCategory'])
            ->setPass(['category'])
            ->setMethods(['GET']);

            // Fetch Vendor Detail
            $routes->connect('/' . $apiVersion . '/vendor/detail/:slug', 
                    ['controller' => 'Vendors', 'action' => 'detail'], 
                    ['_name' => $routeName . 'VendorDetail'])
                ->setPass(['slug'])
                ->setMethods(['GET']);

            // Sign Up Vendor
            $routes->connect('/' . $apiVersion . '/vendor/sign-up', 
                    ['controller' => 'Vendors', 'action' => 'signUp'], 
                    ['_name' => $routeName . 'VendorSignUp'])
                ->setMethods(['POST']);

            // Verify Vendor
            $routes->connect('/' . $apiVersion . '/vendor/verify', 
                    ['controller' => 'Vendors', 'action' => 'verify'], 
                    ['_name' => $routeName . 'VendorVerify'])
                ->setMethods(['POST']);
            
            // Sign In Vendor
            $routes->connect('/' . $apiVersion . '/vendor/sign-in', 
                    ['controller' => 'Vendors', 'action' => 'signIn'], 
                    ['_name' => $routeName . 'VendorSignIn'])
                ->setMethods(['POST']);

            // Update Profile
            /**
             * Need auth (Basic Auth)
             * username => Vendor Email
             * password => Vendor API Key
             */
            $routes->connect('/' . $apiVersion . '/vendor/profile/update', 
                    ['controller' => 'Vendors', 'action' => 'updateProfile'], 
                    ['_name' => $routeName . 'VendorUpdateProfile'])
                ->setMethods(['PUT', 'POST']);

            /**
             * User Actions Routes
             */
            
             // Fetch Provinces List
            $routes->connect('/' . $apiVersion . '/user-action/provinces/list', 
                    ['controller' => 'UserActions', 'action' => 'provincesList'], 
                    ['_name' => $routeName . 'UserActionProvinceList'])
                ->setMethods(['GET']);

            // Fetch Province Detail
            $routes->connect('/' . $apiVersion . '/user-action/province/detail/:id', 
                    ['controller' => 'UserActions', 'action' => 'provinceDetail'], 
                    ['_name' => $routeName . 'UserActionProvinceDetail'])
                ->setPatterns(['id' => '\d+'])
                ->setPass(['id'])
                ->setMethods(['GET']);

            // Fetch Cities List
            $routes->connect('/' . $apiVersion . '/user-action/cities/:province/list', 
                    ['controller' => 'UserActions', 'action' => 'citiesList'], 
                    ['_name' => $routeName . 'UserActionCitiesList'])
                ->setPatterns(['province' => '\d+'])
                ->setPass(['province'])
                ->setMethods(['GET']);

            // Fetch City Detail
            $routes->connect('/' . $apiVersion . '/user-action/city/detail/:id', 
                    ['controller' => 'UserActions', 'action' => 'cityDetail'], 
                    ['_name' => $routeName . 'UserActionCityDetail'])
                ->setPatterns(['id' => '\d+'])
                ->setPass(['id'])
                ->setMethods(['GET']);

            /**
             * Categories Routes
             */

            // Fetch Categories
            /**
             * Query String
             * order_by => name
             * order    => asc, desc
             */
            $routes->connect('/' . $apiVersion . '/categories/view', 
                    ['controller' => 'Categories', 'action' => 'view'], 
                    ['_name' => $routeName . 'CategoriesView'])
                ->setMethods(['GET']);

        });
    }
);

Router::plugin(
    'Bridestiny',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        // $routes->fallbacks(DashedRoute::class);

        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();

        // Vendor Dashboard
        $routes->prefix('v', function ($routes) use ($routePrefix) {
            $routes->prefix('dashboard', function ($routes) use ($routePrefix) {
                $routes->connect('/', 
                    ['controller' => 'VendorDashboard', 'action' => 'index'],
                    ['_name' => $routePrefix . 'VendorDashboard']);

                $routes->connect('/:action', 
                    ['controller' => 'VendorDashboard'],
                    ['_name' => $routePrefix . 'VendorDashboardAction']);
            });
        });

        // Customer Dashboard
        $routes->prefix('c', function ($routes) use ($routePrefix) {
            $routes->prefix('dashboard', function ($routes) use ($routePrefix) {
                $routes->connect('/', 
                    ['controller' => 'CustomerDashboard', 'action' => 'index'],
                    ['_name' => $routePrefix . 'CustomerDashboard']);

                $routes->connect('/:action', 
                    ['controller' => 'CustomerDashboard'],
                    ['_name' => $routePrefix . 'CustomerDashboardAction']);
            });
        });

        $routes->connect('/vendor/sign-up', 
            ['controller' => 'Vendors', 'action' => 'signUp'], 
            ['_name' => $routePrefix . 'VendorSignUp']);

            // Process
            $routes->connect('/vendor/ajax-sign-up', 
                ['controller' => 'Vendors', 'action' => 'ajaxSignUp'], 
                ['_name' => $routePrefix . 'VendorAjaxSignUp']);

        $routes->connect('/vendor/sign-in', 
            ['controller' => 'Vendors', 'action' => 'signIn'], 
            ['_name' => $routePrefix . 'VendorSignIn']);

            // Proccess
            $routes->connect('vendor/ajax-sign-in', 
                ['controller' => 'Vendors', 'action' => 'ajaxSignIn'], 
                ['_name' => $routePrefix . 'VendorAjaxSignIn']);

        $routes->connect('/vendor/verification',
            ['controller' => 'Vendors', 'action' => 'verification'], 
            ['_name' => $routePrefix . 'VendorVerification']);

            // Process
            $routes->connect('/vendor/ajax-verification', 
                ['controller' => 'Vendors', 'action' => 'ajaxVerification'], 
                ['_name' => $routePrefix . 'VendorAjaxVerification']);

        $routes->connect('/vendor/pending-account', 
            ['controller' => 'Vendors', 'action' => 'pendingAccount'], 
            ['_name' => $routePrefix . 'VendorPendingAccount']);

        $routes->connect('/vendors',
            ['controller' => 'Vendors', 'action' => 'view'], 
            ['_name' => $routePrefix . 'VendorsView']);
        
        $routes->connect('/vendors/category/:category',
            ['controller' => 'Vendors', 'action' => 'viewByCategory'], 
            ['_name' => $routePrefix . 'VendorsByCategory'])
            ->setPass(['category']);

        $routes->connect('/vendor/:slug',
            ['controller' => 'Vendors', 'action' => 'detail'], 
            ['_name' => $routePrefix . 'VendorDetail'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/products',
            ['controller' => 'Vendors', 'action' => 'products'], 
            ['_name' => $routePrefix . 'VendorProducts'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/product/:productSlug',
            ['controller' => 'Vendors', 'action' => 'productDetail'], 
            ['_name' => $routePrefix . 'VendorProductDetail'])
            ->setPass(['slug', 'productSlug']);

        $routes->connect('/vendor/:slug/portfolios',
            ['controller' => 'Vendors', 'action' => 'portfolios'], 
            ['_name' => $routePrefix . 'VendorPortfolios'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/about',
            ['controller' => 'Vendors', 'action' => 'about'], 
            ['_name' => $routePrefix . 'VendorAbout'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/faqs',
            ['controller' => 'Vendors', 'action' => 'faqs'], 
            ['_name' => $routePrefix . 'VendorFaqs'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/posts',
            ['controller' => 'Vendors', 'action' => 'posts'], 
            ['_name' => $routePrefix . 'VendorPosts'])
            ->setPass(['slug']);

        $routes->connect('/vendor/:slug/post/:postSlug',
            ['controller' => 'Vendors', 'action' => 'postDetail'], 
            ['_name' => $routePrefix . 'VendorPostDetail'])
            ->setPass(['slug', 'postSlug']);

        $routes->connect('/categories',
            ['controller' => 'Categories', 'action' => 'view'], 
            ['_name' => $routePrefix . 'CategoriesView']);

        $routes->connect('/category/:slug',
            ['controller' => 'Categories', 'action' => 'detail'], 
            ['_name' => $routePrefix . 'CategoryDetail'])
            ->setPass(['slug']);


        $routes->connect('/customer/sign-up', 
            ['controller' => 'Customers', 'action' => 'signUp'], 
            ['_name' => $routePrefix . 'CustomerSignUp']);

        $routes->connect('/customer/sign-in', 
            ['controller' => 'Customers', 'action' => 'signIn'], 
            ['_name' => $routePrefix . 'CustomerSignIn']);

        $routes->connect('/customer/verification',
            ['controller' => 'Customers', 'action' => 'verification'], 
            ['_name' => $routePrefix . 'CustomerVerification']);

        $routes->connect('/customer/profile',
            ['controller' => 'Customers', 'action' => 'profile'], 
            ['_name' => $routePrefix . 'CustomerProfile']);

        // $routes->connect('v/dashboard', 
        //     ['controller' => 'VendorDashboard', 'action' => 'index'], 
        //     ['_name' => $routePrefix . 'VendorDashboard']);
        
    }
);

Router::plugin(
    'Bridestiny',
    ['path' => '/user-action'],
    function (RouteBuilder $routes) {
        // $routes->fallbacks(DashedRoute::class);

        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();

        $routes->connect('/form/cities', 
            ['controller' => 'UserActions', 'action' => 'ajaxLoadCities'], 
            ['_name' => $routePrefix . 'UserActionLoadCities']);

    }
);

Router::plugin(
    'Bridestiny',
    ['path' => '/purple/bridestiny'],
    function (RouteBuilder $routes) {
        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();

        /**
         * Customers Route
         * Controller : Customers
         */
        $routes->connect('/customers', 
            ['prefix' => 'purple', 'controller' => 'Customers', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Customers']);

        $routes->connect('/customers/:action', 
            ['prefix' => 'purple', 'controller' => 'Customers'], 
            ['_name' => $routePrefix . 'CustomersAction']);

        $routes->connect('/customers/detail/:id', 
			['prefix' => 'purple', 'controller' => 'Customers', 'action' => 'detail'], 
			['_name' => $routePrefix . 'CustomerViewDetail'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        /**
         * Vendors Route
         * Controller : Vendors
         */
        $routes->connect('/vendors', 
            ['prefix' => 'purple', 'controller' => 'Vendors', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Vendors']);

        $routes->connect('/vendors/:action', 
            ['prefix' => 'purple', 'controller' => 'Vendors'], 
            ['_name' => $routePrefix . 'VendorsAction']);

        $routes->connect('/vendors/filter/:filter', 
			['prefix' => 'purple', 'controller' => 'Vendors', 'action' => 'filter'], 
			['_name' => $routePrefix . 'VendorsFilter'])
            ->setPass(['filter']);

        $routes->connect('/vendors/detail/:id', 
			['prefix' => 'purple', 'controller' => 'Vendors', 'action' => 'detail'], 
			['_name' => $routePrefix . 'VendorViewDetail'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect('/vendors/detail/:id/:page', 
			['prefix' => 'purple', 'controller' => 'Vendors', 'action' => 'detailPage'], 
			['_name' => $routePrefix . 'VendorViewDetailPage'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id', 'page']);

        /**
         * Categories Route
         * Controller : Categories
         */
        $routes->connect('/categories', 
            ['prefix' => 'purple', 'controller' => 'Categories', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Categories']);

        $routes->connect('/categories/:action', 
            ['prefix' => 'purple', 'controller' => 'Categories'], 
            ['_name' => $routePrefix . 'CategoriesAction']);

        $routes->connect('/categories/removed', 
            ['prefix' => 'purple', 'controller' => 'Categories', 'action' => 'removed'], 
            ['_name' => $routePrefix . 'CategoriesRemoved']);

        $routes->connect('/categories/edit/:id', 
			['prefix' => 'purple', 'controller' => 'Categories', 'action' => 'edit'], 
			['_name' => $routePrefix . 'CategoriesEdit'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        /**
         * Currencies Route
         * Controller : Currencies
         */
        $routes->connect('/currencies', 
            ['prefix' => 'purple', 'controller' => 'Currencies', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Currencies']);

        $routes->connect('/currencies/:action', 
            ['prefix' => 'purple', 'controller' => 'Currencies'], 
            ['_name' => $routePrefix . 'CurrenciesAction']);

        $routes->connect('/currencies/removed', 
            ['prefix' => 'purple', 'controller' => 'Currencies', 'action' => 'removed'], 
            ['_name' => $routePrefix . 'CurrenciesRemoved']);

        $routes->connect('/currencies/edit/:id', 
			['prefix' => 'purple', 'controller' => 'Currencies', 'action' => 'edit'], 
			['_name' => $routePrefix . 'CurrenciesEdit'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        /**
         * Settings Route
         * Controller : Settings
         */
        $routes->connect('/settings', 
            ['prefix' => 'purple', 'controller' => 'Settings', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Settings']);

        $routes->connect('/settings/:action', 
            ['prefix' => 'purple', 'controller' => 'Settings'], 
            ['_name' => $routePrefix . 'SettingsAction']);

        /**
         * Notifications Route
         * Controller : Customers
         */
        $routes->connect('/notifications', 
            ['prefix' => 'purple', 'controller' => 'Notifications', 'action' => 'index'], 
            ['_name' => $routePrefix . 'Notifications']);

        $routes->connect('/notifications/detail/:id', 
			['prefix' => 'purple', 'controller' => 'Notifications', 'action' => 'detail'], 
			['_name' => $routePrefix . 'NotificationDetail'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect('/notifications/filter/:filter', 
			['prefix' => 'purple', 'controller' => 'Notifications', 'action' => 'filter'], 
			['_name' => $routePrefix . 'NotificationFilter'])
            ->setPass(['filter']);

        $routes->connect('/notifications/:action', 
            ['prefix' => 'purple', 'controller' => 'Notifications'], 
            ['_name' => $routePrefix . 'NotificationsAction']);

    }
);