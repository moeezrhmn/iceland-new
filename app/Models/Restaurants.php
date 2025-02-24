<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Restaurants extends Model
{
    use SoftDeletes;
    protected $table = 'restaurants';
    protected $guarded = ['id'];
    protected $fillable = ['excerpt','external_id','source','track_id','phone','restaurant_name','slug','category_id','ssn','order_no','description','deeplink','currency','created_by','website','stars','is_featured','social_1'
        ,'social_2','social_3','social_4','status','deleted_at'];
    public function photo()
    {
        return $this->hasMany('App\Models\Photo','instance_id');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews','instance_id');
    }
    public function favoruite()
    {
        return $this->hasOne('App\Models\Favourite','instance_id');
    }
    public function subCategories_edit() {
        return $this->belongsToMany('App\Models\Category', 'multi_subcategories', 'instance_id', 'subcategory_id')->where('category_id',2);
    }
    public function reviews_avg()
    {
        return $this->hasOne('App\Models\Reviews','instance_id')
            ->select(DB::raw('id,instance_id,category_id,avg(rating) as rating'))->groupBy('instance_id');
    }
    public function single_photo()
    {
        return $this->hasOne('App\Models\Photo','instance_id');
    }

    public function subCategories() {
        return $this->belongsToMany('App\Models\Category', 'multi_subcategories', 'instance_id', 'subcategory_id');
    }
    public function keywords()
    {
        return $this->belongsToMany('App\Models\Keyword','multi_keywords','instance_id','keyword_id');
    }
    public function addressMany()
    {
        return $this->hasMany('App\Models\Address','instant_id');
    }
    public function address()
    {
        return $this->hasone('App\Models\Address','instant_id');
    }
    public function rst_booking()
    {
        return $this->hasMany('App\Models\RestaurantsBooking','restaurant_id');
    }
    public function fav_restaurant()
    {

        return $this->hasOne('App\Models\Favourite','instance_id');
    }
       public function single_category()
    {
         return $this->hasOne('App\Models\Category','id','category_id');
    }
}
