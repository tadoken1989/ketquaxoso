<?php

namespace App\Http\Controllers\Traits;

use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait Lib
{

    // config cap lotto

    protected $config_two_lotto = [
        '00' => '55',
        '01' => '10',
        '02' => '20',
        '03' => '30',
        '04' => '40',
        '05' => '40',
        '06' => '60',
        '07' => '70',
        '08' => '80',
        '09' => '90',
        '11' => '66',
        '12' => '21',
        '13' => '31',
        '14' => '41',
        '15' => '51',
        '16' => '61',
        '17' => '71',
        '18' => '81',
        '19' => '91',
        '22' => '77',
        '23' => '32',
        '24' => '42',
        '25' => '52',
        '26' => '62',
        '27' => '72',
        '28' => '82',
        '29' => '92',
        '33' => '88',
        '34' => '43',
        '35' => '53',
        '36' => '63',
        '37' => '73',
        '38' => '83',
        '39' => '93',
        '44' => '99',
        '45' => '54',
        '46' => '64',
        '47' => '74',
        '48' => '84',
        '49' => '94',
        '56' => '65',
        '57' => '75',
        '58' => '85',
        '59' => '95',
        '67' => '76',
        '68' => '86',
        '69' => '96',
        '78' => '87',
        '79' => '97',
        '89' => '98',
    ];

    /*
       |--------------------------------------------------------------------------
       | Thong ke vip
       |--------------------------------------------------------------------------|
       */

    // lay ngay ve gan nhat cua 1 so

    protected function getLatestDayLottoReturn($provinceAlias, $listProvince, $numCheck = null, $orderBy = 'DESC')
    {
        $numCheck = sprintf('%02d', intval($numCheck));
        $data = Cache::remember('get_latest_day_lotto_return_' . md5($provinceAlias) . '_' . md5($numCheck), env('SHORT_CACHE_EXPIRED', 240), function () use ($listProvince, $numCheck, $orderBy) {
            $data = [];
            $lottery = \App\Models\LotteryResultDetail::where('lottery_result_details.prize_number_lotto', $numCheck)
                ->join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->whereIn('result_lotteries.province_id', $listProvince)
                ->orderBy('result_lotteries.result_day', $orderBy)
                ->first();
            if ($lottery) {
                $data['day'] = $lottery->result_day;
                $data['numbers'] = $numCheck;
            }
            return $data;
        });
        return $data;
    }

    // lay tong do lan xuat hien cua mot dau so theo 1 ngay

    protected function countHead($number, $day, $list_province, $provinceAlias)
    {
        return Cache::remember('countHead_' . md5($number) . '_' . md5($day) . '_' . md5($provinceAlias), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $day, $list_province) {
            $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->where('lottery_result_details.status', env('STATUS', 1))
                ->whereIn('result_lotteries.province_id', $list_province)
                ->where('result_lotteries.type', 'normal')
                ->where('lottery_result_details.head_lotto', $number)
                ->where('result_lotteries.result_day', $day)
                ->count();
            return $count;
        });
    }

    // lay tong do lan xuat hien cua mot duoi so theo 1 ngay


    protected function countFoot($number, $day, $list_province, $provinceAlias)
    {
        return Cache::remember('countFoot_' . md5($number) . '_' . md5($day) . '_' . md5($provinceAlias), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $day, $list_province) {
            $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->where('lottery_result_details.status', env('STATUS', 1))
                ->whereIn('result_lotteries.province_id', $list_province)
                ->where('result_lotteries.type', 'normal')
                ->where('lottery_result_details.foot_lotto', $number)
                ->where('result_lotteries.result_day', $day)
                ->count();
            return $count;
        });
    }

    // lay tong so len xuat hien cua tong(dau + duoi) trong 1 ngay

    protected function countTotalHeadFoot($number, $day, $list_province, $provinceAlias)
    {

        return Cache::remember('countTotalHeadFoot_' . md5($number) . '_' . md5($day) . '_' . md5($provinceAlias), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $day, $list_province) {
            $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->where('lottery_result_details.status', env('STATUS', 1))
                ->whereIn('result_lotteries.province_id', $list_province)
                ->select(DB::raw('COUNT(*) as counter'), 'result_lotteries.*', 'lottery_result_details.*', DB::raw('(lottery_result_details.foot_lotto + lottery_result_details.head_lotto)%10 as total'))
                ->where('result_lotteries.type', 'normal')
                ->groupBy('total')
                ->where('result_lotteries.result_day', $day)
                ->having('total', $number)
                ->first();
            if ($count) {
                return $count->counter;
            } else {
                return 0;
            }
        });
    }

    // lay so theo tong

    protected function getTotalHeadFoot($number, $day, $list_province, $provinceAlias)
    {

        return Cache::remember('getTotalHeadFoot_' . md5($number) . '_' . md5($day) . '_' . md5($provinceAlias), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $day, $list_province) {
            $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                ->where('lottery_result_details.status', env('STATUS', 1))
                ->whereIn('result_lotteries.province_id', $list_province)
                ->select('result_lotteries.*', 'lottery_result_details.*', DB::raw('(lottery_result_details.foot_lotto + lottery_result_details.head_lotto)%10 as total'))
                ->where('result_lotteries.type', 'normal')
                ->where('result_lotteries.result_day', $day)
                ->having('total', $number)
                ->get()->toArray();
            if ($count) {
                return $count;
            } else {
                return [];
            }
        });
    }

    // lay array tu khoang ngay duoc chon

    protected function getArrayLoopFromStartDateEndDate($start, $end): array
    {
        $begin = new \DateTime($start);
        $end = new \DateTime($end);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $array = [];
        foreach ($period as $dt) {
            array_push($array, $dt->format("Y-m-d"));
        }
        return $array;
    }


    /*
    |--------------------------------------------------------------------------
    | Thong ke nhanh
    |--------------------------------------------------------------------------|
    */

    //  lay tong so lan ve cua 1 so trong 1 quang thoi gian

    protected function totalCountLotto($provinceAlias, $listProvince, $numCheck = null, $start_date, $end_date, $special_only = 'off')
    {
        $numCheck = sprintf('%02d', intval($numCheck));
        return Cache::remember('totalCountLotto_' . md5($provinceAlias) . '_' . md5($numCheck) . md5($start_date) . md5($end_date) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($listProvince, $numCheck, $start_date, $end_date, $special_only) {
            if ($special_only == 'off') {
                $count = \App\Models\LotteryResultDetail::where('lottery_result_details.prize_number_lotto', $numCheck)
                    ->join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->where('result_lotteries.type', 'normal')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->count();
            } else {
                $count = \App\Models\LotteryResultDetail::where('lottery_result_details.prize_number_lotto', $numCheck)
                    ->join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->where('result_lotteries.type', 'normal')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->where('lottery_result_details.prize', 0)
                    ->count();
            }
            return $count;
        });
    }

    // lay ngay ve gan nhat cua 1 so trong 1 quãng thời gian truyền vô

    protected function getLatestDayLottoReturnWhereBetween($provinceAlias, $listProvince, $numCheck = null, $start_date, $end_date, $special_only = 'off')
    {
        $numCheck = sprintf('%02d', intval($numCheck));
        return Cache::remember('getLatestDayLottoReturnWhereBetween_' . md5($provinceAlias) . '_' . md5($numCheck) . md5($start_date) . md5($end_date) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($provinceAlias, $listProvince, $numCheck, $start_date, $end_date, $special_only) {
            if ($special_only == 'off') {
                $data = [];
                $lottery = \App\Models\LotteryResultDetail::where('lottery_result_details.prize_number_lotto', $numCheck)
                    ->join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->where('result_lotteries.type', 'normal')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->first();
            } else {
                $data = [];
                $lottery = \App\Models\LotteryResultDetail::where('lottery_result_details.prize_number_lotto', $numCheck)
                    ->join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->where('result_lotteries.type', 'normal')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->where('lottery_result_details.prize', 0)
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->first();
            }
            if ($lottery) {
                $data['day'] = $lottery->result_day;
                $data['numbers'] = $numCheck;
            } else {
                $data['day'] = $end_date;
                $data['numbers'] = $numCheck;
            }
            return $data;
        });
    }
//  tổng số ngày về của 1 số trong 1 khoảng thời gian truyen vô

    protected function getTotalDayReturn($provinceAlias, $listProvince, $numCheck = null, $start_date, $end_date, $special_only = 'off')
    {
        $num_check = sprintf('%02d', intval($numCheck));
        return Cache::remember('getTotalDayReturn_update2306_' . md5($provinceAlias) . '_' . md5($num_check) . '_' . md5($start_date) . '_' . md5($end_date) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($listProvince, $num_check, $start_date, $end_date, $special_only) {
            if ($special_only == 'off') {
                $total_day_return = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.prize_number_lotto', $num_check)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->groupBy('lottery_result_details.result_lottery_id')
                    ->get()
                    ->toArray();
            } else {
                $total_day_return = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.prize_number_lotto', $num_check)
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.prize', 0)
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->groupBy('lottery_result_details.result_lottery_id')
                    ->get()
                    ->toArray();
            }
            return count($total_day_return);
        });
    }

// tổng số lần về 1 số trong 1 khoảng thời gian truyen vô

    protected function getTotalLottoReturn($provinceAlias, $listProvince, $numCheck = null, $start_date, $end_date, $special_only = 'off')
    {
        $num_check = sprintf('%02d', intval($numCheck));
        return Cache::remember('getTotalLottoReturn_update2306_' . md5($provinceAlias) . '_' . md5($num_check) . '_' . md5($start_date) . '_' . md5($end_date) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($listProvince, $num_check, $start_date, $end_date, $special_only) {
            if ($special_only == 'off') {
                $total_lotto_return = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.prize_number_lotto', $num_check)
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->where('result_lotteries.type', 'normal')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->count();
            } else {
                $total_lotto_return = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.prize_number_lotto', $num_check)
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->where('lottery_result_details.prize', 0)
                    ->where('result_lotteries.type', 'normal')
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->count();
            }
            return $total_lotto_return;
        });
    }

    // lay tong do lan xuat hien cua mot dau so theo 1 ngay

    protected function countHeadWhereBetweenDate($number, $start_date, $end_date, $list_province, $provinceAlias, $special_only = 'off')
    {
        return Cache::remember('countHeadWhereBetweenDate_' . md5($number) . '_' . md5($start_date) . '_' . md5($end_date) . '_' . md5($provinceAlias) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $start_date, $end_date, $list_province, $special_only) {
            if ($special_only == 'off') {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.head_lotto', $number)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->count();
            } else {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.prize', 0)
                    ->where('lottery_result_details.head_lotto', $number)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->count();
            }
            return $count;
        });
    }

// lay tong do lan xuat hien cua mot duoi so theo khoang thoi gian truyen vo

    protected function countFootWhereBetweenDate($number, $start_date, $end_date, $list_province, $provinceAlias, $special_only = 'off')
    {
        return Cache::remember('countFootWhereBetweenDate_' . md5($number) . '_' . md5($start_date) . '_' . md5($end_date) . '_' . md5($provinceAlias) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $start_date, $end_date, $list_province, $special_only) {
            if ($special_only == 'off') {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.foot_lotto', $number)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->count();
            } else {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->where('lottery_result_details.prize', 0)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.foot_lotto', $number)
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->count();
            }
            return $count;
        });
    }

// lay tong so len xuat hien cua tong(dau + duoi) trong  khoang thoi gian truyen vo

    protected function countTotalHeadFootWhereBetweenDate($number, $start_date, $end_date, $list_province, $provinceAlias, $special_only = 'off')
    {

        return Cache::remember('countTotalHeadFootWhereBetweenDate_' . md5($number) . '_' . md5($start_date) . '_' . md5($end_date) . '_' . md5($provinceAlias) . '_' . md5($special_only), env('LONG_CACHE_EXPIRED', 1440), function () use ($number, $start_date, $end_date, $list_province, $special_only) {
            if ($special_only == 'off') {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->select(DB::raw('COUNT(*) as counter'), 'result_lotteries.*', 'lottery_result_details.*', DB::raw('(lottery_result_details.foot_lotto + lottery_result_details.head_lotto)%10 as total'))
                    ->where('result_lotteries.type', 'normal')
                    ->groupBy('total')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->having('total', $number)
                    ->first();
            } else {
                $count = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->select(DB::raw('COUNT(*) as counter'), 'result_lotteries.*', 'lottery_result_details.*', DB::raw('(lottery_result_details.foot_lotto + lottery_result_details.head_lotto)%10 as total'))
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.prize', 0)
                    ->groupBy('total')
                    ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
                    ->having('total', $number)
                    ->first();
            }
            if ($count) {
                return $count->counter;
            } else {
                return 0;
            }
        });
    }

}