<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model
{
    use SoftDeletes;
    protected $table = 'cities';
    protected $guarded = [ 'id' ];
    protected $fillable = [
        'region_id','country_id','short_description','description','latitude','longitude','radius',
        'name','image','count','country_code','city_tag','order_no'
    ];
    public function country(){
        return $this->hasOne('App\Models\Country','code','country_code');

    }
    public function city_category(){
        return $this->hasOne('App\Models\CityCategory','id','city_category_id');
    }

}
