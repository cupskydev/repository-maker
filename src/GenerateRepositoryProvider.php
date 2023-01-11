<?php

namespace Cupskydev\RepositoryMaker;

use Cupskydev\RepositoryMaker\Commands\GenerateRepositoryCommand;
use Illuminate\Support\ServiceProvider;

class GenerateRepositoryProvider extends ServiceProvider
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
            GenerateRepositoryCommand::class,
        ]);
    }
}
