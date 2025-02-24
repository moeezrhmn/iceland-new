<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Favourite;
use App\Models\Reviews;
use Illuminate\Support\Facades\Input;
use App\Models\Category;
use Session;
use DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function __construct()
    {
        //$this->middleware('Admin_auth');
        //$this->cat_detail = Category::where('code', '=', 'PLC')->first();
        $this->activityCategory = Category::where('id', '=', '3')->first();
    }
    public function add_cart(Request $request){

        $userId=Auth::id();
        $activity=Activity::with('single_photo')->find($request->instance_id);

        $item= Cart::getContent();
       // dd($items);

       // if(empty($item) || Cart::isEmpty()){

            Cart::add(array(
                'id' => $activity->id,
                'name' => $activity->activity_name,
                'price' => $activity->price,
                'quantity' => 1,
                'value' => $activity->price,
                'image' => $activity->single_photo->photo,
                'currency' => $activity->currency,
                'target' => 'total',
                'attributes' => array()
            ));
//        }else{
//            $plus=(count($item)+1);
//            Cart::update($plus, array(
//                'id' => $activity->id,
//                'name' => $activity->activity_name,
//                'image' => $activity->single_photo->photo,
//                'price' => $activity->price,
//                'target' => 'total',
//                'value' => $activity->price,
//                'currency' => $activity->currency,
//                ));
//        }
        $items = Cart::getContent();
        return count($items);
       // return $items->count();
    }
    public function cart(Request $request){
          $items = Cart::getContent();
        dump($items);
      return count($items);
    }

public function remove_cart(Request $request){
        $id =$request->instance_id;
        $products = Cart::getContent();
dump($products->count());
    foreach ($products as $key => $value)
    {
        echo $key.'tttttt'.$value['id'].'  id ='.$id;
        if ($value['id'] == $id)
        {
            echo "inn condition";
            dump($products[$key]);
            //unset($products[$key]);
            Cart::remove($id);
        }
        //$request->session()->push('cart',$products);
        //then you can redirect or whatever you need
        return redirect()->back();
    }
}
    public function checkout(){
        $cartTotalQuantity = Cart::getContent();
        //dd($cartTotalQuantity);
       // $summedPrice = Cart::getPriceSum();


        return view('activities/checkout');
    }

    //////////// imran travel activity search //////////

    public function search()
    {
        echo 'ddd';

exit;

        $subcat_place = Category::where('parent_id','3')->orderBy('order_no','ASC')->get();
        ///////////////////////////////////////////////////////////////////////////
        $restaurants = Activity::select('stars', 'id', 'description', 'category_id', 'activity_name', 'slug')
            ->with(['single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->where('category_id', '=', 3);
                $query->Where('main', '=', 1);
            }])
            /*->with(['fav_restaurant' => function ($query) {
                $query->where('category_id', '=', 2);
                $query->where('instance_id', '=', 2);
            }])*/
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 3);
                }])
            /*->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 2);
                }])*/
            ->with(['subCategories' => function ($query) {
                $query->where('category_id', '=', 3);
            }]);

        /*  //////////////////////if login get favoruite list also
          if (!empty(Auth::user()->user_id)) {
              $restaurants->with(['fav_restaurant' => function ($query) {
                  $query->where('category_id', 3);
                  $query->where('user_id', Auth::user()->user_id);
              }]);
          }*/
        $restaurants->where('status', 'Active');

        /** filter by city here */
        /* if (Input::get('term') && Input::get('type') == "city") {

             $restaurants->whereHas(
                 'address', function ($query) {
                 $query->where('category_id', '=', 2);
                $Cities = Cities::select('name')->find(Input::get('city_id'));

               if($Cities !='')
                $query->Where("city", $Cities->name);

             }
             );
         }*/

        if (Input::get('activtiy_term') && Input::get('type') == 'city' || Input::get('activity_type') == 'city') {
            $restaurants->whereHas(
                'address', function ($query) {
                $query->where('category_id', '=', 3);
                $query->Where('city', '=', trim(strtok(Input::get('activtiy_term'), ",")));
            }
            );
        }


        if (Input::get('activtiy_term') && Input::get('type') == "activities" || Input::get('activity_type') == 'activities') {
            // $restaurants->where('id', Input::get('city_id'));
             $restaurants->Where('activities.activity_name', 'like', '%' . trim(Input::get('term')) . '%');
        }
        ////////////////filter by sub cat
        if (Input::get('cuisine')) {
            $restaurants->whereHas(
                'subCategories', function ($query) {
                $query->where('category_id', '=', 3);
                if (Input::get('cuisine')) {
                    $query->Where("subcategory_id", "=", Input::get('cuisine'));
                }
            }
            );
        }
        // DB::enableQueryLog();
        if(isset($_GET['sort']) && $_GET['sort']=='name'){
            $restaurants->orderBy('activity_name','ASC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='recent'){
            $restaurants->orderBy('id','DESC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='rating'){
            $restaurants->orderBy('review_rating','DESC');
        }
        $restaurants = $restaurants->paginate(15);
    //dd($restaurants);
        // print_r(DB::getQueryLog()); exit;
        //$places=$restaurants;
        $map_list = '';
        $marker_list = '';
        $map_data = array();
        $marker_data = array();
        /*echo '<pre>';
        print_r($restaurants);
        exit;*/
        if (!empty($restaurants) && sizeof($restaurants) > 0) {
            foreach ($restaurants as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }
                $data['name'] = @$obj->activity_name;
                $data['location_latitude'] = @$obj->single_address->latitude;
                $data['location_longitude'] = @$obj->single_address->longitude;
                $data['map_image_url'] = $map_image = url('uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->place_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('uploads/subcategory/' . $icon);
                $data['phone'] = @$obj->phone;
                $data['url_point'] = url('restaurants/detail/' . @$obj->slug);
                $place_list[] = $data;

                ////////////////////Add Map Data Array/////
                $maps = array($data['name'], $data['location_latitude'], $data['location_longitude']);
                // $marker = array('<div class="info_content" style="width:500px;height:350px;"><h5>' . $data['name'] . '</h5>
                //  <img width="200px" height="150px" src="' . url($map_image) . '" alt="Image"/><span>' . $data['description_point'] . '</span></div>');

                $marker = array('<div class="infoBox" >
                <div class="marker_info_2">
                <img  src="' . url($map_image) . '" alt="Image">
                <h3>' . $data['name'] . '</h3>
                <span>' . $data['description_point'] . '</span>
                <div class="marker_tools">
                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block" "="">
                <input name="saddr" value="" type="hidden">
                <input name="daddr" value="' . $data['location_latitude'] . ',' . $data['location_longitude'] . '" type="hidden">
                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>
                </form>
                </div>
                </div></div>');

                $map_data[] = $maps;
                $marker_data[] = $marker;
                /////////////////////End Map data//
            }

            //$lat = $data['location_latitude'];
            // $long = $data['location_longitude'];
            //dd($place_list);
            $map_list = json_encode($map_data);
            $marker_list = json_encode($marker_data);

            //  dd($_GET['ajax']);
            if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
                echo view('search/searchIndex', compact('sub_cat', 'city_lat_lng', 'map_list', 'marker_list'))->with('restaurants', $restaurants);
                //echo view('restaurants/searchRestaurant',compact( 'sub_cat', 'city_lat_lng','map_list','marker_list'))->with('restaurants', $restaurants);
            } else
                $places=$restaurants;
            return view('search/searchIndex', compact('restaurants','places', 'sub_cat','subcat_place', 'city_lat_lng', 'map_list', 'marker_list'));
            //return view('places/search', compact('places', 'sub_cat', 'map_list','marker_list', 'subcat'));
            //dd($restaurants);
        } else {
            Session::flash('activity_search_error', "No data found ");
            return redirect()->back();
        }

    }

    public function detail(Request $request)
    {
        // id sent to load this actitivty...
        $activity_id = $request->id;
      //  dd($activity_id);
        // get data from activities table
        $item= Activity::select('*')->where(array('slug'=>$activity_id,'status'=>'Active'))
       // $data= Activity::select('*')->where(array('slug'=>$activity_id,'status'=>'Active'))
       // $item = Activity::select('*')->where(array('slug' => $activity_id, 'status' => 'Active'))
            // $data= Activity::select('*')->where(array('slug'=>$activity_id,'status'=>'Active'))
            ->orderBy('updated_at', 'DESC')
            ->with('subCategories_edit')
            ->with([
                'photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=', $this->activityCategory->id);
                    $querys->orderBy('main','DESC');
                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->activityCategory->id);

                }])->with('reviews_avg')->first();
              //dd($item);
            //$item=$data;
              if (isset($item->address) && !empty($item->address)) {
                $lat=$item->address->latitude;
                $long=$item->address->longitude;
                $name=$item->restaurant_name;
        }

     // dd($item);
        if (isset($item) && !empty($item)) {
            $reviews = Reviews::where('instance_id', $item->id)
                ->where('category_id', 3)
                ->with('user_detail')->get();
        }


          if (isset($item) && !empty($item)) {
            $favoruite = Favourite::where('instance_id', $item->id)
                ->where('category_id', 3)
                ->where('user_id',Auth::id())->first();
        }
        $reviews = Reviews::where('instance_id', $item->id)
            ->where('category_id', 3)
            ->with('user_detail')->get();

       // dd($item->id);
        //$data = Activity::select('*')->where(array('id'=>$activity_id,'status'=>'Active'))->first()->toArray();
        // load view file called detailed
       // return view("activities.detailed",$item, compact('activity_detail','lat','long','name','reviews','item','favoruite'));
        if (empty($item)) {
            return redirect(404);
        }else
        return view("activities.detailed",compact('activity_detail','lat','long','name','reviews','item','favoruite'));
    }

    //////////////////Acticity Data from Tripxonic.////


    public function index()
    {

        $sub_cat_detail = $this->cat_detail;
        ///////////////////////get restaurant listing/////////////////////
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_name,cat_image,count(categories.id) as total'))->where('parent_id', 2)->
        join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->Where('status','Active')
        ->groupby('categories.slug', 'categories.id','parent_id','cat_name','cat_image')->orderBy('order_no','ASC')->get();

        $listing = Places::with([
            'single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->Where('category_id', '=', 2);
                $query->Where('main', '=', 1);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 2);
                }]);
        if (!empty(Auth::user()->user_id)) {
            $listing->with(['fav_place' => function ($query) {
                $query->where('category_id', 3);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        $listing->Where('places.status','Active');

        if (Input::get('sort') == 'Name') {
            $listing->orderBy('place_name', 'ASC');
        } elseif (Input::get('sort') == 'Rating') {
            $listing->orderBy('stars', 'DESC');
        } else {
            $listing->orderBy('price', 'DESC');
        }
        $listing = $listing->paginate(15);

        return view('activity/index', compact('listing', 'sub_cat_detail', 'sub_cat'));
    }

    public function subcategory($code, $country, $city, $slug)
    {
        $string = str_replace('-', ' ', $city);
        $this->city = $string;
        $this->code = $code;
        //get sub cat id by slug
        $sub_cat_id = Category::select('id', 'cat_name', 'icon', 'slug')->where('slug', $slug)->first();
        if (empty($sub_cat_id)) {
            return redirect(404);
        }
        //get sub cat list for side bar
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))
            ->where('parent_id', 2)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->Where('status', '=', 'Active')
            ->groupby('categories.slug,categories.id,parent_id,cat_image,cat_name')->orderBy('order_no','ASC')->get();
        // ->Where('deleted_at', '=', NULL)

        //get a listing of restaurnt of givien subcategory
        $listing = Places::select('id', 'is_featured', 'stars', 'category_id', 'description', 'slug', 'place_name')
            ->with(['single_photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
                $query->Where('main', '=', 1);

            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 2);
                }]);


        $listing->whereHas(
            'subcategories', function ($query) use ($sub_cat_id) {
            $query->where('category_id', '=', 2);
            $query->Where("subcategory_id", "=", $sub_cat_id->id);
        });

        if (!empty(Auth::user()->user_id)) {
            $listing->with(['fav_place' => function ($query) {
                $query->where('category_id', 2);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        if (Input::get('sort') == 'Name') {
            $listing->orderBy('place_name', 'ASC');
        } elseif (Input::get('sort') == 'Rating') {
            $listing->orderBy('stars', 'DESC');
        } else {
            $listing->orderBy('is_featured', 'ASC');
        }
        $listing->whereHas(
            'address', function ($query) {
            $query->where('category_id', '=', 2);
            $query->Where('city', '=', $this->city);
            $query->Where('country', '=', $this->code);
        }
        );
        $listing->Where('places.status', '=', 'Active');
        $listing = $listing->orderBy('order_no','ASC')->paginate(15);

        return view('activity/more_activities', compact('listing', 'sub_cat', 'code', 'city', 'country'))->with('sub_cat_detail', $sub_cat_id);
    }
//    public function detail($subcat, $id)
//    {
//        $item = Places::where('id', $id)->orWhere('slug', $id)
//            ->with([
//                'photo' => function ($query) {
//                    $query->select('main', 'photo_id', 'photo', 'instance_id');
//                    $query->Where('category_id', '=', 2);
//                    $query->orderBy('main', 'DESC');
//                }])
//            ->with([
//                'address' => function ($qury) {
//                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
//                    $qury->Where('category_id', '=', 2);
//                }])->with([
//                'reviews_avg' => function ($qury) {
//                    $qury->Where('category_id', '=', 2);
//                }]);
//        if (!empty(Auth::user()->user_id)) {
//            $item->with(['fav_place' => function ($query) {
//                $query->where('category_id', 2);
//                $query->where('user_id', Auth::user()->user_id);
//            }]);
//        }
//        $item = $item->first();
//
//        $request = $_GET;
//        $request['source'] = 'hotel_bed';
//        $request['code'] = $item->external_id;
//        $hotelBed = app('App\Http\Controllers\Api\ApiActivity')->detail($request);
//
//        foreach ($hotelBed['photo'] as $photoObj) {
////            $explode = explode('/', $photoObj['photo']);
////           // $rand = mt_rand();
////            $path = $_SERVER['DOCUMENT_ROOT'] . '/tripxonicuploads/places/' . $explode[2];
////            file_put_contents($path, file_get_contents($photoObj['photo']));
////            $imgUrl = 'places/' . $explode[6];
//
//            $photo = Photo::create([
//                // 'photo' => $explode[2],
//                'photo' =>  $photoObj['photo'],
//                'category_id' => 2,
//                'instance_id' => $item->id,
//                'main' => 0
//            ]);
//        }
//
//        //@@@@@@@@@@@@@@@@@@@@@@@@   Get single activity  @@@@@@@@@@@@@@@@@@@@@///
//        if (isset($item->id) && !empty($item->id)) {
//            $rating = Reviews::where('instance_id', $item->id)
//                ->where('category_id', 2)
//                ->with('user_detail')->get();
//            return view('activity/item', compact('item', 'rating','hotelBed'));
//        } else {
//            return redirect('activities');
//        }
//    }
    public function item_detail($id)
    {
        $item = Places::where('id', $id)->orWhere('slug', $id)
            ->with([
                'photo' => function ($query) {
                    $query->select('main', 'photo_id', 'photo', 'instance_id');
                    $query->Where('category_id', '=', 2);
                    $query->orderBy('main', 'DESC');
                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 2);
                }])->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 2);
                }]);
        if (!empty(Auth::user()->user_id)) {
            $item->with(['fav_place' => function ($query) {
                $query->where('category_id', 2);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        $item = $item->first();
        $request = $_GET;
        $request['source'] = 'hotel_beds';
        $request['code'] = $item->external_id;
        $hotelBed = app('App\Http\Controllers\Api\ApiActivity')->detail($request);
        foreach ($hotelBed['photo'] as $photoObj) {
//            $explode = explode('/', $photoObj['photo']);
//           // $rand = mt_rand();
//            $path = $_SERVER['DOCUMENT_ROOT'] . '/tripxonicuploads/places/' . $explode[2];
//            file_put_contents($path, file_get_contents($photoObj['photo']));
//            $imgUrl = 'places/' . $explode[6];

            $photo = Photo::create([
                // 'photo' => $explode[2],
                'photo' => $photoObj['photo'],
                'category_id' => 2,
                'instance_id' => $item->id,
                'main' => 0
            ]);
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@   Get single activity  @@@@@@@@@@@@@@@@@@@@@///
        if (isset($item->id) && !empty($item->id)) {
            $rating = Reviews::where('instance_id', $item->id)
                ->where('category_id', 2)
                ->with('user_detail')->get();
            return view('activity/item', compact('item', 'rating', 'hotelBed'));
        } else {
            return redirect('activities');
        }
    }


    ///////////// Bokun Api integration..///////
    public function check_availabilities()
    {
        $place_detail = Places::where('external_id', $_GET['id'])->first();
        //@@@@@@@@@@@@@@@@@@@@@@@@   Get single activity  @@@@@@@@@@@@@@@@@@@@@///
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cGET/activity.json/" . $_GET['id'];
        $seceret = "656b1a3490c74789b025fead9a88c084";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $ch = curl_init("https://api.bokuntest.com/activity.json/" . $_GET['id']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
                'Content-Type: application/json',
                //'Content-Length:' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $item1 = json_decode($result);
        //dd($item1);
        $item1->place_detail = $place_detail;
        if (isset($_GET['id']) && !empty($_GET['id'])) { ////check if activity exist or not
            return view('activity/check-availabilities', compact('product_id', 'listing', 'item1', 'pickup_places'))->with('external_id', $_GET['id']);
        } else {
            return redirect('home');
        }
    }

    /*  public function ActivityAutoSearch(Request $request)
      {
          $city = Country::selectRaw('countries.name as country_name,cities.name as city_name,cities.id as city_id')->join('cities', 'cities.country_code', '=', 'countries.code')
              ->where('cities.status', 'Active')->where(function ($query) use ($request) {
                  $query->where('countries.name', 'LIKE', '%' . $request->term . '%');
                  $query->orwhere('cities.name', 'LIKE', '%' . $request->term . '%');
              })->take(5)->get();

          $data_name = Places::select('id', 'place_name')
              ->where('place_name', 'LIKE', '%' . $request->term . '%')
              ->where('category_id', 2)
              ->where('source', 'hotel_beds')
              ->groupBy('id')
              ->get();

          if (!empty($city)) {
              foreach ($city as $row) {
                  $row_set[] = array(
                      "value" => $row['city_name'] . ', ' . $row['country_name'],
                      'id' => $row["city_id"], 'type' => 'city'
                  );
              }
          }
          if (!empty($data_name)) {
              foreach ($data_name as $row) {
                  $row_set[] = array("value" => $row['place_name'],
                      "id" => $row['id'], 'type' => 'activity'); //build an array
              }
          }
          if (!empty($row_set)) {
              echo json_encode($row_set); //format the array into json data
          } else {
              $row_set[] = "No records found";
              echo json_encode($row_set);
          }
      }
  */
    public function calender_data()
    {
        $start_date = $_REQUEST['year'] . '-' . $_REQUEST['month'] . '-' . '01';
        $end_date = date('Y-m-d', strtotime('+2 month', strtotime($start_date)));
        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cGET/availabilities?start=$start_date&end=$end_date&lang=EN&currency=ISK&includeSoldOut=true";
        $seceret = "656b1a3490c74789b025fead9a88c084";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $ch = curl_init("https://api.bokuntest.com/activity.json/" . $_REQUEST['id'] . "/availabilities?start=$start_date&end=$end_date&lang=EN&currency=ISK&includeSoldOut=true");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
                'Content-Type: application/json',
                //'Content-Length:' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $test);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $upcoming_event1 = json_decode($result);
        if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
            $year = intval($_REQUEST['year']);
            $month = intval($_REQUEST['month']);
            $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));
            $dates = array();
            for ($i = 0; $i < count($upcoming_event1); $i++) {
                //$date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, $lastday), 2, '0', STR_PAD_LEFT);
                $formate = str_replace("'", " ", $upcoming_event1[$i]->localizedDate);
                $date = date('Y-m-d', strtotime($formate));
                $dates[$i] = array(
                    'date' => $date,
                    'badge' => ($upcoming_event1[$i]->soldOut == true) ? true : false,
                    'title' => $date,
                    'body' => '<p class="minParticipants"><b>Minimum participants: </b>' . $upcoming_event1[$i]->minParticipants . '</p>
                    <p class="availabilityCount"><b>Available: </b>' . $upcoming_event1[$i]->availabilityCount . '</p>
                    <p class="bookedParticipants"><b>Booked Participants: </b>' . $upcoming_event1[$i]->bookedParticipants . '</p>',
                    'footer' => '',
                );
                if (!empty($_REQUEST['grade'])) {
                    $dates[$i]['badge'] = false;
                    $dates[$i]['classname'] = 'grade-' . rand(1, 4);
                }
            }
            echo json_encode($dates);
        } else {
            echo json_encode(array());
        }
    }

    public function genrate_pdf_invoice($id)
    {
//        DB::enableQueryLog();
//        $pdf_report = Order::select('places.id','activity_detail.child_price','activity_detail.infant_price','places.place_name','booking_date','activity_detail.price','orders.track_id','user_id',
//            'quantity','adults','children','infants','total','first_name','last_name','email','orders.phone','country','orders.created_at')
//            ->join('places', 'places.id', '=', 'orders.instance_id')
//          ->join('order_detail', 'order_detail.activity_id', '=', 'orders.instance_id')
////'activity_detail.price'
//            ->where('orders.category_id','=',2)
//            ->where('orders.track_id',$id)
//        ->first();
//       dd(DB::getQueryLog());
//       dd($pdf_report);
        $order = Order::where('track_id', $id)->first();
        $bookingConfirm = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/bookings/en/' . $order->track_id);
        //        $resp = file_get_contents(url('hotel_beds/hotels_booking_confirm.json'));
//        $bookingConfirm = json_decode($resp);
        if (isset($bookingConfirm->booking) && !empty($bookingConfirm->booking)) {
            $formData['track_id'] = $bookingConfirm->booking->reference;
            $formData['instance_id'] = $bookingConfirm->booking->activities[0]->code;
            $formData['status'] = $bookingConfirm->booking->status;
            $formData['pending_amount'] = $bookingConfirm->booking->pendingAmount;
            $formData['total'] = $bookingConfirm->booking->total;
            $formData['first_name'] = $bookingConfirm->booking->holder->name;
            $formData['currency'] = $bookingConfirm->booking->currency;
            $formData['last_name'] = $bookingConfirm->booking->holder->surname;
            $formData['phone'] = @$bookingConfirm->booking->holder->telephones[0];
            $formData['email'] = @$bookingConfirm->booking->holder->email;
            foreach ($bookingConfirm->booking->activities as $objSupplier) {
                $formData['supplier_phone'] = @$objSupplier->contactInfo->telephone;
                $formData['supplier_address'] = @$objSupplier->contactInfo->address;
                $formData['supplier_country_id'] = @$objSupplier->contactInfo->country->code;
                $formData['supplier_city'] = @$objSupplier->contactInfo->country->destinations[0]->name;
                $formData['supplier_name'] = @$objSupplier->supplier->name;
                $order_detail = array(
                    'type' => @$objSupplier->type,
                    'date_to' => @$objSupplier->dateFrom,
                    'date_from' => @$objSupplier->dateTo,
                    'booking_reference' => @$objSupplier->activityReference,
                    'activity_code' => @$objSupplier->code,
                    'name' => @$objSupplier->name,
                    'unit_price' => @$bookingConfirm->booking->total,
                    //'unit_price' => $bookingConfirm->booking->hotel->totalNet,
                    'total' => @$bookingConfirm->booking->total,
                    'status' => @$bookingConfirm->booking->status,
                    'paxes' => @$objSupplier->paxes,
                );
                $formData['activity_detail'][] = $order_detail;
                $formData['cancellationPolicies'] = @$objSupplier->cancellationPolicies;
                $formData['startingPoints'] = @$objSupplier->content->location->startingPoints[0];
                $formData['adults'] = @$order->adults;
                $formData['children'] = @$order->children;
            }
        }
        $view = \View::make('activity/activity_ticket')->with('item', @$formData);
        $html = $view->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function cancel_booking($id)
    {
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cPOST/booking.json/cancel-booking/$id";
        $seceret = "656b1a3490c74789b025fead9a88c084";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $data = array(
            "note" => "We had to cancel this due to weather.",
            "refund" => true,
            "notify" => true
        );
        $data_string = json_encode($data);
        $ch = curl_init("https://api.bokuntest.com/booking.json/cancel-booking/$id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
                'Content-Type: application/json',
                'Content-Length:' . strlen($data_string)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $item1 = json_decode($result);
        if ($item1->message == "OK") {
            Order::where('track_id', $id)->delete();
            Session::flash('success_msg', 'Your booking has been cancel successfully');
            return redirect('/profile');
        } else {
            return redirect('/profile')->withErrors(array('error_msg' => $item1->message));
        }

    }

    public function getActivitiesMore($code, $country, $city)
    {

        $sub_cat_detail = $this->cat_detail;

        $string = str_replace('-', ' ', $city);
        $this->city = $string;
        $this->code = $code;
        // sub category ///////////////////////
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))
            ->where('parent_id', 2)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->Where('status', '=', 'Active')
            ->groupby('categories.id')->get();

        $listing = Places::select('id', 'place_name', 'stars', 'description', 'slug', 'track_id', 'category_id', 'created_at', 'status')->with([
            'single_photo' => function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                $query->Where('main', '=', 1);

            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);


                }])->orderBy('place_name', 'ASC')->Where('places.source', '=', 'hotel_beds');;

        if (!empty(Auth::user()->user_id)) {
            $listing->with(['fav_place' => function ($query) {
                $query->where('category_id', 2);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        $listing->whereHas(
            'address', function ($query) {
            $query->where('category_id', '=', 2);

            $query->Where('city', '=', $this->city);
            $query->Where('country', '=', $this->code);
        }
        );
        $listing = $listing->paginate(15);
        $locations = array();
        /*   $url='https://maps.googleapis.com/maps/api/distancematrix/xml?origins=Vancouver+BC|Seattle&destinations=San+Francisco|Vancouver+BC&mode=bicycling&language=fr-FR&key=AIzaSyCs9wkj4Lz_ZQYYrI1yFeorC-ejnnCVKA4';
           $str = file_get_contents($url);*/
        foreach ($listing as $location) {

            $dataPlace['address'] = $location->address->address;
            $dataPlace['lat'] = $location->address->latitude;
            $dataPlace['lng'] = $location->address->longitude;
            $place_distance[] = $dataPlace;

        }
        $lat = @$dataPlace['lat'];
        $long = @$dataPlace['lng'];

        // array_push($locations, $place_list);
        //Output JSON
        @$place_distance = json_encode($place_distance);

        //  exit;
        return view('activity/more_activities', compact('listing', 'code', 'city', 'country', 'lat', 'long', 'place_distance', 'sub_cat_detail', 'sub_cat', 'subcat'));

    }
    public function allActivities(){

        $subcat_place = Category::where('parent_id','1')->orderBy('order_no','ASC')->get();
        $sub_category = Category::where('parent_id','2')->orderBy('order_no','ASC')->get();
        $activtySubcategory  = Category::where('parent_id','3')->orderBy('order_no','ASC')->get();

        $ActivityData= Activity::select('activities.id', 'activity_name','slug','price', 'review_rating','duration',
            'excerpt','description','currency','activities.status', 'activities.order_no', 'activities.created_at')->orderBy('order_no')
            ->with('subCategories_edit')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=',  $this->activityCategory->id);
                    $querys->Where('main', '=', 1);

                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=',  $this->activityCategory->id);
                }])->where('status','Active')->orderBy('order_no','ASC')->paginate(24);
        return view('activities/activity_more_listing',compact('subcat_place','sub_category','activtySubcategory','ActivityData'));
    }
    public function get_activities(Request $request)
    {

        $option_list = "";
        $categories = Category::where('parent_id', '2')->get();


        $ActivityData= Activity::select('activities.id', 'activity_name','price', 'review_rating','duration',
            'excerpt','description','currency','activities.status', 'activities.order_no', 'activities.created_at')->orderBy('updated_at', 'DESC')
            ->with('subCategories_edit')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=',  $this->activityCategory->id);
                    $querys->Where('main', '=', 1);

                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=',  $this->activityCategory->id);
                }])->where('status','Active')->orderBy('order_no','ASC')->paginate(15);



        foreach ($ActivityData as $row) {
            /*  $option_list .= '<div class="col-md-4 col-sm-6">
                                     <a href="'.url('restaurants/').'/'.$row->slug.'">
                                         <div class="d-flex justify-content-center img_wrapper">
                                             <img src="'.url('uploads/').'/'.$row->cat_image.'">
                                             <div class="hover_txt">
                                                 <h4>'.$row->cat_name.'</h4>

                                             </div>
                                         </div>

                                     </a>
                                 </div>';*/
            $option_list='<div class="col-lg-3 col-md-4 col-sm-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                
                                    <a href="'.url("activities/detail/".$row["id"]).'" style="overflow: visible;">
                                    <span class="post_time">"'.$row["duration"].'"</span>
                                    <div class="d-flex justify-content-center img_wrapper">
                                        
                                       
                                        <div class="d-flex justify-content-center align-items-center hover_txt">
                                            <p>"'.ubstr($row["description"],0,100).'"
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                        <span>May - Oct</span>
                                    </div>
                                    <div class="select_plan">


                                        <span>From:
                                            <strong>"'.$row["price"].'"</strong>
                                        </span>
                                        <!-- <select class="selectpickerCustom"> -->
                                        <select class="selectpicker">
                                            <option value="USD">USD</option>
                                            <option value="AUD">AUD</option>
                                            <option value="CAD">CAD</option>
                                            <option value="CHF">CHF</option>
                                            <option value="DKK">DKK</option>
                                            <option value="EUR">EUR</option>
                                            <option value="GBP">GBP</option>
                                            <option value="HKD">HKD</option>
                                            <option value="ISK">ISK</option>
                                            <option value="JPY">JPY</option>
                                            <option value="KRW">KRW</option>
                                            <option value="NOK">NOK</option>
                                            <option value="PLN">PLN</option>
                                            <option value="RUB">RUB</option>
                                            <option value="SEK">SEK</option>
                                            <option value="SGD">SGD</option>
                                        </select>
                                    </div>
                                    <span class="place_name">"'.$row['activity_name'].'"</span>

                                </a>


                            </div>';
        }
        echo $option_list;
    }
// //////////////  Activity search //////////////////////

    public function searchAct()
    {
        $input=Input::get('activtiy_term');
        // $se=trim(Input::get('activtiy_term'), ",");
        // $imp=explode(",", $se);
        //$se=trim(Input::get('activtiy_term'), ",");
        
    

        $date= explode("-",Input::get('daterange'))  ;
        $startDate[0]=explode(" ",@$date[0]);
        $endDate[1]=explode(" ",@$date[1]);

        $activtySubcategory= $subcat_place = Category::where('parent_id','3')->orderBy('order_no','ASC')->get();
        $sub_category = Category::where('parent_id','2')->orderBy('order_no','ASC')->get();
        ///////////////////////////////////////////////////////////////////////////
        $restaurants = Activity::select( 'id', 'description', 'category_id','price', 'activity_name', 'slug')
            ->with(['single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->where('category_id', '=', 3);
                $query->Where('main', '=', 1);

            }])
            ->with(['favoruite' => function ($query) {
                $query->where('category_id', '=', 3);

            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 3);
                }])
            /*->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 2);
                }])*/
            ->with(['subCategories' => function ($query) {
                $query->where('category_id', '=', 3);
            }]);

        /*  //////////////////////if login get favoruite list also
          if (!empty(Auth::user()->user_id)) {
              $restaurants->with(['fav_restaurant' => function ($query) {
                  $query->where('category_id', 3);
                  $query->where('user_id', Auth::user()->user_id);
              }]);
          }*/
        $restaurants->where('status', 'Active');

        /** filter by city here */
        /* if (Input::get('term') && Input::get('type') == "city") {

             $restaurants->whereHas(
                 'address', function ($query) {
                 $query->where('category_id', '=', 2);
                $Cities = Cities::select('name')->find(Input::get('city_id'));

               if($Cities !='')
                $query->Where("city", $Cities->name);

             }
             );
         }*/

        if (Input::get('activtiy_term') && Input::get('activity_type') == 'city') {
            $se=trim(Input::get('activtiy_term'), ",");
            $imp=explode(",", $se);

            $restaurants->whereHas(
                'address',function ($query) use ($imp) {
                $query->where('addresses.category_id', '=', 3);
                // $query->Where('city', '=', trim(strtok(Input::get('activity_type'), ",")));
                 $query->Where('addresses.city', $imp[0]);
               // $query->Where('addresses.city', '=', Input::get('activtiy_term'));
                
            }
            );
        }


        if (Input::get('activtiy_term') && Input::get('activity_type') == "activity") {
            // $restaurants->where('id', Input::get('city_id'));
            $restaurants->Where('activities.activity_name', 'like', '%' . trim(Input::get('activtiy_term')) . '%');
        }
        ////////////////filter by sub cat
        if (Input::get('cuisine')) {
            $restaurants->whereHas(
                'subCategories', function ($query) {
                $query->where('category_id', '=', 3);
                if (Input::get('cuisine')) {
                    $query->Where("subcategory_id", "=", Input::get('cuisine'));
                }
            }
            );
        }
        /* $restaurants->whereHas(
             'keywords', function ($query) {
             $query->where('keywords.category_id', '=', 3);

         }
         );*/
        // DB::enableQueryLog();
        $restaurants = $restaurants->orderBy('order_no','ASC')->paginate(10);
        $places=$restaurants;
//dd($restaurants);


        // print_r(DB::getQueryLog()); exit;
        //$places=$restaurants;
        $map_list = '';
        $marker_list = '';
        $map_data = array();
        $marker_data = array();

        if (!empty($restaurants) && sizeof($restaurants) > 0) {
            foreach ($restaurants as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }
                $data['name'] = @$obj->activity_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->place_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('uploads/subcategory/' . $icon);
                $data['phone'] = @$obj->phone;
                $data['url_point'] = url('restaurants/detail/' . @$obj->slug);
                $place_list[] = $data;

                ////////////////////Add Map Data Array/////
                $maps = array($data['name'], $data['location_latitude'], $data['location_longitude']);
                // $marker = array('<div class="info_content" style="width:500px;height:350px;"><h5>' . $data['name'] . '</h5>
                //  <img width="200px" height="150px" src="' . url($map_image) . '" alt="Image"/><span>' . $data['description_point'] . '</span></div>');

                $marker = array('<div class="infoBox" >
                <div class="marker_info_2">
                <img  src="' . url($map_image) . '" alt="Image">
                <h3>' . $data['name'] . '</h3>
                <span>' . $data['description_point'] . '</span>
                <div class="marker_tools">
                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block" "="">
                <input name="saddr" value="" type="hidden">
                <input name="daddr" value="' . $data['location_latitude'] . ',' . $data['location_longitude'] . '" type="hidden">
                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>
                </form>
                </div>
                </div></div>');

                $map_data[] = $maps;
                $marker_data[] = $marker;
                /////////////////////End Map data//
            }

            //$lat = $data['location_latitude'];
            // $long = $data['location_longitude'];
            //dd($place_list);
            $map_list = json_encode($map_data);
            $marker_list = json_encode($marker_data);
  // dd($places);
            //  dd($_GET['ajax']);
            if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
                echo view('search/searchIndex', compact('sub_cat', 'city_lat_lng','places', 'map_list', 'marker_list'))->with('restaurants', $restaurants);
                //echo view('restaurants/searchRestaurant',compact( 'sub_cat', 'city_lat_lng','map_list','marker_list'))->with('restaurants', $restaurants);
            } else
                $places=$restaurants;
            return view('search/searchIndex', compact('restaurants','sub_category','places', 'sub_cat','activtySubcategory','subcat_place', 'city_lat_lng', 'map_list', 'marker_list'));
            //return view('places/search', compact('places', 'sub_cat', 'map_list','marker_list', 'subcat'));
            //dd($restaurants);
        } else {
            /*Session::flash('activity_search_error', "No data found ");
            return redirect()->back();*/
            $places=$restaurants;

            return view('getActivitiesBySubCat',compact('sub_category','places'))
                ->with('activtySubcategory',$activtySubcategory)
                ->with('subcat_place',$subcat_place);

        }

    }
    // /////////////////////////////// get activities by subcategories ////////////////
    public function get_activities_bySubCat($slug)
    {
        //get sub cat id by slug
        $sub_cat_id = Category::select('id', 'cat_name', 'icon', 'slug')->where('slug', $slug)->first();
        if (empty($sub_cat_id)) {
            return redirect(404);
        }
        //get sub cat list for side bar
        $subcat_place = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))
            ->where('parent_id', 1)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->Where('status', '=', 'Active')
            ->groupby('categories.slug,categories.id,parent_id,cat_image,cat_name')->orderBy('order_no','ASC')->get();
        //get a listing of restaurnt of givien subcategory
        $listing = activity::select('id', 'is_featured', 'website_url', 'category_id',
            'order_no', 'description', 'slug', 'activity_name')
            ->with(['single_photo' => function ($query) {
                $query->where('category_id', '=', 3);
                $query->Where('main', '=', 1);

            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 3);
                }]);
        $listing->whereHas(
            'subcategories', function ($query) use ($sub_cat_id) {
            $query->where('category_id', '=', 3);
            $query->Where("subcategory_id", "=", $sub_cat_id->id);
        });
        $listing->whereHas(
            'keywords', function ($query) {
            $query->where('category_id', '=', 3);

        });
        $places = $listing->where('status','Active')->orderBy('order_no','ASC')->paginate(15);
        //  $places = $listing->paginate(20);

        $map_list = '{}';
        $marker_list = '{}';

        if (!empty($places) && sizeof($places) > 0) {

            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }

                $data['name'] = @$obj->activity_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->activity_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('uploads/subcategory/' . $icon);
                $data['phone'] = @$obj->phone;
                $data['url_point'] = url('places/detail/' . @$obj->slug);
                $place_list[] = $data;

                ////////////////////Add Map Data Array/////
                $maps = array($data['name'], $data['location_latitude'], $data['location_longitude']);
                // $marker = array('<div class="info_content" style="width:500px;height:350px;"><h5>' . $data['name'] . '</h5>
                //  <img width="200px" height="150px" src="' . url($map_image) . '" alt="Image"/><span>' . $data['description_point'] . '</span></div>');

                $marker = array('<div class="infoBox" >
                <div class="marker_info_2">
                <img  src="' . url($map_image) . '" alt="Image">
                <h3>' . $data['name'] . '</h3>
                <span>' . $data['description_point'] . '</span>
                <div class="marker_tools">
                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block" "="">
                <input name="saddr" value="" type="hidden">
                <input name="daddr" value="' . $data['location_latitude'] . ',' . $data['location_longitude'] . '" type="hidden">
                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>
                </form>
                </div>
                </div></div>');

                $map_data[] = $maps;
                $marker_data[] = $marker;

                /////////////////////End Map data//
            }
            //$lat = $data['location_latitude'];
            // $long = $data['location_longitude'];
            $map_list = json_encode($map_data);
            $marker_list = json_encode($marker_data);
            // dd($marker_list);


            return view('search/searchIndex', compact('places', 'code', 'country', 'city', 'subcat_place','map_list','marker_list'))->with('sub_cat_detail', $sub_cat_id);
        }else{

            Session::flash('place_search_error', "No data found ");

            return redirect()->back();
        }


    }

    // /////////////////////////////// get activities by subcategories ////////////////
    public function getActivitiesBySubCat($slug)
    {
        //get sub cat id by slug
        $sub_cat_id = Category::select('id', 'cat_name', 'icon', 'slug')->where('slug', $slug)->first();
        $sub_catid=@$sub_cat_id->id;
        /* if (empty($sub_cat_id)) {
             return redirect(404);
         }*/
        //get sub cat list for side bar
        $subcat_place = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))
            ->where('parent_id', 3)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->Where('status', '=', 'Active')
            ->groupby('categories.slug,categories.id,parent_id,cat_image,cat_name')->orderBy('order_no','ASC')->get();
        //get a listing of restaurnt of givien subcategory
        $listing = activity::select('id', 'is_featured', 'website_url', 'category_id',
            'order_no','price', 'description', 'slug', 'activity_name')
            ->with(['single_photo' => function ($query) {
                $query->where('category_id', '=', 3);
                $query->where('main', '=', 1);
            }])
            ->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 3);
                }])/*->with([
                  'keywords', function ($query) {
                  $query->where('multi_keywords.category_id', '=', 3);
              }])*/
            ->with(['favoruite' => function ($query) {
                $query->where('category_id', '=', 3);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 3);
                }]);
        $listing->whereHas(
            'subcategories', function ($query) use ($sub_cat_id) {
            $query->where('category_id', '=', 3);
            $query->Where("subcategory_id", "=", @$sub_cat_id->id);
        });
        if(isset($_GET['sort']) && $_GET['sort']=='name'){
            $listing->orderBy('activity_name','ASC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='recent'){
            $listing->orderBy('activity_name','DESC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='rating'){
            $listing->orderBy('review_rating','DESC');
        }

        $places = $listing->where('status','Active')->paginate(15);
        // dd($places);


        $map_list = '{}';
        $marker_list = '{}';
        if (!empty($places) && sizeof($places) > 0) {

            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }

                $data['name'] = @$obj->activity_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->activity_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('uploads/subcategory/' . $icon);
                $data['phone'] = @$obj->phone;
                $data['url_point'] = url('places/detail/' . @$obj->slug);
                $place_list[] = $data;

                ////////////////////Add Map Data Array/////
                $maps = array($data['name'], $data['location_latitude'], $data['location_longitude']);
                // $marker = array('<div class="info_content" style="width:500px;height:350px;"><h5>' . $data['name'] . '</h5>
                //  <img width="200px" height="150px" src="' . url($map_image) . '" alt="Image"/><span>' . $data['description_point'] . '</span></div>');

                $marker = array('<div class="infoBox" >
                <div class="marker_info_2">
                <img  src="' . url($map_image) . '" alt="Image">
                <h3>' . $data['name'] . '</h3>
                <span>' . $data['description_point'] . '</span>
                <div class="marker_tools">
                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block" "="">
                <input name="saddr" value="" type="hidden">
                <input name="daddr" value="' . $data['location_latitude'] . ',' . $data['location_longitude'] . '" type="hidden">
                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>
                </form>
                </div>
                </div></div>');
                $map_data[] = $maps;
                $marker_data[] = $marker;
                /////////////////////End Map data//
            }

            //$lat = $data['location_latitude'];
            // $long = $data['location_longitude'];

            $map_list = json_encode($map_data);
            $marker_list = json_encode($marker_data);
            // dd($marker_list);
            return view('activities/subcatListing', compact('places', 'code', 'sub_catid', 'country', 'city', 'subcat_place','map_list','marker_list'))->with('sub_cat_detail', $sub_cat_id);
        }else{

//            Session::flash('place_search_error', "No data found ");
//            Session::flash('place_search_error', "No data found ");
            return view('activities/subcatListing')->with('subcat_place', $subcat_place)
                ->with('sub_cat_detail', $sub_cat_id);

//            return redirect()->back();
        }
    }




    ///////////// Hotel BEd Api integration///////////////////

    public function hsearch()
    {
        $request = Input::get();
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_name,cat_image,count(categories.id) as total'))
            ->where('parent_id', 2)->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->
            groupby('categories.id')->orderBy('order_no','ASC')->get();

        if (!isset($request['from']) || !isset($request['to']) || !isset($request['adult']) || !isset($request['children'])) {
            return redirect('/')->withErrors(['error' => 'missing parameters']);
        }
        $request['to'] = date('Y-m-d', strtotime($request['to']));
        // exit;
        $request['from'] = date('Y-m-d', strtotime($request['from']));
        /** filter by subcategory then this code is running*/
        if (isset($request['activity_type']) && !empty($request['activity_type'])) {
            $cityCode = Cities::find($request['city_activity_id']);
            $request['city_code'] = $cityCode->code;
            if (!empty($request)) {
                $data = array(
                    "filters" => array(["searchFilterItems" => array(['type' => 'destination', 'value' => $request['city_code']])]),
                    "from" => $request['from'],
                    "to" => $request['to']
                );
            }
            $hotelBedResult = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/activities', $data);
            if (isset($hotelBedResult->activities) && sizeof($hotelBedResult->activities) > 0) {
                $data2 = array();
                foreach ($hotelBedResult->activities as $obj) {
                    $find = Places::where('external_id', $obj->code)
                        ->with(['single_photo' => function ($query) {
                            $query->where('category_id', 2);
                        }])
                        ->with('address')->whereHas(
                            'subCategories_edit', function ($query) use ($request) {
                            $query->Where('category_id', 2);
                            $query->Where("subcategory_id", $request['activity_type']);
                        })->first();
                    // @$find->price = @$obj->amountsFrom[0]->amount;
                    //dd($find);
                    if (!empty($find)) {
                        $data2[] = $find;
                    }
                }
                $listing = $data2;
                return view('activity/index', compact('listing', 'sub_cat'));
            }
        }
        /** get lat long of a city by request */
        if ($request['search_type'] == "city") {
            $cityCode = Cities::find($request['city_activity_id']);
            $request['city_code'] = $cityCode->code;
            $listing = $this->hotel_bed_search($request);
        } elseif ($request['search_type'] == "activity") {
            /** hotelbeds activity detail */
            $request['code'] = Places::where('id', $request['city_activity_id'])->first()->external_id;
            $listing = $this->hotel_bed_search_by_activity($request);
        }
        $sub_cat_detail = $this->cat_detail;
        return view('activity/index', compact('listing', 'sub_cat_detail', 'sub_cat'));
    }


    public function hotel_bed_search($request)
    {
        $model_obj = new Places();
        $data2 = array();
        if (!empty($request)) {
            $data = array(
                "filters" => array(["searchFilterItems" => array(['type' => 'destination', 'value' => $request['city_code']])]),
                "from" => $request['from'],
                "to" => $request['to']
            );
        }
//        echo '<pre>';
//        echo \GuzzleHttp\json_encode($data);
//        //print_r($hotelBedResult);
//        exit;
        $hotelBedResult = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/activities', $data);

        /** get a temparary data */
//        $resp = file_get_contents(url('hotel_beds/activity/search_by_destination.json'));
//        $hotelBedResult = json_decode($resp);
        if (isset($hotelBedResult->activities) && sizeof($hotelBedResult->activities) > 0) {
            foreach ($hotelBedResult->activities as $obj) {
                $find = Places::where('external_id', $obj->code)->first();
                if (empty($obj->content->name)) {
                    continue;
                }
                $arrayAttribute['id'] = @$obj->content->contentId;
                $arrayAttribute['external_id'] = @$obj->code;
                $arrayAttribute['category_id'] = 2;
                $arrayAttribute['track_id'] = 'ACT-' . mt_rand();
                $arrayAttribute['type'] = "";
                $arrayAttribute['place_name'] = $obj->content->name;
                $arrayAttribute['slug'] = (isset($find->slug) && !empty($find->slug)) ? $find->slug : Functions::slug('', @$obj->content->name, $model_obj);
                $arrayAttribute['currency'] = $obj->currency;
                $arrayAttribute['price'] = $obj->amountsFrom[0]->amount;
                $arrayAttribute['currency'] = $obj->currency;
                $arrayAttribute['pax_type'] = $obj->amountsFrom[0]->paxType;
                $arrayAttribute['ChildUnitCost'] = null;
                $arrayAttribute['QuantityAvailable'] = null;
                $arrayAttribute['description'] = @$obj->content->description;
                $arrayAttribute['address'] = (object)array("country" => @$obj->country->name,
                    "destinations" => @$obj->country->destinations[0]->name,
                    "longitude" => @$obj->content->geolocation->longitude,
                    "latitude" => @$obj->content->geolocation->latitude,
                );
                $arrayAttribute['source'] = 'hotel_beds';
                $arrayAttribute['single_photo'] = (object)array("photo" => @$obj->content->media->images[0]->urls[1]->resource);
                $data2[] = (object)$arrayAttribute;
                if (empty($find)) {
                    $save_responce1 = Places::create($arrayAttribute);
                    ///////////////////////creating image///////////////////////
                    if (isset($obj->content->media->images[0]->urls[1]->resource) && !empty($obj->content->media->images[0]->urls[1]->resource)) {
                        Photo::create([
                            'photo' => $obj->content->media->images[0]->urls[1]->resource,
                            'category_id' => 2,
                            'instance_id' => $save_responce1->id
                        ]);
                    }
                    ///////////////////////// Addresses //////////////////////////
                    $address = array(
                        'instant_id' => $save_responce1->id,
                        'category_id' => 2,
                        'latitude' => @$obj->content->geolocation->latitude,
                        'longitude' => @$obj->content->geolocation->longitude,
                        'city' => @$obj->country->destinations[0]->name,
                        'country' => @$obj->country->code
                    );
                    $data_address = Address::create($address);
                    //$data2[$save_responce1->id]['address'] = $data_address;
                }
            }
            return $data2;
        }
    }
    /** hotelbed search for a single activiy */
    public function hotel_bed_search_by_activity($request)
    {
        $model_obj = new Places();
        if (!empty($request)) {
            $data = array(
                "filters" => array(["searchFilterItems" => array(['type' => 'service', 'value' => $request['code']])]),
                "from" => $request['from'],
                "to" => $request['to']
            );
        }
        $hotelBedResult = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/activities', $data);
        if (isset($hotelBedResult->activities) && sizeof($hotelBedResult->activities) > 0) {
            foreach ($hotelBedResult->activities as $obj) {
                $find = Places::where('external_id', $obj->code)
                    ->with('single_photo')->with('address')->first();
                if (empty($obj->content->contentId)) {
                    continue;
                }
                $arrayAttribute['id'] = @$obj->content->contentId;
                $arrayAttribute['external_id'] = @$obj->code;
                $arrayAttribute['category_id'] = 2;
                $arrayAttribute['track_id'] = 'ACT-' . mt_rand();
                $arrayAttribute['type'] = "";
                $arrayAttribute['place_name'] = (!empty($obj->content->name)) ? $obj->content->name : "Activity";
                $arrayAttribute['slug'] = (isset($find->slug) && !empty($find->slug)) ? $find->slug : Functions::slug('', @$obj->content->name, $model_obj);
                $arrayAttribute['currency'] = $obj->currency;
                $arrayAttribute['price'] = $obj->amountsFrom[0]->amount;
                $arrayAttribute['currency'] = $obj->currency;
                $arrayAttribute['pax_type'] = $obj->amountsFrom[0]->paxType;
                $arrayAttribute['ChildUnitCost'] = null;
                $arrayAttribute['QuantityAvailable'] = null;
                $arrayAttribute['description'] = @$obj->content->description;
                $arrayAttribute['address'] = (object)array("country" => @$obj->country->name,
                    "destinations" => @$obj->country->destinations[0]->name,
                    "longitude" => @$obj->content->geolocation->longitude,
                    "latitude" => @$obj->content->geolocation->latitude,
                );
                $arrayAttribute['source'] = 'hotel_beds';
                $arrayAttribute['single_photo'] = (object)array("photo" => @$obj->content->media->images[0]->urls[1]->resource);
                $data2[] = (object)$arrayAttribute;
                if (!empty($find)) {
                    continue;
                } else {
                    $save_responce1 = Places::create($arrayAttribute);
                    ///////////////////////creating image///////////////////////
                    if (isset($obj->content->media->images[0]->urls[1]->resource) && !empty($obj->content->media->images[0]->urls[1]->resource)) {
                        Photo::create([
                            'photo' => $obj->content->media->images[0]->urls[1]->resource,
                            'category_id' => 2,
                            'instance_id' => $save_responce1->id
                        ]);
                    }
                    ///////////////////////// Addresses //////////////////////////
                    $address = array(
                        'instant_id' => $save_responce1->id,
                        'category_id' => 2,
                        'latitude' => @$obj->content->geolocation->latitude,
                        'longitude' => @$obj->content->geolocation->longitude,
                        'city' => @$obj->country->destinations[0]->name,
                        'country' => @$obj->country->name
                    );
                    $data_address = Address::create($address);
                    //$data2[$save_responce1->id]['address'] = $data_address;
                }
            }
            return $data2;
        }
    }

    public function hotel_bed_detail($request)
    {
        $request['from'] = date('Y-m-d', strtotime($request['to']));
        $request['to'] = date('Y-m-d', strtotime($request['to']));
        /** create adult paxes detail */
        if (isset($request['adult']) && !empty($request['adult'])) {
            for ($i = 1; $i <= $request['adult']; $i++) {
                $paxes[] = array("age" => 30);
            }
        }
        /** create child paxes detail */
        if (isset($request['children']) && !empty($request['children'])) {
            for ($i = 1; $i <= $request['children']; $i++) {
                $paxes[] = array("age" => 14);
            }
        }
        $post_data = array(
            //"paxes" => @$request['paxes'],
            "paxes" => $paxes,
            "code" => @$request['code'],
            "from" => $request['from'],
            "to" => $request['to']
        );
        $detail = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/activities/details/full', $post_data);
        if (isset($detail->activity) && sizeof($detail->activity) > 0) {
            $detail = $detail->activity;
            foreach ($detail->content->media->images as $obj) {
                $image[] = array("photo" => $obj->urls[1]->resource, "sizeType" => $obj->urls[1]->sizeType);
            }
            $data['id'] = @Places::where('external_id', $request['code'])->first()->id;
            $data['type'] = $detail->type;
            $data['code'] = $detail->code;
            $data['place_name'] = $detail->name;
            $data['activityname'] = $detail->content->name;
            $data['currency'] = $detail->currency;
            $data['amountsFrom'] = $detail->amountsFrom;
            $data['operationDays'] = $detail->operationDays;
            $data['modalities'] = $detail->modalities;
            $data['description'] = $detail->content->description;
            $data['address'] = array(
                "country" => @Country::where('name', 'like', '%' . @$detail->country->name . '%')->first()->code,
                "destinations" => @$detail->country->destinations[0]->name,
                "longitude" => @$detail->geolocation->longitude,
                "latitude" => @$detail->geolocation->latitude,
            );
            //$data['startingPoints'] = $detail->content->location->startingPoints;
            $data['featureGroups'] = @$detail->content->featureGroups;
            $data['segmentationGroups'] = @$detail->content->segmentationGroups;
            $data['photo'] = @$image;
            return $data;
        } else {
            return $detail;
        }
    }

    public function get_rate_key()
    {
        /** stor previous request data */
        Session::put('prev_request', $_GET);
        $country = Country::orderBy('name', 'ASC')->get();
        $item = Places::findorfail(Input::get('activity_id'));
        return view('activity/payment_info', compact('gateway', 'country', 'item'));
    }

    public function book_now(Request $request)
    {

        $this->validate($request, [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                // 'sex' => 'required',
                'phoneNumber' => 'required',
                // "dateOfBirth" => 'required',
                "phoneNumber" => 'required',
                "address" => 'required',
                "postCode" => 'required',
//            "state" => 'required',
                "country" => 'required',
                "name_card_bookign" => 'required',
                //  "cardNumber" => 'required',
                // "expire_month" => 'required',
                //"expire_year" => 'required',
                // "ccv" => 'required',
            ]
        );
        $request = (array)$request->all();
        /** send request for activity booking */
//        for ($i = 0; $i < $request['children']; $i++) {
//            $paxes[] = array("roomId" => 1, "type" => "CH", "name" => $request['firstName']);
//        }
        if (isset($request['answer'])) {
            for ($i = 0; $i < count($request['answer']); $i++) {
                $answer[] = array(
                    "question" => array(
                        'code' => $request['question_code'][$i]
                    , 'text' => '')
                , 'answer' => $request['answer'][$i]
                );
            }
        } else {
            $answer = array();
        }
        $data = array(['preferedLanguage' => "en",
            'serviceLanguage' => "en",
            "rateKey" => $request['rateKey'],
            "from" => $request['from'],
            "to" => $request['to'],
            "paxes" => array(),
            "answers" => $answer
        ]);
        $post_data = array(
            "clientReference" => "IntegrationAgency",
            "holder" =>
                array(
                    "name" => $request['firstName'],
                    "surname" => $request['lastName'],
                    "title" => "",
                    "email" => $request['email'],
                    "address" => $request['address'],
                    "zipCode" => $request['postCode'],
                    "telephones" => array($request['phoneNumber']),
                    "mailing" => false,
                    "country" => $request['country'],
                ),
            "language" => "en",
            "activities" => $data
        );
        $bookingConfirm = Functions::HotelBedActivityAuthentication('https://api.test.hotelbeds.com/activity-api/3.0/bookings', $post_data, 'PUT');
//        echo '<pre>';
//        print_r($bookingConfirm);
//        exit;
        if (isset($bookingConfirm->booking) && !empty($bookingConfirm->booking)) {
            /**  if activitybooking confirm then deduct a payment */
            $payment_responce = Functions::BraintreePayment($request);
            if ($payment_responce->success) {
                $activity_id = Places::find($request['activity_id'])->id;
                $formData['category_id'] = 2;
                $formData['track_id'] = $bookingConfirm->booking->reference;
                //$formData['instance_id'] = $bookingConfirm->booking->activities[0]->code;
                $formData['instance_id'] = @$activity_id;
                $formData['status'] = 'Completed';
                $formData['pending_amount'] = $bookingConfirm->booking->pendingAmount;
                $formData['total'] = $bookingConfirm->booking->total;
                $formData['first_name'] = $bookingConfirm->booking->holder->name;
                $formData['last_name'] = $bookingConfirm->booking->holder->surname;
                $formData['children'] = @$request['children'];
                $formData['adults'] = @$request['adult'];
                $formData['currency'] = $bookingConfirm->booking->currency;
                $formData['phone'] = @$bookingConfirm->booking->holder->telephones[0];
                $formData['email'] = @$bookingConfirm->booking->holder->email;
                //$formData['hotel_name'] = $bookingConfirm->booking->hotel->name;
                //$formData['instance_id'] = $bookingConfirm->booking->hotel->code;
                $formData['user_id'] = Auth::user()->user_id;
                $email_order_detail = Order::create($formData);
                foreach ($bookingConfirm->booking->activities as $objSupplier) {
//                $supplierAttr['phone_no'] = @$objSupplier->contactInfo->telephone;
//                $supplierAttr['address'] = @$objSupplier->contactInfo->address;
//                $supplierAttr['country_id'] = @$objSupplier->contactInfo->country->code;
//                $supplierAttr['city'] = @$objSupplier->contactInfo->country->destinations[0]->name;
//                $supplierAttr['first_name'] = @$objSupplier->supplier->name;
//                $supplier_id = Supplier::create($supplierAttr);
                    $order_detail = array(
                        'order_id' => $email_order_detail->id,
                        'check_in' => @$objSupplier->dateFrom,
                        'check_out' => @$objSupplier->dateTo,
                        'room_type' => @$objSupplier->name,
                        'adults' => @$request['adult'],
                        'children' => @$request['children'],
                        'unit_price' => @$bookingConfirm->booking->total,
                        //'unit_price' => $bookingConfirm->booking->hotel->totalNet,
                        'total' => @$bookingConfirm->booking->total,
                        'status' => 'Completed',
                    );
                    OrderDetail::create($order_detail);
                    // $sum = $sum + $bookingConfirm->totalNet;
                }
                /** send responce for confirmation */
                $pdf['id'] = $email_order_detail->id;
                $pdf['track_id'] = $email_order_detail->track_id;
                $pdf['item'] = @$objSupplier->name;
                $pdf['category_id'] = $email_order_detail->category_id;
                $pdf['instance_id'] = $email_order_detail->instance_id;
                $pdf['first_name'] = $email_order_detail->first_name;
                $pdf['last_name'] = $email_order_detail->last_name;
                $pdf['email'] = $email_order_detail->email;
                $pdf['phone'] = $email_order_detail->phone;
                $pdf['total'] = $email_order_detail->total;
                $pdf['pdf_link'] = url('activities/invoice/' . $email_order_detail['track_id']);
                //Mail::to($formData['email'])->send(new ActivityBookingEmail($email_order_detail));
                return view('activity/confirm-activity-booking', compact('summary'))
                    ->with('confirm_data', $pdf)
                    ->with('summary', $request);
            } else {
                $error = $payment_responce->errors->deepAll();
                $error[0]->message;
            }
        } else {
            return view('errors/error_page', compact('request'))->with('error', $bookingConfirm);
        }
    }

    /////////////////////    rating //////////////////////////////////
    public function store_rating(Request $request)
    {
        Reviews::create($request->all());
        if (!empty($request->slug)) {
            $url = $request->slug;
        } else {
            $url = $request->instance_id;
        }
        return redirect(url('/activities' . $request->subcat . '/' . $url));
    }





}
