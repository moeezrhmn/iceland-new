<?php

namespace App\Http\Controllers\Admin;

use App\Models\Places;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;
use App\Models\Address;
use App\Models\multiSubcategories;
use App\Models\PlacesLogs;
use App\Models\Photo;
use App\Models\Keyword;
use App\Models\Flights;
use App\Models\multiKeywords;
use App\Classes\Functions;
use PDF;
use Session;
use URL;
use Excel;


class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function __construct()
    {
        $this->middleware('auth');
        $this->cat_detail = Category::select('id','cat_name')->where('id', '=', 1)->first();
        /// $this->act_cat_detail = Category::where('code', '=', 'ACT')->first();
       
    }
    public function index()
    {
        $perPage = 20;

        //dd($_GET['subcat_id']);
        if(isset($_GET['subcat_id']))
            $subcat_id= $_GET['subcat_id'];
        else
            $subcat_id=0;
        $items = Places::where('category_id','1')
            ->with('subCategories_edit')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo','category_id');
                    $querys->Where('category_id', '=', $this->cat_detail->id);
                }])
            ->take($perPage)->orderBy('place_name', 'asc')->get();
        $subcategory = Category::select('id', 'cat_name', 'parent_id')->where('parent_id', $this->cat_detail->id)->orderBy('cat_name', 'ASC')->get();

        $total = Places::count();
        $currentRoute = 'admin::users';

        $viewData = [
            'items' => $items,
            'total' => $total,
          'subcategory_id' => $subcat_id,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'category_id'=> $this->cat_detail->id,
            'modelInstance' => '\App\Models\Places',
        ];
        return view("admin.places.datatables", $viewData,compact('subcategory'));
    }
    public  function addressfromGeocode($latitude,$longitude)
    {

        if (!empty($latitude)) {
            $result = array();

            $str = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true/false';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $str);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response);
//dump($data->results[0]);
            if (isset($data->results[0]->address_components)) {
                //dump($data->results[0]->address_components[3]);

                foreach ($data->results[0]->address_components as $cityobj) {
                    // $result['city']=$cityobj;
                    if ($cityobj->types[0] == 'locality') {
                        $result['city'] = $cityobj->long_name;
                    }
                    if ($cityobj->types[0] == 'country') {
                        $result['country'] = $cityobj->short_name;
                    }
                }
            }

            if (isset($data->results[0]->geometry->location)) {
                $result['lat'] = $data->results[0]->geometry->location->lat;
                $result['lng'] = $data->results[0]->geometry->location->lng;
                $result['address'] = $data->results[0]->formatted_address;
                //dd($result);
                return $result;
            } else {
                return false;
            }
            unset($address);
        } else {
            return false;
        }

    }


    public function arguments()
    {
        $args = $_REQUEST;

        return array_merge([
            'pagination' => CustomHelper::get_pagination(),
            'per_page' => 20,
            'search' => '',
            'orderBy' => 'id',
            'order' => 'asc',
        ], $args, [

        ]);
    }

    public function places_listing()
    {
        // $items = Places::where('category_id','1') ->with('subCategories_edit')->get();
        //DB::enableQueryLog();
        $items = Places::select('places.id', 'place_name', 'stars', 'places.status','places.order_no', 'places.created_at')
        ->orderBy('updated_at','DESC')
            ->with('subCategories_edit')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo','category_id','instance_id');
                      $querys->Where('category_id', '=', $this->cat_detail->id);
                        $querys->Where('main', '=', 1);
                }])
            ->with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }]);
        
       
        if (request()->get('subcategory_id')) {
            $items->whereHas(
                'subCategories_edit', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (request()->get('subcategory_id')) {
                    $query->Where("subcategory_id", "=", request()->get('subcategory_id'));
                }
            });
        }

        $items=$items->get();

        //dd(DB::getQueryLog());
        $currentRoute = str_replace('places.', '', \Request::route()->getName());
//        $search="";
//        if(Input::get('subcategory_id'))
//        $search= Input::get('subcategory_id');

        return $data= DataTables::of($items)
//            ->filter(function ($query) use ($search) {
//                if (isset($search) && ($search != '')) {
//
//                    $query->where('categories.id', '=', $search);
//                }
//            })
            ->addColumn('actions', function ($items) use ($currentRoute) {
                $edit=' <a href="' . url("admin/places/".$items->id.'/edit').'" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i>
                        </a>';

 $cond = '<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Active"
                title = "Inactive" class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill status-update">
               
                <i class="fa fa-times" ></i>
               
                </a>';
                if($items->status=="Active") {
                    $cond='<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Inactive"
                title="Active" class="m-portlet__nav-link btn m-btn btn-accent m-btn--icon m-btn--icon-only m-btn--pill status-update" >
                
                <i class="fa fa-check" >
                </i>
                
                </a>';
                }
            return '<div id="status_div_'.$items->id.'" class="status_div">'.$edit .$cond.
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
                if ($items->single_photo !='') {
                    for ($i=0; $i<1; $i++) {
                    //return '<img src="'.url('uploads/'.$items->single_photo[$i]->photo).'">';
                        if(isset($items->single_photo->photo) && !empty($items->single_photo->photo))
                        return url('uploads/'.$items->single_photo->photo);
                        else
                            return url('images/no-image.png');
                    }

                }else
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

                })
            ->editColumn('created_at', function ($items) {
                return $items->created_at->format('d-m-Y');
            })
            ->editColumn('id', function ($items) {
                return '<span>
                        <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                            <input name="id[]"  class="bulk-opration" type="checkbox" value="' . $items->id . '">
                            <span></span>
                        </label>
                    </span>';
            })->rawColumns(['status', 'actions', 'id','edit'])->make(true);
        //return redirect()->back();

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id','=', $this->cat_detail->id)->get();
    
        $keywords = Keyword::where('category_id','=', $this->cat_detail->id)->get();
             $region = DB::table('region')->get();
   
        if (sizeof($categories)) {
            return view('admin/places/_form', compact('categories','keywords','region'));
        } else {
            return redirect('admin/places');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'place_name' => 'required',
            'category_id' => 'required',
            'order_no' => 'required',
            'search_address' => 'required',
        ]);

        // if ($validator->fails()) {
        //     return redirect('admin/places/create')->withErrors($validator)->withInput();
        // }

        ///////////////////////creating place//////////////////////
        $category_act = Category::where('id', $request->category_id)->first();
        $model_obj = new Places();
        $formData = $request->all();
        $formData['slug'] = Functions::slug($request->slug, $request->place_name, $model_obj);
         $formData['created_by'] = Auth::id();
          $formData['status'] = 'Active';
         $formData['track_id'] = '4' . mt_rand() . $request->country_short;

           $result = Places::create($formData);
       
        $address = new Address();
        $instant_id = $result->id;
        $address->instant_id = $instant_id;
        $address->category_id = $request->category_id;
        $address->latitude = $request->lat;
        $address->longitude = $request->lng;
        $address->address = $request->formatted_address;
        $address->city = $request->locality;
         $address->region = $request->region;
        $address->state = $request->administrative_area_level_1;
        $address->country = $request->country_short;
        $address->zipcode = $request->postal_code;
        $address->save();
        //////////////////////creating subcategory//////////////////
    
        if (isset($request->subcategory) && !empty($request->subcategory)) {
   
            foreach ($request->subcategory as $subcatlist) {
                $data = multiSubcategories::create([
                    'instance_id' => $result->id,
                    'category_id' => $result->category_id,
                    'subcategory_id' => $subcatlist,
                    'created_by' => $formData['created_by']
                ]);
            }
        }
        //////////////////////creating Keywords//////////////////
        if (isset($request->keywords) && !empty($request->keywords)) {
            foreach ($request->keywords as $keyword) {
                $data = multiKeywords::create([
                    'instance_id' => $result->id,
                    'category_id' => $result->category_id,
                    'keyword_id' => $keyword,
                    'created_by' => $formData['created_by']
                ]);
            }
        }
        ///////////////////////creating image///////////////////////
        if ($result && $request->file) {

            foreach ($request->file as $fileName) {
               $filename = $fileName->getClientOriginalName();
                if ($request->main_image == $filename) {
                    $main_image = 1;
                } else {
                    $main_image = 0;
                }
                
            $destinationPath = 'uploads/places/';
            $filename = $fileName->getClientOriginalName();
            $fileName->move($destinationPath, $filename);
         //  $content->photo = $filename;

                // $img = Functions::make_thumb($path);
                $data = Photo::create([
                    'photo' => 'places/'.$filename,
                    'category_id' => $request->category_id,
                    'instance_id' => $result->id,
                    'main' => $main_image
                ]);
            }
           custom_flash("Record has been added successfully.", "success");
            return redirect('admin/places');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo $id;
        exit;
        $args['record'] = User::find($id);

        return view("admin.places._single", $args);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $user = Places::with('address')->with('subCategories_edit')->with('keywords')->find($id);
   
$edit_place = Places::where('id', $id)->with(['subCategories_edit' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
        }])
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])
            ->with('keywords')->first();
              $region = DB::table('region')->get();
 
       // dd($edit_place);
        if ($edit_place) {
            $keywords = Keyword::where('category_id', $edit_place->category_id)->get();
            $subcategory = Category::where('parent_id', $edit_place->category_id)->get();
            $categories = Category::where('parent_id', 0)->orwhere('id', '1')->get();
           // dd($edit_place->category_id);

            return view('admin/places/_form_edit', compact('edit_place', 'keywords', 'subcategory', 'categories','region'));
        } else {
            return redirect('admin/places')->withErrors('Record not found');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         Functions::validator($request->all(), [
            'place_name' => 'required',
            'category_id' => 'required',
//            'track_id' => 'required|unique:places,track_id,' . $id,
            //'ssn' => 'required|unique:places,ssn,' . $id,
            /* 'order_no' => 'required', */
//            'description' => 'required',
        ])->validate();
        $result = Places::find($id);
        if ($result) {
            $formData = $request->all();
            $formData['slug'] = Functions::slug($request->slug, $request->place_name, $result, $id);
            $formData['created_by'] = Auth::id();
            if(isset($request->is_featured))
            {
            }else
                $formData['is_featured']=0;

            $result->update($formData);
            ///////////////////////// Addresses //////////////////////////
            $data = array(
                'instant_id' => $result->id,
                'category_id' => $request->category_id,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
                'address' => $request->formatted_address,
                'city' => $request->locality,
                'region' =>  $request->region,
                'state' => $request->administrative_area_level_1,
                'country' => $request->country_short,
                'email' => $request->email,
                'zipcode' => $request->postal_code,
            );
            $data_address = Address::where('instant_id', $id)->where('category_id', $this->cat_detail->id)->first();
//            print_r($data_address);
//            exit;
            if (!empty($data_address)) {
                $data_address->update($data);
            } else {
                $address = Address::create($data);
            }
//             dd(DB::getQueryLog());
//dd($data_address);
            //////////////////////creating subcategory//////////////////
            $data = multiSubcategories::where('instance_id', $id)->where('category_id', $this->cat_detail->id)->delete();

            if (!empty($request->subcategory) && isset($request->subcategory)) {
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
             multiKeywords::where('instance_id', $id)->where('category_id', $request->category_id)->delete();
            if (!empty($request->keywords) && isset($request->keywords)) {
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
            if ($result && $request->file) {
                foreach ($request->file as $fileName) {

                    Photo::where('instance_id', $id)->where('category_id', $this->cat_detail->id)->update(['main' => 0]);
                    Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
                    // $filename = $fileName->getClientOriginalName();
                      $filename = time().'.'.$fileName->getClientOriginalExtension();

                    if ($request->main_image == $filename) {
                        $main_image = 1;
                    } else {
                        $main_image = 0;
                    }
                   /* $path = $fileName->storeAs(
                        'uploads/places', rand(0, 100) . '_' . $filename
                    );*/
            $destinationPath = 'uploads/places/';
            $filename = $fileName->getClientOriginalName();
            $fileName->move($destinationPath, $filename);
            // $path= move('uploads/places', $filename);
   
                    // $img = Functions::make_thumb($path);
                    $data = Photo::create([
                        'photo' =>'places/'.$filename,
                        'category_id' => $request->category_id,
                        'instance_id' => $id,
                        'main' => $main_image
                    ]);
                }
            }
            Photo::where('instance_id', $id)->update(['main' => 0]);
            Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
            Session::flash('message', "Record has been updated successfully.");
            return redirect('admin/places');
        } else {
            return redirect('admin/places'.$id.'/edit')->withErrors('There is a error in updating record.');
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Places::destroy($id);
        custom_flash("Record has been deleted successfully.", "success");

        return redirect(getPageUrl('admin::places.index'));
    }
 public function remove_image(Request $request)
    {
        
        echo $result = Functions::image_remove($request->id);
    }


     public function import_excel()
    {
        return view('admin.places.import_places');
    }


    /*
        public function import_places()
        {
            $path = $_FILES['file']['tmp_name'];
            //$file_path = storage_path('exports') . '/Places-Listing.xls';
            Excel::load($path, function ($reader) {
                $results = $reader->toArray();

               // dd($results);
                foreach ($results as $sheet) {
                    if (isset($sheet['place_name']) && $sheet['place_name'] != '') {
                        $sheet['category_id']=1;
                        $check = Places::where('place_name', '=', trim($sheet['place_name']))
                            ->first();
                        if (sizeof($check)) {
                            PlacesLogs::create([
                                //'track_id' => @$sheet['track_id'],
                                'ssn' => @$sheet['ssc'],
                                'title' => @$sheet['place_name']
                            ]);
                            continue;
                        }
                        //dd($sheet['address']);

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
                        $formData['slug'] = Functions::slug($sheet['slug'], $sheet['place_name'], $model_obj);
                        $formData['category_id'] = $sheet['category_id'];
                          $formData['ssn'] = $sheet['ssc'];
                        $formData['track_id'] = 'PLC' . mt_rand();
                        $formData['source'] = @$sheet['source'];
                        if (strpos($formData['website_url'], 'http') !== false) {
                            $formData['website_url'] = $formData['website_url'];
                        } else {
                            $formData['website_url'] = 'http://' . $sheet['website_url'];
                        }

                        //dd(Auth::user()->id);
                        $formData['created_by'] = Auth::user()->id;
                        $result = Places::create($formData);
                        //dd($result);
                        /////////////////////add address//////////////////
                        $address = new Address();
                        $address->instant_id = $result->id;
                        $address->category_id = 1;
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
                        for ($i = 1; $i <= 10; $i++) {
                            if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {
                                Functions::create_multi_images($result->id, $sheet['image' . $i],
                                    $sheet['category_id'], 'places', $sheet['order_no'], isset($sheet['image_order']));
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

        public function update_excel()
        {
            $path = $_FILES['file']['tmp_name'];
            //$file_path = storage_path('exports') . '/Places-Listing.xls';
            Excel::load($path, function ($reader) {
                $results = $reader->toArray();
                $model_obj = new Places();
                foreach ($results as $sheet) {
                    if (isset($sheet['track_id']) && $sheet['track_id'] != '') {
                        $result = Places::where('track_id', '=', trim($sheet['track_id']))
                            ->first();
                        if ($result) {
                            $formData = $sheet;
                            $formData['slug'] = Functions::slug($sheet['slug'], $sheet['place_name'], $model_obj);
                            // $formData['slug'] = Functions::slug($sheet['slug'], $sheet['place_name'], $result, $id);
                            // $formData['created_by'] = Auth::user()->id;
                            if (strchr($formData['website_url'], 'http') !== false) {
                                $formData['website_url'] = $formData['website_url'];
                            } else {
                                $formData['website_url'] = 'http://' . $sheet['website_url'];
                            }
                            $result->update($formData);
                            ///////////////////////// Addresses //////////////////////////
                            $data = array(
                                'instant_id' => $result->id,
                                'category_id' => $formData['category_id'],
                                'latitude' => $formData['latitude'],
                                'longitude' => $formData['longitude'],
                                'address' => $formData['address'],
                                'city' => $formData['city'],
                                'state' => $formData['state'],
                                'email' => $formData['email'],
                                'country' => $formData['country'],
                                'zipcode' => $formData['zipcode'],
                            );
                            $data_address = Address::where('instant_id', $result->id)->first();
                            if (!empty($data_address)) {
                                $data_address->update($data);
                            } else {
                                Address::create($data);
                            }
                            /////////////////////update keywords//////////////////
                            if (isset($sheet['keywords']) && !empty(trim($sheet['keywords']))) {
                                ///delete all existing subcategories
                                multiKeywords::where('instance_id', '=', $result->id)->delete();
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
                                ///delete all existing subcategories
                                multiSubcategories::where('instance_id', '=', $result->id)->delete();
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
                            ///delete all existing images
                            Photo::where('instance_id', '=', $result->id)->delete();
                            for ($i = 1; $i <= 5; $i++) {
                                if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {

                                    Functions::create_multi_images($result->id, $sheet['image' . $i], $sheet['category_id'], 'places', $sheet['order_no'], isset($sheet['image_order']));
                                }
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


        // /////////////////////////////////////// excel ////////////////////////////////////

        public function excel(Request $request)
        {


            $places = Places::with([
                'address' => function ($qury) {
                    $qury->select('address_id', 'latitude', 'longitude', 'address', 'city', 'country', 'instant_id');
                    $qury->Where('category_id', '=', $this->cat_detail->id);
                }])
                ->with([
                        'subCategories_edit' => function ($query) {
                            //$qury->select('address_id','address','city','country','instant_id');
                            $query->Where('category_id', '=', $this->cat_detail->id);
                        }]
                )->with([
                        'keywords' => function ($query) {
                            //$qury->select('address_id','address','city','country','instant_id');
                            $query->Where('multi_keywords.category_id', '=', $this->cat_detail->id);
                        }]
                )
                ->with(['photo' => function ($query) {
                    $query->where('category_id', '=', $this->cat_detail->id);
                }])->latest('id');

            $places->Where('category_id', '=', $this->cat_detail->id);

            ///////////////////////////////filter apply by places listing page//////////////////////
            if (session('country_base')) {
                $places->whereHas(
                    'address', function ($query) {
                    $query->Where('category_id', '=', $this->cat_detail->id);
                    if (session('country_base')) {
                        $query->Where("country", "=", session('country_base'));
                    }
                    if (session('city_base')) {
                        $query->Where("city", "=", session('city_base'));


             return  $places = $places->get();

        }*/
    public function store_restaurants()
    {
        $path = $_FILES['file']['tmp_name'];
        //$file_path = storage_path('exports') . '/Places-Listing.xls';
        Excel::load($path, function ($reader) {
            $results = $reader->toArray();
            foreach ($results as $sheet) {
                if (isset($sheet['place_name']) && $sheet['place_name'] != '') {
                    $check = Places::where('place_name', '=', trim($sheet['place_name']))
                        ->first();

                    if (!empty($check)) {
                        PlacesLogs::create([
                            'track_id' => @$sheet['ssn'],
                            'ssn' => @$sheet['ssn'],
                            'title' => @$sheet['place_name']
                        ]);
                        continue;
                    }

                    //dd($sheet['address']);
                    /////////////////////add address//////////////////
                    if (isset($sheet['address']) && trim($sheet['address']) != "") {

                        // $cordinates = Functions::getAddressfromGeocode($sheet['latitude'], $sheet['longitude']);
                        $cordinates = Functions::addressToLT($sheet['address'] . ',' . @$sheet['country']);
                    }else
                    {
                        //$cordinates = Functions::addressToLT($sheet['address'] . ',' . @$sheet['country']);
                        $cordinates = $this->addressfromGeocode($sheet['latitude'], $sheet['longitude']);
                    }
                    // dd($cordinates);

                    if (empty(trim($sheet['latitude'])) && empty(trim($sheet['longitude']))) {
                        $sheet['latitude'] = $cordinates['lat'];
                        $sheet['longitude'] = $cordinates['lng'];
                    }
                    if (isset($sheet['city']) && empty(trim($sheet['city']) )) {
                        $sheet['city'] = @$cordinates['city'];
                    }
                    $sheet['country'] = @$cordinates['country'];
                    $sheet['address'] = $cordinates['address'];
                    //   }

                    //dd($sheet);

                    $model_obj = new Places();
                    $sheet['slug'] = '';
                    $formData = $sheet;
                    $formData['slug'] = Functions::slug($sheet['slug'], $sheet['place_name'], $model_obj);
                    $formData['category_id'] = $sheet['category_id'];
                    $formData['track_id'] = 'PLC' . mt_rand();
                    // $formData['source'] = @$sheet['source'];
                    $formData['source'] = 'idis';

                    if (strpos($formData['website_url'], 'http') !== false) {
                        $formData['website_url'] = $formData['website_url'];
                    } else {
                        $formData['website_url'] = 'http://' . $sheet['website_url'];
                    }
                    $formData['created_by'] = Auth::user()->id;
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
                    if (isset($sheet['subcategories']) && !empty(trim($sheet['subcategories']))) {
                        $key_explode = explode(',', trim($sheet['subcategories'])); //explode subcategori form sheet
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

                            //$subcatObj = Category::where('code', 'like', trim($cat_name))->
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
                    for ($i = 1; $i <= 10; $i++) {
                        if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {
                            Functions::create_multi_images($result->id, $sheet['image' . $i], $sheet['category_id'], 'places',
                                $sheet['order_no'], isset($sheet['image_order']));
                        }
                    }
                }else {
                    Session::flash('message', "SSN number not exist in your file.");
                    //return redirect('admin/places');

                }
            }

        });



//        if (Input::get('subcat_id')) {
//            $places->whereHas(
//                'subCategories_edit', function ($query) {
//                $query->Where('category_id', '=', $this->cat_detail->id);
//                if (Input::get('subcat_id')) {
//                    $query->Where("subcategory_id", "=", Input::get('subcat_id'));
//                }
//            }
//            );
//        }
//        if (Input::get('action_type')) {
//            $places->Where("places.status", "=", Input::get('action_type'));
//        }
        ///  DB::enableQueryLog();
        // $places = $places->get();
        // dd(DB::getQueryLog());
        //dd($places);


//        if (sizeof($places)) {
//            $j = 0;
//            foreach ($places as $obj) {
//                //  dd($obj->photo);
//                if (sizeof($obj->subCategories_edit)) {
//                    $data1 = array();
//                    foreach ($obj->subCategories_edit as $cat_name) {
//                        $data1[] = $cat_name->cat_name;
//                    }
//                    $subcategories = implode(',', $data1);
//                }
//                if (sizeof($obj->keywords)) {
//                    $data2 = array();
//                    foreach ($obj->keywords as $key_obj) {
//                        $data2[] = $key_obj->keyword_name;
//                    }
//                    $keywords = implode(',', $data2);
//                }
//                $data3 = array();
//                if (sizeof($obj->photo)) {
//                    $i = 1;
//                    foreach ($obj->photo as $photo_obj) {
//                        $data3['image' . $i] = $photo_obj->photo;
//                        $i++;
//                    }
//                    // $images = implode(',', $data);
//                }
//                $data[] = array(
//                    'track_id' => $obj->track_id,
//                    'SSN' => $obj->ssn,
//                    'category_id' => $obj->category_id,
//                    'place_name' => $obj->place_name,
//                    'slug' => $obj->slug,
//                    'order_no' => $obj->order_no,
//                    'stars' => $obj->stars,
//                    'phone' => $obj->phone,
//                    'is_featured' => $obj->is_featured,
//                    'website_url' => $obj->website_url,
//                    'social_1' => $obj->social_1,
//                    'social_2' => $obj->social_2,
//                    'social_3' => $obj->social_3,
//                    'social_4' => $obj->social_4,
//                    'latitude' => @$obj->address[0]->latitude,
//                    'longitude' => @$obj->address[0]->longitude,
//                    'address' => @$obj->address[0]->address,
//                    'city' => @$obj->address[0]->city,
//                    'state' => @$obj->address[0]->state,
//                    'country' => @$obj->address[0]->country,
//                    'zipcode' => @$obj->address[0]->zipcode,
//                    'email' => @$obj->address[0]->email,
//                    'subcategories' => @$subcategories,
//                    'keywords' => @$keywords,
//                    //'images' => @$images,
//                    'excerpt' => $obj->excerpt,
//                    'description' => $obj->description,
//                );
//                $keywords = '';
//                $subcategories = "";
//                $images = "";
//                $data_test[] = array_merge($data[$j], $data3);
//                $j++;
//            }
//
//
//            Excel::create('Places Listing', function ($excel) use ($data_test) {
//                // Set the title
//                $excel->setTitle('excelsheet for listing places');
//                // Chain the setters
//                $excel->setCreator('VisitAnyCity')
//                    ->setCompany('digicom-solutions.com');
//                $excel->sheet('Places Detail', function ($sheet) use ($data_test) {
//                    $sheet->fromArray($data_test);
//                });
//            })->export('xls');
//        } else {
//            return redirect('admin/places');
//        }
    }

    public function store_excel()
    {
        $path = $_FILES['file']['tmp_name'];
        //$file_path = storage_path('exports') . '/Places-Listing.xls';

        Excel::load($path, function ($reader) {
            $results = $reader->toArray();
            $j=0;
            foreach ($results as $sheet) {
                if (isset($sheet['place_name']) && $sheet['place_name'] != '') {
                    $check = Places::where('place_name', '=', trim($sheet['place_name']))
                        ->first();

//                    if (!empty($check)) {
//                        PlacesLogs::create([
//                            'track_id' => @$sheet['ssn'],
//                            'ssn' => @$sheet['ssn'],
//                            'title' => @$sheet['place_name']
//                        ]);
//                        continue;
//                    }
echo $j."</br>";
                    $j++;
                    //dd($sheet['address']);
                    /////////////////////add address//////////////////
                    if (isset($sheet['address']) && trim($sheet['address']) != "") {

                        // $cordinates = Functions::getAddressfromGeocode($sheet['latitude'], $sheet['longitude']);
                        $cordinates = Functions::addressToLT($sheet['address'] . ',' . @$sheet['country']);
                    }else
                    {
                        //$cordinates = Functions::addressToLT($sheet['address'] . ',' . @$sheet['country']);
                        $cordinates = $this->addressfromGeocode($sheet['latitude'], $sheet['longitude']);
                    }
                    // dd($cordinates);

                    if (empty(trim($sheet['latitude'])) && empty(trim($sheet['longitude']))) {
                        $sheet['latitude'] = $cordinates['lat'];
                        $sheet['longitude'] = $cordinates['lng'];
                    }
                    if (isset($sheet['city']) && empty(trim($sheet['city']) )) {
                        $sheet['city'] = @$cordinates['city'];
                    }
                    $sheet['country'] = @$cordinates['country'];
                    $sheet['address'] = $cordinates['address'];
                    //   }

                    //dd($sheet);

                    $model_obj = new Places();
                    $sheet['slug'] = '';
                    $formData = $sheet;
                    $formData['slug'] = Functions::slug($sheet['slug'], $sheet['place_name'], $model_obj);
                    $formData['category_id'] = $sheet['category_id'];
                    $formData['track_id'] = 'PLC' . mt_rand();
                    // $formData['source'] = @$sheet['source'];
                    $formData['source'] = 'idis';

                    if (strpos($formData['website_url'], 'http') !== false) {
                        $formData['website_url'] = $formData['website_url'];
                    } else {
                        $formData['website_url'] = 'http://' . $sheet['website_url'];
                    }
                    $formData['created_by'] = Auth::user()->id;
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

                            //$subcatObj = Category::where('code', 'like', trim($cat_name))->
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
                    for ($i = 1; $i <2; $i++) {
                   // for ($i = 1; $i <= 10; $i++) {
//                        if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {
//                            Functions::create_multi_images($result->id, $sheet['image' . $i], $sheet['category_id'], 'places',
                        if (isset($sheet['ssn']) && !empty(trim($sheet['ssn']))) {
                            Functions::create_multi_images($result->id, $sheet['ssn'].'.jpg', $sheet['category_id'], 'places',

                                false, false);
                        }
                    }
                }else {
                    Session::flash('message', "SSN number not exist in your file.");
                    //return redirect('admin/places');

                }
            }

        });



//        if (Input::get('subcat_id')) {
//            $places->whereHas(
//                'subCategories_edit', function ($query) {
//                $query->Where('category_id', '=', $this->cat_detail->id);
//                if (Input::get('subcat_id')) {
//                    $query->Where("subcategory_id", "=", Input::get('subcat_id'));
//                }
//            }
//            );
//        }
//        if (Input::get('action_type')) {
//            $places->Where("places.status", "=", Input::get('action_type'));
//        }
        ///  DB::enableQueryLog();
        // $places = $places->get();
        // dd(DB::getQueryLog());
        //dd($places);


//        if (sizeof($places)) {
//            $j = 0;
//            foreach ($places as $obj) {
//                //  dd($obj->photo);
//                if (sizeof($obj->subCategories_edit)) {
//                    $data1 = array();
//                    foreach ($obj->subCategories_edit as $cat_name) {
//                        $data1[] = $cat_name->cat_name;
//                    }
//                    $subcategories = implode(',', $data1);
//                }
//                if (sizeof($obj->keywords)) {
//                    $data2 = array();
//                    foreach ($obj->keywords as $key_obj) {
//                        $data2[] = $key_obj->keyword_name;
//                    }
//                    $keywords = implode(',', $data2);
//                }
//                $data3 = array();
//                if (sizeof($obj->photo)) {
//                    $i = 1;
//                    foreach ($obj->photo as $photo_obj) {
//                        $data3['image' . $i] = $photo_obj->photo;
//                        $i++;
//                    }
//                    // $images = implode(',', $data);
//                }
//                $data[] = array(
//                    'track_id' => $obj->track_id,
//                    'SSN' => $obj->ssn,
//                    'category_id' => $obj->category_id,
//                    'place_name' => $obj->place_name,
//                    'slug' => $obj->slug,
//                    'order_no' => $obj->order_no,
//                    'stars' => $obj->stars,
//                    'phone' => $obj->phone,
//                    'is_featured' => $obj->is_featured,
//                    'website_url' => $obj->website_url,
//                    'social_1' => $obj->social_1,
//                    'social_2' => $obj->social_2,
//                    'social_3' => $obj->social_3,
//                    'social_4' => $obj->social_4,
//                    'latitude' => @$obj->address[0]->latitude,
//                    'longitude' => @$obj->address[0]->longitude,
//                    'address' => @$obj->address[0]->address,
//                    'city' => @$obj->address[0]->city,
//                    'state' => @$obj->address[0]->state,
//                    'country' => @$obj->address[0]->country,
//                    'zipcode' => @$obj->address[0]->zipcode,
//                    'email' => @$obj->address[0]->email,
//                    'subcategories' => @$subcategories,
//                    'keywords' => @$keywords,
//                    //'images' => @$images,
//                    'excerpt' => $obj->excerpt,
//                    'description' => $obj->description,
//                );
//                $keywords = '';
//                $subcategories = "";
//                $images = "";
//                $data_test[] = array_merge($data[$j], $data3);
//                $j++;
//            }
//
//
//            Excel::create('Places Listing', function ($excel) use ($data_test) {
//                // Set the title
//                $excel->setTitle('excelsheet for listing places');
//                // Chain the setters
//                $excel->setCreator('VisitAnyCity')
//                    ->setCompany('digicom-solutions.com');
//                $excel->sheet('Places Detail', function ($sheet) use ($data_test) {
//                    $sheet->fromArray($data_test);
//                });
//            })->export('xls');
//        } else {
//            return redirect('admin/places');
//        }
    }
    ///////////////////////// import rcg places /////////////////
    public function import_rcg_plc()
    {
        error_reporting(0);
        $sub_category = DB::table('sub_category')->whereIn('category_id', array( 3, 4))->get();
////dd($sub_category);
        foreach ($sub_category as $subcat) {
            $sub_cat = new Category();
            $sub_cat->parent_id = $this->cat_detail->id;
            $sub_cat->icon = 'subcategory/icon/' . $subcat->icon;
            $sub_cat->cat_image = 'subcategory/' . $subcat->image;
            $sub_cat->cat_name = $subcat->subcat_name;
            $sub_cat->code = $subcat->code;

            $sub_cat->slug = Functions::slug('', $subcat->subcat_name, $sub_cat);
            $sub_cat->status = 'Active';
            $sub_cat->created_by = Auth::id();
            // dd($sub_cat);
            $sub_cat->save();
            // }
            $check = Category::where('cat_name', '=', trim($subcat->subcat_name))
                ->first();
            if (!empty($check)) {
                $check->update(array('source' => 'rcg'));
                PlacesLogs::create([
                    'title' => @$subcat->subcat_name,
                ]);
                continue;
            }
        }


        ////////////////////
        $url = "http://reykjaviktoday.is/rcg/api/refresh";

        $str = file_get_contents($url);
        $response = json_decode($str);
        $response = $response->data;

        foreach ($response->places as $obj) {

            $check = Places::where('place_name', '=', trim($obj->place_name))
                ->first();
            if (!empty($check)) {
                $check->update(array('source' => 'rcg'));
                PlacesLogs::create([
                    'title' => @$obj->place_name
                ]);
                continue;
            }
            $model_obj = new Places();

            if (($obj->category_id == 3 ||$obj->category_id == 4) && $obj->status == 'Active') {
                $formData['place_name'] = $obj->place_name;
                $formData['ssn'] = $obj->ssn;
                $formData['category_id'] = $this->cat_detail->id;

                $formData['order_no'] = $obj->order_no;
                $formData['description'] = $obj->description;
                $formData['website_url'] = $obj->website;
                $formData['is_featured'] = $obj->is_featured;
                $formData['social_1'] = $obj->social_1;
                $formData['social_2'] = $obj->social_2;
                $formData['social_3'] = $obj->social_3;
                $formData['source'] = 'rcg';
                $formData['track_id'] = 'PLC' . mt_rand() . 'IS';
                $formData['slug'] = Functions::slug( $obj->place_slug, $obj->place_name, $model_obj);

                $formData['created_by'] = Auth::id();

                $result = Places::create($formData);
                // echo $result;
                ////////////////////creating subcategory//////////////////
                if ($obj->place_type) {
                    $implode = explode(',', $obj->place_type);
                    foreach ($implode as $subcat_code) {
                        $subcat_id = Category::where('code', $subcat_code)->first();
                        if (!empty($subcat_id)) {
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

                        if (!empty($keyword_id)) {
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

                    //$source_file = 'foo/image.jpg';
                    //$destination_path = 'bar/';
                    //rename($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME));
                    $newFileName = array();
                    $newFileName = explode('/', $fileName->image);


                    $file_name= $fileName->image;
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/travel/uploads/rcg/".$newFileName[6]))
                        rename($_SERVER['DOCUMENT_ROOT']."/travel/uploads/rcg/".$newFileName[6], $_SERVER['DOCUMENT_ROOT']."/travel/uploads/places/".$newFileName[6]);
                    if(file_exists($_SERVER['DOCUMENT_ROOT']."/travel/uploads/rcg/thumb/".$newFileName[6]))
                        rename($_SERVER['DOCUMENT_ROOT']."/travel/uploads/rcg/thumb/".$newFileName[6], $_SERVER['DOCUMENT_ROOT']."/travel/uploads/places/thumb/".$newFileName[6]);

                    //$file_name = str_replace('http://reykjaviktoday.is/rcg/upload/gallery/', '', $fileName->image);

                    Photo::create([
                        'photo' => 'places/'.trim($newFileName[6]),
                        'category_id' => $this->cat_detail->id,
                        'instance_id' => $result->id,
                        'main' => $fileName->main
                    ]);
                    //$path = $_SERVER['DOCUMENT_ROOT'] . '/travel/uploads/places/' . trim($file_name);

                    //file_put_contents($path, file_get_contents($fileName->image));
                    // rename(public_path() . '/uploads/gallery/' . $fileName->image, public_path() . '/uploads/trash/' . $fileName->image);

                }
            }
        }

    }


    ////////////////////////////////// IMPORT IDISCOVER PLACES /////////////////////
    public function import_idiscover_plc()
    {

        $sub_category = DB::table('category_idiscover')->where('code','!=','HTL')
            ->Where('code','!=','RST')->get();
//dd($sub_category);
        foreach ($sub_category as $subcat) {
            $sub_cat = new Category();
            $sub_cat->parent_id = $this->cat_detail->id;
            $sub_cat->cat_name = $subcat->cat_name;
            $sub_cat->code = $subcat->code;
            $sub_cat->slug = Functions::slug('', $subcat->cat_name, $sub_cat);
            $sub_cat->status = 'Active';
            $sub_cat->created_by = Auth::id();
            // dd($sub_cat);
            $sub_cat->save();
            // }
            $check = Category::where('cat_name', '=', trim($subcat->cat_name))
                ->first();
            if (!empty($check)) {
                $check->update(array('source' => 'rcg'));
                PlacesLogs::create([
                    'title' => @$subcat->cat_name,
                ]);
                continue;
            }
        }
        // http://citycentre.is/api/places
        $response = DB::table('places_idiscover')
            ->where('category_name','PTV Interesting Places')
//           ->where('places_idiscover.place_type','like','%'.'CAT'.'%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'GTH' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'GCL' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'TAV' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'VOL' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'WAT' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'WLF' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'ACT' . '%')
//            ->orWhere('places_idiscover.place_type', 'like', '%' . 'FILM' . '%')
            ->get();
        //dd($response);
        if($response){
            $i=0;
            foreach ($response as $obj) {
                //$photo_idis = DB::table('photogallery_idiscover')->where('place_id',$obj->id)->get();
                $check = Places::where('place_name', '=', trim($obj->place_name))
                    ->first();
                if (!empty($check)) {
                    $check->update(array('source' => 'idiscover'));
                    PlacesLogs::create([
                        'title' => @$obj->place_name
                    ]);
                    continue;
                }
                $model_obj = new Places();
                // dd($obj);
                //   if ($obj->category_name == 'PTV Interesting Places' && $obj->status == 'Active') {
                $formData['place_name'] = $obj->place_name;
                $formData['ssn'] = $obj->ssc_no;
                $formData['category_id'] = $this->cat_detail->id;
                $formData['currency'] = "ISK";
                $formData['description'] = $obj->overview;
                $formData['website_url'] = @$obj->webpage;
                $formData['is_featured'] = $obj->display;
                $formData['phone'] = @$obj->telephone;
                $formData['social_1'] = @$obj->social_1;
                $formData['social_2'] = @$obj->social_2;
                $formData['social_3'] = @$obj->social_3;
                $formData['source'] = 'idiscover';
                $formData['track_id'] = 'PLC' . mt_rand() . 'idis';
                $formData['slug'] = Functions::slug($obj->place_name, $obj->place_name, $model_obj);
                $formData['source'] = 'Idiscover';
                $formData['created_by'] = Auth::id();
                $result = Places::create($formData);
                //if(!empty($obj->region)){
                //  DB::enableQueryLog();
                $address = new Address();
                $address->instant_id = $result->id;
                $address->category_id = $this->cat_detail->id;
                $address->latitude = @$obj->latitude;
                $address->longitude = @$obj->longitude;
                $address->address = @$obj->address;
                $address->state = @$obj->state;
                $address->city = @$obj->city;
                $address->region = @$obj->regions;
                $address->country = 'IS';
                $address->zipcode = @$obj->zipcode;
                $address->save();

                //dd(DB::getQueryLog());
                // }
                // echo $result;
                ////////////////////creating subcategory//////////////////
                if ($obj->place_type) {
                    $implode = explode(',', $obj->place_type);
                    foreach ($implode as $subcat_code) {
                        $subcat_id = Category::where('code', $subcat_code)->first();
                        if (!empty($subcat_id)) {
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
                /*
                                   if ($obj->keywords) {

                                       $implode = explode(',', $obj->keywords);
                                       foreach ($implode as $keywords) {
                                           $keyword_id = Keyword::where('keyword_name', trim($keywords))->where('category_id', $this->cat_detail->id)->first();
                                           if (!empty($keyword_id)) {
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
                                   }*/



                // }
            }
            echo 'data import successfuly';
        }

    }


}
