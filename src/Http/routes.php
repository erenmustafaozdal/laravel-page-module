<?php
//max level nested function 100 hatasını düzeltiyor
ini_set('xdebug.max_nesting_level', 300);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
/*==========  Page Category Module  ==========*/
Route::group([
    'prefix' => config('laravel-page-module.url.admin_url_prefix'),
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => config('laravel-page-module.controller.page_category_admin_namespace')
], function()
{
    if (config('laravel-page-module.routes.admin.page_category')) {
        Route::resource(config('laravel-page-module.url.page_category'), config('laravel-page-module.controller.page_category'), [
            'names' => [
                'index' => 'admin.page_category.index',
                'create' => 'admin.page_category.create',
                'store' => 'admin.page_category.store',
                'show' => 'admin.page_category.show',
                'edit' => 'admin.page_category.edit',
                'update' => 'admin.page_category.update',
                'destroy' => 'admin.page_category.destroy',
            ]
        ]);
    }
});

/*==========  Page Module  ==========*/
Route::group([
    'prefix' => config('laravel-page-module.url.admin_url_prefix'),
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => config('laravel-page-module.controller.page_admin_namespace')
], function()
{
    // admin publish page
    if (config('laravel-page-module.routes.admin.page_publish')) {
        Route::get('page/{' . config('laravel-page-module.url.page') . '}/publish', [
            'as' => 'admin.page.publish',
            'uses' => config('laravel-page-module.controller.page').'@publish'
        ]);
    }
    // admin not publish page
    if (config('laravel-page-module.routes.admin.page_notPublish')) {
        Route::get('page/{' . config('laravel-page-module.url.page') . '}/not-publish', [
            'as' => 'admin.page.notPublish',
            'uses' => config('laravel-page-module.controller.page').'@notPublish'
        ]);
    }
    if (config('laravel-page-module.routes.admin.page')) {
        Route::resource(config('laravel-page-module.url.page'), config('laravel-page-module.controller.page'), [
            'names' => [
                'index' => 'admin.page.index',
                'create' => 'admin.page.create',
                'store' => 'admin.page.store',
                'show' => 'admin.page.show',
                'edit' => 'admin.page.edit',
                'update' => 'admin.page.update',
                'destroy' => 'admin.page.destroy',
            ]
        ]);
    }

    /*==========  Category pages  ==========*/
    // admin publish page
    if (config('laravel-page-module.routes.admin.category_pages_publish')) {
        Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page') . '/{' . config('laravel-page-module.url.page') . '}/publish', [
            'middleware' => 'related_model:PageCategory,pages',
            'as' => 'admin.page_category.page.publish',
            'uses' => config('laravel-page-module.controller.page').'@publish'
        ]);
    }
    // admin not publish page
    if (config('laravel-page-module.routes.admin.category_pages_notPublish')) {
        Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page') . '/{' . config('laravel-page-module.url.page') . '}/not-publish', [
            'middleware' => 'related_model:PageCategory,pages',
            'as' => 'admin.page_category.page.notPublish',
            'uses' => config('laravel-page-module.controller.page').'@notPublish'
        ]);
    }
    if (config('laravel-page-module.routes.admin.category_pages')) {
        Route::group(['middleware' => 'related_model:PageCategory,pages'], function() {
            Route::resource(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page'), config('laravel-page-module.controller.page'), [
                'names' => [
                    'index' => 'admin.page_category.page.index',
                    'create' => 'admin.page_category.page.create',
                    'store' => 'admin.page_category.page.store',
                    'show' => 'admin.page_category.page.show',
                    'edit' => 'admin.page_category.page.edit',
                    'update' => 'admin.page_category.page.update',
                    'destroy' => 'admin.page_category.page.destroy',
                ]
            ]);
        });
    }
});



/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
*/
/*==========  Page Category Module  ==========*/
Route::group([
    'prefix' => 'api',
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => config('laravel-page-module.controller.page_category_api_namespace')
], function()
{
    // api page category
    if (config('laravel-page-module.routes.api.page_category_models')) {
        Route::post('page-category/models', [
            'as' => 'api.page_category.models',
            'uses' => config('laravel-page-module.controller.page_category_api').'@models'
        ]);
    }
    // api group action
    if (config('laravel-page-module.routes.api.page_category_group')) {
        Route::post('page-category/group-action', [
            'as' => 'api.page_category.group',
            'uses' => config('laravel-page-module.controller.page_category_api').'@group'
        ]);
    }
    // data table detail row
    if (config('laravel-page-module.routes.api.page_category_detail')) {
        Route::get('page-category/{id}/detail', [
            'as' => 'api.page_category.detail',
            'uses' => config('laravel-page-module.controller.page_category_api').'@detail'
        ]);
    }
    // get page category edit data for modal edit
    if (config('laravel-page-module.routes.api.page_category_fastEdit')) {
        Route::post('page-category/{id}/fast-edit', [
            'as' => 'api.page_category.fastEdit',
            'uses' => config('laravel-page-module.controller.page_category_api').'@fastEdit'
        ]);
    }
    // page category resource
    if (config('laravel-page-module.routes.api.page_category')) {
        Route::resource(config('laravel-page-module.url.page_category'), config('laravel-page-module.controller.page_category_api'), [
            'names' => [
                'index' => 'api.page_category.index',
                'store' => 'api.page_category.store',
                'update' => 'api.page_category.update',
                'destroy' => 'api.page_category.destroy',
            ]
        ]);
    }
});

/*==========  Page Module  ==========*/
Route::group([
    'prefix' => 'api',
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => config('laravel-page-module.controller.page_api_namespace')
], function()
{
    // api group action
    if (config('laravel-page-module.routes.api.page_group')) {
        Route::post('page/group-action', [
            'as' => 'api.page.group',
            'uses' => config('laravel-page-module.controller.page_api').'@group'
        ]);
    }
    // data table detail row
    if (config('laravel-page-module.routes.api.page_detail')) {
        Route::get('page/{id}/detail', [
            'as' => 'api.page.detail',
            'uses' => config('laravel-page-module.controller.page_api').'@detail'
        ]);
    }
    // get page category edit data for modal edit
    if (config('laravel-page-module.routes.api.page_fastEdit')) {
        Route::post('page/{id}/fast-edit', [
            'as' => 'api.page.fastEdit',
            'uses' => config('laravel-page-module.controller.page_api').'@fastEdit'
        ]);
    }
    // api publish page
    if (config('laravel-page-module.routes.api.page_publish')) {
        Route::post('page/{' . config('laravel-page-module.url.page') . '}/publish', [
            'as' => 'api.page.publish',
            'uses' => config('laravel-page-module.controller.page_api').'@publish'
        ]);
    }
    // api not publish page
    if (config('laravel-page-module.routes.api.page_notPublish')) {
        Route::post('page/{' . config('laravel-page-module.url.page') . '}/not-publish', [
            'as' => 'api.page.notPublish',
            'uses' => config('laravel-page-module.controller.page_api').'@notPublish'
        ]);
    }
    // api update page content
    if (config('laravel-page-module.routes.api.page_contentUpdate')) {
        Route::post('pages/{' . config('laravel-page-module.url.page') . '}/content-update', [
            'as' => 'api.page.contentUpdate',
            'uses' => config('laravel-page-module.controller.page_api').'@contentUpdate'
        ]);
    }
    if (config('laravel-page-module.routes.api.page')) {
        Route::resource(config('laravel-page-module.url.page'), config('laravel-page-module.controller.page_api'), [
            'names' => [
                'index' => 'api.page.index',
                'store' => 'api.page.store',
                'update' => 'api.page.update',
                'destroy' => 'api.page.destroy',
            ]
        ]);
    }
    // category pages
    if (config('laravel-page-module.routes.api.category_pages_index')) {
        Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page'), [
            'middleware' => 'related_model:PageCategory,pages',
            'as' => 'api.page_category.page.index',
            'uses' => config('laravel-page-module.controller.page_api').'@index'
        ]);
    }
});
