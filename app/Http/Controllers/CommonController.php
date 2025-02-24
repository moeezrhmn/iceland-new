<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use  App\Models\multiKeywords;
use App\Models\Photo;
use App\Models\multiSubcategories;
use App\Models\Address;

class CommonController extends Controller
{
    public function bulkOprations(Request $request)
    {
//        $validator = Functions::validator($request->all(), [
//            'all_id' => 'required',
//            'action_type' => 'required',
//            'model_instance' => 'required',
//        ]);
        $category_id = $request->category_id;
        $modelInstace = $request->model_instance;
        $id_list = explode(',', $request->all_id);

        $table_instance = new $modelInstace();
        if ($request->action_type == 'delete') {
            $table_instance->whereIn('id',$id_list)->delete();

        if($category_id > 0) {
                $multiKeywords = multiKeywords::where('category_id', $category_id)->whereIn('instance_id', $id_list)->delete();

                $Photo = Photo::where('category_id', $category_id)->whereIn('instance_id', $id_list)->delete();
                $multiSubcat = multiSubcategories::where('category_id', $category_id)->whereIn('instance_id', $id_list)->delete();
                $address = Address::where('category_id', $category_id)->whereIn('instant_id', $id_list)->delete();

            }
        } elseif ($request->action_type == 'active') {
            $table_instance->whereIn('id',$id_list)->update(['status' => "Active"]);
        } else {
            $table_instance->whereIn('id',$id_list)->update(['status' => "Inactive"]);
        }
        custom_flash("Operation has been completed successfully.", "success");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $model = $request->model_instance;
        $category_id = $request->category_id;
        $area = $model::find($request->id);
        $data = [];

        if ($area) {
            $delete = $area->delete();

            if($category_id > 0) {
                $multiKeywords = multiKeywords::where('category_id', $category_id)->where('instance_id', $request->id)->delete();

                $Photo = Photo::where('category_id', $category_id)->where('instance_id', $request->id)->delete();
                $multiSubcategories = multiSubcategories::where('category_id', $category_id)->where('instance_id', $request->id)->delete();
                $address = Address::where('category_id', $category_id)->where('instant_id', $request->id)->delete();
                //$deletedRows = App\Flight::where('active', 0)->delete();
            }

            if ($delete) {
                $data['status'] = 'success';
                $data['message'] = 'Area Deleted Successfully';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Oops! An error occured try again later';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'The area not found in the database please Refresh the Page';
        }

        return $data;
    }

    public function update_status(Request $request)
    {

 
        $model = $request->model_instance;

        $item = $model::find($request->id);

        $data = [];
        if (!empty($item)) {

            if($item->status == 'Active') {
                   // echo 'active';exit;
                $item->update(['status'=>'Inactive']);
            }else{
                // echo 'Inactive dfsdfds';exit;
                $item->update(['status'=>'Active']);
            }
       

            if ($item) {
                $data['status'] = 'success';
                $data['message'] = 'Status update Successfully';
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Oops! An error occured try again later';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'The area not found in the database please Refresh the Page';
        }

        return $data;
    }
}
