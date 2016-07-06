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
