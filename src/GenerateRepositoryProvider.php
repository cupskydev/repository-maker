<?php

namespace App\Providers;

use App\Console\Commands\GenerateRepositoryCommand;
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
