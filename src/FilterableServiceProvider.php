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
        $appViewsDir = base_path('resources/views/vendor/filterable/');

        // === Establish Views Namespace ===========================================================
        
        // The package views have been published - use those views.
        if (is_dir($appViewsDir)) {
            $this->loadViewsFrom($appViewsDir, 'Filterable');
        }

        // The package views have not been published. Use the defaults.        
        else {
            $this->loadViewsFrom(__DIR__ . '/../views', 'Filterable');
            $this->publishes([
                __DIR__ . '/../views/filtering.blade.php' => ($appViewsDir . 'filtering.blade.php'),
            ]);
        }
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
