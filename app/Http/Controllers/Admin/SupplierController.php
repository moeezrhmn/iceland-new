<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Supplier;

class SupplierController extends Controller
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
        $items = Supplier::take($perPage)->orderBy('supplier_name', 'asc')->get();
        $total = Supplier::count();
        $currentRoute = 'admin::Supplier';
        $viewData = [
            'items' => $items,
            'total' => $total,
            'currentRoute' => $currentRoute,
            'perPage' => $perPage,
            'modelInstance' => '\App\Models\Supplier',
        ];
        return view("admin.supplier.datatables", $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        }

    public function supplier_listing()
    {
        $items = Supplier::all();
        $currentRoute = str_replace('suppliers.', '', \Request::route()->getName());

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
            return '<div id="status_div_'.$items->id.'" class="status_div">'.$cond.
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
