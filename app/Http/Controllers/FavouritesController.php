<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Session;
use DB;

class FavouritesController extends Controller {

    public function __construct() {
        // $this->middleware('Web_auth');
    }

    public function index() {


        if (Auth::id()) {

        ///Select Places///
        $activities = Favourite::select('favourite.id','favourite.instance_id','activities.id as activity_id ', 'favourite.category_id', 'activity_name as name', 'slug', 'photo',  'is_featured', 'description', 'activities.status','activities.price', 'favourite.created_at')
                ->join('activities', 'activities.id', '=', 'favourite.instance_id')
                ->leftJoin('photos', 'activities.id', '=', 'photos.instance_id')
                ->Where('photos.category_id', '=', 3)
                ->Where('favourite.category_id', '=', 3)
                ->Where('favourite.user_id', Auth::user()->id)
                 ->Where('activities.status', '=', 'Active')
                ->OrderBy('activities.id', 'desc')
                ->groupBy('activities.id')
        ->get();
        //dd(DB::getQueryLog());
        ///Select restaurants///
        $restaurants = Favourite::select('favourite.id','favourite.instance_id','restaurants.id as place_id ', 'favourite.category_id', 'restaurant_name as name', 'slug', 'photo', 'stars', 'is_featured', 'description', 'restaurants.status as status', 'favourite.created_at')
                ->join('restaurants', 'restaurants.id', '=', 'favourite.instance_id')
                ->leftJoin('photos', 'restaurants.id', '=', 'photos.instance_id')
                ->Where('photos.category_id', '=', 2)
                ->Where('favourite.category_id', '=', 2)
                ->Where('favourite.user_id', Auth::user()->id)
                ->Where('restaurants.status', '=', 'Active')
                ->OrderBy('favourite.id', 'desc')
                ->groupBy('restaurants.id')
        //->union($places)
         ->get();
       // dd($restaurants);

        $places = Favourite::select('favourite.id','favourite.instance_id', 'places.id as place_id ', 'favourite.category_id', 'place_name as name', 'slug', 'photo', 'stars', 'is_featured', 'description', 'places.status', 'favourite.created_at')
                ->join('places', 'places.id', '=', 'favourite.instance_id')
                ->leftJoin('photos', 'places.id', '=', 'photos.instance_id')
                ->Where('photos.category_id', '=', 1)
                ->Where('favourite.category_id', '=', 1)
                ->Where('favourite.user_id', Auth::user()->id)
                 ->Where('places.status', '=', 'Active')
                ->OrderBy('favourite.id', 'desc')
                ->groupBy('places.id')
                //->union($places)
               // ->union($restaurants)

            // ->paginate(15);
//            ->get()->toarray();
            ->get();
//dd($places);

        // ->get();
        //dd($activities);
        //vourite::select('favourite.id', 'places.id as place_id ', 'favourite.category_id', 'place_name as name', 'slug', 'photo', 'stars', 'is_featured', 'description', 'places.status as status', 'favourite.created_at')
       /* $listing = Favourite::select('favourite.id','favourite.instance_id','hotels.id as place_id ', 'favourite.category_id', 'hotel_name as name', 'slug', 'photo', 'stars', 'is_featured', 'description', 'hotels.status', 'favourite.created_at')
                        ->join('hotels', 'hotels.id', '=', 'favourite.instance_id')
                        ->leftJoin('photos', 'hotels.id', '=', 'photos.instance_id')
                        ->Where('photos.category_id', '=', 3)
                        ->Where('favourite.category_id', '=', 3)
                        ->Where('favourite.user_id', Auth::user()->id)
                        ->OrderBy('favourite.id', 'desc')
                        ->groupBy('hotels.id')
                        ->union($places)
                        ->union($restaurants)
                        ->union($activities)
                        // ->paginate(15);
                        ->get()->toarray();*/
        //  $page = Input::get('page', 1);
//        $paginate = 5;

//      
//        if (Input::get('page') != null) {
//            $page = Input::get('page');
//        } else {
//            $page = '2';
//        }
//        $slice = array_slice(   $list , $paginate * ($page - 1), $paginate);
        //$listing = new Paginator($slice, count($list), $paginate);
        //dd($page);
        //$list=[];
        //$page = Input::get('page', 1);
        // $listing = new Paginator($list, 10);
        //$items, $perPage, $currentPage = null,
       // $slice = array_slice($list, 1, $paginate);
        //$slice = array_slice($list, $paginate * ($page - 1), $paginate);
       // $listing = new Paginator($slice, count($list), $paginate);
      // dd($listing);
    // $listing= new Paginator($list, count($list), Input::get('limit') ?: '10');
//        return view('wishlist/index', compact('listing'));
        return view('favourites/index', compact('listing','activities','restaurants','places'));
        } else {
            return redirect('/');
        }
//        public function products(Paginator $paginator)
//{
//    $products = [];
//   
//echo "<pre>";
        //print_r($listing);
        //$listing = $listing->paginate(20);
//                ->with([
//                'fav_restaurants' => function ($query) {
//                    $query->select('stars', 'id', 'is_featured', 'category_id', 'description', 'slug', 'restaurant_name', 'status', 'created_at');
//                    $query->Where('category_id', '=', 1);
//                }])
//            ->with([
//            'fav_restaurants.single_photo' => function ($query) {
//                $query->select('photo_id', 'photo', 'instance_id');
//                $query->Where('category_id', '=', 1);
//            }])->where('user_id',Auth::user()->user_id)->where('category_id',1)->get();
        //dd(DB::getQueryLog());
        // dd($listing_res);
//        $listing_hotel = Favourite::select('id', 'category_id', 'instance_id')->with([
//                            'fav_hotels' => function ($query) {
//                                $query->select('stars', 'id', 'is_featured', 'category_id', 'description', 'slug', 'hotel_name', 'status', 'created_at');
//                                $query->Where('category_id', '=', 3);
//                            }])
//                        ->with([
//                            'fav_hotels.photo' => function ($query) {
//                                $query->select('photo_id', 'photo', 'instance_id');
//                                $query->Where('category_id', '=', 1);
//                            }])->where('user_id', Auth::user()->user_id)
//                        ->where('category_id', 3)->get();
        // $data = array_merge($listing_hotel, $listing_res);
        //dd($listing);
    }

//     public function index()
//    {
//         DB::enableQueryLog();
//        $listing_res = Favourite::select('id','category_id', 'instance_id')
//            ->with([
//                'fav_restaurants' => function ($query) {
//                    $query->select('stars', 'id', 'is_featured', 'category_id', 'description', 'slug', 'restaurant_name', 'status', 'created_at');
//                    $query->Where('category_id', '=', 1);
//                }])
//            ->with([
//            'fav_restaurants.single_photo' => function ($query) {
//                $query->select('photo_id', 'photo', 'instance_id');
//                $query->Where('category_id', '=', 1);
//            }])->where('user_id',Auth::user()->user_id)->where('category_id',1)->get();
//          //dd(DB::getQueryLog());
//           // dd($listing_res);
//        $listing_hotel = Favourite::select('id','category_id', 'instance_id')->with([
//                'fav_hotels' => function ($query) {
//                    $query->select('stars', 'id', 'is_featured', 'category_id', 'description', 'slug', 'hotel_name', 'status', 'created_at');
//                    $query->Where('category_id', '=', 3);
//                }])
//            ->with([
//                'fav_hotels.photo' => function ($query) {
//                    $query->select('photo_id', 'photo', 'instance_id');
//                    $query->Where('category_id', '=', 1);
//                }])->where('user_id',Auth::user()->user_id)
//            ->where('category_id',3)->get();
//      
//        $data  = array_merge($listing_hotel,$listing_res);
//      dd($data);
//        return view('wishlist/index', compact('listing'));
//    }
    public function add_favorite() {
        // echo 'cxx'; exit;
        if (!empty(Auth::id())) {
            Favourite::create(array('instance_id' => $_GET['instance_id'], 'category_id' => $_GET['category_id'], 'user_id' => Auth::id()));
            echo $_GET['instance_id'];
        } else {
            echo "0";
        }
    }

    public function remove_favorite() {
        $find = Favourite::where('instance_id', $_GET['instance_id'])
                        ->where('category_id', $_GET['category_id'])
                        ->where('user_id', Auth::id())
                        ->first();
        $find->delete();
        if(!empty($find))
        {
            echo $find->id;
        }
    }
    public function removefavorite() {
        $find = Favourite::where('id', $_GET['favid'])

                        ->where('user_id', Auth::user()->id)
                        ->first();
        $find->delete();
        if(!empty($find))
        {
            echo $find->id;
        }
    }

    public function favouriteListing(){


    }

}
