<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Places;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use App\Models\Cities;
use App\Models\Address;
use App\Models\Category;
use App\Models\multiSubcategories;
//use App\Models\LogsPlaces;
use App\Models\Photo;
use App\Models\Keyword;
use App\Models\multiKeywords;
use App\Models\Supplier;

use App\Classes\Functions;
//use PDF;
use Session;
use DB;
use URL;
use PHPCoord\OSRef;

//use Excel;

class ActivityController extends Controller
{
    public function __construct()
    {
        //$this->middleware('Admin_auth');
        //$this->cat_detail = Category::where('code', '=', 'PLC')->first();
        $this->cat_detail = Category::where('id', '=', '3')->first();
//        $this->middleware(function ($request, $next) {
//            if (empty(Auth::user()->can('places-listing'))) {
//                return redirect('admin/dashboard');
//            }
//        return $next($request);
//        });
    }
        public function geo_codes()
        {

           // echo "ddddd".rad2deg(3442423423);
            $OSRef = new OSRef( 02157,  6409); //Easting, Northing
            $LatLng = $OSRef->toLatLng();
            $GPSLatLng = $LatLng->toWGS84(); //optional, for GPS compatibility
            //6409N 02157W
              $lat = $LatLng->getLat();
            $long = $LatLng->getLng();
          echo  $lat.' '.$long;
        }


    public function activity_availability(Request $request)
    {

        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s')."5d768e471b3844209b824181f6f5aa3bPOST/activity.json/search?currency=ISK&lang=EN";
        $seceret = "e4d8295c87314700b0d437116149e1b5";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));

        $ch = curl_init('https://api.bokun.io/activity.json/10361/availabilities?start=2018-11-01&end=2018-11-05&lang=EN&currency=ISK&includeSoldOut=false');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :5d768e471b3844209b824181f6f5aa3b',
                'Content-Type: application/json'
                //'Content-Length:' . strlen($data)
            )
        );
       // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
       // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_error($ch)) {
            echo 'Request Error:' . curl_error($ch);
        }

        dd($result);
        dump(curl_getinfo($ch));
        curl_close($ch);
        $data = json_decode($result);

    }

    public function api(Request $request)
    {


        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s')."5d768e471b3844209b824181f6f5aa3bPOST/activity.json/search?currency=USD&lang=EN";
        $seceret = "e4d8295c87314700b0d437116149e1b5";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));

        $page=1;
        if($request->page)
        $page = $request->page;

        $limit=50;
        if($request->limit)
        $limit = $request->limit;
        //''$data = '{"vendorId": 273,"page":1,"pageSize":50}';
        // $data = '"page":1,"pageSize":50';

        $data = '{"vendorId": '.$request->vendorId.',"page":'.$request->page.',"pageSize":'.$request->limit.'}';
        //$data = "{'page':".$request->page.",'pageSize': ".$request->limit."}";
        //$data = trim('"','',$data);
      // $data = '{}';

        $ch = curl_init('https://api.bokun.is/activity.json/search?currency=USD&lang=EN');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :5d768e471b3844209b824181f6f5aa3b',
                'Content-Type: application/json',
                'Content-Length:' . strlen($data)
            )
        );
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_getinfo($ch);
            curl_close($ch);
            $data = json_decode($result);

   //dd($data);
//        if (!empty($data->tagFacets)) {
//            foreach ($data->tagFacets[0]->entries as $supplier) {
//                Supplier::updateOrCreate( array('supplier_name' => $supplier->title,
//                    "term" =>$supplier->term,
//                "count"=> $supplier->count ), ['supplier_name' => $supplier->title]);
//            }
//        }
       // dump($data->termFacets->city->entries);
        if (!empty($data->termFacets->city->entries)) {

            foreach ($data->termFacets->city->entries as $cities) {

                $city = Cities::where('name', $cities->title)->first();
                if (!empty($city)) {
                    continue;
                }else{
                    Cities::create( array('name' => $cities->title,
                        "count"=> $cities->count ));
                }

            }
        }
        if (!empty($data->termFacets->supplier->entries)) {

            foreach ($data->termFacets->supplier->entries as $supplier) {

                Supplier::updateOrCreate( array('supplier_name' => $supplier->title,
                    "term" =>$supplier->term,
                "count"=> $supplier->count ), ['supplier_name' => $supplier->title]);
            }
        }

//dd($data->termFacets->supplier->entries);

        if (!empty($data->termFacets->activityCategories->entries)) {

            foreach ($data->termFacets->activityCategories->entries as $subcategory) {

                $category = Category::where('cat_name', $subcategory->title)->first();
                //print_r($category);
                //dump($category);
                if (empty($category)) {
//                    Category::updateOrCreate( array('cat_name' => $subcategory->title,
//                        'code'=>substr( $subcategory->title,0,5),
//                        'count' => $subcategory->count,
//                        'parent_id'=>3
//                    ) , ['code'=>substr( $subcategory->title,0,5)] );

                }else{
                    continue;
                }

            }
        }

        //dd(Auth::id());//
//        if (!empty($data->items)) {
//
//                    foreach ($data->items as $obj) {
//
//                        //dd//($obj->fields->defaultOpeningHours);
//                        $exist_activity = Activity::where('product_id', $obj->id)->first();
//                        if (!empty($exist_activity)) {
//                            $formData= array();
//                            //dump($obj->googlePlace);
//                            //->googlePlace googlePlace
//                            if (isset($obj->price) && $obj->price != "") {
//                                $formData['price'] =  (int)$obj->price;
//                            } else {
//                                $formData['price'] = 0;
//                            }
//                           // $model_obj = new Activity();
//                            //DB::enableQueryLog();
//                            $result = Activity::where('product_id', $obj->id)->update($formData);
//                           // dd(DB::getQueryLog());
//                            continue;
//                        }
//                    }
//
//                  }
//        echo' page '.$request->page.' limit '.$request->limit;
//                  exit;
//dd($data->items);
        if (!empty($data->items)) {

            foreach ($data->items as $obj) {
               // dd($data);
                //dd($obj->fields->defaultOpeningHours);
                $exist_activity = Activity::where('product_id', $obj->id)->first();
                //dd($exist_activity);
                if (!empty($exist_activity)) {

                    if (isset($obj->price) && $obj->price != "") {
                        $formData['price'] =  (int)$obj->price;
                    } else {
                        $formData['price'] = 0;
                    }
                   // $model_obj = new Activity();
                    //DB::enableQueryLog();
                    $result = Activity::where('product_id', $obj->id)->update($formData);
                   // dd(DB::getQueryLog());
                    echo 'Data exist already</br>';
                    continue;
                }

                if(isset($obj->vendor) && !empty($obj->vendor))
                {
                    $supplier_ext = Supplier::where('term',$obj->vendor->id)->first();
                    if( !empty($supplier_ext))
                    {
                       $obj->supplier_id =$supplier_ext->id;
                    }else{

                        $supplier=Supplier::create([
                            'supplier_name' => $obj->vendor->title,
                            'term' => $obj->vendor->id
                        ]);
                        $obj->supplier_id  =  $supplier->id;

                    }

                }
//                +"externalId": "DT 333"
//               // +"productGroupId": 0
//                +"title": "DT 333 Private Luxury Thórsmörk Valley and Helicopter back to Reykjavík"
//                +"summary": """
                //dd((int)$obj->price);
                $model_obj = new Activity();

                $formData['product_id'] = $obj->id;
                $formData['external_id']  = $obj->externalId;
                $formData['product_group_id'] = $obj->productGroupId;
                $formData['activity_name'] = $obj->title;
                $formData['description'] = $obj->summary;
                if (isset($obj->excerpt) && $obj->excerpt != "")
                    $formData['excerpt'] = $obj->excerpt;

                if (isset($obj->price) && $obj->price != "") {
                    $formData['price'] =  (int)$obj->price;
                } else {
                    $formData['price'] = 0;
                }

                $formData['category_id'] = $this->cat_detail->id;
                $formData['slug'] = Functions::slug('', $obj->title, $model_obj);
                $formData['created_by'] = @Auth::id();
                $formData['track_id'] = 'ACT-' . str_random(5);
                 $formData['review_rating'] = $obj->reviewRating;
                $formData['source'] = 'bokun';
                $formData['supplier_id'] =$obj->supplier_id;

                if (!empty($obj->fields)) {
                    // dd($obj->fields->durationText);
                    $formData['duration'] = $obj->fields->durationText;
                }
                if (sizeof($obj->languages)) {
                   $formData['language']  = implode(',',$obj->languages);
                    }
                if (sizeof($obj->customFields)) {
                    $formData['information']  = $obj->customFields[0]->value;
                }

                $result = Activity::updateOrCreate($formData,['product_id' =>$obj->id]);
                //////////////////Add address of activities//////
                $address = new Address();
                //$formData1['instant_id'] = $obj->locationCode->id;
                //$formData1['category_id'] = $this->cat_detail->id;
                //$formData1['latitude'] = $sub_places->location->latitude;
                //$formData1['longitude'] = $sub_places->location->longitude;
                //$formData1['address'] = $sub_places->location->address;
                if(isset($obj->locationCode) &&  !empty($obj->locationCode))
                {
                    //dd($obj->locationCode->name);
                    $address = new Address();
                    $formData1['city'] = $obj->locationCode->name;
                    $formData1['country'] = $obj->locationCode->country;
                    $formData1['instant_id'] = $result->id;
                    $formData1['category_id'] = $this->cat_detail->id;

                    $address_result1 = Address::create($formData1);

                    //dump($obj->googlePlace);
                    //->googlePlace googlePlace
                   // dump($address_result1->address_id);
                    if(isset($obj->googlePlace) &&  !empty($obj->googlePlace))
                    {

                        $addressData= array();
                        $addressData['city']  = $obj->googlePlace->city;
                        $addressData['city']  = $obj->googlePlace->city;
                        $addressData['latitude']  = $obj->googlePlace->geoLocationCenter->lat;
                        $addressData['longitude']  = $obj->googlePlace->geoLocationCenter->lng;

                        $updated =Address::where('address_id',$address_result1->address_id)->update($addressData);
                    }
                }


                //////////////////add sub Activity here like in reykjavik have multipl famous coffee shops all goes here//////////
                //dd($obj->places);
                if (!empty($obj->places)) {

                    //dd($obj->places);
                    $address = new Address();
                    $formData= array();
                    foreach ($obj->places as $sub_places) {
                        $formData['activity_name'] = $sub_places->title;
                        $formData['excerpt'] = $obj->excerpt; //expert add from parent activity because its not avail at in this loop
                        $formData['description'] = $obj->summary;//summery add from parent activity because its not avail at in this loop
                        $formData['external_id'] = $sub_places->id;
                        $formData['category_id'] = $this->cat_detail->id;
                        $formData['slug'] = Functions::slug('', $sub_places->title, $model_obj);
                       // dd(Auth::user()->id);
                        $formData['created_by'] = Auth::id();
                        $formData['track_id'] = 'PLC-' . rand();
                        $sub_places_result = Places::create($formData);
                        /////add complete address to place
//                    print_r($sub_places->location);
                        $formData1['instant_id'] = $sub_places_result->id;
                        $formData1['category_id'] = $this->cat_detail->id;
                        $formData1['latitude'] = $sub_places->location->latitude;
                        $formData1['longitude'] = $sub_places->location->longitude;
                        $formData1['address'] = $sub_places->location->address;
                        $formData1['city'] = $sub_places->location->city;
                        $formData1['country'] = $sub_places->location->countryCode;
                        $address_result = Address::create($formData1);
                    }

                }

                //////////////////////creating Keywords//////////////////
                if (!empty($obj->keywords)) {
                    foreach ($obj->keywords as $keyword) {
                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
                       // dd($keyword_id);
                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id ,$this->cat_detail->id);
                        //Create multi subcateogory//////
                        //$subcategory_id = Functions::create_subcategory($this->cat_detail->id, $keyword);
                        //$multi_subcategory_id = Functions::create_multi_subcat($result->id, $subcategory_id ,$this->cat_detail->id);
                    }
                } else {
                    foreach ($obj->flags as $keyword) {
                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id ,$this->cat_detail->id);
                       // $subcategory_id = Functions::create_subcategory($this->cat_detail->id, $keyword);
                       // $multi_subcategory_id = Functions::create_multi_subcat($result->id, $subcategory_id ,$this->cat_detail->id);
                    }
                }

                //dd($obj->photos);
                //////////////////////////////creating images/////////////////////////////////
                if (!empty($obj->photos)) {
                    foreach ($obj->photos as $img) {
                        dd($_SERVER['DOCUMENT_ROOT'] );


                 //  $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/activities';
                    $path = $_SERVER['DOCUMENT_ROOT'] . '/travel/uploads/activities';
                        file_put_contents($path .'/large'. $img->fileName, file_get_contents($img->originalUrl));
                        $data = Photo::create([
                           // 'photo' => 'activities' . $img->fileName,
                            'photo' =>  $img->fileName,
                            'category_id' => $this->cat_detail->id,
                            'instance_id' => $result->id,
                            'main' => 1
                        ]);
                      // dd($img->derived);
                        ///add  thumbnails photo ///
                        if (!empty($img->derived)) {
                            foreach ($img->derived as $thumbnail) {


                                if ($thumbnail->name == 'large') {
                                    file_put_contents($path. $img->fileName, file_get_contents($thumbnail->url));
                                }

                                if ($thumbnail->name == 'preview') {
                                    file_put_contents($path.'/preview'. $img->fileName, file_get_contents($thumbnail->url));
                                }

                                if ($thumbnail->name == 'thumbnail') {
                                    file_put_contents($path . '/thumb' . $img->fileName, file_get_contents($thumbnail->url));
                                }


                            }

                        }
                    }


                }

              echo 'Done </br>';

            }


        // return redirect('admin/activities');
        } else {
            echo "Error to import data please check internet connection";
        }
    }

    //////////////////////////////// API Call for Bokun Api////////////
    public function api_old()
    {
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cPOST/activity.json/search?currency=ISK&lang=EN";
        $seceret = "656b1a3490c74789b025fead9a88c084";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $data = '{}';
        $ch = curl_init('https://api.bokuntest.com/activity.json/search?currency=ISK&lang=EN');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
                'Content-Type: application/json',
                'Content-Length:' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_getinfo($ch);
        curl_close($ch);
        $data = json_decode($result);
        //dd($data);


        if (!empty($data->items)) {
            foreach ($data->items as $obj) {
                $exist_place = Places::where('external_id', $obj->id)->first();
                if (!empty($exist_place)) {
                    continue;
                }
                $model_obj = new Places();
                $formData['place_name'] = $obj->title;
                if (isset($obj->price) && $obj->price != "") {
                    $formData['price'] = (int)$obj->price;
                } else {
                    $formData['price'] = 0;

                }
                $formData['excerpt'] = $obj->excerpt;
                $formData['description'] = $obj->summary;
                $formData['external_id'] = $obj->id;
                $formData['category_id'] = $this->cat_detail->id;
                $formData['slug'] = Functions::slug('', $obj->title, $model_obj);
                $formData['created_by'] = @Auth::id();
                $formData['track_id'] = 'ACT-' . str_random(5);
                $formData['source'] = 'bokun';
                $result = Places::create($formData);
                //////////////////add sub places here like in reykjavik have multipl famous coffee shops all goes here//////////
                if (!empty($obj->places)) {
                    //dd($obj->places);
                    $address = new Address();
                    foreach ($obj->places as $sub_places) {
                        $formData['place_name'] = $sub_places->title;
                        $formData['excerpt'] = $obj->excerpt; //expert add from parent activity because its not avail at in this loop
                        $formData['description'] = $obj->summary;//summery add from parent activity because its not avail at in this loop
                        $formData['external_id'] = $sub_places->id;
                        $formData['category_id'] = $this->cat_detail->id;
                        $formData['slug'] = Functions::slug('', $sub_places->title, $model_obj);
                        $formData['created_by'] =  Auth::id();
                        $formData['track_id'] = 'PLC-' . rand();
                        $sub_places_result = Places::create($formData);
                        /////add complete address to place
//                    echo "<pre>";
//                    echo $sub_places->location->latitude;
//                    print_r($sub_places->location);
//                    exit;
                        $formData1['instant_id'] = $sub_places_result->id;
                        $formData1['category_id'] = $this->cat_detail->id;
                        $formData1['latitude'] = $sub_places->location->latitude;
                        $formData1['longitude'] = $sub_places->location->longitude;
                        $formData1['address'] = $sub_places->location->address;
                        $formData1['city'] = $sub_places->location->city;
                        $formData1['country'] = $sub_places->location->countryCode;
                        $address_result = Address::create($formData1);
                    }

                }
                //////////////////////creating Keywords//////////////////
                if (!empty($obj->keywords)) {
                    foreach ($obj->keywords as $keyword) {
                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id);
                    }
                } else {
                    foreach ($obj->flags as $keyword) {
                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id);
                    }
                }

                //////////////////////////////creating images/////////////////////////////////
                if (!empty($obj->photos)) {
                    foreach ($obj->photos as $img) {
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/tripxonic/uploads/places' . $img->fileName;
                        file_put_contents($path, file_get_contents($img->originalUrl));
                        $data = Photo::create([
                            'photo' => 'places' . $img->fileName,
                            'category_id' => $this->cat_detail->id,
                            'instance_id' => $result->id,
                            'main' => 1
                        ]);
                    }
                }
            }
            return redirect('admin/activities');
        } else {
            echo "Error to import data please check internet connection";
        }
    }



    public function index()
    {
        $perPage = 20;
        $items = Activity::with('subCategories_edit')
            ->take($perPage)->orderBy('activity_name', 'asc')->get();

        $subcategory = Category::select('id', 'cat_name', 'parent_id')->where('parent_id', $this->cat_detail->id)
            ->orderBy('cat_name', 'ASC')->get();

        $suppliers = Supplier::select('id', 'supplier_name')
            ->orderBy('count', 'DESC')->get();

        $total = Activity::count();
        $currentRoute = 'admin::activities';

        if(isset($_GET['subcat_id']))
            $subcat_id= $_GET['subcat_id'];
        else
            $subcat_id=0;

        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'category_id' => 0,
            'subcategory_id' => $subcat_id,
            'modelInstance' => '\App\Models\Activity',
        ];
       // dd($viewData['items']);
        return view("admin.activities.datatables", $viewData, compact('subcategory','suppliers'));
    }


    /* public function index()
     {
         if (Input::get('display')) {
             $page = Input::get('display');
         } else {
             $page = '20';
         }
         $activities = Places::select('id', 'place_name','source' ,'track_id', 'category_id', 'created_at', 'status', 'stars')->with([
             'photo' => function ($query) {
                 $query->Where('category_id', "=", $this->cat_detail->id);
             }])
             ->with([
                 'address' => function ($query) {
                     $query->Where('category_id', "=", $this->cat_detail->id);
                 }])
             ->with([
                     'subCategories_edit' => function ($query) {
                         $query->Where('category_id', "=", $this->cat_detail->id);
                     }]
             )->orderBy('id', 'DESC');
         ///////////////////////////////filter apply by places listing page//////////////////////
         $activities->Where('category_id', "=", $this->cat_detail->id);
         if (session('country_base')) {
             $activities->whereHas(
                 'address', function ($query) {
                 $query->Where('category_id', "=", $this->cat_detail->id);
                 if (session('country_base')) {
                     $query->Where("country", "=", session('country_base'));
                 }
                 if (session('city_base')) {
                     $query->Where("city", "=", session('city_base'));
                 }
             });
         }
         if (Input::get('subcat_id')) {
             $activities->whereHas(
                 'subCategories_edit', function ($query) {
                 $query->Where('category_id', "=", $this->cat_detail->id);
                 if (Input::get('subcat_id')) {
                     $query->Where("subcategory_id", "=", Input::get('subcat_id'));
                 }
             });
         }
         if (Input::get('activity_name')) {
             $activities->where('activity_name', 'like', '%' . trim(Input::get('activity_name')) . '%');
         }
         if (Input::get('action_type')) {
             $activities > Where("places.status", "=", Input::get('action_type'));
         }
         if (Input::get('track_id')) {
             $activities->Where("track_id", "LIKE", '%' . trim(Input::get('track_id')) . '%');
         }
         // DB::enableQueryLog();
         $activities = $activities->paginate($page);
         //dd( DB::getQueryLog());
         $subcategory = Category::Where('parent_id', "=", $this->cat_detail->id)->orderBy('cat_name', 'ASC')->get();
         return view('admin/activities/listing_activities', compact('activities', 'categories', 'subcategory', 'cities', 'countries'));
     }*/

/////////////////////////////////// data table activities ////////////////////////////////////
    public function activities_listing()
    {
        // $items = Places::where('category_id','1') ->with('subCategories_edit')->get();
        $items = Activity::select('activities.id','product_id','external_id', 'activity_name', 'review_rating', 'activities.status', 'activities.order_no', 'activities.created_at')->orderBy('activities.updated_at', 'DESC')
            ->with(['subCategories_edit'=>function($query){
                    $query->orderBy('id','ASC');
            }])
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo', 'category_id', 'instance_id');
                    $querys->Where('category_id', '=', $this->cat_detail->id);
                    $querys->Where('main', '=',1);
                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }]);

        if (Input::get('subcategory_id')) {
            $items->whereHas(
                'subCategories_edit', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                $query->Where("subcategory_id", "=", Input::get('subcategory_id'));
            } );
        }
        if (Input::get('supplier_id')) {
            $items->Where("supplier_id", "=", Input::get('supplier_id'));
        }
        $items = $items->get();
            /*   echo '<pre>';
            print_r($items);
            exit;*/
        /*if(Input::get('subcat_id')){
                  return redirect()->back();
               }*/
        $currentRoute = str_replace('activity.', '', \Request::route()->getName());

        return $data = DataTables::of($items)
            ->addColumn('actions', function ($items) use ($currentRoute) {

                $edit = ' <a href="' . url("admin/activities/" . $items->id . '/edit') . '" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i>
                        </a>';
                $cond = '<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Active"
                title = "Inactive" class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill status-update">
               
                <i class="fa fa-times" ></i>
               
                </a>';
                if ($items->status == "Active") {
                    $cond = '<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Inactive"
                title="Active" class="m-portlet__nav-link btn m-btn btn-accent m-btn--icon m-btn--icon-only m-btn--pill status-update" >
                
                <i class="fa fa-check" >
                </i>
                
                </a>';
                }
                return '<div id="status_div_' . $items->id . '" class="status_div">' . $edit . $cond .
                    '</div>
                    <span style="overflow: visible; width: 150px;">
                       
                        <a data-id="' . $items->id . '" href="javascript:void(0)"
                                                   class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                    
                                                </span>
                    ';
            })
            ->editColumn('single_photo', function ($items) {
                if ($items->single_photo != '') {
                    for ($i = 0; $i < 1; $i++) {
                        //return '<img src="'.url('uploads/'.$items->single_photo[$i]->photo).'">';
                        if (isset($items->single_photo->photo) && !empty($items->single_photo->photo))
                            return url('uploads/activities/thumb' . $items->single_photo->photo);
                        else
                            return url('images/no-image.png');
                    }

                } else
                    return url('images/no-image.png');
            })
            ->editColumn('status', function ($items) {
                if ($items->status == 'Active') {
                    return '<span style="width: 110px;">
                            <span  class="m-badge  m-badge--success m-badge--wide">Active</span>
                        </span>';
                } else {
                    return '<span style="width: 110px;">
                            <span class="m-badge  m-badge--danger m-badge--wide">Inactive</span>
                    </span>';
                }
            })
            ->editColumn('subcat_name', function ($items) {

                    if(sizeof($items->subCategories_edit))
                    {
                        foreach ($items->subCategories_edit as $value) {
                            if(!empty($value->cat_name))

                                return $value->cat_name;
                        }
                    }
                    else
                        return 'N/A';

            })->editColumn('created_at', function ($items) {
                return $items->created_at->format('d-m-Y');
            })
            ->editColumn('id', function ($items) {
                return '<span>
                        <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                            <input name="id[]"  class="bulk-opration" type="checkbox" value="' . $items->id . '">
                            <span></span>
                        </label>
                    </span>';
            })->rawColumns(['status', 'actions', 'id'])->make(true);
        //return redirect()->back();
    }






//     public function create()
//     {
//         $categories = Category::where('parent_id', '=', 3)->get();
//         $keywords = Keyword::where('category_id', '=', 3)->get();
//         if (sizeof($categories)) {
//             return view('admin/activities/_form', compact('categories', 'keywords'));
//         } else {
//             return redirect('admin/activities');
//         }
//     }

//     public function store(Request $request)
//     {
//         $validator = Functions::validator($request->all(), [
//             'place_name' => 'required',
//             'category_id' => 'required',
//             'order_no' => 'required',
// //                    'description' => 'required',
//             // 'file' => 'required|image|mimes:jpeg,png,jpg,gif',
//             'search_address' => 'required',
//         ]);
//         if ($validator->fails()) {
//             return redirect('admin/activities/create')->withErrors($validator)->withInput();
//         }
//         ///////////////////////creating place//////////////////////
//         $category_act = Category::where('id', $request->category_id)->first();
//         $model_obj = new Places();
//         $formData = $request->all();
//         $formData['slug'] = Functions::slug($request->slug, $request->place_name, $model_obj);
//         $formData['created_by'] = Auth::user()->user_id;
//         $formData['track_id'] = 'PLC' . mt_rand() . $request->country_short;
//         $result = Places::create($formData);
// //        echo '<pre>';
// //        print_r($result->id);
// //        exit;
//         $address = new Address();
//         $instant_id = $result->id;
//         $address->instant_id = $instant_id;
//         $address->category_id = $request->category_id;
//         $address->latitude = $request->lat;
//         $address->longitude = $request->lng;
//         $address->address = $request->formatted_address;
//         $address->city = $request->locality;
//         $address->state = $request->administrative_area_level_1;
//         $address->country = $request->country_short;
//         $address->zipcode = $request->postal_code;
//         $address->save();
//         //////////////////////creating subcategory//////////////////
//         if (sizeof($request->subcategory)) {
//             foreach ($request->subcategory as $subcatlist) {
//                 $data = multiSubcategories::create([
//                     'instance_id' => $result->id,
//                     'category_id' => $result->category_id,
//                     'subcategory_id' => $subcatlist,
//                     'created_by' => $formData['created_by']
//                 ]);
//             }
//         }
//         //////////////////////creating Keywords//////////////////
//         if (sizeof($request->keywords)) {
//             foreach ($request->keywords as $keyword) {
//                 $data = multiKeywords::create([
//                     'instance_id' => $result->id,
//                     'category_id' => $result->category_id,
//                     'keyword_id' => $keyword,
//                     'created_by' => $formData['created_by']
//                 ]);
//             }
//         }
//         ///////////////////////creating image///////////////////////
//         if ($result && $request->file) {
//             foreach ($request->file as $fileName) {
//                 $filename = $fileName->getClientOriginalName();
//                 if ($request->main_image == $filename) {
//                     $main_image = 1;
//                 } else {
//                     $main_image = 0;
//                 }
//                 $path = $fileName->storeAs(
//                     'places', rand(0, 100) . '_' . $filename
//                 );
//                 $img = Functions::make_thumb($path);
//                 $data = Photo::create([
//                     'photo' => $path,
//                     'category_id' => $request->category_id,
//                     'instance_id' => $result->id,
//                     'main' => $main_image
//                 ]);
//             }
//             Session::flash('message', "Record has been added successfully.");
//             return redirect('admin/activities');
//         }
//     }

//     public function show($id)
//     {
//         //
//     }

    public function edit($id)
    {

        //$cat_id = Places::where('id', $id)->first();
        // DB::enableQueryLog();
        $activity = Activity::where('id', $id)->with(['subCategories_edit' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
        }])

            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])
            ->with('keywords')->first();
        //dd(DB::getQueryLog());
           
        if ($activity) {
            $region = DB::table('region')->get();
            $keywords = Keyword::where('category_id', $this->cat_detail->id)->get();
            $subcategory = Category::where('parent_id', $this->cat_detail->id)->get();
            $categories = Category::where('parent_id', 0)->where('code', 'ACT')->get()->first();
            // $matakuliahs = Matakuliah::where('id','=',$id)->get()->first();
            return view('admin/activities/_form_edit', compact('activity','region', 'keywords', 'subcategory', 'categories'));
        } else {
            return redirect('admin/activities')->withErrors('Record not found');
        }
    }



     public function update(Request $request, $id)
     {
         Functions::validator($request->all(), [
             'activity_name' => 'required',
             'category_id' => 'required',
 //            'track_id' => 'required|unique:activities,track_id,' . $id,
             //'ssn' => 'required|unique:activities,ssn,' . $id,
             /* 'order_no' => 'required', */
 //            'description' => 'required',
         ])->validate();
    /*echo $id;
         echo '<pre>';
        print_r($request->all());
        exit;*/

         $result = Activity::find($id);
         if ($result) {

             $formData = $request->all();
             if(isset($request->is_featured))
             {
             }else
                 $formData['is_featured']=0;

             $formData['slug'] = Functions::slug($request->slug, $request->activity_name, $result, $id);
             //$formData['created_by'] = Auth::user()->user_id;
             $formData['created_by'] =  Auth::id();

             $result->update($formData);
             ///////////////////////// Addresses //////////////////////////
             $data = array(
                 'instant_id' => $result->id,
                 'category_id' => $request->category_id,
                 'latitude' => $request->lat,
                 'longitude' => $request->lng,
                 'address' => $request->formatted_address,
                 'city' => $request->locality,
                 'region' => $request->region,
                 'state' => $request->administrative_area_level_1,
                 'country' => $request->country_short,
                 'zipcode' => $request->postal_code,
             );
             $data_address = Address::where('instant_id', $id)->where('category_id',$this->cat_detail->id)->first();
 //            print_r($data_address);
 //            exit;
             if (!empty($data_address)) {
                 $data_address->update($data);
             } else {
                 $Address = Address::create($data);
             }
 //             dd(DB::getQueryLog());
 //dd($data_address);

             //////////////////////creating subcategory//////////////////
             $data = multiSubcategories::where('instance_id', $id)->where('category_id', $this->cat_detail->id)->delete();
            if (!empty($request->subcategory)) {
                foreach ($request->subcategory as $subcatlist) {

                    $data = multiSubcategories::create([
                        'instance_id' => $result->id,
                        'category_id' => $result->category_id,
                        'subcategory_id' => $subcatlist,
                        'created_by' => Auth::id()
                    ]);
                }
            }
             //////////////////////creating keywords//////////////////
             $data = multiKeywords::where('instance_id', $id)->where('category_id',$this->cat_detail->id)->delete();
            if (!empty($request->keywords)) {
                foreach ($request->keywords as $keyword) {
                    $data = multiKeywords::create([
                        'instance_id' => $result->id,
                        'keyword_id' => $keyword,
                        'category_id' => $result->category_id,
                        'created_by' => $formData['created_by']
                    ]);
                }
            }
             ///////////////////////creating image///////////////////////
             //dd($request->all());

             if ($result && $request->file) {

                 foreach ($request->file as $fileName) {

                     /// dd($fileName);$this->cat_detail->id
                     Photo::where('instance_id', $id)->where('category_id',$this->cat_detail->id)->update(['main' => 0]);
                     Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
                     $filename = $fileName->getClientOriginalName();
                     if ($request->main_image == $filename) {
                         $main_image = 1;
                     } else {
                         $main_image = 0;
                     }
//                     $path = $fileName->storeAs(
//                         'activities', rand(0, 100) . '_' . $filename
//                     );

                     $destinationPath = 'uploads/activities/';
                     $filename = $fileName->getClientOriginalName();
                     $fileName->move($destinationPath, $filename);

                     $img = Functions::make_thumb('activities/'.$filename);
                     //dd($img);
                     $data = Photo::create([
                         'photo' =>'/'.$filename,
                         'category_id' => 3,
                         'instance_id' => $id,
                         'main' => $main_image
                     ]);

                 }
             }
             Photo::where('instance_id', $id)->where('category_id',$this->cat_detail->id)->update(['main' => 0]);
             Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
             Session::flash('message', "Record has been updated successfully.");
             return redirect($request->prev_url);
         } else {
             return redirect('admin/activities')->withErrors('There is a error in updating record.');
         };
     }

    /*   public function destroy($id)
       {
           $data = Places::find($id);
           $data->delete();
           Address::where('instant_id', $data->id)->where('category_id', $data->category_id)->delete();
           $deleted_photo = Photo::where('instance_id', $data->id)->where('category_id', $data->category_id)->get();
           if (!empty($deleted_photo)) {
               foreach ($deleted_photo as $obj) {
                   if (file_exists(public_path() . '/uploads/' . $obj->photo)) {
                       rename(public_path() . '/uploads/' . $obj->photo, public_path() . '/uploads/trash/' . $obj->photo);
                   }
                   $obj->delete();
               }
           }
           multiKeywords::where('instance_id', $data->id)->where('category_id', $data->category_id)->delete();
           multiSubcategories::where('instance_id', $data->id)->where('category_id', $data->category_id)->delete();
           Session::flash('message', "Record has been deleted successfully.");
           return redirect('admin/activities');
       }
   */
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

    public function remove_image(Request $request)
    {
        echo $result = Functions::image_remove($request->id);
    }


    public function get_subcategories(Request $request)
    {
        $option_list = "";
        $categories = Category::where('parent_id', $request->id)->get();
        foreach ($categories as $row) {
            $option_list .= "<option value='$row->id'>$row->cat_name</option>";
        }
        echo $option_list;
    }

    public function get_keywords(Request $request)
    {
        $option_list = "";
        $categories = Keyword::where('category_id', $request->id)->get();
        foreach ($categories as $row) {
            $option_list .= "<option value='$row->id'>$row->keyword_name</option>";
        }
        echo $option_list;
    }

    public function excel()
    {
        $data = array();
        $activity = Places::with(['subCategories_edit' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
            $query->orWhere('category_id', '=', $this->act_cat_detail->id);
        }])
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
                $query->orWhere('category_id', '=', $this->act_cat_detail->id);

            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
                $query->orWhere('category_id', '=', $this->act_cat_detail->id);
            }])
            ->with('keywords')->get();

        if (sizeof($activity)) {
            foreach ($activity as $obj) {
                if (sizeof($obj->subCategories_edit)) {
                    $data1 = array();
                    foreach ($obj->subCategories_edit as $cat_name) {
                        $data1[] = $cat_name->cat_name;
                    }
                    $subcategories = implode(',', $data1);
                }
                if (sizeof($obj->keywords)) {
                    $data2 = array();
                    foreach ($obj->keywords as $key_obj) {
                        $data2[] = $key_obj->keyword_name;
                    }
                    $keywords = '';
                    $keywords = implode(',', $data2);
                }
                if (sizeof($obj->photo)) {
                    $data3 = array();
                    foreach ($obj->photo as $photo_obj) {
                        $data3[] = $photo_obj->photo;
                    }
                    $images = implode(',', $data3);
                }

                $data[] = array(
                    'track_id' => $obj->track_id,
                    'SSN' => $obj->ssn,
                    'category_id' => $obj->category_id,
                    'activity_name' => $obj->activity_name,
                    'slug' => $obj->slug,
                    'order_no' => $obj->order_no,
                    'review_rating' => $obj->review_rating,
                    'phone' => $obj->phone,
                    'is_featured' => $obj->is_featured,
                    'website' => $obj->website,
                    'social_1' => $obj->social_1,
                    'social_2' => $obj->social_2,
                    'social_3' => $obj->social_3,
                    'latitude' => @$obj->address[0]->latitude,
                    'longitude' => @$obj->address[0]->longitude,
                    'address' => @$obj->address[0]->address,
                    'city' => @$obj->address[0]->city,
                    'state' => @$obj->address[0]->state,
                    'country' => @$obj->address[0]->country,
                    'zipcode' => @$obj->address[0]->zipcode,
                    'email' => @$obj->address[0]->email,
                    'subcategories' => @$subcategories,
                    'keywords' => @$keywords,
                    'images' => @$images,
                    'excerpt' => $obj->excerpt,
                    'description' => $obj->description,
                );
                $keywords = '';
                $subcategories = "";
                $images = "";
            }

            Excel::create('Places Listing', function ($excel) use ($data) {
                // Set the title
                $excel->setTitle('excelsheet for listing places');
                // Chain the setters
                $excel->setCreator('Tripxonic')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Places Detail', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->export('xls');
        } else {
            return redirect('admin/places');
        }
    }

    public function csv()
    {
        $activity = Places::all();
        if (sizeof($activity)) {
            foreach ($activity as $obj) {
                $counter = count($obj->address);
                $data[] = array('place name' => $obj->activity_name, 'SSN' => $obj->ssn, 'Description' => $obj->description, 'Website' => $obj->website, 'Facebook Link' => $obj->social_1, 'Twitter Link' => $obj->social_2);
            }
            Excel::create('Places Listing', function ($excel) use ($data) {
                // Set the title
                $excel->setTitle('excelsheet for listing places');
                // Chain the setters
                $excel->setCreator('Tripxonic')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Places Detail', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->export('csv');
        } else {
            return redirect('admin/places');
        }
    }

    public function logs()
    {
        $data = array();
        $activity = LogsPlaces::all();
        if (sizeof($activity)) {
            foreach ($activity as $obj) {
                $data[] = array(
                    'id' => $obj->instance_id,
                    'title' => $obj->title,
                    'message' => $obj->message,
                    'source' => $obj->source,
                    'created_at' => $obj->created_at,
                );
            }
            Excel::create('Places Listing', function ($excel) use ($data) {
                // Set the title
                $excel->setTitle('excelsheet for listing places');
                // Chain the setters
                $excel->setCreator('Tripxonic')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Places Detail', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->export('xls');
        } else {
            return redirect('admin/places');
        }
    }

    public function import_excel()
    {
        return view('admin/places/import_places');
    }

    public function store_excel()
    {
        $path = $_FILES['file']['tmp_name'];
        //$file_path = storage_path('exports') . '/Places-Listing.xls';
        Excel::load($path, function ($reader) {
            $results = $reader->toArray();
            foreach ($results as $sheet) {
                if (isset($sheet['activity_name']) && $sheet['activity_name'] != '') {
                    $check = Places::where('activity_name', '=', trim($sheet['activity_name']))
                        ->first();
                    if (sizeof($check)) {
                        LogsPlaces::create([
                            'track_id' => @$sheet['track_id'],
                            'ssn' => @$sheet['ssn'],
                            'title' => @$sheet['activity_name']
                        ]);
                        continue;
                    }
                    /////////////////////add address//////////////////
                    if (isset($sheet['address']) && trim($sheet['address']) != "") {
                        $cordinates = Functions::addressToLT($sheet['address'] . ',' . @$sheet['country']);
                        if (empty(trim($sheet['latitude'])) && empty(trim($sheet['longitude']))) {
                            $sheet['latitude'] = $cordinates['lat'];
                            $sheet['longitude'] = $cordinates['lng'];
                        }
//                        if (empty(trim($sheet['city']))) {
//                            $sheet['city'] = @$cordinates['city'];
//                        }
                        // $sheet['country'] = @$cordinates['country'];
                        $sheet['address'] = $cordinates['address'];
                    }
                    $model_obj = new Places();
                    $sheet['slug'] = '';
                    $formData = $sheet;
                    $formData['slug'] = Functions::slug($sheet['slug'], $sheet['activity_name'], $model_obj);
                    $formData['category_id'] = $sheet['category_id'];
                    $formData['track_id'] = 'PLC' . mt_rand();
                    $formData['source'] = @$sheet['source'];
                    if (strpos($formData['website'], 'http') !== false) {
                        $formData['website'] = $formData['website'];
                    } else {
                        $formData['website'] = 'http://' . $sheet['website'];
                    }
                    //$formData['created_by'] = Auth::user()->user_id;
                    $formData['created_by'] = Auth::id();


                    $result = Places::create($formData);
                    /////////////////////add address//////////////////
                    $address = new Address();
                    $address->instant_id = $result->id;
                    $address->category_id = $sheet['category_id'];
                    $address->latitude = @$sheet['latitude'];
                    $address->longitude = @$sheet['longitude'];
                    $address->zipcode = @$sheet['zipcode'];
                    $address->email = @$sheet['email'];
                    $address->city = @$sheet['city'];
                    $address->country = @$sheet['country'];
                    $address->address = @$sheet['address'];
                    $address->save();
                    if (isset($sheet['keywords']) && !empty(trim($sheet['keywords']))) {
                        $key_explode = explode(',', trim($sheet['keywords'])); //explode subcategori form sheet
                        foreach ($key_explode as $key_name) {
                            $keyObj = Keyword::where('keyword_name', 'like', trim($key_name))->
                            where('category_id', '=', $sheet['category_id'])->first(); //check if sub cat already exist
                            if (empty($keyObj)) {//if empaty then create it and add it to multi sub cat table
                                $keyword_id = Functions::create_keyword($sheet['category_id'], trim($key_name));
                                Functions::create_multi_keyword($result->id, $keyword_id, $sheet['category_id']);
                            } else {//if exist then direct add it to multysubcat table
                                Functions::create_multi_keyword($result->id, $keyObj->id, $sheet['category_id']);
                            }
                        }
                    }
                    if (isset($sheet['subcategories']) && !empty(trim($sheet['subcategories']))) {
                        $implode = explode(',', trim($sheet['subcategories'])); //explode subcategori form sheet
                        foreach ($implode as $cat_name) {
                            $subcatObj = Category::where('cat_name', 'like', trim($cat_name))->
                            where('parent_id', '=', $sheet['category_id'])->first(); //check if sub cat already exist
                            if (empty($subcatObj)) {//if empaty then create it and add it to multi sub cat table
                                $subcat_id = Functions::create_subcategory($sheet['category_id'], trim($cat_name));
                                Functions::create_multi_subcat($result->id, $subcat_id, $sheet['category_id']);
                            } else {//if exist then direct add it to multysubcat table
                                Functions::create_multi_subcat($result->id, $subcatObj->id, $sheet['category_id']);
                            }
                        }
                    }
                    for ($i = 1; $i <= 5; $i++) {
                        if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {
                            Functions::create_multi_images($result->id, $sheet['image' . $i], $sheet['category_id'], 'places', $sheet['order_no'], isset($sheet['image_order']));
                        }
                    }
                } else {
                    Session::flash('message', "SSN number not exist in your file.");
                    return redirect('admin/places');
                }
            }
        });
        return redirect('admin/places');
    }

    public function store_import_images(Request $request)
    {
        foreach ($request->images as $fileName) {
            $filename = $fileName->getClientOriginalName();
//            if ($request->main_image == $filename) {
//                $main_image = 1;
//            } else {
//                $main_image = 0;
//            }
            //$filename->store('places');
            $path = $fileName->storeAs(
                'places', $filename
            );
        }
        return redirect('admin/places');
    }

    public function import_petrol()
    {
//Create a client with a base URI
        $str = file_get_contents('http://apis.is/petrol');
        $data = json_decode($str);
        $category_act = Category::where('code', 'PST')->first();
        $model_obj = new Places();
        foreach ($data->results as $row) {
            $check = Places::where('ssn', $row->key)
                ->first();
            if (sizeof($check)) {
                $data = LogsPlaces::create([
                    'ssn' => $row->key,
                    'title' => $row->name
                ]);
                continue;
            }
            $formData['activity_name'] = $row->name;
            $formData['category_id'] = $this->cat_detail->id;
            $formData['ssn'] = $row->key;
            $formData['slug'] = Functions::slug('', $row->name, $model_obj);
            $formData['track_id'] = 'PLC' . mt_rand();
            $formData['created_by'] = Auth::id();
            $result = Places::create($formData);
            $address = new Address();
            $address->instant_id = $result->id;
            $address->category_id = $this->cat_detail->id;
            $address->latitude = $row->geo->lat;
            $address->longitude = $row->geo->lon;
            $address->save();
            $data = multiSubcategories::create([
                'instance_id' => $result->id,
                'category_id' => $this->cat_detail->id,
                'subcategory_id' => $category_act->id,
                'created_by' => $formData['created_by']
            ]);
        }
        return redirect('admin/places');
    }

    public function import_rcg_plc()
    {
//       $sub_category = DB::table('sub_category')->whereIn('category_id', array(1,3,4))->get();
//
//            foreach ($sub_category as $subcat) {
//                $sub_cat = new Category();
//                $sub_cat->parent_id = $this->cat_detail->id;
//                $sub_cat->cat_image = 'subcategory/' . $subcat->icon;
//                $sub_cat->cat_name = $subcat->subcat_name;
//                $sub_cat->code = $subcat->code;
//                $sub_cat->slug = Functions::slug('', $subcat->subcat_name, $sub_cat);
//                $sub_cat->status = 'Active';
//                $sub_cat->created_by = Auth::user()->user_id;
//                $sub_cat->save();
//            }
        ////////////////////
        $url = "http://reykjaviktoday.is/rcg/api/refresh";
        $str = file_get_contents($url);
        $response = json_decode($str);
        $response = $response->data;
//        echo '<pre>';
//       print_r($response);
//      exit;
        foreach ($response->places as $obj) {
            // print_r($obj);
            $model_obj = new Places();
            //foreach ($users as $obj) {
            //echo "dsdsdsds".$obj->activity_name;
            //exit;
            //echo "category_id".$obj->category_id.'</br>';

            if ($obj->category_id != 1 && $obj->status == 'Active') {
                $formData['activity_name'] = $obj->activity_name;
                $formData['ssn'] = $obj->ssn;
                $formData['category_id'] = $this->cat_detail->id;
                $formData['order_no'] = $obj->order_no;
                $formData['description'] = $obj->description;
                $formData['website'] = $obj->website;
                $formData['is_featured'] = $obj->is_featured;
                $formData['social_1'] = $obj->social_1;
                $formData['social_2'] = $obj->social_2;
                $formData['social_3'] = $obj->social_3;
                $formData['track_id'] = 'PLC' . mt_rand() . 'IS';
                //$formData['slug'] = Functions::slug( $obj->place_slug, $obj->activity_name, $model_obj);
                $formData['created_by'] = Auth::id();
                //echo "<pre>";
                // echo $formData['slug'];
                //exit;
                $result = Places::create($formData);
                // echo $result;
                ////////////////////creating subcategory//////////////////
                if ($obj->place_type) {
                    $implode = explode(',', $obj->place_type);
                    foreach ($implode as $subcat_code) {
                        $subcat_id = Category::where('code', $subcat_code)->first();
                        if (sizeof($subcat_id)) {
                            $data = multiSubcategories::create([
                                'instance_id' => $result->id,
                                'subcategory_id' => $subcat_id->id,
                                'category_id' => $this->cat_detail->id,
                                'created_by' => Auth::id(),
                            ]);
                        }
                    }
                }
                //////////////////////creating keywords//////////////////
                if ($obj->keywords) {
                    $implode = explode(',', $obj->keywords);
                    foreach ($implode as $keywords) {
                        $keyword_id = Keyword::where('keyword_name', trim($keywords))->where('category_id', $this->cat_detail->id)->first();

                        if (sizeof($keyword_id)) {
                            $data = multiKeywords::create([
                                'instance_id' => $result->id,
                                'keyword_id' => $keyword_id->id,
                                'category_id' => $result->category_id,
                                'created_by' => $formData['created_by']
                            ]);
                        } else {
                            $value = trim($keywords);
                            $keyword_id = Functions::create_keyword($this->cat_detail->id, $value);
                            Functions::create_multi_keyword($result->id, $keyword_id, $this->cat_detail->id);
                        }
                    }
                }
//            ///////////////////////creating places address//////////////////////
                foreach ($obj->address as $request) {
                    $address = new Address();
                    $address->instant_id = $result->id;
                    $address->category_id = $this->cat_detail->id;
                    $address->latitude = $request->latitude;
                    $address->longitude = $request->longitude;
                    $address->address = $request->address;
                    $address->city = $request->city;
                    $address->state = $request->state;
                    $address->country = 'IS';
                    $address->zipcode = $request->zip;
                    $address->email = $request->email;
                    $address->save();
                }
                foreach ($obj->images as $fileName) {
                    $data = Photo::create([
                        'photo' => 'places/' . $fileName->image,
                        'category_id' => $this->cat_detail->id,
                        'instance_id' => $result->id,
                        'main' => $fileName->main
                    ]);
//                if (file_exists(public_path() . '/uploads/gallery/' . $fileName->image)) {
//                    rename(public_path() . '/uploads/gallery/' . $fileName->image, public_path() . '/uploads/trash/' . $fileName->image);
//                }
                }
            }
        }
    }

        /**
     * Display the search view.
     *
     * @return load view 
     */
    public function searchPage()
    {
        return view("admin.search.index");
    }
        /**
     *
     * @return search data 
     */
    public function getSearch(Request $request)
    {   //dd('afsadfsd');
        
        $value = Input::get('term');
         // DB::enableQueryLog();
        $results = Places::join('addresses',function($join)
    {
        $join->on('places.id','=','addresses.instant_id');
        $join->on('places.category_id','=','addresses.category_id');
    })
        ->where('place_name','like',"%".$value."%")
        ->orwhere('addresses.address','like',"%".$value."%")->offset(0)->limit(10)->get()->toArray();
       
            // dd(DB::getQueryLog());
        $arr = [];
        foreach ($results as $key => $value) {
            $arr[] = ["value"=>$value['id'],"label"=>$value['place_name']];
        }
        
        return json_encode($arr);
    }
//////////////////////////////// API Call for Bokun Api////////////
//    public function api()
//    {
//        date_default_timezone_set('Asia/Karachi');
//        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cPOST/activity.json/search?currency=ISK&lang=EN";
//        $seceret = "656b1a3490c74789b025fead9a88c084";
//        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
//        $data = '{}';
//        $ch = curl_init('https://api.bokuntest.com/activity.json/search?currency=ISK&lang=EN');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'X-Bokun-Signature:' . $signature,
//                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
//                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
//                'Content-Type: application/json',
//                'Content-Length:' . strlen($data)
//            )
//        );
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $result = curl_exec($ch);
//        curl_getinfo($ch);
//        curl_close($ch);
//        $data = json_decode($result);
//        if (!empty($data->items)) {
//            foreach ($data->items as $obj) {
//                $exist_place = Places::where('external_id', $obj->id)->first();
//                if (!empty($exist_place)) {
//                    continue;
//                }
//                $model_obj = new Places();
//                $formData['activity_name'] = $obj->title;
//                if (isset($obj->price) && $obj->price != "") {
//                    $formData['price'] = $obj->price;
//                } else {
//                    $formData['price'] = 0;
//
//                }
//                $formData['excerpt'] = $obj->excerpt;
//                $formData['description'] = $obj->summary;
//                $formData['external_id'] = $obj->id;
//                $formData['category_id'] = $this->cat_detail->id;
//                $formData['slug'] = Functions::slug('', $obj->title, $model_obj);
//                $formData['created_by'] = @Auth::user()->user_id;
//                $formData['track_id'] = 'ACT-' . str_random(5);
//                $formData['source'] = 'bokun';
//                $result = Places::create($formData);
//                //////////////////add sub places here like in reykjavik have multipl famous coffee shops all goes here//////////
//                if (!empty($obj->places)) {
//                    //dd($obj->places);
//                    $address = new Address();
//                    foreach ($obj->places as $sub_places) {
//                        $formData['activity_name'] = $sub_places->title;
//                        $formData['excerpt'] = $obj->excerpt; //expert add from parent activity because its not avail at in this loop
//                        $formData['description'] = $obj->summary;//summery add from parent activity because its not avail at in this loop
//                        $formData['external_id'] = $sub_places->id;
//                        $formData['category_id'] = $this->cat_detail->id;
//                        $formData['slug'] = Functions::slug('', $sub_places->title, $model_obj);
//                        $formData['created_by'] = Auth::user()->user_id;
//                        $formData['track_id'] = 'PLC-' . rand();
//                        $sub_places_result = Places::create($formData);
//                        /////add complete address to place
////                    echo "<pre>";
////                    echo $sub_places->location->latitude;
////                    print_r($sub_places->location);
////                    exit;
//                        $formData1['instant_id'] = $sub_places_result->id;
//                        $formData1['category_id'] = $this->cat_detail->id;
//                        $formData1['latitude'] = $sub_places->location->latitude;
//                        $formData1['longitude'] = $sub_places->location->longitude;
//                        $formData1['address'] = $sub_places->location->address;
//                        $formData1['city'] = $sub_places->location->city;
//                        $formData1['country'] = $sub_places->location->countryCode;
//                        $address_result = Address::create($formData1);
//                    }
//
//                }
//                //////////////////////creating Keywords//////////////////
//                if (!empty($obj->keywords)) {
//                    foreach ($obj->keywords as $keyword) {
//                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
//                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id);
//                    }
//                } else {
//                    foreach ($obj->flags as $keyword) {
//                        $keyword_id = Functions::create_keyword($this->cat_detail->id, $keyword);
//                        $multi_keyword_id = Functions::create_multi_keyword($result->id, $keyword_id);
//                    }
//                }
//
//                //////////////////////////////creating images/////////////////////////////////
//                if (!empty($obj->photos)) {
//                    foreach ($obj->photos as $img) {
//                        $path = $_SERVER['DOCUMENT_ROOT'] . '/tripxonic/uploads/places' . $img->fileName;
//                        file_put_contents($path, file_get_contents($img->originalUrl));
//                        $data = Photo::create([
//                            'photo' => 'places' . $img->fileName,
//                            'category_id' => $this->cat_detail->id,
//                            'instance_id' => $result->id,
//                            'main' => 1
//                        ]);
//                    }
//                }
//            }
//            return redirect('admin/activities');
//        } else {
//            echo "Error to import data please check internet connection";
//        }
//    }


}

