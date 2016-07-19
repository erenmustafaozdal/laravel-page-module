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
        'page_categories'           => 'page-categories',       // page categories url
        'page'                      => 'pages',                 // pages url
        'admin_url_prefix'          => 'admin',                 // admin dashboard url prefix
        'middleware'                => ['auth', 'permission']   // page module middleware
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
