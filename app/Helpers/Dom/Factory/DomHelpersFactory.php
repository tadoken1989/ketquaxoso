<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:25 AM
 */

namespace App\Helpers\Dom\Factory;

use Carbon\Carbon;
use Cache;

abstract class DomHelpersFactory
{
    abstract public function createType($mode, $finder);
}