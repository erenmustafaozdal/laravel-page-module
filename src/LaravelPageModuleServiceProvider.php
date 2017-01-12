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

        $router = $this->app['router'];
        // model binding
        $router->model(config('laravel-page-module.url.page'),  'App\Page');
        $router->model(config('laravel-page-module.url.page_category'),  'App\PageCategory');
    }
}
