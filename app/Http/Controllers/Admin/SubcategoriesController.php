<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;
use App\Classes\Functions;

class SubCategoriesController extends Controller
{
     public function __construct()
    {
       $this->middleware('auth');
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

      $categories = Category::whereRaw('parent_id = 0')->get();
        $perPage = 10;
        $items= DB::table('categories as c')
            ->select('s.id as id', 'c.cat_name as cat_name', 's.cat_name as sub_cat_name','s.code as code',
                's.cat_image as cat_image', 's.status as status','s.order_no as order_no', 's.created_at as created_at')
            ->join('categories AS s', 'c.id', '=', 's.parent_id')->whereNull('s.deleted_at')
            ->orderBy('order_no','asc')->take($perPage)->get();
           

        // $item = Category::take($perPage)->where('parent_id','>','0')->get();
        $total = Category::count();
        $currentRoute = 'admin::subcategories';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'category_id'=> 0,
            'modelInstance' => '\App\Models\Category',
        ];
        return view("admin.subcategories.datatables", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(0);
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
        if ($request->has('id')) {
            return $this->update($request, 0);
        } else {
            return $this->index();
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
        $args['record'] = Category::find($id);

        return view("admin.categories._single", $args);
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
        $user = Category::find($id);
        $categories = Category::where('parent_id','=','0')->get();


        $args['isNew'] = empty($id);

        // if user exists, in case of edit || creating new user
        if ($user || $args['isNew']) {

            $currentUser = auth()->user();

            /** redirect if trying to edit to user 1, if logged in user is not 1*/
            /*if ($id == 1 && $currentUser->id !== 1) {
                return redirect('categories');
            }*/

            $args['item'] = $args['isNew'] ? [] : $user;
            $args['active'] = $args['isNew'] ? 1 : $user->active;

            //$args['groups'] = Role::all()->pluck('name', 'id')->toArray();
            return view("admin.subcategories._form", $args,compact('categories'));
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
        $data = $request->all();
        $additionalCheck = [];

        $request->validate([
            'cat_name' => 'required',
            'code' => 'required',
            'order_no' => 'required',
        ]);

        $object = (empty($id)) ? new Category() : Category::find($id);
        $object->cat_name = $data['cat_name'];
        $object->code = $data['code'];
        $cat_slug = Functions::slug($request->slug,$request->cat_name,$object,$id);
        $object->slug = $cat_slug;
        $object->parent_id = $data['parent_id'];;
        $object->order_no = $data['order_no'];
        $object->status = 'Active';
        $object->created_by = Auth::id();
      if($request->file)
        {
            $image  = $request->file;
           
             $filename = time().'.'.request()->file->getClientOriginalExtension();
             request()->file->move('uploads/subcategories', $filename);
             $object->cat_image='subcategories/'.$filename;   
        }
 /*if (!empty($request->file)) {
        $filename = $request->file->getClientOriginalName();
        $object->cat_image = $request->file->storeAs(
            'subcategories', rand() . '_' . $filename
        );
      
    }else{
//            echo 'hi';exit;
            $object->cat_image = "NULL";
        }*/


        $object->save();

        if (empty($id)) {
            custom_flash("Record has been added successfully.", "success");
        } else {
            custom_flash("Record has been updated successfully.", "success");
        }
        return redirect()->back();
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
        Category::destroy($id);
        custom_flash("Record has been deleted successfully.", "success");

        return redirect(getPageUrl('admin::categories.index'));
    }

    public function subcategoriesListing()

    {
        // $items = Category::where('parent_id', '>', 0);

  $items = DB::table('categories as c')
            ->select('s.id as id', 'c.cat_name as cat_name', 's.cat_name as sub_cat_name','s.code as code', 's.cat_image as cat_image', 's.status as status','s.order_no as order_no', 's.created_at as created_at')
            ->join('categories AS s', 'c.id', '=', 's.parent_id')->whereNull('s.deleted_at')
            ->orderBy('created_at','DESC')->get();


        $currentRoute = str_replace('admin.', '', \Request::route()->getName());

        return DataTables::of($items)->addColumn('actions', function ($items) use ($currentRoute) {
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
                $edit='<a href="' . url("admin/subcategories/".$items->id.'/edit').'" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
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
            ->editColumn('created_at', function ($items) {
                return   date('d-m-Y', strtotime($items->created_at));
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
}
