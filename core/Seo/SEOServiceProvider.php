<?php

namespace Core\Seo;

use Illuminate\Support\ServiceProvider;

class SEOServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */

    protected $defer = true;

    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/Resources/views'), 'html');
    }

    public function register()
    {
        $this->registerSEO();
        $this->app->alias('seo', 'Core\Seo\SEO');
    }

    protected function registerSEO()
    {
        $this->app->singleton('seo', function() {
            return new SEO();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('seo' ,'Core\Html\SEO');
    }
}
