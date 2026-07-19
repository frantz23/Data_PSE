<?php

namespace App\Providers;

use EsperoSoft\Artisan\Console\Commands\MakeCrudCommand;
use EsperoSoft\Artisan\Console\Commands\MakeEntityCommand;
use EsperoSoft\Artisan\Console\Commands\MakeServiceCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->commands([
            MakeEntityCommand::class,
            MakeCrudCommand::class,
            MakeServiceCommand::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
