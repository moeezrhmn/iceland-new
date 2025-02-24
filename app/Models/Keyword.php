<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Keyword extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'keywords';
    protected $fillable = ['category_id', 'keyword_name', 'slug', 'status', 'deleted_at'];
    protected $hidden = ['updated_at'];

//    public static function get_keywords()
//    {
//        $keywords = DB::table('keywords')
//            ->leftJoin('categories', 'categories.id', '=', 'keywords.category_id')
//            ->select('keywords.*', 'categories.cat_name')
//            ->whereNull('keywords.deleted_at')
//            ->get();
//        return $keywords;
//    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
      public function single_category()
    {
         return $this->hasOne('App\Models\Category','id','category_id');
    }
 
    
}

