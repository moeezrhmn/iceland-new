<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use JmesPath\Parser;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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
            'per_page' => 20,
            'search' => '',
            'orderBy' => 'id',
            'order' => 'asc',
        ], $args, [

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 10;
        $items = User::where('user_type', '=', 'user')->orWhere('user_type', '=', 'news_letter')->take($perPage)->orderBy('name', 'asc')->get();
        $total = User::count();
        $currentRoute = 'admin::users';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => '\App\User',
        ];
        return view("admin.users.datatables", $viewData);
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
        if (Input::has('id')) {
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

        $args['record'] = User::find($id);

        return view("users._single", $args);
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
        $user = User::find($id);


        $args['isNew'] = empty($id);

        // if user exists, in case of edit || creating new user
        if ($user || $args['isNew']) {

            $currentUser = auth()->user();

            /** redirect if trying to edit to user 1, if logged in user is not 1*/
            if ($id == 1 && $currentUser->id !== 1) {
                return redirect('users');
            }

            $args['item'] = $args['isNew'] ? [] : $user;
            $args['active'] = $args['isNew'] ? 1 : $user->active;

            //$args['groups'] = Role::all()->pluck('name', 'id')->toArray();
            return view("admin.users._form", $args);
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

        $data = Input::all();
        $additionalCheck = [];
        if (empty($id) || !empty($request->password)) {
            $additionalCheck['password'] = 'required|min:6';
            if (empty($id))
                $additionalCheck['email'] = 'required|email|max:255|unique:users';
        } else {
            $additionalCheck['email'] = 'unique:users,email,' . $id;
        }
        $this->validate($request, array_merge([
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
        ], $additionalCheck));

        $object = (empty($id)) ? new User() : User::find($id);
        $object->email = $data['email'];
        $object->first_name = $data['first_name'];
         $object->last_name = $data['last_name'];
        $object->status = 'Active';
        // $object->user_photo = $data['user_photo']; 
 if($request->file)
        {
            $image  = $request->file;
           /* $object->user_photo = $request->file->storeAs(
                'users_photo',rand().'_'.$filename
            );*/

             $filename = time().'.'.request()->file->getClientOriginalExtension();
             request()->file->move('uploads/users_photo', $filename);
             $object->user_photo='users_photo/'.$filename;   
        }

        if (!empty($data['password'])) {
            $object->password = Hash::make($data['password']);
        }
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
        User::destroy($id);
        custom_flash("User has been deleted successfully.", "success");

        return redirect(getPageUrl('admin::users.index'));
    }

    public function users_lisitng()

    {
        $items = User::where('user_type', '=', 'user')->orWhere('user_type', '=', 'news_letter')->orderBy('updated_at','DESC')->get();
        $currentRoute = str_replace('users.', '', \Request::route()->getName());

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
                $edit=' <a href="' . url("admin/users/".$items->id.'/edit').'" class="m-portlet__nav-link btn m-btn btn-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
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
        })
        ->editColumn('status', function ($items) {
            if ($items->status == "Active") {
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
             ->editColumn('name', function ($items) {
                return $items->first_name . ' '.$items->last_name ;
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
