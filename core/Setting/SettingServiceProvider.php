<?php

namespace Core\Setting;

use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('setting', function() {
            return new SettingStorage(
                $this->app->make('Illuminate\Cache\Repository')
            );
        });
    }

    public function boot()
    {
        require __DIR__ . '/helpers.php';

        $this->publishes([
            __DIR__.'/Database/Migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
