<?php

namespace Core\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The providers package.
     *
     * @var array
     */
    protected $providers = [
        \Core\Setting\SettingServiceProvider::class,
        \Core\Seo\SEOServiceProvider::class,
    ];

    /**
     * The facades package.
     *
     * @var array
     */
    protected $facades = [
        'SEO'       => \Core\Seo\SEOFacade::class,
        'Setting'   => \Core\Setting\Facades\SettingFacade::class,
    ];

    /**
     * The available shortname.
     *
     * @var array
     */
    protected $commands = [
        \Core\Foundation\Console\BuildCommand::class,
    ];

    /**
     * Register the providers.
     */
    public function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register the facades.
     */
    public function registerFacades()
    {
        AliasLoader::getInstance($this->facades);
    }

    /**
     * Register the commands.
     */
    public function registerCommands()
    {
        foreach ($this->commands as $command) {
            $this->commands($command);
        }
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        require_once __DIR__ . '/../helpers.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProviders();
        $this->registerFacades();
        $this->registerCommands();
    }
}
