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

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->cat_detail = Category::where('code', '=', 'PTV')->first();
    }

    public function index()
    {
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_name,parent_id,cat_image,count(categories.id) as total'))
            ->where('parent_id', 4)
            ->Where('status', '=', 'Active')

            ->join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->groupby('categories.id')->orderBy('order_no','ASC')->get();

// /////////   listing ///////////////////////

        $listing = Places::select('id', 'place_name', 'stars', 'description', 'slug', 'track_id', 'category_id', 'created_at', 'status')->with([
            'single_photo' => function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                $query->Where('main', '=',1);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }])->orderBy('order_no','ASC');

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

        $listing->Where('status', '=', 'Active');
        $listing = $listing->paginate($page);

        //dd($places);
        return view('places/index', compact('listing', 'sub_cat'));
    }
 public function get_subcategories(Request $request)
    {
        $option_list = "";
        $categories = Category::where('parent_id', '1')->Where('status', '=', 'Active')->orderBy('order_no','ASC')->get();
    
        foreach ($categories as $row) {
            $option_list .= '<div class="col-md-4 col-sm-6">
                                <a href="'.url('places/').'/'.$row->slug.'">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="'.url('uploads/').'/'.$row->cat_image.'">
                                        <div class="hover_txt">
                                            <h4>'.$row->cat_name.'</h4>
                                        </div>
                                    </div>

                                </a>
                            </div>';
        }
        echo $option_list;
    }
    public function get_places_bySubCat($slug)
    {
        //get sub cat id by slug
        $sub_cat_id = Category::select('id', 'cat_name', 'icon', 'slug')->where('slug', $slug)->first();
        if (empty($sub_cat_id)) {
            return redirect(404);
        }
        //get sub cat list for side bar
          $subcat_place = Category::select('slug','id','parent_id','cat_image','cat_name','parent_id')
                    ->where('parent_id', 1)
                    ->Where('status', '=', 'Active')
                    ->orderBy('order_no')->get();
                    ///Commented by Waseem
//        $subcat_place = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))
//            ->where('parent_id', 1)->
//            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
//            ->Where('status', '=', 'Active')
//            ->groupby('categories.id')->get();
        // ->Where('deleted_at', '=', NULL)

        //get a listing of restaurnt of givien subcategory
        $listing = Places::select('id', 'is_featured', 'stars', 'order_no', 'category_id', 'description',
            'slug', 'place_name', 'website_url', 'social_1', 'social_2', 'social_3', 'social_4', 'phone')
            ->with(['single_photo' => function ($query) {
                $query->where('category_id', '=', 1);
                $query->where('main', '=', 1);
            }])
            ->with(['favoruite' => function ($query) {
                $query->where('category_id', '=', 1);

            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 1);
                }])->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 1);
                }]);
        $listing->whereHas(
            'subcategories', function ($query) use ($sub_cat_id) {
            $query->where('category_id', '=', 1);
            $query->Where("subcategory_id", "=", $sub_cat_id->id);
        });

        if (!empty(Auth::user()->id)) {
            $listing->with(['fav_place' => function ($query) {
                $query->where('category_id', 1);
                $query->where('user_id', Auth::user()->id);
            }]);
        }

//        $listing->whereHas(
//            'address', function ($query) {
//            $query->where('category_id', '=', 4);
//            $query->Where('city', '=', $this->city);
//            $query->Where('country', '=', $this->code);
//        }
//        );
        if(isset($_GET['sort']) && $_GET['sort']=='name'){
            $listing->orderBy('place_name','ASC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='recent'){
            $listing->orderBy('id','DESC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='rating'){
            $listing->orderBy('stars','DESC');
        }
        $listing->Where('status', '=', 'Active');
        $places = $listing->orderBy('order_no','ASC')->paginate(10);


             $map_list = '{}';
                    $marker_list = '{}';
                    if (!empty($places) && sizeof($places) > 0) {

              foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }
                $data['name'] = @$obj->place_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->place_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);
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
      //dd($map_list);
        return view('search/listing', compact('places', 'code', 'country', 'city', 'subcat_place','map_list','marker_list'))->with('sub_cat_detail', $sub_cat_id);
    }else{

            Session::flash('place_search_error', "No data found ");
             return view('search/listing')->with('sub_cat_detail', $sub_cat_id);
            //return redirect()->back();
    }
    }

// /////////////////////////////////// Search ///////////////////////////////
    public function search()
    {

        $subcat_place = Category::where('parent_id','1')->Where('status', 'Active')->orderBy('order_no','ASC')->get();
        $sub_category = Category::where('parent_id','2')->Where('status', 'Active')->orderBy('order_no','ASC')->get();
        $activtySubcategory = Category::where('parent_id','3')->Where('status', 'Active')->orderBy('order_no','ASC')->get();
        $item = strtok(Input::get('city'), ",");
 
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_name,count(categories.id) as total'))
            ->where('parent_id', 1)->Where('status', 'Active')->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->
            groupby('categories.id')->orderBy('order_no','ASC')->get();

        //////////////////////////////////////////////////////////////////////////////////////
        $places = Places::select('id', 'stars', 'place_name', 'description', 'phone', 'category_id', 'slug', 'description'
            , 'website_url', 'social_1', 'social_2', 'social_3', 'social_4');

        $places->Where('status', 'Active')

            ->with(['single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->where('category_id', '=', 1);
               // $query->where('main',1);
            }])
            ->with([
                $address = 'address' => function ($qury) {
                    $qury->select('address_id', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 1);
                }])
            ->with(['favoruite' => function ($query) {
                $query->where('category_id', '=', 1);

            }])->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 1);
                }]);
        //////////////////////if login get favoruite list also
        if (!empty(Auth::user()->id)) {
            $places->with(['fav_place' => function ($query) {
                $query->where('category_id', 1);
                $query->where('user_id', Auth::user()->id);
            }]);
        }
        if ($item && Input::get('search_type') == 'city') {
            $se=trim(Input::get('city'), ",");
            $imp=explode(",", $se);
            $places->whereHas(
                'address', function ($query) use ($imp) {
                $query->where('category_id', '=', 1);
                $query->Where('city', '=', $imp[0]);
            }
            );
        }
        if ($item && Input::get('search_type') == 'place') {
            $places->Where('places.place_name', 'like', '%' . trim(Input::get('city')) . '%');
        }
        //////////////////////////////////////////////////////
        if (Input::get('subcategory')) {
            $places->whereHas(
                'subCategories_edit', function ($query) {
                $query->Where('category_id', '=', 1);
                $query->Where("subcategory_id", "=", Input::get('subcategory'));
            }
            );
        }
        if(isset($_GET['sort'])&& $_GET['sort']=='name'){
            $places->orderBy('places.place_name','ASC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='recent'){
            $places->orderBy('places.place_name','DESC');
        }
        if(isset($_GET['sort']) && $_GET['sort']=='rating'){
            $places->orderBy('places.stars','DESC');
        }
//        $places->groupBy('place_name');
        $places = $places->paginate(15);
  // dd($_GET['sort']);
        //  echo count($places);
        $map_list = '{}';
        $marker_list = '{}';
        if (!empty($places) && sizeof($places) > 0) {

            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }
                $data['name'] = @$obj->place_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->place_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);
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
            // dd($map_list);

            return view('search/searchIndex', compact('places','subcat_place','activtySubcategory','sub_category', 'sub_cat', 'map_list', 'marker_list', 'subcat'));
        } else {
            Session::flash('place_search_error', "No data found " . Input::get('city'));
            return view('search/searchIndex')
                ->with('subcat_place',$subcat_place)
                ->with('sub_category',$sub_category)
                ->with('activtySubcategory',$activtySubcategory);

//            return redirect()->back();
        }

    }


    public function searchAppend()
    {

        $item = strtok(Input::get('city'), ",");
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_name,count(categories.id) as total'))
            ->where('parent_id', 4)->where('status', 'Active')->
            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->
            groupby('categories.id')->orderBy('order_no','ASC')->get();

        //////////////////////////////////////////////////////////////////////////////////////
        $places = Places::select('id', 'stars', 'place_name', 'description', 'category_id', 'slug', 'description')
            ->where('status', 'Active')
        ->groupBy('places.place_name')
            ->with(['single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->where('category_id', '=', 4);
                $query->where('main', '=', 1);
            }])->with(['fav_place' => function ($query) {
                $query->where('category_id', '=', 4);
                /*$query->where('instance_id', '=', 1);*/
            }])->with([
                $address = 'address' => function ($qury) {
                    $qury->select('address_id', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 4);
                }])->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 4);
                }]);
        //////////////////////if login get favoruite list also
        if (!empty(Auth::user()->user_id)) {
            $places->with(['fav_place' => function ($query) {
                $query->where('category_id', 4);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        if ($item && Input::get('search_type') == 'city') {
            $se=trim(Input::get('city'), ",");
            $imp=explode(",", $se);
            $places->whereHas(
                'address', function ($query) {
                $query->where('category_id', '=', 4);
                $query->Where('city', '=', $imp[0]);
            }
            );
        }
        if ($item && Input::get('search_type') == 'place') {
            $places->Where('places.place_name', 'like', '%' . trim(Input::get('city')) . '%');
        }
        //////////////////////////////////////////////////////
        if (Input::get('subcategory')) {
            $places->whereHas(
                'subCategories_edit', function ($query) {
                $query->Where('category_id', '=', 4);
                $query->Where("subcategory_id", "=", Input::get('subcategory'));
            }
            );
        }
        $places = $places->orderBy('order_no','ASC');
        $places = $places->paginate(15);
        // dd($places);
        if (!empty($places)) {
            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
                }
                $data['name'] = @$obj->place_name;
                $data['location_latitude'] = @$obj->address->latitude;
                $data['location_longitude'] = @$obj->address->longitude;
                $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);
                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);
                $data['name_point'] = @$obj->place_name;
                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');
                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
                $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);
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
            //dd($place_list);

            $map_list = json_encode($map_data);
            $marker_list = json_encode($marker_data);
        }
        //dd($places);
        //echo view('places/placestest', compact('sub_cat','count','map_list','lat','long'))->with('places', $places);
        echo view('places/searchPlacesAppend', compact('count', 'map_list', 'marker_list', 'lat', 'long'))->with('places', $places);
    }

//    public function searchAppend(){
//
//        $item = strtok(Input::get('destination'), ",");
//        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_name,count(categories.id) as total'))
//            ->where('parent_id', 4)->
//            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->
//            groupby('categories.id')->get();
//
//        //////////////////////////////////////////////////////////////////////////////////////
//        $places = Places::select('id', 'stars', 'place_name', 'category_id', 'slug', 'description')
//            ->with(['single_photo' => function ($query) {
//                $query->select('photo_id', 'photo', 'instance_id');
//                $query->where('category_id', '=', 4);
//            }])
//                ->with([
//                $address= 'address' => function ($qury) {
//                    $qury->select('address_id', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');
//                    $qury->Where('latitude', '!=', '');
//                    $qury->Where('longitude', '!=', '');
//                    $qury->Where('category_id', '=', 4);
//                }]);
//
//        //////////////////////if login get favoruite list also
//        if (!empty(Auth::user()->user_id)) {
//            $places->with(['fav_place' => function ($query) {
//                $query->where('category_id', 4);
//                $query->where('user_id', Auth::user()->user_id);
//            }]);
//        }
//
//        if($item) {
//            $places->whereHas(
//                'address', function ($query) {
//                $query->where('category_id', '=', 4);
//                $query->Where('latitude', '!=', '');
//                $query->Where('longitude', '!=', '');
//                $query->Where('city', '=',  trim(strtok(Input::get('city'),",")) );
//            }
//            );
//        }
//        /*if($item) {
//            $places->orWhere('places.place_name', 'like', '%' . trim(Input::get('city')) . '%');
//        }*/
//        //////////////////////////////////////////////////////
//        if (Input::get('subcategory')) {
//            $places->whereHas(
//                'subCategories_edit', function ($query) {
//                $query->Where('category_id', '=', 4);
//                $query->Where("subcategory_id", "=", Input::get('subcategory'));
//            }
//            );
//        }
//        $places->Where('latitude', '!=', '');
//        $places->Where('longitude', '!=', '');
//        $places = $places->paginate(20);
////dd($places);
//        if (!empty($places)) {
//            foreach ($places as $obj) {
//                if (sizeof($obj->subCategories)) {
//                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();
//                }
//                $data['name'] = @$obj->place_name;
//                $data['location_latitude'] = @$obj->address->latitude;
//                $data['location_longitude'] = @$obj->address->longitude;
//                $data['map_image_url'] = url('/uploads/' . @$obj->single_photo->photo);
//                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);
//                $data['name_point'] = @$obj->place_name;
//                //$data['description_point']=str_limit(strip_tags(trim($obj->description)), 100, '....');
//                $data['description_point'] = "sample text sample text sample text sample text sample text ";
//                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);
//                $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);
//                $data['phone'] = @$obj->phone;
//                $data['url_point'] = url('places-to-visit/' . @$subcat->slug . '/' . @$obj->slug);
//                $place_list[] = $data;
//            }
//        }
//        if (!empty($data)) {
//
//            $lat = $data['location_latitude'];
//            $long = $data['location_longitude'];
//           // echo '<pre>';
//           // dd($place_list);
//
//            $map_list = json_encode($place_list);
//        }
//       dd($places);
//        return view('places/searchPlacesAppend', compact('places', 'sub_cat', 'map_list', 'lat', 'long', 'subcat'));
//
//       // echo view('hotels/searchHotelAppend', compact('sub_cat','count','hotels_map_list','lat','long'))->with('hotels', $hotels);
//
//    }


    public function viewMorePlaces($code, $country, $city)
    {
        $sub_cat_detail = $this->cat_detail;
        $string = str_replace('-', ' ', $city);
        $this->city = $string;
        $this->code = $code;
        // sub category ///////////////////////
        $sub_cat = Places::selectRaw('categories.*,COUNT(places.id) AS total')->
        join('multi_subcategories', 'multi_subcategories.instance_id', '=', 'places.id')->
        join('categories', 'categories.id', '=', 'multi_subcategories.subcategory_id')->
        join('addresses', 'addresses.instant_id', '=', 'places.id')
            ->where('places.status', 'Active')
            ->Where('city', $this->city)
            ->Where('addresses.category_id', 1)
            ->Where('multi_subcategories.category_id', 1)
            ->Where('country', '=', $this->code)
            ->groupBy('multi_subcategories.subcategory_id')->orderBy('order_no','ASC')->get();

        $listing = Places::select('id', 'place_name', 'stars', 'description', 'slug', 'track_id', 'category_id', 'created_at', 'status')->with([
            'single_photo' => function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                $query->where('main', '=', 1);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }]);
        if (!empty(Auth::user()->user_id)) {
            $listing->with(['fav_place' => function ($query) {
                $query->where('category_id', 4);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        if (!empty(Input::get('category'))){
            $listing->whereHas(
                'subCategories', function ($query) {
                $query->where('category_id', '=', 4);
                $query->Where("subcategory_id", Input::get('category'));
            }
            );
        }
        $listing->whereHas(
            'address', function ($query) {
            $query->where('category_id', '=', 4);
            if ($this->city == 'all of iceland') {
                $query->Where('country', '=', $this->code);
            } else {
                $query->where('category_id', '=', 4);
                $query->Where('city', '=', $this->city);
                $query->Where('country', '=', $this->code);
            }
        }
        );

        if (Input::get('sort') == 'Name') {
            $listing->orderBy('place_name', 'ASC');
        } elseif (Input::get('sort') == 'Rating') {
            $listing->orderBy('stars', 'DESC');
        } elseif (Input::get('sort') == 'Popular') {
            $listing->orderBy('id', 'DESC');
        } else {
            $listing->orderBy('place_name', 'ASC');
        }
        $listing->where('status', 'Active');
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
        $lat = $dataPlace['lat'];
        $long = $dataPlace['lng'];

        // array_push($locations, $place_list);
        //Output JSON
        $place_distance = json_encode($place_distance);

        //  exit;
        return view('places/index', compact('listing', 'code', 'city', 'country', 'lat', 'long', 'place_distance', 'sub_cat_detail', 'sub_cat', 'subcat'));
    }

    public function detail($id)
    {
        // echo $id; exit;
        $item = Places::Where('slug', $id)
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', 1);
                $query->orderBy('main','DESC');
            }])
            ->with('reviews_avg')->with(['address' => function ($query) {
                $query->where('category_id', '=', 1);
            }])
            /*->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 1);
                }])*/;
       /* if (!empty(Auth::user()->user_id)) {
            $item->with(['fav_place' => function ($query) {
                $query->where('category_id', 1);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }*/
        $item = $item->first();

        /*  if(!empty(Auth::id) {
              $item_fav = Favourite::where('instance_id',$item->id)
                  ->where('category_id', 1)
                  ->where('user_id', Auth::id())
                  ->first();
          }*/

        //dd($item);
        $reviews = Reviews::where('instance_id', $item->id)
            ->where('category_id', 1)
            ->with('user_detail')->get();
               if (isset($item) && !empty($item)) {
            $favoruite = Favourite::where('instance_id', $item->id)
                ->where('category_id', 1)
                ->where('user_id',Auth::id())->first();
        }
        //dd($rating);
        if (isset($item->address) && !empty($item->address)) {
            $lat=$item->address->latitude;
            $long=$item->address->longitude;
            $name=$item->place_name;
            // $maps[] = array($item->place_name, $item->address->latitude, $item->address->longitude);
           /* $marker[] = array('<div class="infoBox" >
                <div class="marker_info_2">
                <img  src="' . url('/uploads/' . @$item->photo[0]['photo']) . '" alt="Image">
                <h3>' . $item->place_name . '</h3>
                <span>' . $item->excerpt . '</span>
                <div class="marker_tools">
                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block">
                <input name="saddr" value="" type="hidden">
                <input name="daddr" value="' . $item->address->latitude . ',' . $item->address->longitude . '" type="hidden">
                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>
                </form>
                <a href="tel://' . $item->phone . '" class="btn_infobox_phone">' . $item->phone . '</a></div>
                </div></div>');
            ///////////////END MAp////////////////
            $map_list = json_encode($maps);
            $marker_list = json_encode($marker);*/
        }

        if ($item) {
            $categories = Category::where('parent_id', 0)->orwhere('code', 'PLC')->get();
            return view('detail',compact('item', 'categories', 'rating','reviews', 'lat', 'long','name','favoruite'));
        }

    }

    public function placedetail($country, $subcat, $id)
    {

        $cunt = str_replace('-', ' ', $country);


        $item = Places::where('id', $id)->orWhere('slug', $id)
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
                $query->orderBy('main','DESC');
            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 4);
                }]);
        if (!empty(Auth::user()->user_id)) {
            $item->with(['fav_place' => function ($query) {
                $query->where('category_id', 4);
                $query->where('user_id', Auth::user()->user_id);
            }]);
        }
        $item = $item->first();
        $countryItem = Country::select('code', 'name')->where('name', $cunt)->first();

        $rating = Reviews::where('instance_id', $item->id)
            ->where('category_id', 4)
            ->with('user_detail')->get();

        if ($item) {
            $categories = Category::where('parent_id', 0)->orwhere('code', 'PLC')->get();

        }
        return view('places/item', compact('item', 'countryItem', 'categories', 'rating'));

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
        return redirect(url('/places-to-visit/' . $request->subcat . '/' . $url));
    }

////////////////////////////////     autocomplete name //////////////////////
  /*  public function SearchPlcAutoName(Request $request)
    {
        $city = Country::selectRaw('countries.name as country_name,cities.name as city_name,cities.id as city_id')->join('cities', 'cities.country_code', '=', 'countries.code')
            ->where('cities.status', 'Active')->where(function ($query) use ($request) {
                $query->where('countries.name', 'LIKE', '%' . $request->term . '%');
                $query->orwhere('cities.name', 'LIKE', '%' . $request->term . '%');
            })->take(5)->get();

        $data_name = Places::select('id', 'place_name')
            ->where('place_name', 'LIKE', '%' . $request->term . '%')
            ->where('category_id', 4)
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
                    "id" => $row['id'], 'type' => 'place'); //build an array
            }
        }
        if (!empty($row_set)) {
            echo json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            echo json_encode($row_set);
        }

    }*/


//    public function SearchPlcAutoName(Request $request)
//    {
//        $data_city = cities::where('name', 'LIKE', '%' . $request->term . '%')->get();
//        if (sizeof($data_city)) {
//            $country = Country::select('name', 'code')->Where('code', $data_city[0]->country_code)->groupBy('name')->first();
//        }
//        $data_name = Places::select('place_name')->where('place_name', 'LIKE', '%' . $request->term . '%')->get();
//
//        if (sizeof($data_city) > 0) {
//            foreach ($data_city as $city) {
//                $row_set[] = $city['name'] . ', ' . $country['name']; //build an array
//            }
//        }
//        if (sizeof($data_name) > 0) {
//            foreach ($data_name as $name) {
//                $row_set[] = $name['place_name']; //build an array
//            }
//        }
//        if (!empty($row_set) > 0) {
//            echo json_encode($row_set); //format the array into json data
//        } else {
//            $row_set[] = "No records found";
//            echo json_encode($row_set);
//        }
//    }
}
