<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class multiKeywords extends Model
{
    protected $table = 'multi_keywords';
    protected $fillable = ['id','instance_id','category_id','keyword_id','created_by'];
}
