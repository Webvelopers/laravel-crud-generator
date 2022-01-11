<?php

namespace Webvelopers\LaravelCRUDGenerator;

use Illuminate\Support\ServiceProvider;
use Webvelopers\LaravelCRUDGenerator\Console\LaravelCRUDGeneratorCommand;

class LaravelCRUDGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaravelCRUDGeneratorCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}