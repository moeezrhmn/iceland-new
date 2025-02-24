<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'name','code'
    ];
    public function country(){
        $this->hasMany('App\Models\Cities','country_code');

    }
}
