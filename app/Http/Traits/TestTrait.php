<?php

namespace App\Http\Traits;




trait TestTrait
{

    static $c=3;
    public function any()
    {
        return static::$c;
    }



}
