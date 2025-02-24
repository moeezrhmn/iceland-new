<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\TestTrait;
echo LARAVEL_START;
class testController extends Controller
{
//    use TestTrait;
//   static $c = 4;

    public function index (){

        return CURRENT_TIME;
    }


}
