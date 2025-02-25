<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static   $status  = [ ''=>'Select','0'=>'Inactive', '1'=>'Active' ];
    protected $fillable = [
        'name', 'first_name', 'last_name','phone_no','user_photo','address','city','state','zip','country_code','user_type',
        'email', 'password','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
