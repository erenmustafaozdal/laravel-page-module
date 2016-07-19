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
    // api group action
    Route::post('page-category/group-action',  [
        'as' => 'api.page_category.group',
        'uses' => 'PageCategoryApiController@group'
    ]);
    // get page category edit data for modal edit
    Route::post('page-category/{' . config('laravel-page-module.url.page_category') . '}/fast-edit',  [
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
});
