<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Activity extends Model {

    // use SoftDeletes;
    protected $table = 'activities';
    protected $guarded = [ 'id' ];  
    protected $fillable = ['activity_name','source','excerpt','external_id','product_id','product_group_id', 'slug','track_id',
        'price', 'category_id', 'phone',
        'ssn', 'order_no', 'description', 'currency',  'duration' ,  'review_rating'  ,'language', 'information', 'supplier_id',
        'website_url', 'review_rating', 'is_featured', 'source'
       , 'status',     'created_by', 'created_at', 'updated_at'];

    public function subcategories()
    {
        return $this->hasMany('App\Models\multiSubcategories','instance_id');
    }

    static function subcat_name($array)
    {
        foreach ($array as $obj)
        {
             $users = DB::table('categories')->select('cat_name')->where('id',$obj->subcategory_id)
                ->first();
            echo $users->cat_name.', ';
        }
//        echo "<pre>";
//        print_r($array);
       // exit;
       // return $this->hasMany('App\Models\multiSubcategories','instance_id');
    }

    public function reviews_avg()
    {
        return $this->hasOne('App\Models\Reviews','instance_id')
            ->select(DB::raw('id,instance_id,category_id,avg(rating) as rating'))->groupBy('instance_id');
    }

    public function photo()
    {
        return $this->hasMany('App\Models\Photo','instance_id');
    }

    public function single_photo()
    {
        return $this->hasOne('App\Models\Photo','instance_id');
    }
    public function favoruite()
    {
        return $this->hasOne('App\Models\Favourite','instance_id');
    }
    public function subCategories_edit() {
        return $this->belongsToMany('App\Models\Category', 'multi_subcategories', 'instance_id', 'subcategory_id')
        ->where('category_id','3');
    }
    public function address()
    {
        return $this->hasOne('App\Models\Address','instant_id');
    }

    public function keywords()
    {
        return $this->belongsToMany('App\Models\Keyword','multi_keywords','instance_id','keyword_id')->select('instance_id','keyword_id');
    }
    public function fav_place()
    {
        return $this->hasOne('App\Models\Favourite','instance_id');
    }
      public function single_category()
    {
         return $this->hasOne('App\Models\Category','id','category_id');
    }

}
