<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General config
    |--------------------------------------------------------------------------
    */
    'date_format'                   => 'd.m.Y H:i:s',
    'icons' => [
        'page'                      => 'icon-note',
        'page_category'             => 'icon-note'
    ],

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
            'page_category'             => true,        // Is the route to be used categories admin
            'page'                      => true,        // Is the route to be used pages admin
            'sub_category_pages'        => true,        // Did subcategory page admin route will be used
        ],
        'api' => [
            'page_category'             => true,        // Is the route to be used categories api
            'page'                      => true,        // Is the route to be used pages api
            'sub_category_pages'        => true,        // Did subcategory page api route will be used
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
            'create'                => 'laravel-modules-core::page_category.operation',// get page category create view blade
            'show'                  => 'laravel-modules-core::page_category.show',  // get page category show view blade
            'edit'                  => 'laravel-modules-core::page_category.operation',// get page category edit view blade
        ],
        // page view
        'page' => [
            'layout'                => 'laravel-modules-core::layouts.admin',       // user layout
            'index'                 => 'laravel-modules-core::page.index',          // get page index view blade
            'create'                => 'laravel-modules-core::page.operation',      // get page create view blade
            'show'                  => 'laravel-modules-core::page.show',           // get page show view blade
            'edit'                  => 'laravel-modules-core::page.operation',      // get page edit view blade
        ]
    ],






    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'page_category' => [
            'title'                 => 'Sayfa Kategorileri',
            'routes' => [
                'admin.page_category.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini veri tablosunda listeleyebilir.',
                ],
                'admin.page_category.create' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisi ekleyebilir',
                ],
                'admin.page_category.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisi bilgilerini görüntüleyebilir',
                ],
                'admin.page_category.edit' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisini düzenleyebilir',
                ],
                'admin.page_category.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisini silebilir',
                ],
                'api.page_category.models' => [
                    'title'         => 'Rolleri Listeleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini bazı seçim kutularında listeleyebilir',
                ],
                'api.page_category.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri veri tablosunda toplu işlem yapabilir',
                ],
                'api.page_category.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri tablosunda detayını görebilir.',
                ],
            ],
        ],
        'page' => [
            'title'                 => 'Sayfalar',
            'routes' => [
                'admin.page.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar sayfaları veri tablosunda listeleyebilir.',
                ],
                'admin.page.create' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfa ekleyebilir',
                ],
                'admin.page.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar sayfa bilgilerini görüntüleyebilir',
                ],
                'admin.page.edit' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfa bilgilerini düzenleyebilir',
                ],
                'admin.page.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfayı silebilir',
                ],
                'api.page.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar sayfalar veri tablosunda toplu işlem yapabilir',
                ],
                'api.page.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar sayfalar tablosunda detayını görebilir.',
                ]
            ],
        ]
    ],
];
