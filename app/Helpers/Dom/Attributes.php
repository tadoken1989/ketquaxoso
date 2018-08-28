<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:40 AM
 */

namespace App\Helpers\Dom;


abstract class Attributes
{
    private $finder;
    protected $dom;

    public function __construct($finder)
    {
        $this->finder = $finder;
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
    }

    public function getFinder()
    {
        return $this->finder;
    }

    public function loadHtml($document)
    {
        $internalErrors = libxml_use_internal_errors(true);
        $this->dom->loadHTML($document);
        libxml_use_internal_errors($internalErrors);
        return $this;
    }
}