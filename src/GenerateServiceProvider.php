<?php

namespace Cupskydev\RepositoryMaker;

use Cupskydev\RepositoryMaker\Commands\GenerateServiceCommand;
use Illuminate\Support\ServiceProvider;

class GenerateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            GenerateServiceCommand::class,
        ]);
    }
}
