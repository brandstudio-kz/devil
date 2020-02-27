<?php

namespace BrandStudio\Devil;

use Illuminate\Support\ServiceProvider;
use BrandStudio\Devil\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class DevilServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/devil.php', 'devil'
        );

        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'brandstudio');

        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/devil.php' => config_path('devil.php'),
            ]);
        }
    }

}
