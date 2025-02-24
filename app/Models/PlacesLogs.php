<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacesLogs extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $fillable = ['ssn','place_name','source','title','created_at'
    ];
}
