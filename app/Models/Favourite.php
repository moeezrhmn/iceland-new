<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Favourite extends Model
{
    protected $table = 'favourite';
    protected $fillable = ['category_id','user_id','instance_id'];
    public function fav_restaurants()
    {
        return $this->hasOne('App\Models\Restaurants','id','instance_id');
    }
    public function fav_hotels()
    {
        return $this->hasOne('App\Models\Hotel','id','instance_id');
    }
    public function fav_places()
    {
        return $this->hasOne('App\Models\Places','id','instance_id');
    }
    public function fav_restaurant()
    {
        return $this->hasOne('App\Models\Restaurants','id','instance_id');
    }

    public function currency_symbol()
    {
        return $this->hasOne('App\Models\CurrencyModel','currency_code','currency');
    }
    static function get_subcat($instant_id,$category_id)
    {

        $activities = multiSubcategories::select('categories.slug')
            ->join('categories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->where('multi_subcategories.category_id',$category_id)
            ->where('multi_subcategories.instance_id',$instant_id)->first();
       return  @$activities->slug;

    }


}
