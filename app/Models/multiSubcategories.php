<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class multiSubcategories extends Model
{
    protected $table = 'multi_subcategories';
    protected $fillable = ['id','instance_id','category_id','subcategory_id','created_by'];

    public function sub_cat() {
        return $this->hasMany('App\Models\category','category_id','id');
    }
}
