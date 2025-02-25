<?php


class Html {

    public static function script($path) {
        if(str_contains($path, 'http') === false){
            $path = asset($path);
        }
        return "<script src='$path'></script>";
    }
    
    public static function style($path) {
        if(str_contains($path, 'http') === false){
            $path = asset($path);
        }
        return "<link rel='stylesheet' href='$path'>";
    }
}