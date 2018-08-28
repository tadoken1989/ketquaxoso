<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $table = 'advertises';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'image',
        'information',
        'width',
        'height',
        'sort_by',
        'url',
        'position_to_advertise',
        'price',
        'status'
    ];
}
