<?php

namespace Core\Seo;

use Route;
use Request;

class SEO
{
    protected $titles = [];

    protected $description;
    
    protected $image;
    
    protected $url;

    protected $titleSeparate = ' — ';

    protected $configTitleFormat = 'seo.%s.title';

    protected $configDescriptionFormat = 'seo.%s.description';

    public function title($title = null, $prepend = true)
    {
        if (is_null($title)) {
            return $this->makeTitle();
        }

        if ($prepend) {
            array_unshift($this->titles, $title);
        } else {
            $this->titles[] = $title;
        }

        return $this;
    }

    protected function makeTitle()
    {
        return implode($this->titleSeparate, $this->titles);
    }

    public function description($description = null)
    {
        if (is_null($description)) {
            return $this->description;
        }

        $this->description = $description;
        return $this;
    }
    
    public function image($image = null)
    {
        if (is_null($image)) {
            return $this->image;
        }

        $this->image = $image;
        return $this;
    }

    public function url($url = null)
    {
        if (is_null($url)) {
            return $this->url;
        }

        $this->url = $url;
        return $this;
    }

    public function render()
    {
        if ($title = setting($this->getConfigTitleName())) {
            $this->title($title);
        }

        if (! $this->description && $description = setting($this->getConfigDescriptionName())) {
            $this->description = $description;
        }
        
        $tags[] = '<title>'.$this->makeTitle().'</title>';
        $tags[] = '<meta name="title" content="'.$this->makeTitle().'"/>';
        $tags[] = '<meta name="description" content="'.$this->description.'"/>';
        $tags[] = '<link rel="canonical" href="'.($this->url ?: Request::url()).'" />';
        if ($this->image) {
            $tags[] = '<link rel="image_src" href="'.$this->image.'" />';
        }
        
        $tags[] = '<meta property="og:title" content="'.$this->makeTitle().'" />';
        $tags[] = '<meta property="og:description" content="'.$this->description.'" />';
        $tags[] = '<meta property="og:url" content="'.($this->url ?: Request::url()).'" />';
        if ($this->image) {
            $tags[] = '<meta property="og:image" content="'.$this->image.'" />';
        }

        return implode(PHP_EOL, $tags);
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
