<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:39 AM
 */

namespace App\Helpers\Dom;


class ClassHelpers extends Attributes
{
    protected $className;
    protected $queryBuilder;

    public function __construct($finder)
    {
        parent::__construct($finder);
        $this->className = $this->getFinder();
    }

    public function find()
    {
        $this->queryBuilder = new \DomXPath($this->dom);
        return $this->queryBuilder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $this->className ')]");
    }
}