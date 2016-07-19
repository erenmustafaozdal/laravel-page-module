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
    Route::resource(config('laravel-page-module.url.page_categories'), 'PageCategoryController', [
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
    /*==========  Page Module  ==========*/
    // api group action
    Route::post('page/group-action',  [
        'as' => 'api.page.group',
        'uses' => 'PageApiController@group'
    ]);
    // get page edit data for modal edit
    Route::post('page/{' . config('laravel-page-module.url.page') . '}/fast-edit',  [
        'as' => 'api.page.fastEdit',
        'uses' => 'PageApiController@fastEdit'
    ]);
    Route::resource(config('laravel-page-module.url.page'), 'PageApiController', [
        'names' => [
            'index'     => 'api.page.index',
            'store'     => 'api.page.store',
            'update'    => 'api.page.update',
            'destroy'   => 'api.page.destroy',
        ]
    ]);
});
