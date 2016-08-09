<?php
//max level nested function 100 hatasını düzeltiyor
ini_set('xdebug.max_nesting_level', 300);

/*
|--------------------------------------------------------------------------
| Page Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => config('laravel-page-module.url.admin_url_prefix'),
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers'
], function()
{
    /*==========  Page Category Module  ==========*/
    Route::resource(config('laravel-page-module.url.page_category'), 'PageCategoryController', [
        'names' => [
            'index'     => 'admin.page_category.index',
            'create'    => 'admin.page_category.create',
            'store'     => 'admin.page_category.store',
            'show'      => 'admin.page_category.show',
            'edit'      => 'admin.page_category.edit',
            'update'    => 'admin.page_category.update',
            'destroy'   => 'admin.page_category.destroy',
        ]
    ]);

    /*==========  Page Module  ==========*/
    // admin publish page
    Route::get('page/{' . config('laravel-page-module.url.page') . '}/publish',  [
        'as' => 'admin.page.publish',
        'uses' => 'PageController@publish'
    ]);
    // admin not publish page
    Route::get('page/{' . config('laravel-page-module.url.page') . '}/not-publish',  [
        'as' => 'admin.page.notPublish',
        'uses' => 'PageController@notPublish'
    ]);
    Route::resource(config('laravel-page-module.url.page'), 'PageController', [
        'names' => [
            'index'     => 'admin.page.index',
            'create'    => 'admin.page.create',
            'store'     => 'admin.page.store',
            'show'      => 'admin.page.show',
            'edit'      => 'admin.page.edit',
            'update'    => 'admin.page.update',
            'destroy'   => 'admin.page.destroy',
        ]
    ]);

    /*==========  Category pages  ==========*/
    // admin publish page
    Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page') . '/{' . config('laravel-page-module.url.page') . '}/publish',  [
        'as' => 'admin.page_category.page.publish',
        'uses' => 'PageController@publish'
    ]);
    // admin not publish page
    Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page') . '/{' . config('laravel-page-module.url.page') . '}/not-publish',  [
        'as' => 'admin.page_category.page.notPublish',
        'uses' => 'PageController@notPublish'
    ]);
    Route::resource(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page'), 'PageController', [
        'names' => [
            'index'     => 'admin.page_category.page.index',
            'create'    => 'admin.page_category.page.create',
            'store'     => 'admin.page_category.page.store',
            'show'      => 'admin.page_category.page.show',
            'edit'      => 'admin.page_category.page.edit',
            'update'    => 'admin.page_category.page.update',
            'destroy'   => 'admin.page_category.page.destroy',
        ]
    ]);
});



/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'api',
    'middleware' => config('laravel-page-module.url.middleware'),
    'namespace' => 'ErenMustafaOzdal\LaravelPageModule\Http\Controllers'
], function()
{
    /*==========  Page Category Module  ==========*/
    // api roles
    Route::post('page-category/models',  [
        'as' => 'api.page_category.models',
        'uses' => 'PageCategoryApiController@models'
    ]);
    // api group action
    Route::post('page-category/group-action',  [
        'as' => 'api.page_category.group',
        'uses' => 'PageCategoryApiController@group'
    ]);
    // data table detail row
    Route::get('page-category/{id}/detail',  [
        'as' => 'api.page_category.detail',
        'uses' => 'PageCategoryApiController@detail'
    ]);
    // get page category edit data for modal edit
    Route::post('page-category/{id}/fast-edit',  [
        'as' => 'api.page_category.fastEdit',
        'uses' => 'PageCategoryApiController@fastEdit'
    ]);
    Route::resource(config('laravel-page-module.url.page_category'), 'PageCategoryApiController', [
        'names' => [
            'index'     => 'api.page_category.index',
            'store'     => 'api.page_category.store',
            'update'    => 'api.page_category.update',
            'destroy'   => 'api.page_category.destroy',
        ]
    ]);


    /*==========  Page Module  ==========*/
    // api group action
    Route::post('page/group-action',  [
        'as' => 'api.page.group',
        'uses' => 'PageApiController@group'
    ]);
    // data table detail row
    Route::get('page/{id}/detail',  [
        'as' => 'api.page.detail',
        'uses' => 'PageApiController@detail'
    ]);
    // get page category edit data for modal edit
    Route::post('page/{id}/fast-edit',  [
        'as' => 'api.page.fastEdit',
        'uses' => 'PageApiController@fastEdit'
    ]);
    // api publish page
    Route::post('page/{' . config('laravel-page-module.url.page') . '}/publish',  [
        'as' => 'api.page.publish',
        'uses' => 'PageApiController@publish'
    ]);
    // api not publish page
    Route::post('page/{' . config('laravel-page-module.url.page') . '}/not-publish',  [
        'as' => 'api.page.notPublish',
        'uses' => 'PageApiController@notPublish'
    ]);
    // api update page content
    Route::post('pages/{' . config('laravel-page-module.url.page') . '}/content-update',  [
        'as' => 'api.page.contentUpdate',
        'uses' => 'PageApiController@contentUpdate'
    ]);
    Route::resource(config('laravel-page-module.url.page'), 'PageApiController', [
        'names' => [
            'index'     => 'api.page.index',
            'store'     => 'api.page.store',
            'update'    => 'api.page.update',
            'destroy'   => 'api.page.destroy',
        ]
    ]);
    // category pages
    Route::get(config('laravel-page-module.url.page_category') . '/{id}/' . config('laravel-page-module.url.page'),  [
        'as' => 'api.page_category.page.index',
        'uses' => 'PageApiController@index'
    ]);
});
