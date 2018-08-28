<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\VietlottCrawler;
use App\Models\LotteryResultDetail;
use App\Models\Menu;
use App\Models\Province;
use App\Models\Region;
use App\Models\ResultLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /*
     * Home function
     *
     * @return view
    */
    public function home(Request $request)
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
        return view('frontend.home.index', compact('resultLottery'));
    }

    public function index(Request $request, $slug)
    {
        // get 1 region from slug name
        $region = Region::where('slug', $slug)->first();
        // get 1 province from slug name
        $province = Province::where('slug', $slug)->first();
        // not exits both
        if (!$region && !$province) {
            abort(404);
        }
        $date = date('Y-m-d');
        if (request()->query('ngay') && (preg_match('/[\d]{4}-[\d]{2}-[\d]{2}/', request()->query('ngay')) || preg_match('/[\d]{2}-[\d]{2}-[\d]{4}/', request()->query('ngay')))) {
            $date = request()->query('ngay');
            $date = $this->parseDate($date);
        }
        // check exits region

        // mien bac
        if ($slug == 'mien-bac') {

            $resultLotteriesOthers = null;
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
                $resultLotteriesOthers['dien-toan-123'] = ResultLottery::where('province_id', 60)
                    ->where('status', 1)
                    ->orderByDesc('result_day')
                    ->first();
                $resultLotteriesOthers['636'] = ResultLottery::where('province_id', 61)
                    ->where('status', 1)
                    ->orderByDesc('result_day')
                    ->first();
                $resultLotteriesOthers['than-tai'] = ResultLottery::where('province_id', 62)
                    ->where('status', 1)
                    ->orderByDesc('result_day')
                    ->first();


            } else {

                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->whereIn('province_id', $listProvinces)
                    ->where('status', $this->status)
                    ->where('result_day', $date)
                    ->first();

                $resultLotteriesOthers['dien-toan-123'] = ResultLottery::where('province_id', 60)
                    ->where('status', 1)
                    ->where('result_day', $date)
                    ->first();
                $resultLotteriesOthers['636'] = ResultLottery::where('province_id', 61)
                    ->where('status', 1)
                    ->where('result_day', $date)
                    ->first();
                $resultLotteriesOthers['than-tai'] = ResultLottery::where('province_id', 62)
                    ->where('status', 1)
                    ->where('result_day', $date)
                    ->first();

            }
            return view("frontend.home.result_north", compact('region', 'province', 'resultLottery', 'resultLotteriesOthers'));

        } // mien nam or mien trung
        elseif ($slug == 'mien-trung' || $slug == 'mien-nam') {
            $listProvinces = Province::where('region_id', $region->id)->pluck('id')->toArray();
            if (request()->query('ngay') == null) {
                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->whereIn('province_id', $listProvinces)
                    ->where('result_day', $date)
                    ->orderByDesc('result_day')
                    ->where('status', $this->status)
                    ->get();
                if (!$resultLottery || count($resultLottery) == 0) {
                    $date = date('Y-m-d', strtotime("-1 days"));
                    $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                        ->whereIn('province_id', $listProvinces)
                        ->where('result_day', $date)
                        ->orderByDesc('result_day')
                        ->where('status', $this->status)
                        ->get();
                }
            } else {
                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->whereIn('province_id', $listProvinces)
                    ->where('status', $this->status)
                    ->where('result_day', $date)
                    ->get();
            }
            return view("frontend.home.result_south", compact('region', 'province', 'resultLottery', 'date'));
        } // not exits region => check province
        elseif ($province) {
            if (request()->query('ngay') == null) {
                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->where('province_id', $province->id)
                    ->where('status', $this->status)
                    ->orderByDesc('result_day')
                    ->first();
            } else {
                $resultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->where('province_id', $province->id)
                    ->where('status', $this->status)
                    ->where('result_day', $date)
                    ->first();
            }
            if ($province->region_id == 2) {
                return view("frontend.home.result_north", compact('region', 'province', 'resultLottery'));
            }elseif ($province->region_id == 4){
                if ($resultLottery){
                    $resultLottery->lotteries_db_content = json_decode($resultLottery->lotteries_db_content);
                    $resultLottery->results = !empty($resultLottery->lotteries_db_content->result) ? str_split($resultLottery->lotteries_db_content->result,2) : [];

                    $resultLottery->recents = VietlottCrawler::getRecentResults($province->alias, $province->id,$province->alias == VietlottCrawler::TYPE_MAX4D?10:5);
                    if ($province->alias != VietlottCrawler::TYPE_MAX4D){
                        $resultLottery->bestNumbers = VietlottCrawler::getBestPeriodNumbers($province->alias, $province->id, 20, 12);
                        $resultLottery->worstNumbers = VietlottCrawler::getWorstNumbers($province->alias, $province->id, 20, 12);
                    }else{
                        foreach($resultLottery->recents as &$recent){
                            $recent->lotteries_db_content = json_decode($recent->lotteries_db_content);
                        }
                    }
                }

                return view("frontend.home.vietlott_{$province->alias}", compact('region', 'province', 'resultLottery'));
            }

            return view("frontend.home.result_province_south", compact('region', 'province', 'resultLottery'));
        } else {
            return abort(404);
        }
    }


    //  detail post
    public function detailPost($slug)
    {
        $detail = Post::where('slug', $slug)->first();

        echo $detail->title;
        return view('frontend.posts.detailPost');
    }

    //all post
    public function allPost()
    {
        $all = Post::paginate(10);
        foreach ($all as $a) {
            echo $a->title;
        }
    }

    public function lotteryToday()
    {
        $date = date('Y-m-d', strtotime("-1 days"));
        if (request()->query('ngay') && (preg_match('/[\d]{4}-[\d]{2}-[\d]{2}/', request()->query('ngay')) || preg_match('/[\d]{2}-[\d]{2}-[\d]{4}/', request()->query('ngay')))) {
            $date = request()->query('ngay');
            $date = $this->parseDate($date);
        }
        $listResultLottery = ResultLottery::with(['resultsDetail', 'province'])->where('status', $this->status)
            ->orderBy('province_id', 'DESC')->where('result_day', $date)->get();
        $resultLotteriesOthers = [];
        $resultLotteriesOthers['dien-toan-123'] = ResultLottery::where('province_id', 60)
            ->where('status', 1)
            ->where('result_day', $date)
            ->first();
        $resultLotteriesOthers['636'] = ResultLottery::where('province_id', 61)
            ->where('status', 1)
            ->where('result_day', $date)
            ->first();
        $resultLotteriesOthers['than-tai'] = ResultLottery::where('province_id', 62)
            ->where('status', 1)
            ->where('result_day', $date)
            ->first();
        return view("frontend.home.lotteryToday", compact('listResultLottery', 'resultLotteriesOthers', 'date'));

    }

    public function resultsBook()
    {
        $limit = 30;
        $provinces = collect([]);
        $provinces = $provinces->concat(Region::where('slug', 'mien-nam')->first()->provinces);
        $provinces = $provinces->merge(Region::where('slug', 'mien-trung')->first()->provinces);

        if (request()->query('tinh') == null && request()->query('bien-do-ngay') == null && request()->query('so-ngay') == null) {
            $arr_province_id_truyenthong = Province::where('region_id', Region::where('slug', 'mien-bac')->first()->id)
                ->whereNotIn('slug', ['than-tai', 'dien-toan-123', 'dien-toan-6-36'])->pluck('id')->toArray();

            $listResultLottery = ResultLottery::with(['resultsDetail', 'province'])
                ->whereIn('province_id', $arr_province_id_truyenthong)
                ->where('result_day', '<=', date('Y-m-d'))
                ->orderByDesc('result_day')
                ->limit($limit)
                ->get();
        } else {
            $limit = intval(request()->query('so-ngay'));
            if($limit > 300) {
                $limit = 30;
            }
            if (request()->query('tinh') == 'truyen-thong') {
                $listResultLottery = collect([]);

                $arr_province_id_truyenthong = Province::where('region_id', Region::where('slug', 'mien-bac')->first()->id)
                    ->whereNotIn('slug', ['than-tai', 'dien-toan-123', 'dien-toan-6-36'])->pluck('id')->toArray();

                $listResultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->whereIn('province_id', $arr_province_id_truyenthong)
                    ->where('result_day', '<=', request()->query('bien-do-ngay'))
                    ->orderByDesc('result_day')
                    ->limit($limit)
                    ->get();

            } else {

                $province = Province::where('slug', request()->query('tinh'))->firstOrFail();
                $listResultLottery = ResultLottery::with(['resultsDetail', 'province'])
                    ->where('status', $this->status)
                    ->where('province_id', $province->id)
                    ->where('result_day', '<=', request()->query('bien-do-ngay'))
                    ->orderByDesc('result_day')
                    ->limit($limit)
                    ->get();
            }
        }
        return view('frontend.home.resultsBook', compact('provinces', 'listResultLottery', 'region', 'resultLotteriesOthers', 'province','limit'));
    }
}
