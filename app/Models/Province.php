<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Province extends Model
{
    protected $table = 'provinces';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'weekdays_result_lottery',
        'region_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function results()
    {
        return $this->hasMany(ResultLottery::class, 'province_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public static function scopeIsActive(Builder $query)
    {
        $query->where('status',env('STATUS',1));
    }

}
