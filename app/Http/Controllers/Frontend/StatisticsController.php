<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Traits\Crawl;
use App\Http\Controllers\Traits\Lib;
use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{

    use Crawl, Lib;

    public function loop(Request $request)
    {
        $data = [];
        $numbers = null;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $numbers = $request->get('numbers');
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $data = $this->getBetweenDateLottoLongerReturn($provinceAlias);
        if ($data) {
            foreach ($data as $num_check => $value) {
                $num_check = sprintf('%02d', $num_check);
                $data[$num_check]['latest'] = $this->getLatestDayLottoReturn($provinceAlias, $listProvince, $num_check, 'DESC');
            }
        }
        return view('frontend.statistics.loop', compact('data', 'provinceAlias', 'numbers'));
    }

    // thong-ke-tan-so-nhip-loto
    public function frequency(Request $request)
    {
        $list_results = [];
        $number = rand(00, 99);
        $day_ow = 7;
        $provinceAlias = 'mien-bac';
        $start_date = date('Y-m-d', strtotime("-30 days"));
        $end_date = date('Y-m-d', strtotime("-1 days"));
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $number = $request->get('number');
            $day_ow = $request->get('day_ow');
            $start_date = parseDate($request->get('begin_date'));
            $end_date = parseDate($request->get('end_date'));
        }
        $number = sprintf('%02d', $number);

        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $list_results = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->where('lottery_result_details.prize_number_lotto', $number)
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->whereBetween('result_lotteries.result_day', array($start_date, $end_date))
            ->select(DB::raw('count(*) as counter'), 'result_lotteries.*', 'lottery_result_details.*')
            ->groupBy('result_lotteries.result_day')
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->get()
            ->toArray();

        return view('frontend.statistics.frequency', compact('provinceAlias', 'number', 'start_date', 'end_date', 'day_ow', 'list_results'));
    }

//   thong-ke-tan-suat-loto
    public function rateLotto(Request $request)
    {
        $data = [];
        $count = 60;
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $count = $request->get('count');
            $date = parseDate($request->get('date'));
            if ($count > 1000) {
                $count = 100;
            }
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }

        $list_date = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->where('result_lotteries.result_day', '<=', $this->parseDate($date))
            ->select('result_lotteries.result_day')
            ->groupBy('result_lotteries.result_day')
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->limit($count)
            ->get()
            ->toArray();

        if ($list_date) {
            foreach ($list_date as $d) {
                $data[$d['result_day']] = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->where('result_lotteries.result_day', parseDate($d['result_day']))
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->pluck('lottery_result_details.prize_number_lotto')
                    ->toArray();
            }

        }
        return view('frontend.statistics.rate_lotto', compact('data', 'provinceAlias', 'count', 'date', 'list_date'));
    }

    public function rateTwoLotto(Request $request)
    {
        $data = [];
        $count = 30;
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d', strtotime("-1 days"));
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $count = $request->get('count');
            $date = parseDate($request->get('date'));
            if ($count > 1000) {
                $count = 100;
            }
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }

        $list_date = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->where('result_lotteries.result_day', '<', $this->parseDate($date))
            ->select('result_lotteries.result_day')
            ->groupBy('result_lotteries.result_day')
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->limit($count)
            ->get()
            ->toArray();

        if ($list_date) {
            foreach ($list_date as $d) {
                $data[$d['result_day']] = LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->where('result_lotteries.result_day', parseDate($d['result_day']))
                    ->whereIn('result_lotteries.province_id', $listProvince)
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->pluck('lottery_result_details.prize_number_lotto')
                    ->toArray();
            }

        }
        $list_lotto = $this->config_two_lotto;
        return view('frontend.statistics.rate_two_lotto', compact('data', 'provinceAlias', 'count', 'date', 'list_date', 'list_lotto'));
    }

    public function lottoGan(Request $request)
    {
        $data = $maxGan = [];
        $day_count = 10;
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $begin_date = date('2014-01-01');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $day_count = $request->get('day_count');
            $end_date = parseDate($request->get('end_date'));
            $begin_date = parseDate($request->get('begin_date'));
            if ($day_count > 1000) {
                $day_count = 100;
            }
        }
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $data = LotteryResultDetail::join('result_lotteries', function ($join) use ($listProvince, $begin_date, $end_date) {
            $join->on('result_lotteries.id', '=', 'lottery_result_details.result_lottery_id')
                ->where('result_lotteries.type', 'normal')->whereIn('result_lotteries.province_id', $listProvince)
                ->whereBetween('result_lotteries.result_day', array($begin_date, $end_date))
                ->orderBy('result_lotteries.result_day', 'DESC');
        })
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->select(['lottery_result_details.prize_number_lotto as number', DB::raw('MAX(result_lotteries.result_day) as latest_day'), DB::raw('MIN(DATEDIFF(NOW(),result_lotteries.result_day)) as days')])
            ->orderBy('days', 'ASC')
            ->orderBy('latest_day', 'DESC')
            ->groupBy('number')
            ->having('days', '>', $day_count)
            ->get()
            ->toArray();

        $maxGan = $this->crawlerMaxGan($provinceAlias, $begin_date, $end_date, $day_count);

        return view('frontend.statistics.lotto_gan', compact('data', 'maxGan', 'provinceAlias', 'begin_date', 'end_date', 'day_count'));
    }

    public function headFoot(Request $request)
    {
        $data = [];
        $count = 20;
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $count = $request->get('count');
            $date = parseDate($request->get('date'));
            if ($count > 1000) {
                $count = 100;
            }
        }
        $start_date = date('Y-m-d', strtotime("-$count days",strtotime($date)));
        if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        $list_date = \App\Models\ResultLottery::whereIn('result_lotteries.province_id', $listProvince)->orderBy('result_lotteries.result_day', 'DESC')->limit($count)->pluck('result_day');
        foreach ($list_date as $day) {
            for ($i = 0; $i < 10; $i++) {
                $num_check = intval($i);
                $data['head'][$day][$num_check] = $this->countHead($num_check, $day, $listProvince, $provinceAlias);
                $data['foot'][$day][$num_check] = $this->countFoot($num_check, $day, $listProvince, $provinceAlias);
                $data['totalHeadFoot'][$day][$num_check] = $this->countTotalHeadFoot($num_check, $day, $listProvince, $provinceAlias);
            }
        }
        return view('frontend.statistics.head_foot', compact('data', 'provinceAlias', 'count', 'date'));
    }

    //thong-ke-chu-ky-dac-biet

    public function special(Request $request)
    {
        $data = [];
        $provinceAlias = 'mien-bac';
        $date = date('Y-m-d', strtotime("-1 days"));
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $date = parseDate($request->get('end_date'));
        }
        /*if ($provinceAlias == 'mien-bac') {
            $listProvince = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        } else {
            $listProvince = Province::where('slug', trim($provinceAlias))->pluck('id')->toArray();
        }
        for ($i = 0; $i < 10; $i++) {
            $num_check = intval($i);
            $data['head'][$num_check]['latest'] = $this->getLatestDay($num_check, 'head_lotto', $listProvince, $date, $provinceAlias);
            $data['foot'][$num_check]['latest'] = $this->getLatestDay($num_check, 'foot_lotto', $listProvince, $date, $provinceAlias);
            $data['total'][$num_check]['latest'] = $this->getLatestDay($num_check, 'total', $listProvince, $date, $provinceAlias);
        }
        */
        $raw = $this->crawlSpecial($provinceAlias, $date);
        return view('frontend.statistics.special', compact('data', 'provinceAlias', 'date', 'raw'));
    }

    protected function getLatestDay($number, $action = 'head_lotto', $list_province, $date, $province_alias)
    {
        if ($action != 'total') {
            return Cache::remember('getLatestDay_' . md5($number) . '_' . md5($action) . '_' . md5($province_alias) . '_' . md5($date), env('LONG_CACHE_EXPIRED', 86400), function () use ($number, $action, $list_province, $date, $province_alias) {
                return LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.prize', 0)
                    ->where('lottery_result_details.' . $action, $number)
                    ->where('result_lotteries.result_day', '<', $this->parseDate($date))
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->first()->toArray();
            });
        } else {
            return Cache::remember('getLatestDay_' . md5($number) . '_' . md5($action) . '_' . md5($province_alias) . '_' . md5($date), env('LONG_CACHE_EXPIRED', 86400), function () use ($number, $action, $list_province, $date, $province_alias) {
                return LotteryResultDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
                    ->where('lottery_result_details.status', env('STATUS', 1))
                    ->whereIn('result_lotteries.province_id', $list_province)
                    ->select('result_lotteries.*', 'lottery_result_details.*', DB::raw('(lottery_result_details.foot_lotto + lottery_result_details.head_lotto)%10 as total'))
                    ->where('result_lotteries.type', 'normal')
                    ->where('lottery_result_details.prize', 0)
                    ->where('result_lotteries.result_day', '<', $this->parseDate($date))
                    ->having('total', $number)
                    ->orderBy('result_lotteries.result_day', 'DESC')
                    ->first()->toArray();
            });
        }
    }

    protected function selectMaxGanHead($number, $list_province)
    {


    }

    protected function selectMaxGanFoot($number)
    {

    }

    // thong-ke-chu-ky-dan-dac-biet
    public function specialLoop(Request $request)
    {
        $data = [];
        $number = 10;
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $begin_date = date('2000-01-01');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $number = $request->get('numbers');
            $end_date = parseDate($request->get('end_date'));
            $begin_date = parseDate($request->get('begin_date'));
        }
        $raw = $this->crawlStatisticsSpecialLoop($provinceAlias, $begin_date, $end_date, $number);

        return view('frontend.statistics.special_loop', compact('data', 'provinceAlias', 'begin_date', 'end_date', 'number', 'raw'));
    }

    //thong-ke-chu-ky-dan-loto
    public function lottoLoop(Request $request)
    {
        $data = [];
        $number = 10;
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $begin_date = date('2005-01-01');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $number = $request->get('numbers');
            $end_date = parseDate($request->get('end_date'));
            $begin_date = parseDate($request->get('begin_date'));
        }
        $raw = $this->crawlStatisticsLottoLoop($provinceAlias, $begin_date, $end_date, $number);

        return view('frontend.statistics.lotto_loop', compact('data', 'provinceAlias', 'begin_date', 'end_date', 'number', 'raw'));
    }

    // thong-ke-chu-ky-max-dan-cung-ve
    public function maxDanResults(Request $request)
    {
        $data = [];
        $number = 10;
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $begin_date = date('2005-01-01');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $number = $request->get('numbers');
            $end_date = parseDate($request->get('end_date'));
            $begin_date = parseDate($request->get('begin_date'));
        }
        $raw = $this->crawlMaxDanResults($provinceAlias, $begin_date, $end_date, $number);

        return view('frontend.statistics.max_dan_results', compact('data', 'provinceAlias', 'begin_date', 'end_date', 'number', 'raw'));

    }

    // bang-dac-biet-tuan
    public function specialLottoWeekend(Request $request)
    {
        $data = [];
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $begin_date = date('Y-m-d', strtotime("-31 days"));
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $end_date = parseDate($request->get('end_date'));
            $begin_date = parseDate($request->get('begin_date'));
        }
        $raw = $this->crawlSpecialLottoWeekend($provinceAlias, $begin_date, $end_date);
        return view('frontend.statistics.special_weekend', compact('data', 'provinceAlias', 'begin_date', 'end_date', 'raw'));

    }


    public function specialLottoYear(Request $request)
    {
        $data = [];
        $year = 2018;
        if ($request->isMethod('post')) {
            $year = $request->get('year');
            if ($year > date('Y')) {
                $year = date('Y');
            }
        }
        $raw = $this->crawlSpecialLottoYear($year);

        return view('frontend.statistics.special_year', compact('data', 'year', 'raw'));

    }

    public function specialLottoMonth(Request $request)
    {

        $data = [];
        $year = date('Y');
        $month = date('m');
        if ($request->isMethod('post')) {
            $year = $request->get('year');
            if ($year > date('Y')) {
                $year = date('Y');
            }
            $month = $request->get('month');
        }

        $raw = $this->crawlSpecialLottoMonth($year, $month);

        return view('frontend.statistics.special_month', compact('data', 'year', 'month', 'raw'));

    }

    // thong-ke-giai-dac-biet-ngay-mai
    public function specialTomorrow(Request $request)
    {
        $data = [];
        $provinceAlias = 'mien-bac';
        $end_date = date('Y-m-d');
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $end_date = parseDate($request->get('end_date'));
        }
        $raw = $this->crawlSpecialTomorrow($provinceAlias, $end_date);

        return view('frontend.statistics.special_tomorrow', compact('data', 'provinceAlias', 'end_date', 'raw'));
    }


    // tao phoi
    public function createCasts(Request $request)
    {
        $data = [];
        $date = date('Y-m-d', strtotime("-1 days"));
        $count = 4;
        if ($request->isMethod('post')) {
            $date = parseDate($request->get('date'));
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $listProvinces = Province::where('region_id', 2)->where('type', 'normal')->pluck('id')->toArray();
        $data = ResultLottery::with(['resultsDetail', 'province'])
            ->whereIn('province_id', $listProvinces)
            ->where('status', $this->status)
            ->where('result_lotteries.result_day', '<', $this->parseDate($date))
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->limit($count)
            ->get();
        return view('frontend.statistics.create_casts', compact('data', 'date', 'count'));
    }
}
