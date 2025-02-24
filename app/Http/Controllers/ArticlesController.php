<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;
class ArticlesController extends Controller
{


    public function index()
    {
        // get data from articles table
        $data  = Articles::select('*')
                    ->with(['keywords' =>function($query){

                        $query->select('keywords.id', 'keywords.category_id', 'keyword_name');
                        $query->Where('keywords.category_id', '=',4);
                    }])
            ->where(array('status'=>'Active'))->orderBy('updated_at', 'DESC')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=',4);
                }])->orderBy('order_no','ASC')-> get();

            //dd($data);
        // load view file called all_articles
        return view("articles.all_articles")->with('all_articles',$data);
    }

    public function detail($id)
    {
        // get data from articles table
        $data  = Articles::select('*')->with(['keywords' =>function($query){

                        $query->select('keywords.id', 'keywords.category_id', 'keyword_name');
                        $query->Where('keywords.category_id', '=',4);
            }])->where(array('slug'=>$id))
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=',4);
                }])
            ->first();
      // dd($data);
       // $data = Articles::select('*')->where(array('status'=>'Active'))->first()->toArray();
        // load view file called all_articles
        return view("articles.single_detail",compact('data'));
    }
}
