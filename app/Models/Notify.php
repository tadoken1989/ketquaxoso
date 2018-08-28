<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model {

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

    protected $table = 'notify';

    protected $fillable = [
        'content', 'url','status','sort_by'
    ];
}
