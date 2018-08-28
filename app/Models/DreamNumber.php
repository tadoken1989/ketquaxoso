<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DreamNumber extends Model
{
    protected $table = 'dream_numbers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dream_content',
        'result_dream',
        'status'
    ];
}
