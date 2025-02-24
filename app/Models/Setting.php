<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    protected $fillable = ['support_email', 'country_code','contact_email', 'sale_email', 'contact_no', 'address', 'city', 'state', 'zip_code', 'social_1', 'social_2', 'map_iframe', 'google_analytic'];
}
