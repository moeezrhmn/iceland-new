<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'permissions';
    protected $fillable = [
        'name', 'guard_name','type',
    ];
}
