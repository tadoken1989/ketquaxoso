<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Traits\Lib;
use App\Models\DreamNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Crawl;
use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Repositories\LotteriesRepository;

class InspiredController extends Controller
{
    use Crawl, Lib;

    protected $repository;

    public function __construct(LotteriesRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    // soi cau giai dac biet
    public function specialLotto(Request $request)
    {

        $title = 'đặc biệt';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 2;
        $both_digit = 'off';
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            $both_digit = $request->get('both_digit');
            if(!$both_digit) {
                $both_digit = 'off';
            }
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredSpecialLotto($provinceAlias, $end_date, $count, $both_digit);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title','both_digit'));
    }

    // soi cau 2 nhay
    public function twoLotto(Request $request)
    {
        $title = '2 nháy';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 2;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredLottoWithUrl('http://ketqua.net/cau-hai-nhay', $provinceAlias, $end_date, $count);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title'));

    }

    // Cầu loto
    public function Lotto(Request $request)
    {
        $title = 'Cầu loto';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 3;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredLottoWithUrl('http://ketqua.net/cau-loto', $provinceAlias, $end_date, $count);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title'));

    }

    // soi cau bac thu
    public function bachThu(Request $request)
    {
        $title = 'Bạch thủ';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 3;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredLottoWithUrl('http://ketqua.net/cau-loto-bach-thu', $provinceAlias, $end_date, $count);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title'));

    }

    // soi cau loai lotto
    public function dropLotto(Request $request)
    {
        $title = 'Loại lotto';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 3;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredLottoWithUrl('http://ketqua.net/cau-loai-loto', $provinceAlias, $end_date, $count);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title'));

    }

    // soi cau loai bach thu
    public function dropBachThu(Request $request)
    {
        $title = 'Cầu loại bạch thủ';
        $data = [];
        $end_date = date('Y-m-d', strtotime("-1 days"));
        $count = 3;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $end_date = parseDate($request->get('end_date'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlInspiredLottoWithUrl('http://ketqua.net/cau-loai-bach-thu', $provinceAlias, $end_date, $count);
        return view('frontend.inspired.special_lotto', compact('data', 'provinceAlias', 'end_date', 'count', 'raw', 'title'));

    }

    // soi cau loai bach thu
    public function viewByDay(Request $request)
    {
        $title = 'Cầu loto theo thứ ';
        $data = [];
        $day_ow = 7;
        $count = 3;
        $provinceAlias = 'mien-bac';
        if ($request->isMethod('post')) {
            $day_ow = parseDate($request->get('day_ow'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlViewByDay('http://ketqua.net/cau-theo-thu', $provinceAlias, $day_ow, $count, false);
        return view('frontend.inspired.view_by_day', compact('data', 'provinceAlias', 'day_ow', 'count', 'raw', 'title'));

    }

    public function viewSpecialByDay(Request $request)
    {
        $title = 'Cầu giải đặc biệt theo thứ';
        $data = [];
        $day_ow = 0;
        $count = 3;
        $end_date = date('Y-m-d');
        $provinceAlias = 'mien-bac';
        $both_digit = 'off';
        if ($request->isMethod('post')) {
            $day_ow = parseDate($request->get('day_ow'));
            $provinceAlias = $request->get('code');
            $count = intval($request->get('count'));
            $both_digit = $request->get('both_digit');
            if(!$both_digit) {
                $both_digit = 'off';
            }
            if ($count > 100) {
                $count = 10;
            }
        }
        $raw = $this->crawlViewByDay('http://ketqua.net/cau-dac-biet-theo-thu', $provinceAlias, $day_ow, $count, $both_digit);
        return view('frontend.inspired.view_by_day', compact('data', 'provinceAlias', 'day_ow', 'count', 'raw', 'title', 'end_date'));

    }

    public function searchHistory(Request $request)
    {
        $data = [];
        $begin_date = date('2014-01-01');
        $end_date = date('Y-m-d',strtotime("-1 days"));
        $provinceAlias = 'mien-bac';
        $bach_thu = 'off';
        $pos_1 = 20;
        $pos_2 = 30;
        if ($request->isMethod('post')) {
            $provinceAlias = $request->get('code');
            $begin_date = $this->parseDate($request->get('begin_date'));
            $end_date = $this->parseDate($request->get('end_date'));
            $bach_thu = $request->get('bach_thu');
            if (!$bach_thu) {
                $bach_thu = 'off';
            }
            $pos_1 = intval($request->get('pos_1'));
            $pos_2 = intval($request->get('pos_2'));
        }
        $raw = $this->crawlSearchHistory($provinceAlias, $begin_date, $end_date, $bach_thu, $pos_1, $pos_2);
        return view('frontend.inspired.search_history', compact('data', 'provinceAlias', 'begin_date', 'end_date', 'bach_thu', 'pos_1', 'pos_2', 'raw'));
    }

    public function viewProvinceCauDetails(Request $request)
    {
        $raw = $provinceAlias = $begin_date = $end_date = '';
        $pos_1 = 1;
        $pos_2 = 9;
        $provinceAlias = $request->query('province_alias');
        $begin_date = $request->query('begin_date');
        $end_date = $request->query('end_date');
        $pos_1 = intval($request->query('pos_1'));
        $pos_2 = intval($request->query('pos_2'));
        if ($provinceAlias && $begin_date && $end_date) {
            $raw = $this->crawlViewProvinceCauDetails($provinceAlias, $begin_date, $end_date, $pos_1, $pos_2);
        }
        return view('frontend.inspired.view_province_cau_details', compact('provinceAlias', 'begin_date', 'end_date', 'pos_1', 'pos_2', 'raw'));
    }
}
