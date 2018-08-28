<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Mail;
use Validator;

class AjaxController extends Controller
{
    public $countTotal = 0;

    protected $configSupportModel = [
        'user' => \App\Models\User::class,
        'result_lotteries' => \App\Models\ResultLottery::class,
        'adv' => \App\Models\Advertise::class,
    ];
    protected $res = [
        'status' => 500,
        'data' => [],
        'html' => "",
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function statusActive(Request $request)
    {
        $id = $request->get('id');
        $modelName = $request->get('model');
        if (array_key_exists($modelName, $this->configSupportModel) && !is_null($id)) {
            $modelObj = new $this->configSupportModel[$modelName];
            $obj = $modelObj->findOrFail($id);
            if ($obj) {
                $state = 0;
                if ($obj->status == 1) {
                    $obj->status = 0;
                    $state = 0;
                } else {
                    $obj->status = 1;
                    $state = 1;
                }
                if ($obj->save()) {
                    $this->res = [
                        'status' => 200,
                        'state' => $state,
                        'data' => $obj->toArray(),
                        'html' => "",
                    ];
                } else {
                    $this->res = [
                        'status' => 201,
                        'state' => $state,
                        'data' => [],
                        'html' => "",
                    ];
                }
            }
        }
        return response()->json($this->res, $this->res['status']);
    }
}
