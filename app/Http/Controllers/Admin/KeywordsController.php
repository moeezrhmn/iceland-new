<?php

namespace App\Http\Controllers\Admin;


use App\Models\multiKeywords;
use App\Models\multiSubcategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Keyword;
use App\Classes\Functions;
use DB;
use Session;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;

class KeywordsController extends Controller {
 public function __construct() {
        $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //     if(empty(Auth::user()->can('keyword-listing')))
        //     {
        //         return redirect('admin/dashboard');
        //     }
        //     return $next($request);
        // });
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
        $items = Keyword::with('single_category')->take($perPage)->orderBy('id', 'DESC')->get();

        $total = Keyword::count();
        $currentRoute = 'admin::Keyword';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => 'App\Models\Keyword',
        ];
        return view("admin.keywords.datatable", $viewData);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Input::has('id')) {
            //echo 'id'; exit;
            return $this->update($request, 0);
        } else {
            //echo 'no id'; exit;
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $Permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=Category::where('parent_id','=','0')->where('status','Active')->get();
         $user = Keyword::find($id);
        if (!empty($id)) {
        
             $keywordsCat=Category::find($user->category_id);
        }
      
  
        $args['isNew'] = empty($id);

        // if user exists, in case of edit || creating new user
        if ($user || $args['isNew']) {
            if ($id == 1 && $currentUser->id !== 1) {
                return redirect('keywords');
            }


            $args['item'] = $args['isNew'] ? [] : $user;
            $args['active'] = $args['isNew'] ? 1 : $user->active;

            //$args['groups'] = Role::all()->pluck('name', 'id')->toArray();
            return view("admin.keywords._form", $args,compact('categories'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Input::all();

        $additionalCheck = [];
        $this->validate($request, array_merge([
            'keyword_name' => 'required',
        ], $additionalCheck));

        $object = (empty($id)) ? new Keyword() : Keyword::find($id);
        $object->keyword_name = $data['keyword_name'];
        $object->category_id = $data['category_id'];
        $object->slug =Functions::slug($request->keyword_name, $request->keyword_name, $object);
         $object->created_by = Auth::id();
    
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
     * @param  \App\Models\Permission  $Permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Keyword::destroy($id);
        custom_flash("Record has been deleted successfully.", "success");

        return redirect(getPageUrl('admin::keywords.index'));
    }
    public function keyword_listing()
    {

        $items = Keyword::with('single_category')->orderBy('updated_at', 'DESC')->get();
        $currentRoute = str_replace('admin.', '', \Request::route()->getName());
//dump($items->single_category);

        return DataTables::of($items)->addColumn('actions', function ($items) use ($currentRoute) {
 $cond = '<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Active"
                title = "Inactive" class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill status-update">
               <i class="fa fa-times" ></i></a>';

                if($items->status=="Active") {
                    $cond='<a href = "javascript:void(0);" data-id="' . $items->id . '" data-ng-switch="Inactive"
                title="Active" class="m-portlet__nav-link btn m-btn btn-accent m-btn--icon m-btn--icon-only m-btn--pill status-update" >
                <i class="fa fa-check" > </i></a>';

                }

                $edit='   <a href="' . url("admin/keywords/".$items->id.'/edit').'" class="m-portlet__nav-link btn m-btn btn-metal m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i> </a>';

            return '<div id="status_div_'.$items->id.'" class="status_div">'.$edit.$cond.'</div>
                    <span style="overflow: visible; width: 150px;">
                        <a data-id="' . $items->id . '" href="javascript:void(0)"
                                                   class="m-portlet__nav-link btn m-btn btn-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                   title="Delete"><i class="la la-trash"></i></a> </span>';
                 })
            ->editColumn('created_at', function ($items) {
                return $items->created_at->format('d-m-Y');
            })
            ->editColumn('cat_name', function ($items) {
               // dd($items->single_category->cat_name);
                if($items->single_category)
                return $items->single_category->cat_name;
                else
                    return 'N/A';
            })
            ->editColumn('status', function ($items) {
            if ($items->status == 'Active') {
                return '<span style="width: 110px;"> <span  class="m-badge  m-badge--success m-badge--wide">Active</span> </span>';
            } else {
                return '<span style="width: 110px;"> <span class="m-badge  m-badge--danger m-badge--wide">Inactive</span></span>';
            }
        })
            ->rawColumns(['status', 'actions', 'id'])->make(true);
    }

}
