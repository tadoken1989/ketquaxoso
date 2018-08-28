<?php

namespace App\Http\Controllers\Frontend;

use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrintController extends Controller
{
    public function index()
    {
        $date = date('Y-m-d');
        if (request()->query('ngay') && (preg_match('/[\d]{4}-[\d]{2}-[\d]{2}/', request()->query('ngay')) || preg_match('/[\d]{2}-[\d]{2}-[\d]{4}/', request()->query('ngay')))) {
            $date = request()->query('ngay');
            $date = $this->parseDate($date);
        }
        $listProvinces = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        if (request()->query('ngay') == null) {
            $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                ->whereIn('province_id', $listProvinces)
                ->where('result_day', $date)
                ->orderByDesc('result_day')
                ->where('status', $this->status)
                ->first();
            if (!$resultLottery) {
                $date = date('Y-m-d', strtotime("-1 days"));
                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->whereIn('province_id', $listProvinces)
                    ->where('result_day', $date)
                    ->orderByDesc('result_day')
                    ->where('status', $this->status)
                    ->first();
            }
        } else {
            $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                ->whereIn('province_id', $listProvinces)
                ->where('status', $this->status)
                ->where('result_day', $date)
                ->first();
        }
        return view('frontend.print.index', compact('resultLottery'));
    }
}
