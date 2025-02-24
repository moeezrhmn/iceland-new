<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'categories';
    protected $fillable = [
        'external_id', 'cat_name','slug','code','order_no','cat_image','count','parent_id','status','created_by','country'
    ];

    
}
