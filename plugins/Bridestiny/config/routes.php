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


    }
);

Router::plugin(
    'Bridestiny',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        // $routes->fallbacks(DashedRoute::class);

        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();

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

            // Process
            $routes->connect('/vendor/ajax-sign-in', 
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

        $routes->connect('/vendor/profile', 
            ['controller' => 'Vendors', 'action' => 'profile'], 
            ['_name' => $routePrefix . 'VendorProfile']);
        
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

    }
);