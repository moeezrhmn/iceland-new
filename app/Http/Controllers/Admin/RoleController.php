<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
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
        $perPage = 10;
        $items = Role::take($perPage)->orderBy('id', 'DESC')->get();
        $total = Role::count();
        $currentRoute = 'admin::role';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => 'App\Models\Role',
        ];
        return view("admin.role.datatable", $viewData);
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
     * @param  \App\Models\Role $Role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $Role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $Role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles_permissions = array();
        $user = Role::find($id);
        $roles_permissions1 = DB::table('role_has_permissions')->where('role_id', $id)->get();
        $allPermissions = Permission::all();
        $permissionTypes = [];
        foreach ($allPermissions as $permission) {
            if (!empty($permission->type)) {
                $permissionTypes[$permission->type][] = $permission;
            }
        }
        if (sizeof($roles_permissions1) > 0) {
            foreach ($roles_permissions1 as $obj) {
                $roles_permissions[] = $obj->permission_id;
            }
        }
        $args['isNew'] = empty($id);
        // if user exists, in case of edit || creating new user
        if ($user || $args['isNew']) {
            $currentUser = auth()->user();
            /** redirect if trying to edit to user 1, if logged in user is not 1*/
            if ($id == 1 && $currentUser->id !== 1) {
                return redirect('role');
            }
            $args['item'] = $args['isNew'] ? [] : $user;

            //$args['groups'] = Role::all()->pluck('name', 'id')->toArray();
            return view("admin.role._form", $args, compact('permissionTypes', 'roles_permissions', 'permissions'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Role $Role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $data = Input::all();
        $additionalCheck = [];
  if (!empty($id)) {
              $this->validate($request, array_merge([
            'name' => 'required',
        ], $additionalCheck));
        }else{
             $this->validate($request, array_merge([
            'name' => 'required|unique:roles,name',
        ], $additionalCheck));
        }


    
        $object = (empty($id)) ? new Role() : Role::find($id);
        $object->name = $data['name'];
        $object->guard_name = 'web';
        $object->save();

        $permissions = $request->permissions;

        if ( !empty( $permissions ) ) {
            $object->syncPermissions( $permissions );
        }
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
     * @param  \App\Models\Role $Role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        custom_flash("Record has been deleted successfully.", "success");

        return redirect(getPageUrl('admin::role.index'));
    }

    public function apirole()

    {
        $items = Role::where('id', '>', '0');
        $currentRoute = str_replace('api.', '', \Request::route()->getName());

        return DataTables::of($items)->addColumn('actions', function ($items) use ($currentRoute) {

            return '<span style="overflow: visible; width: 150px;">
	                    <a href="' . getPageUrl("{$currentRoute}.edit", [$items->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">
                            <i class="la la-edit"></i>
	                    </a>
                        <a data-id="' . $items->id . '" href="javascript:void(0)"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                                   <div class="dropdown ">
                            
                           
                        </div>
                                                </span>
					';
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
}
