<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $fillable = ['id', 'supplier_name','term', 'count',  'contact_no', 'address', 'city', 'status','created_at','updated_at'];
}
