<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Region extends Model
{
    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_id');
    }

    public static function scopeIsActive(Builder $query)
    {
        $query->where('status',env('STATUS',1));
    }
}
