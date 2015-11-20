<?php

namespace Ravaelles\Filterable;

use Illuminate\Support\ServiceProvider;

class FilterableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $appViewsDir = base_path('resources/views/packages/filterable/');

        // Establish Views Namespace
        if (is_dir($appViewsDir)) {
            // The package views have been published - use those views.
            $this->loadViewsFrom($appViewsDir, 'Filterable');
        } else {
            // The package views have not been published. Use the defaults.
            $this->loadViewsFrom(__DIR__ . '/../views', 'Filterable');
            $this->publishes([
                __DIR__ . '/../views/filtering.blade.php' => ($appViewsDir . 'filtering.blade.php'),
            ]);
        }

//        $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'filterable');
//        $this->loadViewsFrom(__DIR__ . '/../views', 'filterable');
//        $this->loadViewsFrom(__DIR__ . '/views', 'filterable');
//		$this->setupRoutes($this->app->router);
        // this  for conig
//        $this->publishes([
//                __DIR__.'/config/contact.php' => config_path('contact.php'),
//        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}