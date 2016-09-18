<?php

return [
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
];
