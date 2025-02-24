<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Functions;
use App\Models\Address;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Photo;
use App\Models\Places;
use App\Models\Restaurants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Packages;
use App\Models\Category;
use App\Models\Setting;
use Auth;
use Session;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;

class SettingController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       /* $this->middleware(function ($request, $next) {
            if(empty(Auth::user()->can('setting-listing')))
            {
                return redirect('admin/dashboard');
            }
            return $next($request);
        });*/
    }
    public function index()
    {
        $result = Setting::find(1);
        // $country = Country::all();

        if(!empty($result))
        {
            $setting = $result;
        }
        else{
            $setting = (object) array('support_email'=>"",
                'sale_email'=>"",
                'contact_email'=>"",
                'contact_no'=>"",
                'address'=>"",
                'city'=>"",
                'state'=>"",
                'zipcode'=>"",
                'map_iframe'=>"",
                'google_analytic'=>"",
                'social_1'=>"",
                'social_2'=>"",);
        }

        return view('admin/setting/update_form',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

/////////////////////////////////////////  setting /////////////////////////////////////
    public function general_setting()
    {
        return view('admin/setting/update');
    }
    protected function validator($request, $rules)
    {
        return $validator = Validator::make($request, $rules);
        //return $validator->errors()->all();
    }
    public function update_setting(Request $request)
    {
  
        $validator = $this->validator($request->all(), [
            'support_email' => 'required',
            'sale_email' => 'required',
            'contact_no' => 'required|numeric',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            /*'zipcode' => 'required|numeric',*/
            /*'social_1' => 'required',
            'social_2' => 'required',*/

        ]);

        if ($validator->fails()) {
            return redirect('admin/setting')->withErrors($validator)->withInput();
        }
        $setting = Setting::find(1);
  
        if(isset($setting) && !empty($setting))
        {
            $setting->country_code = $request->country_code;
            $setting->support_email = $request->support_email;
            $setting->sale_email = $request->sale_email;
            // $setting->contact_email = $request->contact_email;
            $setting->contact_no = $request->contact_no;
            $setting->address = $request->address;
            $setting->state = $request->state;
            $setting->city = $request->city;
            $setting->zipcode = $request->zipcode;
            $setting->social_1 = $request->social_1;
            $setting->social_2 = $request->social_2;
            $setting->map_iframe = $request->map_iframe;
            $setting->google_analytic = $request->google_analytic;
            $setting->_token = $request->_token;
            $setting->created_by = Auth::user()->user_id;
            $setting->save();

            Session::flash('message', "Record has been updated successfully.");
            return redirect('admin/setting');
        }
        else{

            $setting = new Setting();
             $setting->country_code = $request->country_code;
            $setting->support_email = $request->support_email;
            $setting->sale_email = $request->sale_email;
            $setting->contact_no = $request->contact_no;
            // $setting->contact_email = $request->contact_email;
            $setting->address = $request->address;
            $setting->state = $request->state;
            $setting->city = $request->city;
            $setting->zipcode = $request->zipcode;
            $setting->social_1 = $request->social_1;
            $setting->social_2 = $request->social_2;
            $setting->map_iframe = $request->map_iframe;
            $setting->google_analytic = $request->google_analytic;
            $setting->_token = $request->_token;
            $setting->created_by = Auth::user()->user_id;
   
            $setting->save();
            Session::flash('message', "Record has been updated successfully.");
            return redirect('admin/setting');
        }
    }
    public function plan()
    {
        $packages = Packages::all()->sortBy('id');
        return view('admin/prising_plan/list_packages_plan', compact('packages'));
    }
//    search function
    public function search_places(){
        $url = 'https://api.foursquare.com/v2/venues/categories?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
        $str = file_get_contents($url);
        $data = json_decode($str);
        $result = $data->response->categories;
        return view('admin/search_places/form_search_places')->with('categories',$result);
    }
    public function search_listing(Request $request){
        $url = 'https://api.foursquare.com/v2/venues/categories?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
        $str = file_get_contents($url);
        $data = json_decode($str);
        $cat = $data->response->categories;
        ////////////////////////////////////////////
        $url = 'https://api.foursquare.com/v2/venues/search?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508&near='.$_GET['search_address'].'&categoryId='.$_GET['category_id'];
        $str = file_get_contents($url);
        $data = json_decode($str);

       /* foreach($data->response->venues as $obj)
        {
            $formData['place_name'] = $obj->name;
            $formData['track_id'] = 'PLC' . mt_rand() .$obj->location->cc;
            $formData['external_id'] = $obj->id;
            /////////////////// adding contact detail
            if(!empty($obj->contact))
            {
                $formData['social_1'] = 'https://www.facebook.com/'.@$obj->contact->facebook;
                $formData['social_2'] = 'https://twitter.com/'.@$obj->contact->twitter;
                $formData['social_3'] = 'https://www.instagram.com'.@$obj->contact->google;
                $formData['social_4'] = 'https://plus.google.com/'.@$obj->contact->instagram;
                $formData['phone']    = @$obj->contact->phone;

            }
            //////////////////////////////categories////////////////
            if(!empty($obj->categories))
            {
                $formData['category_name'] = $obj->categories[0]->name;

            }
            $result[$obj->id] = $formData;
            /////////////////// adding location detail
            if(!empty($obj->location))
            {
                $cordinates = Functions::addressToLT($obj->location->lat.','.$obj->location->lng);
                //$instant_id = $result->id;
                //$address['instant_id'] = $instant_id;
                //$address['category_id'] = $this->cat_detail->id;
                $address['latitude'] = $obj->location->lat;
                $address['longitude'] = $obj->location->lng;
                $address['address'] = @$cordinates['address'];
                $address['city'] =    @$cordinates['city'];
                // $address['state'] = $request->administrative_area_level_1;
                $address['country'] = $obj->location->cc;
                // $address['zipcode'] = $request->postal_code;
                $result[$obj->id]['address'] =$address;
               // Address::create($address);
            }
            ///////////////////////////adding images////////////////////////////
            if(!empty($obj->id))
            {
                $url = 'https://api.foursquare.com/v2/venues/'.$obj->id.'/photos?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
                $str = file_get_contents($url);
                $photos = json_decode($str);
                foreach ($photos->response->photos->items as $img)
                {
                    $path = $_SERVER['DOCUMENT_ROOT'].'/tripxonic/uploads/places'.$img->suffix;
                    //file_put_contents($path, file_get_contents($img->prefix.'original'.$img->suffix));
                    //$result[$obj->id]['photo_path'] =public_path().'/uploads/places'.$img->suffix;
                    $result[$obj->id]['photo_path'] =$img->prefix.'original'.$img->suffix;
                }
            }
        }*/



        if($data->response->venues) {
            foreach ($data->response->venues as $obj) {

                $formData['place_name'] = $obj->name;
                $formData['track_id'] = 'PLC' . mt_rand() . $obj->location->cc;
                $formData['external_id'] = $obj->id;
                /////////////////// adding contact detail
                if (!empty($obj->contact)) {
                    $formData['social_1'] = 'https://www.facebook.com/' . @$obj->contact->facebook;
                    $formData['social_2'] = 'https://twitter.com/' . @$obj->contact->twitter;
                    $formData['social_3'] = 'https://www.instagram.com' . @$obj->contact->google;
                    $formData['social_4'] = 'https://plus.google.com/' . @$obj->contact->instagram;
                    $formData['phone'] = @$obj->contact->phone;

                }
                //////////////////////////////categories////////////////
                if (!empty($obj->categories)) {
                    $formData['category_name'] = $obj->categories[0]->name;

                }
                $result[$obj->id] = $formData;
                /////////////////// adding location detail
                if (!empty($obj->location)) {
                    $cordinates = Functions::addressToLT($obj->location->lat . ',' . $obj->location->lng);
                    //$instant_id = $result->id;
                    //$address['instant_id'] = $instant_id;
                    //$address['category_id'] = $this->cat_detail->id;
                    $address['latitude'] = $obj->location->lat;
                    $address['longitude'] = $obj->location->lng;
                    $address['address'] = @$cordinates['address'];
                    $address['city'] = @$cordinates['city'];
                    // $address['state'] = $request->administrative_area_level_1;
                    $address['country'] = $obj->location->cc;
                    // $address['zipcode'] = $request->postal_code;
                    $result[$obj->id]['address'] = $address;
                    // Address::create($address);
                }
                ///////////////////////////adding images////////////////////////////
                if (!empty($obj->id)) {
                    $url = 'https://api.foursquare.com/v2/venues/' . $obj->id . '/photos?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
                    $str = file_get_contents($url);
                    $photos = json_decode($str);
                    foreach ($photos->response->photos->items as $img) {
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/tripxonic/uploads/places' . $img->suffix;
                        //file_put_contents($path, file_get_contents($img->prefix.'original'.$img->suffix));
                        //$result[$obj->id]['photo_path'] =public_path().'/uploads/places'.$img->suffix;
                        $result[$obj->id]['photo_path'] = $img->prefix . 'original' . $img->suffix;
                    }
                }
            }
          $total_record=  count($data->response->venues);
            Session::flash('message', "Record Found.");
        }else{
            Session::flash('error_message', "Record Not Found.");
            return redirect()->back();
        }
        $all_categories = Category::where('parent_id', 0)->get();
        return view('admin/search_places/listing_search_places',compact('all_categories','total_record'))->with('data',$result)->with('categories',$cat);
    }

    public  function save_forsquare_data(Request $request)
    {
        $url = 'https://api.foursquare.com/v2/venues/search?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508&near='.$request->search_address.'&categoryId='.$request->category_id.'';
        $str = file_get_contents($url);
        $data = json_decode($str);

        //dd($data->response->venues);
        if($data->response->venues) {
            $model_obj = new Places();
            $model_obj_res = new Restaurants();
            $model_obj_htl = new Hotel();
            if($request->category_code_id == 1 || $request->category_code_id == 2 || $request->category_code_id == 3 || $request->category_code_id == 4) {
                if (isset($data->response->venues) && !empty($data->response->venues) && $request->category_code_id == 2 || $request->category_code_id == 4) {


                    foreach ($data->response->venues as $obj) {

                        $check = Places::where('external_id', $obj->id)->first();
                        if (!empty($check)) {
                            continue;
                        }
                        $formData['category_id'] = $request->category_code_id;
                        $formData['place_name'] = $obj->name;
                        $formData['slug'] = Functions::slug('', $obj->name, $model_obj);
                        $formData['track_id'] = 'PLC' . mt_rand() . $obj->location->cc;
                        $formData['external_id'] = $obj->id;
                        /////////////////// adding contact detail
                        if (!empty($obj->contact->facebook)) {
                            $formData['social_1'] = 'https://www.facebook.com/' . @$obj->contact->facebook;
                        }
                        if (!empty($obj->contact->twitter)) {
                            $formData['social_2'] = 'https://twitter.com/' . @$obj->contact->twitter;
                        }
                        if (!empty($obj->contact->google)) {
                            $formData['social_3'] = 'https://www.instagram.com' . @$obj->contact->google;
                        }
                        if (!empty($obj->contact->instagram)) {
                            $formData['social_4'] = 'https://plus.google.com/' . @$obj->contact->instagram;
                        }
                        $formData['phone'] = @$obj->contact->phone;
                        $formData['source'] = 'Foursqure api';

                        $result = Places::create($formData);

                        /////////////////// adding location detail
                        if (!empty($obj->location)) {
                            $cordinates = Functions::addressToLT($obj->location->lat . ',' . $obj->location->lng);
                            $instant_id = $result->id;
                            $address['instant_id'] = $instant_id;
                            $address['category_id'] = $request->category_code_id;
                            $address['latitude'] = $obj->location->lat;
                            $address['longitude'] = $obj->location->lng;
                            $address['address'] = @$cordinates['address'];
                            $address['city'] = @$cordinates['city'];
                            // $address['state'] = $request->administrative_area_level_1;
                            $address['country'] = $obj->location->cc;
                            // $address['zipcode'] = $request->postal_code;
                            Address::create($address);

                        }
                        ///////////////////////////adding images////////////////////////////
                        if (!empty($obj->id)) {
                            $url = 'https://api.foursquare.com/v2/venues/'. $obj->id .'/photos?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
                            $str = file_get_contents($url);
                            $photos = json_decode($str);
                            foreach ($photos->response->photos->items as $img) {
                                $path = $_SERVER['DOCUMENT_ROOT'] . '/dev/uploads/places'.$img->suffix;

                                file_put_contents($path, file_get_contents($img->prefix .'original'. $img->suffix));
                                $data = Photo::create([
                                    'photo' => 'places' . $img->suffix,
                                    'category_id' => $request->category_code_id,
                                    'instance_id' => $result->id,
                                    'main' => 0
                                ]);

                            }
                            ///////adding sub cat////////////////
                            foreach ($request->subcategory as $subObj) {
                                Functions::create_multi_subcat($result->id, $subObj, $request->category_code_id);
                            }

                        }

                    }
                }
                if (isset($data->response->venues) && !empty($data->response->venues) && $request->category_code_id == 1) {
                    foreach ($data->response->venues as $obj) {
                        $check = Restaurants::where('external_id', $obj->id)->first();
                        if (!empty($check)) {
                            continue;
                        }
                        $formData['category_id'] = $request->category_code_id;
                        $formData['restaurant_name'] = $obj->name;

                        $formData['slug'] = Functions::slug('', $obj->name, $model_obj_res);

                        $formData['track_id'] = 'RST' . mt_rand() . $obj->location->cc;
                        $formData['external_id'] = $obj->id;
                        /////////////////// adding contact detail
                        if (!empty($obj->contact)) {
                            $formData['social_1'] = 'https://www.facebook.com/' . @$obj->contact->facebook;
                            $formData['social_2'] = 'https://twitter.com/' . @$obj->contact->twitter;
                            $formData['social_3'] = 'https://www.instagram.com' . @$obj->contact->google;
                            $formData['social_4'] = 'https://plus.google.com/' . @$obj->contact->instagram;
                            $formData['phone'] = @$obj->contact->phone;
                        }
                        $result = Restaurants::create($formData);
                        /////////////////// adding location detail
                        if (!empty($obj->location)) {
                            $cordinates = Functions::addressToLT($obj->location->lat . ',' . $obj->location->lng);
                            $instant_id = $result->id;
                            $address['instant_id'] = $instant_id;
                            $address['category_id'] = $request->category_code_id;
                            $address['latitude'] = $obj->location->lat;
                            $address['longitude'] = $obj->location->lng;
                            $address['address'] = @$cordinates['address'];
                            $address['city'] = @$cordinates['city'];
                            // $address['state'] = $request->administrative_area_level_1;
                            $address['country'] = $obj->location->cc;
                            // $address['zipcode'] = $request->postal_code;
                            Address::create($address);

                        }
                        ///////////////////////////adding images////////////////////////////
                        if (!empty($obj->id)) {
                            $url = 'https://api.foursquare.com/v2/venues/' . $obj->id . '/photos?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
                            $str = file_get_contents($url);
                            $photos = json_decode($str);
                            foreach ($photos->response->photos->items as $img) {
                                $path = $_SERVER['DOCUMENT_ROOT'] . '/dev/uploads/restaurant_pic' . $img->suffix;
                                file_put_contents($path, file_get_contents($img->prefix . 'original' . $img->suffix));
                                $data = Photo::create([
                                    'photo' => 'restaurant_pic' . $img->suffix,
                                    'category_id' => $request->category_code_id,
                                    'instance_id' => $result->id,
                                    'main' => 0
                                ]);
                            }
                            ///////adding sub cat////////////////
                            if($request->subcategory) {
                                foreach ($request->subcategory as $subObj) {
                                    Functions::create_multi_subcat($result->id, $subObj, $request->category_code_id);
                                }
                            }
                        }
                    }
                }
                if (isset($data->response->venues) && !empty($data->response->venues) && $request->category_code_id == 3) {
                    foreach ($data->response->venues as $obj) {
                        $check = Hotel::where('external_id', $obj->id)->first();
                        if (!empty($check)) {
                            continue;
                        }
                        $formData['category_id'] = $request->category_code_id;
                        $formData['hotel_name'] = $obj->name;
                        $formData['slug'] = Functions::slug('', $obj->name, $model_obj_htl);
                        $formData['track_id'] = 'HTL' . mt_rand() . $obj->location->cc;
                        $formData['external_id'] = $obj->id;
                        /////////////////// adding contact detail
                        if (!empty($obj->contact)) {
                            $formData['social_1'] = 'https://www.facebook.com/' . @$obj->contact->facebook;
                            $formData['social_2'] = 'https://twitter.com/' . @$obj->contact->twitter;
                            $formData['social_3'] = 'https://www.instagram.com' . @$obj->contact->google;
                            $formData['social_4'] = 'https://plus.google.com/' . @$obj->contact->instagram;
                            $formData['phone'] = @$obj->contact->phone;
                            if (!empty($obj->location)) {
                                $cordinates = Functions::addressToLT($obj->location->lat . ',' . $obj->location->lng);
                                $formData['latitude'] = $obj->location->lat;
                                $formData['longitude'] = $obj->location->lng;
                                $formData['address'] = @$cordinates['address'];
                                $formData['city'] = @$cordinates['city'];
                                // $address['state'] = $request->administrative_area_level_1;
                                $formData['country'] = $obj->location->cc;
                                // $address['zipcode'] = $request->postal_code;

                            }
                        }
                        $result = Hotel::create($formData);
                        /////////////////// adding location detail
                        if (!empty($obj->location)) {
                            $cordinates = Functions::addressToLT($obj->location->lat . ',' . $obj->location->lng);
                            $instant_id = $result->id;
                            $address['instant_id'] = $instant_id;
                            $address['category_id'] = $request->category_code_id;
                            $address['latitude'] = $obj->location->lat;
                            $address['longitude'] = $obj->location->lng;
                            $address['address'] = @$cordinates['address'];
                            $address['city'] = @$cordinates['city'];
                            // $address['state'] = $request->administrative_area_level_1;
                            $address['country'] = $obj->location->cc;
                            // $address['zipcode'] = $request->postal_code;
                            Address::create($address);

                        }
                        ///////////////////////////adding images////////////////////////////
                        if (!empty($obj->id)) {
                            $url = 'https://api.foursquare.com/v2/venues/' . $obj->id . '/photos?oauth_token=CISBN4VCKW0B4APVYOVMAAZA4JORJ1FNXZNJJQGT550EF00V&v=20170508';
                            $str = file_get_contents($url);
                            $photos = json_decode($str);

                            foreach ($photos->response->photos->items as $img) {
                                $path = $_SERVER['DOCUMENT_ROOT'] . '/dev/uploads/hotel_pic' . $img->suffix;
                                file_put_contents($path, file_get_contents($img->prefix . 'original' . $img->suffix));
                                $data = Photo::create([
                                    'photo' => 'hotel_pic' . $img->suffix,
                                    'category_id' => $request->category_code_id,
                                    'instance_id' => $result->id,
                                    'main' => 0
                                ]);
                            }
                            ///////adding sub cat////////////////
                            foreach ($request->subcategory as $subObj) {
                                Functions::create_multi_subcat($result->id, $subObj, $request->category_code_id);
                            }

                        }

                    }

                }
                Session::flash('message', "Records has been added successfully;");
                return redirect('admin/search-places');
            }else{
                    Session::flash('error_message', "There is a category error ;");
                    return redirect()->back();
            }

        }else{
            Session::flash('error_message', "Record Not Found");
            return redirect()->back();
        }
    }
    public function search_subcategory(Request $request){
       /* $categories = Category::whereRaw('parent_id != 0')->get();*/
        $term = $request->term;
        $data = Category::where('cat_name', 'LIKE', '%' . $term . '%')->where('parent_id','!=','0')
            ->get();
        if (sizeof($data) > 0) {
            foreach ($data as $place) {
                $row_set[] = $place['cat_name']; //build an array
            }
        }
        if (sizeof($row_set) > 0) {
            echo json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            echo json_encode($row_set);
        }

    }
}
