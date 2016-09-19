<?php

namespace ErenMustafaOzdal\LaravelPageModule;

use Illuminate\Support\ServiceProvider;

class LaravelPageModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-page-module.php' => config_path('laravel-page-module.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('ErenMustafaOzdal\LaravelModulesBase\LaravelModulesBaseServiceProvider');
        $this->app->register('Mews\Purifier\PurifierServiceProvider');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-page-module.php', 'laravel-page-module'
        );
        // merge default configs with publish configs
        $this->mergeDefaultConfig();

        $router = $this->app['router'];
        // model binding
        $router->model(config('laravel-page-module.url.page'),  'App\Page');
        $router->model(config('laravel-page-module.url.page_category'),  'App\PageCategory');
    }

    /**
     * merge default configs with publish configs
     */
    protected function mergeDefaultConfig()
    {
        $config = $this->app['config']->get('laravel-page-module', []);
        $default = require __DIR__.'/../config/default.php';

        // admin page category routes
        $route = $config['routes']['admin']['page_category'];
        $default['routes']['admin']['page_category'] = $route;
        // admin page routes
        $route = $config['routes']['admin']['page'];
        $default['routes']['admin']['page'] = $route;
        $default['routes']['admin']['page_publish'] = $route;
        $default['routes']['admin']['page_notPublish'] = $route;
        // admin sub page categories pages
        $route = $config['routes']['admin']['sub_category_pages'];
        $default['routes']['admin']['category_pages'] = $route;
        $default['routes']['admin']['category_pages_publish'] = $route;
        $default['routes']['admin']['category_pages_notPublish'] = $route;

        // api page category routes
        $route = $config['routes']['api']['page_category'];
        $default['routes']['api']['page_category'] = $route;
        $default['routes']['api']['page_category_models'] = $route;
        $default['routes']['api']['page_category_group'] = $route;
        $default['routes']['api']['page_category_detail'] = $route;
        $default['routes']['api']['page_category_fastEdit'] = $route;
        // api page routes
        $model = $config['routes']['api']['page'];
        $default['routes']['api']['page'] = $model;
        // api sub page categories pages
        $subModel = $config['routes']['api']['sub_category_pages'];
        $default['routes']['api']['category_pages_index'] = $subModel;

        $default['routes']['api']['page_group'] = $model || $subModel;
        $default['routes']['api']['page_detail'] = $model || $subModel;
        $default['routes']['api']['page_fastEdit'] = $model || $subModel;
        $default['routes']['api']['page_publish'] = $model || $subModel;
        $default['routes']['api']['page_notPublish'] = $model || $subModel;
        $default['routes']['api']['page_contentUpdate'] = $model || $subModel;

        $config['routes'] = $default['routes'];

        $this->app['config']->set('laravel-page-module', $config);
    }
}
