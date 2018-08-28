<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Traits\Crawl;
use App\Http\Controllers\Traits\Lib;
use App\Models\LotteryResultDetail;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\StatisticsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class StatisticsFastController extends Controller
{
    use  Lib,Crawl;

    // Thống kê nhanh
    public function fast(Request $request)
    {
        $data = [];
        $numbers = null;
        $start_date = date('Y-m-d', strtotime("2014-01-01"));
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d', strtotime("-1 days"));
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $numbers = $request->get('numbers');
            $start_date = parseDate($request->get('begin_date'));
            $end_date = parseDate($request->get('end_date'));
            $date = parseDate($request->get('date'));
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        for ($i = 0; $i < 100; $i++) {
            $num_check = sprintf('%02d', intval($i));
            $data[$num_check]['latest'] = $this->getLatestDayLottoReturnWhereBetween($provinceAlias, $listProvince, $num_check, $start_date, $end_date);
            $data[$num_check]['counter'] = $this->totalCountLotto($provinceAlias, $listProvince, $num_check, $start_date, $end_date);
        }

        return view('frontend.statistics.fast', compact('data', 'numbers', 'provinceAlias', 'results', 'date', 'start_date', 'end_date'));
    }

    // Thống kê tần suất bộ số
    public function frequencySetOfNumbers(Request $request)
    {
        $data = [];
        $numbers = null;
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d');
        $day_count = 500;
        $special_only = 'off';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $day_count = $request->get('day_count');
            $special_only = $request->get('special_only');
            if (!$special_only) {
                $special_only = 'off';
            }
        }
        $start_date = date('Y-m-d', strtotime("-$day_count days"));
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $total = 0;
        for ($i = 0; $i < 100; $i++) {
            $num_check = sprintf('%02d', intval($i));
            $data[$num_check]['total_day'] = $this->getTotalDayReturn($provinceAlias, $listProvince, $num_check, $start_date, $end_date, $special_only);
            $data[$num_check]['total_lotto'] = $this->getTotalLottoReturn($provinceAlias, $listProvince, $num_check, $start_date, $end_date, $special_only);
            $total = $total + $data[$num_check]['total_lotto'];
        }

        $data = array_sort_key($data,'total_day',SORT_DESC);

        return view('frontend.statisticsFast.frequencySetOfNumbers', compact('data', 'provinceAlias', 'day_count', 'special_only', 'total'));
    }

    // Thống kê tổng hợp (chưa xong)
    public function general(Request $request)
    {
        $data = $items = $sort_arr = [];
        $numbers = null;
        $begin_date = date('Y-m-d', strtotime("2014-01-01"));
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d', strtotime("-1 days"));
        $special_only = 'off';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $numbers = $request->get('numbers');
            $begin_date = parseDate($request->get('begin_date'));
            $end_date = parseDate($request->get('end_date'));
            $date = parseDate($request->get('date'));
            $special_only = $request->get('special_only');
            if (!$special_only) {
                $special_only = 'off';
            }
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        for ($i = 0; $i < 100; $i++) {
            $num_check = sprintf('%02d', intval($i));
            $data[$num_check]['latest'] = $this->getLatestDayLottoReturnWhereBetween($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only);
            $data[$num_check]['counter'] = $this->totalCountLotto($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only);
        }
        // lấy theo đầu số
        for ($j = 0; $j < 10; $j++) {
            $num_check = intval($j);
            $items['head'][$num_check] = $this->countHeadWhereBetweenDate($num_check, $begin_date, $end_date, $listProvince, $provinceAlias, $special_only);
            $items['foot'][$num_check] = $this->countFootWhereBetweenDate($num_check, $begin_date, $end_date, $listProvince, $provinceAlias, $special_only);
        }
        return view('frontend.statisticsFast.general', compact('data', 'items', 'numbers', 'provinceAlias', 'results', 'date', 'begin_date', 'end_date', 'special_only'));
    }

    // cùng quay xổ số
    public function snipLottery(Request $request)
    {

        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
        }

        if ($provinceAlias == 'mien-bac') {
            $province = Province::where('region_id', 2)->first();
        } else {
            $province = Province::where('slug', trim($provinceAlias))->first();
        }

        return view('frontend.statisticsFast.snipLottery', compact('provinceAlias', 'province'));
    }

    // công cụ gộp số VIP
    public function aggregationTool()
    {
        return view('frontend.statisticsFast.aggregationTool');
    }

    // công cụ tách số VIP
    public function numberSeparatorTool()
    {
        return view('frontend.statisticsFast.numberSeparatorTool');
    }

    // công cụ lọc ghép dàn VIP
    public function transplantStretcherTool()
    {
        return view('frontend.statisticsFast.transplantStretcherTool');
    }

    // tạo nhanh dàn đặc biệt
    public function createFastSpecialArrangements()
    {
        return view('frontend.statisticsFast.createFastSpecialArrangements');
    }

    // loại dàn đặc biệt
    public function specialArrangement()
    {
        return view('frontend.statisticsFast.specialArrangement');

    }

    // lô xiên tự động
    public function obliqueAutomatic()
    {
        return view('frontend.statisticsFast.obliqueAutomatic');
    }
    // thong ke theo ngay
    public function statisticsByDay(Request $request)
    {
        $data = [];
        $provinceAlias = 'mien-bac';
        $day_of_week = get_index_by_day_name(date('l'));
        $day_method = 4;
//        $end_date = date('Y-m-d');
//        $special_only = 'off';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $day_method = $request->get('day_method');
            $day_of_week = $request->get('day_of_week');
        }
//        $begin_date = date('Y-m-d',strtotime("-$day_method weeks"));
//        if ($provinceAlias == 'mien-bac') {
//            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
//        } else {
//            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
//        }
//        for ($i = 0; $i < 100; $i++) {
//            $num_check = sprintf('%02d', intval($i));
//            // lay ngay ve gan nhat
//            $data[$num_check]['latest'] = $this->getLatestDayLottoReturnWhereBetween($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only);
//            // lay  tong so lan ve
//            $data[$num_check]['counter'] = $this->totalCountLotto($provinceAlias, $listProvince, $num_check,$begin_date,$end_date,$special_only);
//        }
        $raw = $this->crawlStatisticsByDay($provinceAlias,$day_of_week,$day_method);
        return view('frontend.statisticsFast.statisticsByDay',compact('data','provinceAlias','day_of_week','day_method','raw'));
    }

    // thong ke tong

    public function statisticsTotalLotto(Request $request) {

        $data = $item = [];
        $begin_date = date('Y-m-d', strtotime("2014-01-01"));
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d', strtotime("-1 days"));
        $special_only = 'off';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $begin_date = parseDate($request->get('begin_date'));
            $end_date = parseDate($request->get('end_date'));
            $date = parseDate($request->get('date'));
            $special_only = $request->get('special_only');
            if (!$special_only) {
                $special_only = 'off';
            }
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
//        for ($i = 0; $i < 100; $i++) {
//            $num_check = sprintf('%02d', intval($i));
//            $data[$num_check]['latest'] = $this->getLatestDayLottoReturnWhereBetween($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only);
//            $data[$num_check]['counter'] = $this->totalCountLotto($provinceAlias, $listProvince, $num_check, $begin_date, $end_date, $special_only);
//        }
        $latestData = ResultLottery::where('status',1)->whereIn('province_id',$listProvince)->orderBy('result_lotteries.result_day','DESC')->first();
        $day = $this->parseDate($latestData->result_day);

        $raw = $this->crawlStatisticsTotalLotto($provinceAlias, $listProvince, $num_check = null, $begin_date, $end_date, $special_only);

        return view('frontend.statisticsFast.statisticsTotalLotto', compact('data','raw', 'provinceAlias', 'date', 'begin_date', 'end_date', 'special_only','day'));

    }

    public function statisticsImportant(Request $request) {
        $data = $item = [];
        $raw = '';
        $provinceAlias = 'mien-bac';
        $special_only = 'off';
        $limit = 30;
        $begin_date = date('Y-m-d', strtotime("-30 days"));
        $end_date = date('Y-m-d');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        for ($i = 0; $i < 100; $i++) {
            $num_check = sprintf('%02d', intval($i));
            // lay ngay ve gan nhat
            $data[$num_check]['latest'] = $this->getLatestDayLottoReturn($provinceAlias, $listProvince, $num_check,'DESC');
            // lay  tong so lan ve
            $data[$num_check]['counter'] = $this->totalCountLotto($provinceAlias, $listProvince, $num_check,$begin_date,$end_date,$special_only);
        }
        $raw = $this->crawlStatisticsImportant($provinceAlias,$limit);
        return view('frontend.statisticsFast.statisticsImportant', compact('data','item', 'provinceAlias','raw'));
    }

}
