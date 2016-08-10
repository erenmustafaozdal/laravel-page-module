<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'date_format'                   => 'd.m.Y H:i:s',

    /*
    |--------------------------------------------------------------------------
    | URL config
    |--------------------------------------------------------------------------
    */
    'url' => [
        'page_category'             => 'page-categories',       // page categories url
        'page'                      => 'pages',                 // pages url
        'admin_url_prefix'          => 'admin',                 // admin dashboard url prefix
        'middleware'                => ['auth', 'permission']   // page module middleware
    ],

    /*
    |--------------------------------------------------------------------------
    | Controller config
    | if you make some changes on controller, you create your controller
    | and then extend the Laravel Page Module Controller. If you don't need
    | change controller, don't touch this config
    |--------------------------------------------------------------------------
    */
    'controller' => [
        'page_category_admin_namespace' => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers',
        'page_admin_namespace'          => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers',
        'page_category_api_namespace'   => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers',
        'page_api_namespace'            => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers',
        'page_category'                 => 'PageCategoryController',
        'page'                          => 'PageController',
        'page_category_api'             => 'PageCategoryApiController',
        'page_api'                      => 'PageApiController'
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes on / off
    | if you don't use any route; set false
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'admin' => [
            'page_category'             => true,                // admin page category resource route
            'page'                      => true,                // admin page resource route
            'page_publish'              => true,                // admin page publish get route
            'page_notPublish'           => true,                // admin page not publish get route
            'category_pages'            => true,                // admin category pages resource route
            'category_pages_publish'    => true,                // admin category pages publish get route
            'category_pages_notPublish' => true                 // admin category pages not publish get route
        ],
        'api' => [
            'page_category'             => true,                // api page category resource route
            'page_category_models'      => true,                // api page category model post route
            'page_category_group'       => true,                // api page category group post route
            'page_category_detail'      => true,                // api page category detail get route
            'page_category_fastEdit'    => true,                // api page category fast edit post route
            'page'                      => true,                // api page resource route
            'page_group'                => true,                // api page group post route
            'page_detail'               => true,                // api page detail get route
            'page_fastEdit'             => true,                // api page fast edit post route
            'page_publish'              => true,                // api page publish get route
            'page_notPublish'           => true,                // api page not publish get route
            'page_contentUpdate'        => true,                // api page content update post route
            'category_pages_index'      => true,                // api category pages index get route
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | View config
    |--------------------------------------------------------------------------
    | dot notation of blade view path, its position on the /resources/views directory
    */
    'views' => [
        // page category view
        'page_category' => [
            'layout'                => 'laravel-modules-core::layouts.admin',       // user layout
            'index'                 => 'laravel-modules-core::page_category.index', // get page category index view blade
            'create'                => 'laravel-modules-core::page_category.create',// get page category create view blade
            'show'                  => 'laravel-modules-core::page_category.show',  // get page category show view blade
            'edit'                  => 'laravel-modules-core::page_category.edit',  // get page category edit view blade
        ],
        // page view
        'page' => [
            'layout'                => 'laravel-modules-core::layouts.admin',       // user layout
            'index'                 => 'laravel-modules-core::page.index',          // get page index view blade
            'create'                => 'laravel-modules-core::page.create',         // get page create view blade
            'show'                  => 'laravel-modules-core::page.show',           // get page show view blade
            'edit'                  => 'laravel-modules-core::page.edit',           // get page edit view blade
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    */
];
