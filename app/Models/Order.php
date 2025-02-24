<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'booking_id','payment_id','title','username','email','phone_no','currency','price','city','country'
    ];
}
