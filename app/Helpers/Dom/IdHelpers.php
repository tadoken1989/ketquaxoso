<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:39 AM
 */

namespace App\Helpers\Dom;


class IdHelpers extends Attributes
{
    public function find()
    {
        return $this->dom->getElementById($this->getFinder());
    }
}