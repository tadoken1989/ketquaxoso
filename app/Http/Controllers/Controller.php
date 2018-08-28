<?php

namespace App\Http\Controllers;

use Cocur\Slugify\Slugify;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $redirectToAdmin = '/admin';
    protected $isAdminField = 'role';
    protected $isAdminValue = 'admin';
    protected $slugify;
    protected $status;
    public function __construct()
    {
        $this->slugify = new Slugify();
        $this->status = env('STATUS',1);
    }


    public function parseDate($date, $format = 'Y-m-d')
    {
        return date($format, (strtotime($date)));
    }

}
