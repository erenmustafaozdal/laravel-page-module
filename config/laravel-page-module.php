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
                'admin.page.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri veri tablosu sayfasına gidebilir.',
                ],
                'admin.page.create' => [
                    'title'         => 'Ekleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisi ekleme sayfasına gidebilir',
                ],
                'admin.page.store' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisi ekleyebilir',
                ],
                'admin.page.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisi bilgilerini görüntüleyebilir',
                ],
                'admin.page.edit' => [
                    'title'         => 'Düzenleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisini düzenleme sayfasına gidebilir',
                ],
                'admin.page.update' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisini düzenleyebilir',
                ],
                'admin.page.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorisini silebilir',
                ],
                'api.page.index' => [
                    'title'         => 'Listeleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini veri tablosunda listeleyebilir',
                ],
                'api.page.store' => [
                    'title'         => 'Hızlı Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini veri tablosunda hızlı ekleyebilir.',
                ],
                'api.page.update' => [
                    'title'         => 'Hızlı Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini veri tablosunda hızlı düzenleyebilir.',
                ],
                'api.page.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini veri tablosunda silebilir',
                ],
                'api.page.models' => [
                    'title'         => 'Seçim İçin Listeleme',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorilerini bazı seçim kutularında listeleyebilir',
                ],
                'api.page.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri veri tablosunda toplu işlem yapabilir',
                ],
                'api.page.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri tablosunda detayını görebilir.',
                ],
                'api.page.fastEdit' => [
                    'title'         => 'Hızlı Düzenleme Bilgileri',
                    'description'   => 'Bu izne sahip olanlar sayfa kategorileri tablosunda hızlı düzenleme amacıyla bilgileri getirebilir.',
                ],
            ],
        ],
        'page' => [
            'title'                 => 'Sayfalar',
            'routes' => [
                'admin.page.index' => [
                    'title'         => 'Veri Tablosu',
                    'description'   => 'Bu izne sahip olanlar sayfalar veri tablosu sayfasına gidebilir.',
                ],
                'admin.page.create' => [
                    'title'         => 'Ekleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar sayfa ekleme sayfasına gidebilir',
                ],
                'admin.page.store' => [
                    'title'         => 'Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfa ekleyebilir',
                ],
                'admin.page.show' => [
                    'title'         => 'Gösterme',
                    'description'   => 'Bu izne sahip olanlar sayfa bilgilerini görüntüleyebilir',
                ],
                'admin.page.edit' => [
                    'title'         => 'Düzenleme Sayfası',
                    'description'   => 'Bu izne sahip olanlar sayfayı düzenleme sayfasına gidebilir',
                ],
                'admin.page.update' => [
                    'title'         => 'Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfayı düzenleyebilir',
                ],
                'admin.page.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfayı silebilir',
                ],
                'admin.page.publish' => [
                    'title'         => 'Yayınlama',
                    'description'   => 'Bu izne sahip olanlar sayfayı yayınlayabilir',
                ],
                'admin.page.notPublish' => [
                    'title'         => 'Yayından Kaldırma',
                    'description'   => 'Bu izne sahip olanlar sayfayı yayından kaldırabilir',
                ],
                'api.page.index' => [
                    'title'         => 'Listeleme',
                    'description'   => 'Bu izne sahip olanlar sayfaları veri tablosunda listeleyebilir',
                ],
                'api.page.store' => [
                    'title'         => 'Hızlı Ekleme',
                    'description'   => 'Bu izne sahip olanlar sayfaları veri tablosunda hızlı ekleyebilir.',
                ],
                'api.page.update' => [
                    'title'         => 'Hızlı Düzenleme',
                    'description'   => 'Bu izne sahip olanlar sayfaları veri tablosunda hızlı düzenleyebilir.',
                ],
                'api.page.destroy' => [
                    'title'         => 'Silme',
                    'description'   => 'Bu izne sahip olanlar sayfaları veri tablosunda silebilir',
                ],
                'api.page.group' => [
                    'title'         => 'Toplu İşlem',
                    'description'   => 'Bu izne sahip olanlar sayfalar veri tablosunda toplu işlem yapabilir',
                ],
                'api.page.detail' => [
                    'title'         => 'Detaylar',
                    'description'   => 'Bu izne sahip olanlar sayfalar tablosunda detayını görebilir.',
                ],
                'api.page.fastEdit' => [
                    'title'         => 'Hızlı Düzenleme Bilgileri',
                    'description'   => 'Bu izne sahip olanlar sayfalar tablosunda hızlı düzenleme amacıyla bilgileri getirebilir.',
                ],
                'api.page.publish' => [
                    'title'         => 'Hızlı Yayınlama',
                    'description'   => 'Bu izne sahip olanlar sayfalar tablosunda sayfayı yayınlanyabilir.',
                ],
                'api.page.notPublish' => [
                    'title'         => 'Hızlı Yayından Kaldırma',
                    'description'   => 'Bu izne sahip olanlar sayfalar tablosunda sayfayı yayından kaldırabilir.',
                ],
            ],
        ]
    ],
];
