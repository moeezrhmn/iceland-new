<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatatablesCustomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('custom-datatable/datatables_custom');
    }

    public function form()
    {
        return view('custom-datatable/form-controls');
    }

    public function multicolumnforms()
    {
        return view('custom-datatable/multi-column-forms');
    }

}
