<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacesSubcategories extends Model
{
    protected $table = 'places_subcategories';
    protected $fillable = ['id','place_id','subcategory_id','created_by'];
}
