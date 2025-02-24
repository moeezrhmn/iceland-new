<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deals extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'deals';
    protected $fillable = ['category_id', 'instant_id', 'deals_title', 'discount_price', 'valid_from', 'valid_to', 'deals_image', 'description', 'status', 'deleted_at'];
    protected $hidden = ['updated_at'];
}
