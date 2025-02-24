<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'photo_id';
    protected $fillable = [
        'photo_id','photo','category_id', 'instance_id', 'main','image_type',
    ];
    public function places()
    {
        return $this->belongsTo('App\Models\Places','instance_id','id');
    }
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel','instance_id','id');
    }
    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurants','instance_id','id');
    }


}
