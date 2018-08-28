<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryResultDetail extends Model
{
    protected $table = 'lottery_result_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'result_lottery_id',
        'prize',
        'prize_number',
        'head_lotto',
        'foot_lotto',
        'prize_number_lotto',
        'order',
        'status',
        'created_at',
        'updated_at'
    ];

    public function lottery()
    {
        return $this->belongsTo(ResultLottery::class, 'result_lottery_id');
    }

    public function getTwoNumberFromPrizeNumber()
    {
        return substr($this->prize_number, -2);
    }
}
