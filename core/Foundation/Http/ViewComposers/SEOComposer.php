<?php

namespace Core\Foundation\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class SEOComposer
{
    protected $configTitleFormat = 'seo.%s.title';
    protected $configDescriptionFormat = 'seo.%s.description';

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($title = config($this->getConfigTitleName())) {
            $view->with('seo_title', $title);
        }

        if ($title = config($this->getConfigTitleName())) {
            $view->with('seo_description', $title);
        }
    }

    protected function getConfigTitleName()
    {
        return sprintf($this->configTitleFormat, Route::currentRouteName());
    }

    protected function getConfigDescriptionName()
    {
        return sprintf($this->configDescriptionFormat, Route::currentRouteName());
    }
}