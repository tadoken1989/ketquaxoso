<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/14/18
 * Time: 10:37 AM
 */

namespace App\Helpers\Dom\Factory;


use App\Helpers\Dom\ClassHelpers;
use App\Helpers\Dom\IdHelpers;
use App\Helpers\Dom\TagNameHelpers;

class DomFactory extends DomHelpersFactory
{
    public function createType($mode, $finder)
    {
        switch (strtolower($mode)) {
            case 'class':
                return new ClassHelpers($finder);
                break;
            case 'id':
                return new IdHelpers($finder);
                break;
            case 'tag_name':
                return new TagNameHelpers($finder);
                break;
            default:
                return ;
                break;
        }
    }
}