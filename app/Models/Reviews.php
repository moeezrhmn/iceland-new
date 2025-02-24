<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['image','category_id','user_id','instance_id','rating','description','review_time_friendly','title','comment'];
    public function user_detail()
    {
        return $this->hasOne('App\User','id','user_id');
    }
    public function reviews_avg()
    {
        return $this->hasOne('App\Models\Reviews','instance_id')
            ->select(DB::raw('id,instance_id,category_id,avg(rating) as rating'))->groupBy('instance_id');
    }
}
