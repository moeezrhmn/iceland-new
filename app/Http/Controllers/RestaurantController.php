<?php



namespace App\Http\Controllers;



use App\Models\Country;

use App\Models\Favourite;

use App\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Input;



use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Redirect;

use App\Models\Restaurants;

use App\Models\Places;

use App\Models\Hotel;

use App\Models\Category;

use App\Models\Cities;

use App\Models\Reviews;

use App\Models\Restaurant_menu;

use App\Models\multiSubcategories;

use App\Models\Photo;

use App\Models\Keyword;

use App\Models\multiKeywords;

use App\Models\Address;

use App\Models\LogsPlaces;

use App\Classes\Functions;



use Session;

use DB;



class RestaurantController extends Controller

{

    public function __construct()

    {

        $this->cat_detail = Category::select('*')->where('code', '=', 'RST')->first();



        $subcat_place = Category::where('parent_id','1')->orderBy('order_no','ASC')->get();

        $sub_category = Category::where('parent_id','2')->orderBy('order_no','ASC')->get();



    }





    public function index()
    {
        ///////////////////////get restaurant listing/////////////////////
        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_name,cat_image,count(categories.id) as total'))->where('parent_id', 1)->
        join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')
            ->where('status', 'Active')
            ->groupby('categories.id')->orderBy('order_no','ASC')->get();
        $listing = Restaurants::select('stars', 'id', 'is_featured', 'category_id', 'description', 'slug', 'restaurant_name', 'status', 'created_at')->with([
            'single_photo' => function ($query) {
                $query->select('photo_id', 'photo', 'instance_id');
                $query->Where('category_id', '=', 1);
                $query->Where('main', '=', 1);
            }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', 1);
                }])
            ->with([
                'reviews_avg' => function ($qury) {
                    $qury->Where('category_id', '=', 1);
                }]);
        if (request()->get('sort') == 'Name') {
            $listing->orderBy('restaurant_name', 'ASC');
        } elseif (request()->get('sort') == 'Rating') {
            $listing->orderBy('stars', 'DESC');
        } else {
            $listing->orderBy('is_featured', 'DESC');
        }

        $listing->where('restaurants.status', 'Active');

        $listing = $listing->paginate(15);


        return view('restaurants/index', compact('listing', 'sub_cat'));



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

        $places = $listing->orderBy('order_no','ASC')->paginate(15);





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

public function get_restaurants_bySubCat($slug)
    {
        //get sub cat id by slug

        $sub_cat_id = Category::select('id', 'cat_name', 'icon', 'slug')->where('slug', $slug)->first();

        $subcat_place = Category::where('parent_id','1')->orderBy('order_no','ASC')->get();

        $sub_category = Category::where('parent_id','2')->orderBy('order_no','ASC')->get();

        $activtySubcategory  = Category::where('parent_id','3')->orderBy('order_no','ASC')->get();

        if (empty($sub_cat_id)) {

            return redirect(404);

        }

        //get sub cat list for side bar

        $subcat_place = Category::select(DB::raw('categories.slug,categories.id,parent_id,cat_image,cat_name,count(categories.id) as total'))

            ->where('parent_id', 2)->

            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')

            ->Where('status', '=', 'Active')

            ->groupby('categories.id')->orderBy('order_no','ASC')->get();

        // ->Where('deleted_at', '=', NULL)

        //get a listing of restaurnt of givien subcategory

        $listing = Restaurants::select('id', 'is_featured', 'stars', 'category_id', 'description', 'slug',

            'restaurant_name', 'website', 'social_1', 'social_2', 'social_3', 'social_4','phone')

            ->with(['single_photo' => function ($query) {

                $query->where('category_id', '=', 2);

                $query->where('main', '=', 1);

            }])

            ->with(['favoruite' => function ($query) {

                $query->where('category_id', '=', 2);

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

            //        $listing->whereHas(

            //            'address', function ($query) {

            //            $query->where('category_id', '=', 4);

            //            $query->Where('city', '=', $this->city);

            //            $query->Where('country', '=', $this->code);

            //        }

            //        );

                if(isset($_GET['sort']) && $_GET['sort']=='name'){

                    $listing->orderBy('restaurant_name','ASC');

                }

                if(isset($_GET['sort']) && $_GET['sort']=='recent'){

                    $listing->orderBy('id','DESC');

                }

                if(isset($_GET['sort']) && $_GET['sort']=='rating'){

                    $listing->orderBy('review_rating','DESC');

                }

                    $places = $listing->paginate(15);



                    /////////////////Start place map code here//////////////

                $map_list = '{}';

                $marker_list = '{}';

                if (!empty($places) && sizeof($places) > 0) {

                    foreach ($places as $obj) {

                        if (sizeof($obj->subCategories)) {

                            $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();

                        }

            if(!empty($obj->address->longitude) && !empty($obj->address->latitude)) {



                $data['name'] = @$obj->restaurant_name;

                $data['location_latitude'] = @$obj->address->latitude;

                $data['location_longitude'] = @$obj->address->longitude;

                $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);

                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);

                $data['name_point'] = @$obj->restaurant_name;

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

            //            $marker = array('<div class="infoBox" >

//                    <div class="marker_info_2">

//                    <img  src="' . url($map_image) . '" alt="Image">

//                    <h3>' . $data['name'] . '</h3>

//                    <span>' . $data['description_point'] . '</span>

//                    <div class="marker_tools">

//                    <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block" "="">

//                    <input name="saddr" value="" type="hidden">

//                    <input name="daddr" value="' . $data['location_latitude'] . ',' . $data['location_longitude'] . '" type="hidden">

//                    <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>

//                    </form>

//                    </div>

//                    </div></div>');



            $marker = array('<div class="infoBox" >

                <div class="marker_info_2">

                <img  src="' . url($map_image) . '" alt="Image">

                <h3>' . $data['name'] . '</h3>

                <span>' . $data['description_point'] . '</span>

                <div class="marker_tools">

                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block">

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

        }

        //$lat = $data['location_latitude'];

        // $long = $data['location_longitude'];

        $map_list = json_encode($map_data);

        $marker_list = json_encode($marker_data);

        ////////////////////////////

       // dd($places);

//        }

        /////////////////////End Map data//

    }

    //$lat = $data['location_latitude'];

    // $long = $data['location_longitude'];

//    $map_list = json_encode($map_data);

//    $marker_list = json_encode($marker_data);

        if(sizeof($places)>0){

          //dd($map_list);

            return view('search/listing', compact('places','sub_category', 'code', 'country',

                'city', 'subcat_place','map_list','marker_list'))->with('sub_cat_detail', $sub_cat_id);

//            return view('search/listing', compact('places','marker_list','sub_category',

//                'map_list','sub_category', 'code', 'country', 'city', 'subcat_place'))

//                ->with('sub_cat_detail', $sub_cat_id);



                            }else{

                            // echo 'ttttttttt';exit;

                                return view('search/listing')->with('sub_cat_detail', $sub_cat_id)

                                    ->with('subcat_place', $subcat_place)->with('sub_category', $sub_category);
                                }



        }



    public function viewMoreRestaurant($code, $country, $city)

    {

        $sub_cat_detail = $this->cat_detail;

        $string = str_replace('-', ' ', $city);

        $this->city = $string;

        $this->code = $code;



        $sub_cat = Restaurants::selectRaw('categories.*,COUNT(restaurants.id) AS total')->

        join('multi_subcategories', 'multi_subcategories.instance_id', '=', 'restaurants.id')->

        join('categories', 'categories.id', '=', 'multi_subcategories.subcategory_id')->

        join('addresses', 'addresses.instant_id', '=', 'restaurants.id')

            ->Where('city', $this->city)

            ->Where('addresses.category_id', 1)

            ->Where('multi_subcategories.category_id', 1)

            ->Where('country', '=', $this->code)

            ->groupBy('multi_subcategories.subcategory_id')->orderBy('order_no','ASC')->get();

       // dd($sub_cat);



        $listing = Restaurants::select('*')

            ->with([

                'subCategories' => function ($query) {

                    //$qury->select('address_id','address','city','country','instant_id');

                    $query->Where('category_id', $this->cat_detail->id);

                }])

            ->with([

                'single_photo' => function ($query) {

                    $query->select('photo_id', 'photo', 'instance_id');

                    $query->where('main', '=', 1);

                    $query->Where('category_id', '=', 1);

                }])

            ->with([

                'address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 1);

                }])->orderBy('is_featured', 'DESC');

        if (!empty(Input::get('category'))){

            $listing->whereHas(

                'subCategories', function ($query) {

                $query->where('category_id', '=', 1);

                $query->Where("subcategory_id", Input::get('category'));

            }

            );

        }

        if (!empty(Auth::user()->user_id)) {

            $listing->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 1);

                }]);

        }

        if ($this->city == 'all of iceland') {

            $listing->whereHas(

                'address', function ($query) {

                $query->where('category_id', '=', 1);

                // $query->Where('city', '=', $this->city);

                $query->Where('country', '=', $this->code);

            }

            );

        } else {

            $listing->whereHas(

                'address', function ($query) {

                $query->where('category_id', '=', 1);

                $query->Where('city', '=', $this->city);

                $query->Where('country', '=', $this->code);

            }

            );

        }

        if (Input::get('sort') == 'Name') {

            $listing->orderBy('restaurant_name', 'ASC');

        } elseif (Input::get('sort') == 'Rating') {

            $listing->orderBy('stars', 'DESC');

        } elseif (Input::get('sort') == 'Popular') {

            $listing->orderBy('order_no', 'DESC');

        } else {

            $listing->orderBy('order_no', 'DESC');

        }

        $listing = $listing->paginate(15);

        return view('restaurants/index', compact('listing', 'code', 'city', 'country', 'sub_cat', 'sub_cat_detail'));



    }

     public function get_subcategories(Request $request)

    {

     

       

        $option_list = "";

        $categories = Category::where('parent_id', '2')->orderBy('order_no','ASC')->get();

    

        foreach ($categories as $row) {

         $option_list .= '<div class="col-md-4 col-sm-6">

                                <a href="'.url('restaurants/').'/'.$row->slug.'">

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



//////////////////////// Search //////////////////////////////////////

    public function search()

    {

     // print_r(Input::get('city_id')); exit;



        $sub_category = Category::where('parent_id','2')->where('status', 'Active')->orderBy('order_no','ASC')->get();

        $subcat_place = Category::where('parent_id','1')->where('status', 'Active')->orderBy('order_no','ASC')->get();

        $activtySubcategory  = Category::where('parent_id','3')->where('status', 'Active')->orderBy('order_no','ASC')->get();

        ///////////////////////////////////////////////////////////////////////////

        $restaurants = Restaurants::select('stars', 'id', 'description', 'category_id', 'restaurant_name', 'slug'

            , 'website', 'social_1', 'social_2', 'social_3', 'social_4','phone')

            ->with(['single_photo' => function ($query) {

                $query->select('photo_id', 'photo', 'instance_id');

                $query->where('category_id', '=', 2);

                //$query->where('main', '=', 1);

            }])

            /*->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', '=', 2);

                $query->where('instance_id', '=', 2);

            }])*/

            ->with([

                'address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 2);

                }])

            /*->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 2);

                }])*/

            ->with(['subCategories' => function ($query) {

                $query->where('category_id', '=', 2);

            }]);



        //////////////////////if login get favoruite list also

        if (!empty(Auth::user()->id)) {

            $restaurants->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', 2);

                $query->where('user_id', Auth::user()->id);

            }]);

        }

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

              if (Input::get('term') && Input::get('type') == 'city') {

                $se=trim(Input::get('term'), ",");

                $imp=explode(",", $se);

            $restaurants->whereHas(

                'address', function ($query) use ($imp) {

                $query->where('category_id', '=', 2);

                $query->Where('city', '=', $imp[0]);

            }

            );

        }



        if (Input::get('term') && Input::get('type') == "restaurant") {

            $restaurants->where('restaurant_name', Input::get('term'));

        }

        ////////////////filter by sub cat

        if (Input::get('cuisine')) {

            $restaurants->whereHas(

                'subCategories', function ($query) {

                $query->where('category_id', '=', 2);

                if (Input::get('cuisine')) {

                    $query->Where("subcategory_id", "=", Input::get('cuisine'));

                }

            }

            );

        }

        //DB::enableQueryLog();

        if(isset($_GET['sort']) && $_GET['sort']=='name'){

            $restaurants->orderBy('restaurant_name','ASC');

        }

        if(isset($_GET['sort']) && $_GET['sort']=='recent'){

            $restaurants->orderBy('id','DESC');

        }

        if(isset($_GET['sort']) && $_GET['sort']=='rating'){

            $restaurants->orderBy('review_rating','DESC');

        }

        $restaurants = $restaurants->paginate(15);





        //dd(DB::getQueryLog()); exit;

        //$places=$restaurants;

        $map_list = '';

        $marker_list = '';

        $map_data = array();

        $marker_data = array();

        //echo '<pre>';

        //dump($restaurants);

        //exit;

        if (!empty($restaurants) && sizeof($restaurants) > 0) {

            foreach ($restaurants as $obj) {

                if (sizeof($obj->subCategories)) {

                    $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();

                }

                $data['name'] = @$obj->restaurant_name;

                $data['location_latitude'] = @$obj->address->latitude;

                $data['location_longitude'] = @$obj->address->longitude;

                $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);

                $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);

                $data['name_point'] = @$obj->place_name;

                $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');

                $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);

                $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);

                $data['phone'] = @$obj->phone;

                $data['url_point'] = url('restaurants/detail/' . @$obj->slug);

                $place_list[] = $data;



                ////////////////////Add Map Data Array/////

                $maps = array($data['name'], $data['location_latitude'], $data['location_longitude']);

                // $marker = array('<div class="info_content" style="width:500px;height:350px;"><h5>' . $data['name'] . '</h5>

                //  <img width="200px" height="150px" src="' . url($map_image) . '" alt="Image"/><span>' . $data['description_point'] . '</span></div>');

                //dump($maps);

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

          //dd($map_data);

            $map_list = json_encode($map_data);

            $marker_list = json_encode($marker_data);
            $places = $restaurants;


          //  dd($_GET['ajax']);
         // dd($city_lat_lng);

                return view('search/searchIndex', compact('restaurants',

                    'places','sub_category','activtySubcategory','subcat_place',

                    'map_list', 'marker_list','sub_category'));

            //return view('places/search', compact('places', 'sub_cat', 'map_list','marker_list', 'subcat'));

            //dd($restaurants);

        } else {

            $places=$restaurants;



            return view('search/searchIndex',compact('places'))

                ->with('subcat_place',$subcat_place)

                ->with('sub_category',$sub_category)



                ->with('activtySubcategory',$activtySubcategory);



//            return redirect()->back();

        }



    }



/////////////////////////////// search append ////////////////////

    public function searchAppend()

    {

        // dd($_GET);

        //$city_lat_lng = Cities::where('name',trim(Input::get('city')))->first();

//        $sub_cat= Category::select(DB::raw('categories.slug,categories.id,cat_image,cat_name,count(categories.id) as total'))

//            ->where('parent_id', 1)->

//            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->

//            groupby('categories.id')->get();



        ///////////////////////////////////////////////////////////////////////////



        $restaurants = Restaurants::select('stars', 'id', 'description', 'category_id', 'restaurant_name', 'slug')

            ->with(['single_photo' => function ($query) {

                $query->select('photo_id', 'photo', 'instance_id');

                $query->where('category_id', '=', 1);

                $query->where('main', '=', 1);

            }])->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', '=', 1);

                $query->where('instance_id', '=', 1);

            }])->with([

                'single_address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 1);

                }])->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 1);

                }])->with(['subCategories' => function ($query) {

                $query->where('category_id', '=', 1);

            }]);



        //////////////////////if login get favoruite list also

        if (!empty(Auth::user()->user_id)) {

            $restaurants->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', 1);

                $query->where('user_id', Auth::user()->user_id);

            }]);

        }

        $restaurants->where('status', 'Active');



        /** filter by city here */

        if (Input::get('term') && Input::get('type') == "city") {

            

            $restaurants->whereHas(

                'address', function ($query) {

                $query->where('category_id', '=', 1);

                $query->Where("city", Cities::select('name')->find(Input::get('city_id'))->name);



            }

            );

        }

        if (Input::get('term') && Input::get('type') == "restaurant") {

            $restaurants->where('id', Input::get('city_id'));

        }

        ////////////////filter by sub cat

        if (Input::get('cuisine')) {

            $restaurants->whereHas(

                'subCategories', function ($query) {

                $query->where('category_id', '=', 1);

                if (Input::get('cuisine')) {

                    $query->Where("subcategory_id", "=", Input::get('cuisine'));

                }

            }

            );

        }

        // DB::enableQueryLog();

        $restaurants = $restaurants->orderBy('order_no','ASC')->paginate(15);

//dd($restaurants);



        // print_r(DB::getQueryLog()); exit;

        //$places=$restaurants;

        $map_list = '';

        $marker_list = '';

        $map_data = array();

        $marker_data = array();



        foreach ($restaurants as $obj) {



            if (sizeof($obj->subCategories)) {

                $subcat = Category::where('id', $obj->subCategories[0]->subcategory_id)->first();

            }

            $data['name'] = @$obj->restaurant_name;

            $data['location_latitude'] = @$obj->single_address->latitude;

            $data['location_longitude'] = @$obj->single_address->longitude;

            $data['map_image_url'] = $map_image = url('/uploads/' . @$obj->single_photo->photo);

            $data['map_pin_image_url'] = url('/uploads/' . @$subcat->cat_image);

            $data['name_point'] = @$obj->place_name;

            $data['description_point'] = str_limit(strip_tags(trim($obj->description)), 100, '....');

            $icon = str_replace("subcategory", "thumb", @$subcat->cat_image);

            $data['get_directions_start_address'] = url('/uploads/subcategory/' . $icon);

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

        //dd($restaurants);

        echo view('restaurants/searchRestaurant', compact('sub_cat', 'city_lat_lng', 'map_list', 'marker_list'))->with('restaurants', $restaurants);

        //echo view('restaurants/searchRestaurant',compact( 'sub_cat', 'city_lat_lng','map_list','marker_list'))->with('restaurants', $restaurants);





    }



    public function detail($id)

    {

        $item = Restaurants::where('id', $id)->orWhere('slug', $id)->with([

            'photo' => function ($query) {

                $query->select('main', 'photo_id', 'photo', 'instance_id');

                $query->Where('category_id', '=', 2);

                $query->orderBy('main', 'DESC');

            }])



            ->with([

                'address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 2);

                }])

            ->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 2);

                }]);

       /* if (!empty(Auth::user()->user_id)) {

            $item->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', 2);

                $query->where('user_id', Auth::user()->user_id);

            }]);

        }*/

        $item = $item->first();

  /*if(!empty(Auth::id()) {

              $item_fav = Favourite::where('instance_id',$item->id)

                  ->where('category_id', 2)

                  ->where('user_id', Auth::id())

                  ->first();

          }*/

        $reviews = Reviews::where('instance_id', $item->id)

            ->where('category_id', 2)

            ->with('user_detail')->get();

                   if (isset($item) && !empty($item)) {

            $favoruite = Favourite::where('instance_id', $item->id)

                ->where('category_id', 3)

                ->where('user_id',Auth::id())->first();

        }

//dd($rating);



        if (isset($item->address) && !empty($item->address)) {

            $lat=$item->address->latitude;

            $long=$item->address->longitude;

            $name=$item->restaurant_name;

           /* $maps[] = array($item->restaurant_name, $item->address->latitude, $item->address->longitude);

            $marker[] = array('<div class="infoBox" >

                <div class="marker_info_2">

                <img  src="' . url('/uploads/' . @$item->photo[0]['photo']) . '" alt="Image">

                <h3>' . $item->restaurant_name . '</h3>

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

        return view('detail', compact('item', 'reviews','name','lat','long', 'map_list', 'marker_list','favoruite'));



    }



    public function item_detail($id)

    {

        $item = Restaurants::where('id', $id)->orWhere('slug', $id)->with([

            'photo' => function ($query) {

                $query->select('main', 'photo_id', 'photo', 'instance_id');

                $query->Where('category_id', '=', 1);

                $query->orderBy('main', 'DESC');

            }])

            ->with([

                'single_address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 1);

                }])->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 1);

                }]);

        if (!empty(Auth::user()->user_id)) {

            $item->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', 1);

                $query->where('user_id', Auth::user()->user_id);

            }]);

        }

        $item = $item->first();



        $rating = Reviews::where('instance_id', $item->id)

            ->where('category_id', 1)

            ->with('user_detail')->get();



        if (isset($item->single_address) && !empty($item->single_address)) {

            $maps[] = array($item->restaurant_name, $item->single_address->latitude, $item->single_address->longitude);

            $marker[] = array('<div class="infoBox" >

                <div class="marker_info_2">

                <img  src="' . url('/uploads/' . @$item->photo[0]['photo']) . '" alt="Image">

                <h3>' . $item->restaurant_name . '</h3>

                <span>' . $item->excerpt . '</span>

                <div class="marker_tools">

                <form action="http://maps.google.com/maps" method="get" target="_blank" style="display:inline-block">

                <input name="saddr" value="" type="hidden">

                <input name="daddr" value="' . $item->single_address->latitude . ',' . $item->single_address->longitude . '" type="hidden">

                <button type="submit" value="Get directions" class="btn_infobox_get_directions">Directions</button>

                </form>

                <a href="tel://' . $item->phone . '" class="btn_infobox_phone">' . $item->phone . '</a></div>

                </div></div>');

            ///////////////END MAp////////////////

            $map_list = json_encode($maps);

            $marker_list = json_encode($marker);

        }

        return view('restaurants/item', compact('item', 'rating', 'map_list', 'marker_list'));



    }



    public function restaurantDetail($country, $subcat, $id)

    {

        $item = Restaurants::where('id', $id)->orWhere('slug', $id)->with([

            'photo' => function ($query) {

                $query->select('main', 'photo_id', 'photo', 'instance_id');

                $query->Where('category_id', '=', 1);

                $query->orderBy('main', 'DESC');

            }])

            ->with([

                'address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 1);

                }])->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 1);

                }]);

       /* if (!empty(Auth::id()) {

            $item->with(['fav_restaurant' => function ($query) {

                $query->where('category_id', 1);

                $query->where('user_id', Auth::user()->user_id);

            }]);

        }*/

        $item = $item->first();



        $rating = Reviews::where('instance_id', $item->id)

            ->where('category_id', 1)

            ->with('user_detail')->get();

        return view('restaurants/item', compact('item', 'rating'));



    }



    public function load_more($id)

    {

        $sub_cat = Category::select(DB::raw('categories.slug,categories.id,cat_image,cat_name,count(categories.id) as total'))

            ->where('parent_id', 1)->

            join('multi_subcategories', 'multi_subcategories.subcategory_id', '=', 'categories.id')->

            groupby('categories.id')->orderBy('order_no','ASC')->get();



        $restaurants = Restaurants::select('stars', 'id', 'description', 'category_id', 'restaurant_name', 'slug')

            ->with(['photo' => function ($query) {

                $query->select('photo_id', 'photo', 'instance_id');

                $query->where('category_id', '=', 1);

                $query->where('main', '=', 1);

            }])->with([

                'address' => function ($qury) {

                    $qury->select('address_id', 'email', 'address', 'latitude', 'longitude', 'city', 'country', 'instant_id');

                    $qury->Where('category_id', '=', 1);

                }])->with([

                'reviews_avg' => function ($qury) {

                    $qury->Where('category_id', '=', 1);

                }])->with(['subCategories' => function ($query) {

                $query->where('category_id', '=', 1);

            }]);

        if (Input::get('city')) {

            $restaurants->whereHas(

                'address', function ($query) {

                $query->where('category_id', '=', 1);

                if (Input::get('city')) {

                    $query->Where("city", "=", trim(Input::get('city')));

                }

            }

            )->orWhere('restaurant_name', 'like', '%' . trim(Input::get('city')) . '%');

        }

        if (Input::get('cuisine')) {

            $restaurants->whereHas(

                'subCategories', function ($query) {

                $query->where('category_id', '=', 1);

                if (Input::get('cuisine')) {

                    $query->Where("subcategory_id", "=", Input::get('cuisine'));

                }

            }

            );

        }

        /*if(Input::get('restaurant_name')) {

            $restaurants->where('restaurant_name', 'like', '%' . trim(Input::get('restaurant_name')) . '%');

        }*/

        if ($id) {

            $page = $id;

        } else {

            $page = '20';

        }

        $restaurants = $restaurants->orderBy('order_no','ASC')->paginate($page);





        return view('restaurants/load_more', compact('restaurants', 'sub_cat'));

    }



    public function store_rating(Request $request)

    {

        Reviews::create($request->all());

        if (!empty($request->res_slug)) {

            $url = $request->res_slug;

        } else {

            $url = $request->instance_id;

        }

        return redirect(url('/restaurants/' . $request->cat_slug . '/' . $url));

    }



   

    ///////





}

