<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Places;
use App\Models\Restaurants;
use App\Models\Hotel;
use App\Models\Deals;
use App\Classes\Functions;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;

class DealsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
      /*  $this->middleware('Admin_auth');
        $this->middleware(function ($request, $next) {
            if(empty(Auth::user()->can('deal-listing')))
            {
                return redirect('admin/dashboard');
            }
            return $next($request);
        });*/
    }
 public function arguments()
    {
        $args = $_REQUEST;

        return array_merge([
            'pagination' => CustomHelper::get_pagination(),
            'per_page' => 10,
            'search' => '',
            'orderBy' => 'id',
            'order' => 'asc',
        ], $args, [

        ]);
    }
    public function index()
    {
        // $items = Deals::orderBy('created_at','DESC')->paginate(20);
//        echo "<pre>";
//        print_r(sizeof($deals));
//        exit;
        // $users= array();
        $perPage = 10;
        $items = Deals::take($perPage)->get();
        $total = Deals::count();
        $currentRoute = 'admin::deals';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => '\App\Models\Deals',
        ];
        return view("admin.deals.datatable", $viewData);
        // return view('admin/deals/datatable', compact('items'));
    }
    public function create()
    {
        $categories = Category::where('parent_id','=',0)->get();
  
        $currency=DB::table('currency')->get();

        $places = Places::where('status','Active')->get();
        return view('admin.deals.create_form', compact('categories','places','currency'));
    }
    protected function validator($request, $rules)
    {
        return $validator = Validator::make($request, $rules);
    }
    public function store(Request $request)
    {
        $validator = $this->validator($request->all(), [
            'category_name' => 'required',
            'place_id' => 'required',
            'deal_name' => 'required',
            'discount_price' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'currency' => 'required',
           /* 'description' => 'required',*/
            // 'file' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return redirect('admin/deals/create')->withErrors($validator)->withInput();
        }
//        echo '<pre>';
//        print_r($request->all());
//        exit;

        $deals = new Deals();
        $deals->category_id = $request->category_name;
        $deals->instant_id = $request->place_id;
        $deals->deals_title = $request->deal_name;
        $deals->discount_price = $request->discount_price;
        $deals->valid_from = $request->valid_from;
        $deals->valid_to = $request->valid_to;
        $deals->description = $request->description;
        $deals->currency = $request->currency;
        $deals->status = 'Active';
        $deals->created_by = Auth::id();
        // $deals->deals_image = $request->file->store('deals');

if($request->file)
        {
            $image  = $request->file;
           
             $filename = time().'.'.request()->file->getClientOriginalExtension();
             request()->file->move('uploads/deals', $filename);
             $deals->deals_image='deals/'.$filename;   
        }

        $deals->save();
        if ($deals) {
            Session::flash('message', "Record has been added successfully.");
            return redirect('admin/deals');
        } else {
            return redirect('admin/deals')->withErrors('There is a error in adding new record.');
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $categories = Category::where('parent_id','=',0)->get();
        $currency=DB::table('currency')->get();
        $places = Places::whereRaw('id',$id)->get();
//        echo '<pre>';
//        print_r($places);
//        exit;

        $deals = Deals::find($id);
//        echo '<pre>';
//        print_r($deals);
//        exit;
        if (!empty($deals)) {
            $cat_code = Category::where('id', $deals->category_id)->first();
            if ($cat_code->code == "PLC" || $cat_code->code == "ACT") {
                $result = Places::select('place_name as name', 'id')->get();

            }/* elseif ($cat_code->code == "RST") {
                $result = Restaurants::select('restaurant_name as name', 'id')->get();

            } else {
                $result = Hotel::select('hotel_name as name', 'id')->get();
            }*/
        }

        return view('admin/deals/edit_form', compact('result','deals',  'categories','places','currency','edit_deals'));
    }
    public function update(Request $request, $id)
    {
        $deals = Deals::find($id);
        $validator = $this->validator($request->all(), [
            'category_name' => 'required',
            'place_id' => 'required',
            'deal_name' => 'required',
            'discount_price' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'description' => 'required',
        ])->validate();

        $deals->category_id = $request->category_name;
        $deals->instant_id = $request->place_id;
        $deals->deals_title = $request->deal_name;
        $deals->discount_price = $request->discount_price;
        $deals->valid_from = $request->valid_from;
        $deals->valid_to = $request->valid_to;
        $deals->description = $request->description;
        $deals->status = 'Active';
        /*if($request->file){
            $deals->deals_image = $request->file->store('deals');
        }*/
        if($request->file)
        {
            $image  = $request->file;
           
             $filename = time().'.'.request()->file->getClientOriginalExtension();
             request()->file->move('uploads/deals', $filename);
             $deals->deals_image='deals/'.$filename;   
        }
        $deals->save();
        if ($deals) {
            Session::flash('message', "Record has been updated successfully.");
            return redirect('admin/deals');
            //return redirect('admin')->withErrors('signup','You are signup successfully');
        } else {
            return redirect('admin/deals')->withErrors('There is a error in updating record.');
        }
    }

    public function destroy($id)
    {
        $data = Deals::find($id);
        $data->delete();
        Session::flash('message', "Record has been deleted successfully.");
        return redirect('admin/deals');
    }
///////////////////////////////// status  /////////////////////
    public function status (Request $request)
    {
        $deals = Deals::find($request->id);
        echo Functions::status($deals,$request->status,$request->id);
    }
    /////////////////////// bulk operation //////////////
/*    public function bulk_operation(Request $request)
    {
        $validator = Functions::validator($request->all(), [
            'bulk_action' => 'required',
            'all_id' => 'required',
        ])->validate();

        $id_list = explode(',', $request->all_id);
        if ($request->bulk_action != 'Delete') {
            foreach ($id_list as $row) {
                $deals = Deals::find($row);
                if ($deals) {
                    $deals->status = $request->bulk_action;
                    $deals->save();
                } else {
                    return redirect('admin/deals')->withErrors('There is a error in action perform.');
                };
            }
        } else {
            foreach ($id_list as $row) {
                $data = Deals::find($row);
                $data->delete();
            }
        }
        Session::flash('message', "Your action has been performed successfully.");
        return redirect('admin/deals');
    }*/
////////////////////// Get places , hotel , Restaurants ///////////////////////
    public function get_places($id)
    {
        //echo 'xzczxczczx'; exit;
        $category_id =$id;

        if ($category_id == 1 ) {
            $places = Places::select('place_name','id')
                ->where('category_id', '=', $category_id);
              //DB::enableQueryLog();
            $places = $places->get();
            // dd(DB::getQueryLog());
            //dd($places);
            foreach ($places as $row) {
                $places .= "<option value='$row->id'>$row->place_name</option>";
            }
            echo $places;
        }elseif($category_id == 2)
        {
            $restaurants = Restaurants::select('restaurant_name','restaurants.id as id')
                ->where('restaurants.category_id', '=', $category_id);
            $restaurants = $restaurants->get();
            //dd($places);
            foreach ($restaurants as $row) {
                $restaurants .= "<option value='$row->id'>$row->restaurant_name</option>";
            }
            echo $restaurants;
        }
        else{
            $hotel = Hotel::select('hotel_name','id')->where('category_id', '=', $category_id);
            $hotel = $hotel->get();
            foreach ($hotel as $row) {
                $hotel .= "<option value='$row->id'>$row->hotel_name</option>";
            }
            echo $hotel;
        }
    }
    public function dealsListing()

    {
        $items = Deals::orderBy('updated_at','DESC')->get();
        $currentRoute = str_replace('admin.', '', \Request::route()->getName());

        return DataTables::of($items)->addColumn('actions', function ($items) use ($currentRoute) {
$edit=' <a href="'.url('deals/'.$items->id.'/edit') . '" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
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
        })
            ->editColumn('created_at', function ($items) {
                return $items->created_at->format('d-m-Y');
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
            ->rawColumns(['status', 'actions', 'id'])->make(true);
    }
}
