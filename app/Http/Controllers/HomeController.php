<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Activity as activity;
use App\Models\Category;
use App\Models\Articles;
use App\Models\Places;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class HomeController extends Controller
{

    public function __construct()
    {
        //$this->middleware('Admin_auth');
        //$this->cat_detail = Category::where('code', '=', 'PLC')->first();
        $this->activityCategory = Category::where('id', '=', '3')->first();
    }
//$this->cat_detail = Category::where('id', '=', '3')->first()

   public function index(){

        $SubCategoriesData = Category::where(array('status'=> 'Active','parent_id'=>1))
        ->orderBy('order_no')->take(14)->get()->toArray();
        //dd($SubCategoriesData);
        $data= array();
       //DB::enableQueryLog();
   	 $ActivityData= Activity::select('activities.id', 'product_id','activity_name','slug','price', 'review_rating','duration',
         'excerpt','description','currency','activities.status', 'activities.order_no', 'activities.created_at')
           ->with('subCategories_edit')
           ->with([
               'single_photo' => function ($querys) {
                   $querys->select('photo', 'category_id', 'instance_id');
                   $querys->Where('category_id', '=',  $this->activityCategory->id);
                   $querys->Where('main', '=',1);
               }])
           ->with([
               'address' => function ($qury) {
                   $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                   $qury->Where('category_id', '=',  $this->activityCategory->id);
               }])
         ->where('status','Active')
         ->orderBy('order_no')->paginate(12);
     //dd(DB::getQueryLog());
   	 //////////get article data//
      //dd($ActivityData);
       $ArticleData  = Articles::select('*')->orderBy('updated_at', 'DESC')
           ->with([
               'single_photo' => function ($querys) {
                   $querys->select('photo', 'category_id', 'instance_id');
                   $querys->Where('category_id', '=',4);
                   $querys->Where('main', '=',1);
               }])
           ->where('status','Active')
                ->take(2)->get();
       //echo 'fffffffff</br>'.currency(100, $from ='USD', $to = 'ISK', $format = true);
       //dd($ActivityData);
//   	return view('home')->with(array('ActivityData'=>
//        (activity::all()->toArray()),'SubCategoriesData'=>$subcategories_for_places));
      // DB::enableQueryLog();
                 $featuredData =Places::select('places.id','place_name','photo','cat_name', 'code')
                     ->join('photos','photos.instance_id','places.id')
                     ->join('multi_subcategories','multi_subcategories.instance_id','places.id')
                     ->join('categories','categories.id','multi_subcategories.subcategory_id')
                     ->where('places.status','Active')
                     ->Where('multi_subcategories.category_id', 1)
                     ->Where('photos.category_id', 1)
                     ->Where('photos.main', 1)
                    // ->Where('code`', 'PLC')
                     ->where('is_featured','1')
                     ->groupBy('places.id', 'place_name', 'photo', 'cat_name', 'code')
                     ->orderBy('places.order_no','asc')
                     ->take(10)
                     ->get();
//                 ->with([
//           'single_photo' => function ($querys) {
//                   $querys->select('photo', 'category_id', 'instance_id','main');
//                   $querys->Where('category_id', 1);
//                   $querys->where('main',1);
//               }])
       //dd(DB::getQueryLog());
//echo '<pre>';
      //dd($featuredData);
       $title='Visit Iceland';
       return view('home', compact('SubCategoriesData','ActivityData','ArticleData','featuredData','title'));
   }
   public function more_gallery(){

    //$places =Places::where('is_featured','1')->get();
       $places =Places::select('places.id','place_name','photo','places.description')
           ->join('photos','photos.instance_id','places.id')
           ->join('multi_subcategories','multi_subcategories.instance_id','places.id')
           ->join('categories','categories.id','multi_subcategories.subcategory_id')
           ->Where('multi_subcategories.category_id', 1)
           ->Where('photos.category_id', 1)
           ->Where('photos.main', 1)
           //->Where('code', 'PLC')
           ->where('is_featured','1')
           ->where('places.status','Active')
           ->groupBy('places.id')
           ->orderBy('places.order_no','asc')
           ->paginate(20);
           //->get();

     return view('more_gallery', compact('places'));
   }

}
