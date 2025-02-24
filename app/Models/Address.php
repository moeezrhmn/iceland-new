<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    protected $fillable = ['instant_id','category_id','latitude','longitude','address','city','region','state','country','zipcode','email'
       ];
}
