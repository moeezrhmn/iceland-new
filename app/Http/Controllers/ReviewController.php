<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Places;
use App\Models\Cities;
use App\Models\Address;
use App\Models\Category;
use App\Models\Reviews;
use App\Models\multiSubcategories;
use App\Models\LogsPlaces;
use App\Models\Photo;
use App\Models\Keyword;
use App\Models\Flights;
use App\Models\multiKeywords;
use App\Classes\Functions;
use Session;
use DB;

class ReviewController extends Controller
{
    public function __construct()
    {
        //$this->cat_detail = Category::where('code', '=', 'PTV')->first();
    }

    public function index()
    {
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_name,parent_id,cat_image,count(categories.id) as total'))
            ->where('parent_id', 4)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->
            groupby('categories.id')->get();

// /////////   listing ///////////////////////

        $listing = Places::select('id', 'place_name', 'stars', 'description', 'slug', 'track_id', 'category_id', 'created_at', 'status')->with([
            'single_photo' => function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }])->orderBy('place_name', 'ASC');
        if (Input::get('sort') == 'Name') {
            $listing->orderBy('place_name', 'ASC');
        } elseif (Input::get('sort') == 'Rating') {
            $listing->orderBy('stars', 'DESC');
        } else {
            $listing->orderBy('is_featured', 'DESC');
        }
        if (Input::get('display')) {
            $page = Input::get('display');
        } else {
            $page = '20';
        }
        $listing = $listing->paginate($page);

        //dd($places);
        return view('places/index', compact('listing', 'sub_cat'));
    }

   public function store(Request  $request){
  $validator = Functions::validator($request->all(), [
//            'comment' => 'required',
//            'rating_star' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
          $formData = $request->all();


       $formData['comment']=$request->comment;
        $formData['category_id']=$request->category_id;
        $formData['rating']=$request->rating_star;
         $formData['instance_id']=$request->instance_id;
        $formData['user_id']=Auth::id();
         //dd($formData);


        $review = Reviews::create($formData);

  
        if($review){
           return Redirect::back();
        }else{
            echo 'error' ; 
        }


   }
   public function change_currency(){
    
    return view('restaurants/currency');
   }




  
}
