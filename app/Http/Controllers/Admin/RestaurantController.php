<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cities;
use App\Models\Country;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Restaurants;
use App\Models\Places;
use App\Models\Hotel;
use App\Models\Category;
use App\Models\PlacesLogs;
use App\Models\Reviews;
use App\Models\Restaurant_menu;
use App\Models\multiSubcategories;
use App\Models\Photo;
use App\Models\Keyword;
use App\Models\multiKeywords;
use App\Models\Address;
use App\Classes\Functions;
use Illuminate\Filesystem\Filesystem;
use Session;
use DB;
use Excel;
use Yajra\DataTables\DataTables;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->cat_detail = Category::where('id', '=', '2')->first();
//        $this->middleware(function ($request, $next) {
//            if (empty(Auth::user()->can('restaurant-listing'))) {
//                return redirect('admin/dashboard');
//            }
//            return $next($request);
//        });
    }

     public function arguments()
    {
        $args = $_REQUEST;

        return array_merge([
            'pagination' => CustomHelper::get_pagination(),
            'per_page' => 10,
            'search' => '',
            'orderBy' => 'id',
			'category_id'=>$this->cat_detail ,
			
            'order' => 'asc',
        ], $args, [

        ]);
    }

    public function index()
    {
        $perPage = 10;
        $items = Restaurants::with('single_category')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo','category_id','instance_id');
                    $querys->Where('category_id', '=', $this->cat_detail->id);
                }])
            ->where('category_id',$this->cat_detail->id)->take($perPage)->orderBy('restaurant_name', 'asc')->get();

        $total = Restaurants::count();
        $subcategory = Category::select('id', 'cat_name', 'parent_id')->where('parent_id', $this->cat_detail->id)->orderBy('cat_name', 'ASC')->get();

        $currentRoute = 'admin::restaurants';
            //dd($items);
            //$viewData = [
            //'items' => $items,
            //'total' => $total,
            //'category_id' => $this->cat_detail ,
            //'currentRoute' => $currentRoute,
            //'perPage' => $perPage,
            //'modelInstance' => '\App\Models\Restaurants',
            //];
        $viewData = [
            'items' => $items,
            'total' => $total,
            //'subcategory_id' => $subcat_id,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'category_id'=> $this->cat_detail,
            'modelInstance' => '\App\Models\Restaurants',
        ];
        return view("admin.restaurants.datatables", $viewData,compact('subcategory'));

        //return view("admin.restaurants.datatables", $viewData);
    }

    public function restaurant_listing()

    {
      
        $items = Restaurants::where('category_id',$this->cat_detail->id)->with('single_category')
            ->with('subCategories_edit')
            ->with([
                'single_photo' => function ($querys) {
                    $querys->select('photo','category_id','instance_id');
                    $querys->Where('category_id', '=', $this->cat_detail->id);
                    $querys->where('main', '=', 1);
                }]);

        if (Input::get('subcategory_id')) {
            $items->whereHas(
                'subCategories_edit', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (Input::get('subcategory_id')) {
                    $query->Where("subcategory_id", "=", Input::get('subcategory_id'));
                }
            });
        }

        //DB::enableQueryLog();
        $items=$items->orderBy('order_no','ASC')->get();
        //dd(DB::getQueryLog());

        $currentRoute = str_replace('restaurants.', '', \Request::route()->getName());

        return DataTables::of($items)
        ->addColumn('actions', function ($items) use ($currentRoute) {
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
                $edit=' <a href="' . url("admin/restaurants/".$items->id.'/edit').'" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i>
                        </a>';
            return '<div id="status_div_'.$items->id.'" class="status_div">'.$edit.$cond.
                    '</div>
                    <span style="overflow: visible; width: 150px;">
                       
                        <a data-id="' . $items->id . '" href="javascript:void(0)"
                                                   class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                            
                                                </span>
                    ';
        }) ->editColumn('single_photo', function ($items) {
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
            })->rawColumns(['status', 'actions', 'id'])->make(true);
    }

    public function create()
    {
        /*if (empty(Auth::user()->can('restaurant-create'))) {
            return redirect('admin/dashboard');
        }*/
        if (!empty($this->cat_detail)) {
            $keywords = Keyword::where('category_id', $this->cat_detail->id)->get();
            $subcategory = Category::where('parent_id', $this->cat_detail->id)->get();
            return view('admin/restaurants/_form', compact('keywords', 'subcategory'));
        } else {
            return redirect('admin/restaurants');
        }
    }

    public function store(Request $request)
    {

        $validator = Functions::validator($request->all(), [
            'restaurant_name' => 'required',
            'order_no' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('admin/restaurants/create')->withErrors($validator)->withInput();
        }
        ///////////////////////creating restaurant//////////////////////
        $model_obj = new Restaurants();
        $formData = $request->all();
        $formData['slug'] = Functions::slug($request->slug, $request->restaurant_name, $model_obj);
        $formData['created_by'] = Auth::id();
        $formData['category_id'] = $this->cat_detail->id;
        $formData['status'] = 'Active';
        $formData['track_id'] = 'RST' . mt_rand();

        $result = Restaurants::create($formData);
        //////////////////////creating subcategory//////////////////

        if (!empty($request->subcategory)) {
            foreach ($request->subcategory as $obj) {

                $data2[$obj] = ['category_id' => $this->cat_detail->id];
            }
            $result->subCategories()->sync($data2);
        }
        //////////////////////creating keywords//////////////////
        if (!empty($request->keywords)) {
            foreach ($request->keywords as $keyword) {

                $data1[$keyword] = ['category_id' => $this->cat_detail->id];
            }
        }

        if(!empty($data1))
        $result->keywords()->sync($data1);
        ///////////////////////creating image///////////////////////
        if ($result && $request->file) {
            foreach ($request->file as $fileName) {
               $filename = $fileName->getClientOriginalName();
                if ($request->main_image == $filename) {
                    $main_image = 1;
                } else {
                    $main_image = 0;
                }
                
            $destinationPath = 'uploads/restaurant_pic/';
            $filename = $fileName->getClientOriginalName();
            $fileName->move($destinationPath, $filename);
         //  $content->photo = $filename;

                // $img = Functions::make_thumb($path);
                $data = Photo::create([
                    'photo' => 'restaurant_pic/'.$filename,
                    'category_id' =>$this->cat_detail->id,
                    'instance_id' => $result->id,
                    'main' => $main_image
                ]);
            }
            Session::flash('message', "Record has been added successfully.");
            return redirect('admin/restaurants/address/' . $result->id);
        } else {
            return redirect('admin/restaurants')->withErrors('There is a error in adding new record.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // if (empty(Auth::user()->can('restaurant-edit'))) {
        //     return redirect('admin/dashboard');
        // }
        $edit_place = Restaurants::where('id', $id)->with(['subCategories' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
        }])
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
                $query->orderBy('main','DESC');
                //$query->where('main', '=', 1);
            }])
            ->with('keywords')->first();
        $keywords = Keyword::where('category_id', $edit_place->category_id)->get();
        $subcategory = Category::where('parent_id', $edit_place->category_id)->get();
        return view('admin/restaurants/form_edit', compact('subcategory', 'keywords', 'edit_place', 'categories'));
    }

    public function update(Request $request, $id)
    {
        Functions::validator($request->all(), [
            'restaurant_name' => 'required',
            //'order_no' => 'required',
            //'description' => 'required',
        ])->validate();
        $result = Restaurants::find($id);
        $data1=array();
        if ($result) {
            $formData = $request->all();
            $formData['slug'] = Functions::slug($request->slug, $request->restaurant_name, $result, $id);
            $formData['created_by'] = Auth::id();
            if(isset($request->is_featured))
            {
            }else
                $formData['is_featured']=0;

            $result->update($formData);
            //////////////////////creating subcategory//////////////////
            if (sizeof($request->subcategory)) {
                foreach ($request->subcategory as $obj) {

                    $data2[$obj] = ['category_id' => $this->cat_detail->id];
                }
                $result->subCategories()->sync($data2);
            }
            //////////////////////creating keywords//////////////////
            if (sizeof($request->keywords)) {
                foreach ($request->keywords as $keyword) {

                    $data1[$keyword] = ['category_id' => $this->cat_detail->id];
                }
            }
            $result->keywords()->sync($data1);
            ///////////////////////creating image///////////////////////
            if ($result && $request->file) {
                foreach ($request->file as $fileName) {
                    Photo::where('instance_id', $id)->where('category_id',$this->cat_detail->id)->update(['main' => 0]);
                    Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
                    $filename = $fileName->getClientOriginalName();
                    if ($request->main_image == $filename) {
                        $main_image = 1;
                    } else {
                        $main_image = 0;
                    }
                  /*  $path = $fileName->storeAs(
                        'restaurant_pic', rand(0, 100) . '_' . $filename
                    );*/
                   // $img = Functions::make_thumb($path);
                       $destinationPath = 'uploads/restaurant_pic/';
                        $filename = $fileName->getClientOriginalName();
                        $fileName->move($destinationPath, $filename);
                    $data = Photo::create([
                      'photo' => 'restaurant_pic/'.$filename,
                        'category_id' => $result->category_id,
                        'instance_id' => $id,
                        'main' => $main_image
                    ]);
                }
            } else {
                Photo::where('instance_id', $id)->where('category_id',$this->cat_detail->id)->update(['main' => 0]);
                Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
            }
            Session::flash('message', "Record has been updated successfully.");
            return redirect($request->prev_url);
        } else {
            return redirect('admin/restaurants')->withErrors('There is a error in updating record.');
        };
    }

    public function destroy($id)
    {
        $data = Restaurants::find($id);
        if ($data) {
            $data->delete();
            Address::where('instant_id', $data->id)->where('category_id', $data->category_id)->delete();
            $deleted_photo = Photo::where('instance_id', $data->id)->where('category_id', $data->category_id)->get();
            //echo 'yyyyy'.public_path();


            if (!empty($deleted_photo)) {
                foreach ($deleted_photo as $obj) {
                    if (file_exists(public_path() . '/uploads/' . $obj->photo)) {
                        rename(public_path() . '/uploads/' . $obj->photo, public_path() . '/uploads/trash/' . $obj->photo);
                    }
                    $obj->delete();
                }
            }

            // dd($deleted_photo);
            multiKeywords::where('instance_id', $data->id)->where('category_id', $data->category_id)->delete();
            multiSubcategories::where('instance_id', $data->id)->where('category_id', $data->category_id)->delete();
        }
        Session::flash('message', "Record has been deleted successfully.");
        return redirect('admin/restaurants');
    }

    //////////////////////////////custom action fuction start here//////////////////////////////////////////////////////
    public function address($id)
    {
        //echo 'vczxczxcz'; exit;
        $restaurant_id = $id;
        $restaurants_name = Restaurants::select('restaurant_name', 'id')->where('id', $restaurant_id)->first();

      /*  $is_city=Cities::select('id','name','country_code')->where('country_code','IS')
            ->where('status','Active')->get();*/
        //$address_list = Address::where('instant_id', $id)->get();
        $address_list = Address::where('instant_id', $id)->where('category_id', $this->cat_detail->id)->get();
        return view('admin/restaurants/add_restaurant_address', compact('restaurant_id', 'address_list', 'restaurants_name' , 'is_city'));
    }

    public function edit_address(Request $request)
    {
        $address_list = json_decode(Address::where('address_id', $request->id)->get());
        echo json_encode($address_list[0]);
    }

    public function address_store(Request $request, $id)
    {
        
        $validator = Functions::validator($request->all(), [
            'search_address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/restaurants/address/' . $id)->withErrors($validator)->withInput();
        }
        if ($request->address_id) {
            $address = Address::find($request->address_id);
        } else {
            $address = new Address();
        }
        ///////////////////////creating restaurant address//////////////////////
        $address->instant_id = $id;
        $address->category_id = $this->cat_detail->id;
        $address->latitude = $request->lat;
        $address->longitude = $request->lng;
        $address->address = $request->formatted_address;
        $address->city = $request->locality;
        $address->region = $request->region;
        $address->email = $request->email;
        $address->state = $request->administrative_area_level_1;
        $address->country = $request->country_short;
        $address->zipcode = $request->postal_code;
        $address->save();
        Session::flash('message', "Record has been added successfully.");
        return redirect('admin/restaurants/address/' . $id);

    }

    public function address_delete($id)
    {
        $data = Address::find($id);
        if ($data) {
            $data->delete();
            Session::flash('message', "Record has been deleted successfully.");
            return redirect('admin/restaurants/address/' . $data->instant_id);
        }
    }

//////////////////////////////////  Menu ///////////////////////////////////////
    public function menus($id)
    {
        $restaurant_id = $id;
        $restaurants_name = Restaurants::select('restaurant_name', 'id')->where('id', $restaurant_id)->first();
        $menu_list = Restaurant_menu::where('restaurant_id', $id)->get();
        /*  $menu_list3 = Restaurant_menu::join('restaurants','restaurants.id','=','restaurant_menus.restaurant_id')
              ->where('restaurant_id', $id)->get();*/

        return view('admin/restaurants/add_menu_restaurant', compact('menu_list', 'restaurant_id', 'restaurants_name'));

    }

    public function menu_store(Request $request, $id)
    {

        $validator = Functions::validator($request->all(), [
            'menu_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/restaurants/menu/' . $id)->withErrors($validator)->withInput();
        }

        if ($request->id) {

            $restaurant_menu = Restaurant_menu::find($request->id);
        } else {
            $restaurant_menu = new Restaurant_menu();
        }
        ///////////////////////creating restaurant address//////////////////////
        $restaurant_menu['restaurant_id'] = $id;

        $restaurant_menu['menu_name'] = $request->menu_name;
        if ($request->file) {

            $filename = $request->file->getClientOriginalName();

            $restaurant_menu->image = $request->file->storeAs(
                'restaurants_menu', rand() . '_' . $filename
            );


        }

        $restaurant_menu->save();
        Session::flash('message', "Record has been added successfully.");
        return redirect('admin/restaurants/menu/' . $id);

    }

    public function menu_edit(Request $request)
    {

        $menu_list = json_decode(Restaurant_menu::where('id', $request->id)->get());
        echo json_encode($menu_list[0]);
    }

    public function menu_delete($id)
    {
        $data = Restaurant_menu::find($id);
        if ($data) {
            $data->delete();
            Session::flash('message', "Record has been deleted successfully.");
            return redirect('admin/restaurants/menu/' . $data->restaurant_id);
        }
    }


    public function status(Request $request)
    {
        $place = Restaurants::find($request->id);
        echo Functions::status($place, $request->status, $request->id);
    }

    public function remove_image(Request $request,$id)
    {
         // echo $id; exit;
        $data = array();
        // $id = $request->id;

        $data = Photo::where('photo_id',$id)->where('category_id',2)->first();

        // unlink('uploads/' . $data->photo);
        $delete= $data->delete();
        echo $delete;
    }

    public function bulk_operation(Request $request)
    {
        $validator = Functions::validator($request->all(), [
            'bulk_action' => 'required',
            'all_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/restaurants')->withErrors($validator);
        }
        $id_list = explode(',', $request->all_id);
        if ($request->bulk_action != 'Delete') {
            foreach ($id_list as $row) {
                $place = Restaurants::find($row);
                if ($place) {
                    $place->status = $request->bulk_action;
                    $place->save();
                } else {
                    return redirect('admin/restaurants')->withErrors('There is a error in action perform.');
                };
            }
        } else {
            foreach ($id_list as $row) {
                $data = Restaurants::find($row);
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
            }
        }
        Session::flash('message', "Your action has been performed successfully.");
        return redirect('admin/restaurants');
    }

    public function get_subcategories(Request $request)
    {
        $option_list = "";
        $categories = Category::where('parent_id', $request->id)->groupBy('cat_name')->get();
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

    public function delete_image(Request $request)
    {
        echo $result = Functions::image_remove($request->id);
    }

///////////////////////////////////export functions start here///////////////////////////////////////
    public function excel(Request $request)
    {
        $places = Restaurants::with(['subCategories' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
        }])
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with([
                    'keywords' => function ($query) {
                        //$qury->select('address_id','address','city','country','instant_id');
                        $query->Where('multi_keywords.category_id', '=', $this->cat_detail->id);
                    }]
            )->latest('id');
        if (session('country_base')) {
            $places->whereHas(
                'address', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (session('country_base')) {
                    $query->Where("country", "=", session('country_base'));
                }
                if (session('city_base')) {
                    $query->Where("city", "=", session('city_base'));
                }
            }
            );
        }
        if (Input::get('subcat_id')) {
            $places->whereHas(
                'subCategories', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (Input::get('subcat_id')) {
                    $query->Where("subcategory_id", "=", Input::get('subcat_id'));
                }
            }
            );
        }
        if (Input::get('action_type')) {
            $places->Where("restaurants.status", "=", Input::get('action_type'));
        }
        $places = $places->get();
        dd($places);
        if (sizeof($places)) {
            $j = 0;
            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $data1 = array();
                    foreach ($obj->subCategories as $cat_name) {
                        $data1[] = $cat_name->cat_name;
                    }
                    $subcategories = implode(',', $data1);
                }
                if (sizeof($obj->keywords)) {
                    $data2 = array();
                    foreach ($obj->keywords as $key) {
                        $data2[] = $key->keyword_name;
                    }
                    $keywords = implode(',', $data2);
                }
                $data3 = array();
                if (sizeof($obj->photo)) {
                    $i = 1;
                    foreach ($obj->photo as $photo_obj) {
                        $data3['image' . $i] = $photo_obj->photo;
                        $i++;
                    }
                }
                $data[] = array(
                    'track_id' => $obj->track_id,
                    'ssn' => $obj->ssn,
                    'category_id' => $obj->category_id,
                    'restaurant_name' => $obj->restaurant_name,
                    'slug' => $obj->slug,
                    'order_no' => $obj->order_no,
                    'stars' => $obj->stars,
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
                    //'images' => @$images,
                    'description' => $obj->description,
                    'excerpt' => $obj->excerpt,
                );
                $data_test[] = array_merge($data[$j], $data3);
                $j++;
            }

            Excel::create('Restaurant Listing', function ($excel) use ($data_test) {
                // Set the title
                $excel->setTitle('excelsheet for listing Restaurant');
                // Chain the setters
                $excel->setCreator('VisitAnyCity')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Restaurant Detail', function ($sheet) use ($data_test) {
                    $sheet->fromArray($data_test);
                });
            })->export('xls');
        } else {
            return redirect('admin/restaurants');

        }
    }

    public function csv(Request $request)
    {
        $places = Restaurants::with(['subCategories' => function ($query) {
            $query->where('category_id', '=', $this->cat_detail->id);
        }])
            ->with(['photo' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with(['address' => function ($query) {
                $query->where('category_id', '=', $this->cat_detail->id);
            }])->with('keywords')->latest('id');
        if (session('country_base')) {
            $places->whereHas(
                'address', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (session('country_base')) {
                    $query->Where("country", "=", session('country_base'));
                }
                if (session('city_base')) {
                    $query->Where("city", "=", session('city_base'));
                }
            }
            );
        }
        if (Input::get('subcat_id')) {
            $places->whereHas(
                'subCategories', function ($query) {
                $query->Where('category_id', '=', $this->cat_detail->id);
                if (Input::get('subcat_id')) {
                    $query->Where("subcategory_id", "=", Input::get('subcat_id'));
                }
            }
            );
        }
        if (Input::get('action_type')) {
            $places->Where("restaurants.status", "=", Input::get('action_type'));
        }
        $places = $places->get();
//        dd($places);
        if (sizeof($places)) {
            foreach ($places as $obj) {
                if (sizeof($obj->subCategories)) {
                    $data1 = array();
                    foreach ($obj->subCategories as $cat_name) {
                        $data1[] = $cat_name->cat_name;
                    }
                    $subcategories = implode(',', $data1);
                }
                if (sizeof($obj->keywords)) {
                    $data2 = array();
                    foreach ($obj->keywords as $key) {
                        $data2[] = $key->keyword_name;
                    }
                    $keywords = implode(',', $data2);
                }
                if (sizeof($obj->photo)) {
                    $data3 = array();
                    foreach ($obj->photo as $cat_name) {
                        $data3[] = $cat_name->photo;
                    }
                    $images = implode(',', $data3);
                }
                $data[] = array(
                    'track_id' => $obj->track_id,
                    'ssn' => $obj->ssn,
                    'category_id' => $obj->category_id,
                    'restaurant_name' => $obj->restaurant_name,
                    'slug' => $obj->slug,
                    'order_no' => $obj->order_no,
                    'stars' => $obj->stars,
                    'phone' => $obj->phone,
                    'is_featured' => $obj->is_featured,
                    'website' => $obj->website,
                    'social_1' => $obj->social_1,
                    'social_2' => $obj->social_2,
                    'social_3' => $obj->social_3,
                    'social_4' => $obj->social_4,
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
                    'description' => $obj->description,
                    'excerpt' => $obj->excerpt,
                );
            }
            Excel::create('Restaurant Listing', function ($excel) use ($data) {
                // Set the title
                $excel->setTitle('excelsheet for listing Restaurant');
                // Chain the setters
                $excel->setCreator('VisitAnyCity')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Restaurant Detail', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->export('csv');
        } else {
            return redirect('admin/restaurants');

        }
    }


    //////////////////////////////////////importe functions start here/////////////////////////////
    public function import_excel()
    {
//        $result = DB::table('countries')->get();
//        foreach ($result as $obj)
//        {
//            DB::table('countries')
//                ->where('id', $obj->id)
//                ->update(['code' => strtoupper($obj->code)]);
//        }
        return view('admin/restaurants/import_restaurant');
    }

    public function store_excel()
    {
        $path = $_FILES['file']['tmp_name'];
        //$file_path = storage_path('exports') . '/Places-Listing.xls';
        Excel::load($path, function ($reader) {
            $results = $reader->toArray();

            foreach ($results as $sheet) {
                if (isset($sheet['restaurant_name']) && $sheet['restaurant_name'] != '') {

                    $check = Restaurants::where('restaurant_name', '=', trim($sheet['restaurant_name']))
                        ->first();
                    if (sizeof($check)) {
                        LogsPlaces::create([
                            'track_id' => @$sheet['track_id'],
                            'ssn' => @$sheet['ssn'],
                            'title' => @$sheet['restaurant_name']
                        ]);
                        continue;
                    }

                    $model_obj = new Restaurants();
                    $sheet['slug'] = '';
                    $formData = $sheet;
                    $formData['slug'] = Functions::slug($sheet['slug'], $sheet['restaurant_name'], $model_obj);
                    $formData['category_id'] = $sheet['category_id'];
                    $formData['track_id'] = 'RST' . mt_rand();
                    $formData['source'] = @$sheet['source'];
                    $formData['status'] = 'Active';
                    if (!empty($formData['website'])) {
                        if (strpos($formData['website'], 'http') !== false) {
                            $formData['website'] = $formData['website'];
                        } else {
                            $formData['website'] = 'http://' . $sheet['website'];
                        }
                    }
                    $formData['created_by'] = Auth::user()->user_id;
                    $result = Restaurants::create($formData);
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
                        //$sheet['country'] = @$cordinates['country'];
                        $sheet['address'] = $cordinates['address'];
                    }
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

                    if (isset($sheet['keywords']) && $sheet['keywords'] != "") {
                        $key_explode = explode(',', trim($sheet['keywords']));//explode subcategori form sheet
                        foreach ($key_explode as $key_name) {
                            $keyObj = Keyword::where('keyword_name', 'like', trim($key_name))->
                            where('category_id', '=', $sheet['category_id'])->first();//check if sub cat already exist
                            if (empty($keyObj)) {//if empaty then create it and add it to multi sub cat table
                                $keyword_id = Functions::create_keyword($this->cat_detail->id, trim($key_name));
                                Functions::create_multi_keyword($result->id, $keyword_id, $this->cat_detail->id);
                            } else {//if exist then direct add it to multysubcat table
                                Functions::create_multi_keyword($result->id, $keyObj->id, $this->cat_detail->id);
                            }
                        }
                    }
                    if (isset($sheet['subcategories']) && $sheet['subcategories'] != "") {
                        $implode = explode(',', trim($sheet['subcategories']));//explode subcategori form sheet
                        foreach ($implode as $cat_name) {
                            $subcatObj = Category::where('cat_name', 'like', trim($cat_name))->
                            where('parent_id', '=', $sheet['category_id'])->first();//check if sub cat already exist
                            if (empty($subcatObj)) {//if empaty then create it and add it to multi sub cat table
                                $subcat_id = Functions::create_subcategory($sheet['category_id'], $cat_name);
                                Functions::create_multi_subcat($result->id, $subcat_id, $sheet['category_id']);
                            } else {//if exist then direct add it to multysubcat table
                                Functions::create_multi_subcat($result->id, $subcatObj->id, $sheet['category_id']);
                            }
                        }
                    }
                    for ($i = 1; $i <= 5; $i++) {
                        if (isset($sheet['image' . $i]) && !empty(trim($sheet['image' . $i]))) {
                            Functions::create_multi_images($result->id, $sheet['image' . $i], $sheet['category_id'], 'restaurant_pic', $sheet['order_no'], isset($sheet['image_order']));
                        }
                    }

                } else {
                    Session::flash('message', "Restaurant Name column not exist in your file.");
                    return redirect('admin/restaurants');
                }
            }
        });
        return redirect('admin/restaurants');
    }

    public function update_excel()
    {
        $path = $_FILES['file']['tmp_name'];
        //$file_path = storage_path('exports') . '/Places-Listing.xls';
        Excel::load($path, function ($reader) {
            $results = $reader->toArray();
            $model_obj = new Restaurants();
            foreach ($results as $sheet) {
                if (isset($sheet['track_id']) && $sheet['track_id'] != '') {
                    $result = Restaurants::where('track_id', '=', trim($sheet['track_id']))
                        ->first();
                    if ($result) {
                        $formData = $sheet;
                        $formData['slug'] = Functions::slug($sheet['slug'], $sheet['restaurant_name'], $model_obj);
                        if (strchr($formData['website'], 'http') !== false) {
                            $formData['website'] = $formData['website'];
                        } else {
                            $formData['website'] = 'http://' . $sheet['website'];
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
                'restaurant_pic', $filename
            );
        }
        return redirect('admin/restaurants');
    }

    public function import_address()
    {
        $file_path = storage_path('exports/restaurants') . '/address.xls';
        Excel::load($file_path, function ($reader) {
            $results = $reader->toArray();
            foreach ($results as $sheet) {
                $restaurants = Restaurants::where('token_no', $sheet['token_no'])->first();
                $formData = $sheet;
                $formData['instant_id'] = $restaurants['id'];
                $formData['created_by'] = Auth::user()->user_id;
                $result = Address::create($formData);
            }
        });
    }

    public function import_rcg_rst()
    {


     /*       $sub_category = DB::table('sub_category')->whereIn('category_id', array(1))->get();

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
        }*/


        $url = "http://reykjaviktoday.is/rcg/api/refresh";
        $str = file_get_contents($url);
        $response = json_decode($str);
        $response = $response->data;
        // echo 'ffffff';
         
        foreach ($response->places as $obj) {
            //$model_obj = new Places();
            if ($obj->category_id == 2 && $obj->status == 'Active') {
           
               // echo "place_name" . $obj->place_name;
                $formData['restaurant_name'] = $obj->place_name;
                $formData['ssn'] = $obj->ssn;
                $formData['category_id'] = $this->cat_detail->id;
                $formData['order_no'] = $obj->order_no;
                $formData['description'] = $obj->description;
                $formData['website'] = $obj->website;
                $formData['is_featured'] = $obj->is_featured;
                $formData['social_1'] = $obj->social_1;
                $formData['social_2'] = $obj->social_2;
                $formData['social_3'] = $obj->social_3;
                $formData['status'] = 'Active';
                $formData['track_id'] = 'RST' . mt_rand();
                //$formData['slug'] = Functions::slug($obj->place_slug, $obj->place_name, $model_obj);
                $formData['slug'] = $obj->place_slug;
                $formData['created_by'] = Auth::id();
                $result = Restaurants::create($formData);
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
                                'created_by' => Auth::id()
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
//                 foreach ($obj->images as $fileName) {
//                     $data = Photo::create([
//                         'photo' => 'restaurant_pic/' . $fileName->image,
//                         'category_id' => $this->cat_detail->id,
//                         'instance_id' => $result->id,
//                         'main' => $fileName->main
//                     ]);
// //                if (file_exists(public_path() . '/uploads/gallery/' . $fileName->image)) {
// //                    rename(public_path() . '/uploads/gallery/' . $fileName->image, public_path() . '/uploads/trash/' . $fileName->image);
// //                }

//                 }
                 foreach ($obj->images as $fileName) {
                        $file_name = str_replace('http://reykjaviktoday.is/rcg/upload/gallery/', '', $fileName->image);

                        Photo::create([
                            'photo' => 'restaurant_pic/' . trim($file_name),
                            'category_id' => $this->cat_detail->id,
                            'instance_id' => $result->id,
                            'main' => $fileName->main
                        ]);
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/travel/uploads/restaurant_pic/' . trim($file_name);
 
                        file_put_contents($path, file_get_contents($fileName->image));
                        rename(public_path() . '/uploads/gallery/' . $fileName->image, public_path() . '/uploads/trash/' . $fileName->image);

                    }
            }
             echo ' Restaurenats data import successfuly';
        }
    }


    public function logs()
    {
        $data = array();
        $places = LogsPlaces::all();
        if (sizeof($places)) {
            foreach ($places as $obj) {
                $data[] = array(
                    'track_id' => $obj->track_id,
                    'ssn' => $obj->ssn,
                    'title' => $obj->title,
                    'created_at' => $obj->created_at,
                );
            }
            Excel::create('Restaurants Listing', function ($excel) use ($data) {
                // Set the title
                $excel->setTitle('excelsheet for listing restaurants');
                // Chain the setters
                $excel->setCreator('VisitAnyCity')
                    ->setCompany('digicom-solutions.com');
                $excel->sheet('Places Detail', function ($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->export('xls');
        } else {
            return redirect('admin/restaurants');
        }
    }

    ///////////////////////////// ajax source search
    public function autocomplete_search(Request $request)
    {
        $term = $request->term;
        $data = Restaurants::where('restaurant_name', 'LIKE', '%' . $term . '%')/*->orwhere('track_id','LIKE','%'.$term.'%')*/
        ->groupBy('id');
        $data = $data->get();
        if (sizeof($data) > 0) {
            foreach ($data as $place) {
                $row_set[] = $place['restaurant_name']; //build an array

            }
        }
        if (sizeof($row_set) > 0) {
            echo json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            echo json_encode($row_set);
        }
    }

    ///////////////////////////Restaurants api start here///////////////////////////////////

   
  
    public function import_idiscover_rst()
    {
//        echo "asdf";
//        exit;
//        $sub_category = DB::table('category_idiscover')->get();
//        foreach ($sub_category as $subcat) {
//            $check = Category::
//                where('code', '=', trim($subcat->code))->first();
//
//            if (!empty($check)) {
//                continue;
//            }
//            $sub_cat = new Category();
//            $sub_cat->parent_id = $this->cat_detail->id;
//            //$sub_cat->cat_image = 'subcategory/' . @$subcat->icon;
//            $sub_cat->cat_name = $subcat->cat_name;
//            $sub_cat->code = $subcat->code;
//            $sub_cat->slug = Functions::slug('', $subcat->cat_name, $sub_cat);
//            $sub_cat->status = 'Active';
//            $sub_cat->created_by = Auth::user()->user_id;
//            $sub_cat->save();
//        }
//        exit;

        ////////////////////
//        $url = "http://reykjaviktoday.is/rcg/api/refresh";
//        $str = file_get_contents($url);
//        $response = json_decode($str);
//        $response = $response->data;
        //  DB::enableQueryLog();
        $response = DB::table('places_idiscover')
            ->where('status','Active')
            ->where('place_type','RST')
         //   ->orwhere('place_type','RST')
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
            foreach ($response as $obj) {
                $photo_idis = DB::table('photogallery_idiscover')->where('place_id',$obj->id)->get();
                $check = Restaurants::where('restaurant_name', '=', trim($obj->place_name))
                    ->first();
                if (sizeof($check)) {
                    $check->update(array('source' => 'idiscover'));
                    LogsPlaces::create([
                        'title' => @$obj->place_name
                    ]);
                    continue;
                }
                $model_obj = new Restaurants();
                //   if ($obj->category_name == 'PTV Interesting Places' && $obj->status == 'Active') {
                $formData['restaurant_name'] = $obj->place_name;
                $formData['ssn'] = $obj->ssc_no;
                $formData['category_id'] = $this->cat_detail->id;
                $formData['currency'] = "ISK";
                $formData['description'] = $obj->description;
                $formData['website_url'] = @$obj->webpage;
                $formData['is_featured'] = $obj->display;
                $formData['phone'] = $obj->phone_no;
                $formData['social_1'] = @$obj->social_1;
                $formData['social_2'] = @$obj->social_2;
                $formData['social_3'] = @$obj->social_3;
                $formData['source'] = 'idiscover';
                $formData['track_id'] = 'PLC' . mt_rand() . 'idis';
                $formData['slug'] = Functions::slug($obj->place_name, $obj->place_name, $model_obj);
                $formData['created_by'] = Auth::id();
                $result = Restaurants::create($formData);
                //if(!empty($obj->region)){
                $address = new Address();
                $address->instant_id = $result->id;
                $address->category_id = $this->cat_detail->id;
                $address->latitude = @$obj->latitude;
                $address->longitude = @$obj->longitude;
                $address->address = @$obj->address;
                $address->state = @$obj->state;
                $address->city = @$obj->city;
                $address->region = @$obj->region;
                $address->country = 'IS';
                $address->zipcode = @$obj->zipcode;
                $address->save();
                // }
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
                                'created_by' => Auth::id()
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
                                }*/
//            ///////////////////////creating places address//////////////////////

                foreach ($photo_idis as $fileName) {
                    //$file_name = str_replace('http://reykjaviktoday.is/rcg/upload/gallery/', '', $fileName->image);
                    Photo::create([
                        'photo' => 'restaurant_pic/' . $fileName->photo,
                        'category_id' => $this->cat_detail->id,
                        'instance_id' => $result->id,
                        'main' => $fileName->main
                    ]);
                    // $file = new Filesystem();
                    //echo 'ppppp'.$_SERVER['DOCUMENT_ROOT'].'/tripxonic/uploads/idiscover/'.$fileName->photo;
                   // echo 'fds'.$file->moveDirectory($_SERVER['DOCUMENT_ROOT'].'/tripxonic/uploads/idiscover/'.$fileName->photo, $_SERVER['DOCUMENT_ROOT'].'/tripxonic/uploads/restaurant_pic/'.$fileName->photo);

                    //$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/places/' . trim($file_name);
                    //file_put_contents($path, file_get_contents($fileName->image));
                    // rename(public_path() . '/uploads/gallery/' . $fileName->image, public_path() . '/uploads/trash/' . $fileName->image);
                }
                // }
            }
            echo ' Restaurenats data import successfuly';
        }

    }
}
