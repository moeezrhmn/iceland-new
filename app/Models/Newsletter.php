<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use SoftDeletes;
    protected $table = 'newslatter';
    protected $fillable = [
        'email','is_sub'
    ];
    //
}
