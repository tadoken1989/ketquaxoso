<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:39 AM
 */

namespace App\Helpers\Dom;


class TagNameHelpers extends Attributes
{
    public function __construct($finder)
    {
        parent::__construct($finder);
    }

    public function find()
    {
        return $this->dom->getElementsByTagName($this->getFinder());
    }
}