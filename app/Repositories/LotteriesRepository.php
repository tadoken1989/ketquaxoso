<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/12/18
 * Time: 9:10 AM
 */

namespace App\Repositories;

use App\Models\LotteryResultDetail;
use App\Models\Province;
use App\Models\ResultLottery;

class LotteriesRepository
{

    /**
     * The Tag instance.
     *
     * @var \App\Models\LotteryResultDetail
     */
    protected $resultsDetail;

    /**
     * The Comment instance.
     *
     * @var \App\Models\Province
     */
    protected $province;

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Create a new BlogRepository instance.
     *
     * @param  \App\Models\ResultLottery $resultLottery
     * @param  \App\Models\Province $province
     * @param  \App\Models\LotteryResultDetail $detail
     */
    public function __construct(ResultLottery $resultLottery, Province $province, LotteryResultDetail $resultsDetail)
    {
        $this->model = $resultLottery;
        $this->province = $province;
        $this->resultsDetail = $resultsDetail;
    }

    public function getResultLotteryWithDateRange($listProvince, $startDate, $endDate)
    {
        return $this->model::with(['province', 'resultsDetail'])
            ->where('result_lotteries.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->whereBetween('result_lotteries.result_day', array(parseDate($startDate), parseDate($endDate)))
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->get()->toArray();
    }

    public function getResultLotteryWithDate($listProvince, $date)
    {
        return $this->model::with(['province', 'resultsDetail'])
            ->where('result_lotteries.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->where('result_lotteries.result_day', parseDate($date))
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->first();
    }

    public function getResultLotteryDetailWithDateRange($listProvince, $startDate, $endDate)
    {
        return $this->resultsDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->whereBetween('result_lotteries.result_day', array(parseDate($startDate), parseDate($endDate)))
            ->select('result_lotteries.*', 'lottery_result_details.*')
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->get()->toArray();
    }

    public function getResultLotteryDetailWithDate($listProvince, $date)
    {
        return $this->resultsDetail::join('result_lotteries', 'result_lotteries.id', 'lottery_result_details.result_lottery_id')
            ->where('lottery_result_details.status', env('STATUS', 1))
            ->whereIn('result_lotteries.province_id', $listProvince)
            ->where('result_lotteries.result_day', parseDate($date))
            ->select('result_lotteries.*', 'lottery_result_details.*')
            ->orderBy('result_lotteries.result_day', 'DESC')
            ->first()->toArray();
    }
}