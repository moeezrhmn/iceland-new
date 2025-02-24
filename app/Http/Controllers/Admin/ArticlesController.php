<?php

namespace App\Http\Controllers\Admin;

use App\Models\Keyword;
use App\Models\multiKeywords;
use App\Models\Places;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;
use App\Models\Photo;
use App\Models\Flights;
use App\Classes\Functions;
use App\Models\Articles;
use PDF;
use Session;
use URL;
use Excel;


class ArticlesController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function __construct(Request $req)
{
    
    //$this->middleware('auth');
     $this->cat_detail = Category::where('code', '=', 'ART')->first();
    /// $this->act_cat_detail = Category::where('code', '=', 'ACT')->first();

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

    $perPage = 10;
    $items = Articles::take($perPage)->orderBy('created_at','DESC')->get();

    $total = Articles::count();
    $currentRoute = 'admin::users';

    $viewData = [
        'items' => $items,
        'total' => $total,
        'currentRoute' => $currentRoute,
        'perPage' => $perPage,
        'modelInstance' => '\App\Models\Articles',
    ];
    return view("admin.articles.datatables", $viewData);
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    $keywords=Keyword::where('category_id',4)->get();

    return view('admin/articles/_form',compact('keywords'));
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

    $validator = Functions::validator($request->all(), [
        'title' => 'required',
//        'short_des' => 'required',
        'description' => 'required',

    ]);
    if ($validator->fails()) {
        return redirect('admin/articles/create')->withErrors($validator)->withInput();
    }

    ///////////////////////creating Articles//////////////////////

    $model_obj = new Articles();
    //$formData = $request->all();


        $formData['created_by'] = Auth::id();
        $formData['title'] = $request->title;
        $formData['short_des'] = $request->short_des;
        $formData['publish_by'] = $request->publish_by;
        $formData['publish_on'] = $request->publish_on;
        $formData['order_no'] = $request->order_no;
        $formData['slug'] = $request->slug;
        $formData['description'] = $request->description;
        $formData['status'] = 'Active';

        $result = Articles::create($formData);

    if ($result && $request->keyword) {
        foreach ($request->keyword as $key => $keyword) {
            $formDataKeyword['created_by'] = Auth::id();
            $formDataKeyword['instance_id'] = $result->id;
            $formDataKeyword['category_id'] = '4';
            $formDataKeyword['keyword_id'] = $keyword[$key];
            $result2 = multiKeywords::create($formDataKeyword);

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

            $destinationPath = 'uploads/articles/';
            $filename = $fileName->getClientOriginalName();
            $fileName->move($destinationPath, $filename);
            //  $content->photo = $filename;

            // $img = Functions::make_thumb($path);
            $data = Photo::create([
                'photo' => 'articles/' . $filename,
                'instance_id' => $result->id,
                'category_id' => '4',
                'main' => $main_image
            ]);
        }
        custom_flash("Record has been added successfully.", "success");
        return redirect('admin/articles');
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

    $edit_place = Articles::where('id', $id)->with('keywords')->first();
    $keywords=Keyword::where('category_id',4)->get();
    //dd($edit_place);
    if ($edit_place) {

        $photo = Photo::where('instance_id', $edit_place->id)->where('category_id', '4')->get();

        return view('admin/articles/_form_edit', compact('edit_place', 'photo','keywords'));
    } else {
        return redirect('admin/articles')->withErrors('Record not found');
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
        'title' => 'required',
//        'short_des' => 'required',
//            'track_id' => 'required|unique:places,track_id,' . $id,
        //'ssn' => 'required|unique:places,ssn,' . $id,
        /* 'order_no' => 'required', */
//            'description' => 'required',
    ])->validate();

    $result = Articles::find($id);


    if ($result) {

        $result->created_by = Auth::id();
        $result->title = $request->title;
        $result->short_des = $request->short_des;
        $result->publish_by = $request->publish_by;
        $result->publish_on = $request->publish_on;
        $result->order_no = $request->order_no;
        $result->slug = $request->slug;
        $result->description = $request->description;
        $result->status = 'Active';

        $result->update();

        //////////////////////creating keywords//////////////////
        $data = multiKeywords::where('instance_id', $id)->where('category_id', '4')->delete();
        if (!empty($request->keyword) && isset($request->keyword)) {
            foreach ($request->keyword as $keyword) {
                $data = multiKeywords::create([
                    'instance_id' => $result->id,
                    'keyword_id' => $keyword,
                    'category_id' => '4',
                    'created_by' => Auth::id()
                ]);
            }
        }

        ///////////////////////creating image///////////////////////
        if ($result && $request->file) {
            foreach ($request->file as $fileName) {
                Photo::where('instance_id', $id)->update(['main' => 0]);
                Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
                $filename = $fileName->getClientOriginalName();
                if ($request->main_image == $filename) {
                    $main_image = 1;
                } else {
                    $main_image = 0;
                }
                /*                    $path = $fileName->storeAs(
                                        '/articles', rand(0, 100) . '_' . $filename
                                    );
                                  */
                $destinationPath = 'uploads/articles/';
                $filename = $fileName->getClientOriginalName();
                $fileName->move($destinationPath, $filename);

                $data = Photo::create([
                    'photo' => 'articles/' . $filename,
                    'category_id' => '4',
                    'instance_id' => $id,
                    'main' => $main_image
                ]);
            }
        }
        Photo::where('instance_id', $id)->update(['main' => 0]);
        Photo::where('photo_id', $request->main_image)->update(['main' => 1]);
        Session::flash('message', "Record has been updated successfully.");
        return redirect('admin/articles');
    } else {
        return redirect('admin/articles' . $id . '/edit')->withErrors('There is a error in updating record.');
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
public function remove_image(Request $request, $id)
{

    echo $result = Functions::image_remove($id);
}
public function articles_listing()

{
$items = Articles::orderBy('created_at','DESC')->get();
$currentRoute = str_replace('Articles.', '', \Request::route()->getName());
//dd($items);
return DataTables::of($items)
    ->addColumn('actions', function ($items) use ($currentRoute) {
        $edit = '  <a href="' . url("admin/articles/" . $items->id . '/edit') . '" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
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
                })->editColumn('status', function ($items) {
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

            ->editColumn('short_des', function ($items) {
                if (strlen($items->short_des) > 50) {
                    $trimstring = substr($items->short_des, 0, 50) . ' ....';
                } else {
                    $trimstring = $items->short_des;
                }
                return $trimstring;
            })
        ->editColumn('created_at', function ($items) {
        return $items->created_at->format('d-m-Y');
        })
        ->editColumn('id', function ($items) {
        return '<span>
                                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                    <input name="id[]" class="bulk-opration" type="checkbox" value="' . $items->id . '">
                                    <span></span>
                                </label>
                            </span>';
        })->rawColumns(['status', 'actions', 'id'])->make(true);
        }

public function import_excel()
{
return view('admin.places.import_places');
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
}
}
);
}
if (Input::get('subcat_id')) {
$places->whereHas(
'subCategories_edit', function ($query) {
$query->Where('category_id', '=', $this->cat_detail->id);
if (Input::get('subcat_id')) {
$query->Where("subcategory_id", "=", Input::get('subcat_id'));
}
}
);
}
if (Input::get('action_type')) {
$places->Where("places.status", "=", Input::get('action_type'));
}
///  DB::enableQueryLog();
$places = $places->get();
// dd(DB::getQueryLog());
//dd($places);


if (sizeof($places)) {
$j = 0;
foreach ($places as $obj) {
//  dd($obj->photo);
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
$keywords = implode(',', $data2);
}
$data3 = array();
if (sizeof($obj->photo)) {
$i = 1;
foreach ($obj->photo as $photo_obj) {
$data3['image' . $i] = $photo_obj->photo;
$i++;
}
// $images = implode(',', $data);
}
$data[] = array(
'track_id' => $obj->track_id,
'SSN' => $obj->ssn,
'category_id' => $obj->category_id,
'place_name' => $obj->place_name,
'slug' => $obj->slug,
'order_no' => $obj->order_no,
'stars' => $obj->stars,
'phone' => $obj->phone,
'is_featured' => $obj->is_featured,
'website_url' => $obj->website_url,
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
//'images' => @$images,
'excerpt' => $obj->excerpt,
'description' => $obj->description,
);
$keywords = '';
$subcategories = "";
$images = "";
$data_test[] = array_merge($data[$j], $data3);
$j++;
}


Excel::create('Places Listing', function ($excel) use ($data_test) {
// Set the title
$excel->setTitle('excelsheet for listing places');
// Chain the setters
$excel->setCreator('VisitAnyCity')
->setCompany('digicom-solutions.com');
$excel->sheet('Places Detail', function ($sheet) use ($data_test) {
$sheet->fromArray($data_test);
});
})->export('xls');
} else {
return redirect('admin/places');
}
}
}
