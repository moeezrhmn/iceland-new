<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\EmailTemplates;
use App\Models\Category;
use App\Models\Newsletter;
use App\Classes\Functions;
use Session;
use DB;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\signUp;
use Yajra\DataTables\DataTables;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
         $this->middleware('auth');
      /*  $this->middleware(function ($request, $next) {
            if(empty(Auth::user()->can('email-template-listing')))
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
    

       $perPage = 10;
        $items = EmailTemplates::take($perPage)->get();
        $total = EmailTemplates::count();
        $currentRoute = 'admin::deals';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => '\App\Models\EmailTemplates',
        ];
        return view("admin.emailTemplates.datatables", $viewData);


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        return view('admin/emailTemplates/create_form', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=   Functions::validator($request->all(), [
            'template_name' => 'required',
            'template_subject' => 'required',
//            'category_id' => 'required',
            'description' => 'required',
            'template_type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/emailTemplates/create')->withErrors($validator)->withInput();
        }
        ///////////////////////creating place//////////////////////
        $formData = $request->all();
   
        $formData['created_by'] = Auth::id();
        $result = EmailTemplates::create($formData);
        if ($result) {
            if(!empty($request->send_email))
            {
                foreach ($request->send_email as $obj)
                {
                    if($obj == "all_supplier")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','restaurants')
                            ->orwhere('user_type','hotels')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }elseif ($obj =="restaurant")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','restaurant')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }elseif ($obj =="hotel")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','hotel')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }
                    elseif ($obj =="site_users")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','user')->get();
//                        echo "<pre>";
//                        print_r($users);
//                        exit;
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }elseif ($obj =="newsletter")
                    {
                        $users = newsletter::where('is_sub','1')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }
                }
            }
            Session::flash('message', "Record has been added successfully.");
            return redirect('admin/email-templates');
        } else {
            return redirect('admin/email-templates')->withErrors('There is a error in adding new record.');
        }
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $emailtemplates = EmailTemplates::find($id);
  
        if ($emailtemplates) {
            $categories = Category::where('parent_id', 0)->get();
               return view('admin/emailTemplates/edit_form', compact('emailtemplates','categories'));
        }else{
            return redirect('admin/email-templates')->withErrors('Record not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Functions::validator($request->all(), [
            'template_name' => 'required',
            'template_subject' => 'required',
//            'category_id' => 'required',
            'description' => 'required',
            'template_type' => 'required',
        ])->validate();
        ///////////////////////creating place//////////////////////
        $result = EmailTemplates::find($id);
        if ($result) {
            $formData = $request->all();
            $formData['created_by'] = Auth::user()->user_id;
            $result->update($formData);
            if(sizeof($request->send_email))
            {
                foreach ($request->send_email as $obj)
                {
                    if($obj == "all_supplier")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','restaurants')
                            ->orwhere('user_type','hotels')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }elseif ($obj =="restaurant")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','restaurant')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }elseif ($obj =="hotel")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','hotel')->get();
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }
                    }
                    elseif ($obj =="site_users")
                    {
                        $users = User::select('email','user_type')->where('status','Active')
                            ->where('user_type','user')->get();
//                        echo "<pre>";
//                        print_r($users);
//                        exit;
                        foreach ($users as $user)
                        {
                            Mail::to($user)->send(new signUp($result,$user));
                        }

                    }
                }
            }
            Session::flash('message', "Record has been updated successfully.");
            return redirect('admin/emailTemplates');
        } else {
            return redirect('admin/emailTemplates')->withErrors('There is a error in updating record.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = EmailTemplates::find($id);
        $data->delete();
        Session::flash('message', "Record has been deleted successfully.");
        return redirect('admin/emailTemplates');
    }
    public function status(Request $request)
    {
        $place = EmailTemplates::find($request->id);
        echo Functions::status($place, $request->status, $request->id);
    }
    public function email(){
        return view('admin/emailTemplates/email');
    }

       public function email_templates_listing()

    {
        $items = EmailTemplates::all();
        $currentRoute = str_replace('admin.', '', \Request::route()->getName());

        return DataTables::of($items)->addColumn('actions', function ($items) use ($currentRoute) {



            return '<span style="overflow: visible; width: 150px;">
                        <a href="'.url('email-templates/'.$items->id.'/edit') . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i>
                        </a>
                        <a data-id="' . $items->id . '" href="javascript:void(0)"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                                                 <div class="dropdown ">
                            <a href="" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                               data-toggle="dropdown">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="' . $items->id . '" class="dropdown-item status-update" href="javascript:void(0)">
                                    Update Status
                                </a>
                            </div>
                        </div>
                              
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
