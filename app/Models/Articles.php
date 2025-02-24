<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Articles extends Model {


    protected $table = 'articles';
    protected $guarded = [ 'id' ];
    protected $fillable = ['title','short_des','publish_by','publish_on','keyword','order_no','slug','description','created_by','created_at','updated_at'];

    public function photo()
    {
        return $this->hasMany('App\Models\Photo','instance_id');
    }

    public function single_photo()
    {
        return $this->hasOne('App\Models\Photo','instance_id');
    }
    public function keywords()
    {
        return $this->belongsToMany('App\Models\Keyword','multi_keywords','instance_id','keyword_id');
    }

}
