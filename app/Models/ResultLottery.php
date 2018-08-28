<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultLottery extends Model
{
    protected $table = 'result_lotteries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'province_id',
        'result_day',
        'type',
        'status',
        'alias',
        'created_at',
        'updated_at'
    ];

    public function resultsDetail()
    {
        return $this->hasMany(LotteryResultDetail::class, 'result_lottery_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function bingo()
    {
        return $this->resultsDetail;
    }

    public function bingo_head()
    {
        return $this->ksort(
            $this->resultsDetail
                ->groupBy(function ($rd, $key) {
                    return substr($rd->getTwoNumberFromPrizeNumber(), 0, 1);
                })
        );
    }

    public function bingo_duoi()
    {
        return $this->ksort(
            $this->resultsDetail
                ->groupBy(function ($rd, $key) {
                    return substr($rd->getTwoNumberFromPrizeNumber(), -1, 1);
                })
        );
    }

    private function ksort($c)
    {
        for ($i = 0; $i <= 9; $i++) {
            if (!isset($c[$i])) {
                $c[$i] = collect([]);
            }
        }

        $items = $c->all();
        ksort($items, SORT_REGULAR);
        return collect($items);
    }

    public static function loadDataResultLotteries($province_id, $limit = 40)
    {
        return self::with(['resultsDetail'])->where('province_id', $province_id)->limit($limit)->get();
    }

    public function loadByHead()
    {
        $data = [];
        for ($i = 0; $i <= 9; $i++) {
            $data[$i] = $this->resultsDetail()->where('head_lotto', $i)->orderBy('prize_number_lotto', 'ASC')->get();
        }
        return $data;
    }


    public function loadByFoot()
    {
        $data = [];
        for ($i = 0; $i <= 9; $i++) {
            $data[$i] = $this->resultsDetail()->where('foot_lotto', $i)->orderBy('prize_number_lotto', 'ASC')->get();
        }
        return $data;
    }


}
