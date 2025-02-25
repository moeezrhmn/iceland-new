<?php

namespace App\Classes;

use App\Models\Keyword;
use App\Models\multiKeywords;
use App\Models\multiSubcategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Places;
use App\Models\Cities;
use App\Models\Restaurants;
use App\Models\Hotel;
use Validator;
use DB;
//use App\Models\CompanyProfile;
use App\Models\Category;
require 'vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Photo;
use App\Models\Reviews;

class Functions
{

    /////////////////////common function/////////////////////////
    public static function validator($request, $rules)
    {
        return $validator = Validator::make($request, $rules);
    }

    public static function slug($slug, $cat_name, $model, $id = false)
    {

        if (!empty($slug)) {
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($cat_name));
        }
        if ($id) {
            //DB::enableQueryLog();
            $exists = $model::where('slug', 'LIKE', '%' . $slug . '%')->where('id', '!=', $id)->get();
            //dd(DB::getQueryLog());
//            $exists =Category::where('slug', 'LIKE', '%'.$slug.'%')->where('id', '!=', $id)->get();
        } else {
//            $exists =Category::where('slug', '=', $slug)->get();
            // DB::enableQueryLog();
            $exists = $model::where('slug', 'LIKE', '%' . $slug . '%')->get();
//            dd(DB::getQueryLog());
//            echo "<pre>";
//            print_r($exists);
//            exit;
        }
        if (sizeof($exists)) {
            $n = rand(1, 1000);
            $exists = count($exists);
            $count = $exists + 1;
            for ($i = 1; $i <= $count; $i++) {
                $cat_slug = $slug . "-" . $i;
            }
            return $cat_slug;
        } else {
            return $cat_slug = $slug;
        }
    }

    ///////////////////////end common function/////////////////
    public static function status($model, $status, $id)
    {
        if ($status == 'Active') {
            $model->status = $status;
            $model->save();
            echo ' <a href="javascript:void(0);" data-ng-switch="Inactive" id="' . $id . '" title="Active"    class="btn green active">
                                    <i class="fa fa-check"></i>
                                </a>';
        } else {
            $model->status = $status;
            $model->save();
            echo '<a href="javascript:void(0);" data-ng-switch="Active" id="' . $id . '" title="inactive"     class="btn btn-warning active">
                                    <i class="fa fa-times"></i>
                                </a>';
        };
    }
    public static function reviewsAvg($id,$rating, $category_id)
    {

        if($category_id==1){
            $model = Restaurants::find($id);

        }elseif ($category_id==2){
            $model = Places::find($id);

        }elseif ($category_id==3){
            $model = Hotel::find($id);

        }
        elseif ($category_id==4){
            $model = Places::find($id);

        }

        if ($model) {
            $modelData['stars'] = $rating;

            $model->update($modelData);
        }
     return   $model->stars;
    }
    
    public static function make_thumb($path)
    {
        $myArray = explode('/', $path);
        $img = Image::make('public/uploads/' . $path)->resize(320, 240)->save('public/uploads/' . $myArray[0] . '/thumb/' . $myArray[1]);
        return $img;
    }

    public static function image_remove($id)
    {
        $data = Photo::find($id);
  
        $data->delete();
        if(file_exists(public_path().'public/uploads/'.$data->photo)) {
           // rename(public_path().'public/uploads/'.$data->photo, public_path().'/uploads/trash/'.$data->photo);
            unlink('public/uploads/' . $data->photo);
        }
        if(file_exists(public_path().'/uploads/thumb/'.$data->photo)) {
            rename(public_path().'/uploads/'.$data->photo, public_path().'/uploads/trash/'.$data->photo);
            //unlink('public/uploads/' . $myArray[0] . '/thumb/' . $myArray[1]);
        }
        return $id;
    }

    public static function create_subcategory($cat_id = false, $cat_name = false)
    {
        $sub_cat = new Category();
        $sub_cat->parent_id = $cat_id;
        $sub_cat->cat_name = $cat_name;
        $sub_cat->code = rand();
        $sub_cat->slug = Functions::slug('', $cat_name, $sub_cat);
        $sub_cat->status = 'Active';
        $sub_cat->created_by = Auth::id();
        $sub_cat->save();
        return $sub_cat->id;
    }

    public static function create_multi_subcat($instance_id = false, $subcat_id = false, $cat_id = false)
    {
        $data = multiSubcategories::create([
            'instance_id' => $instance_id,
            'subcategory_id' => $subcat_id,
            'category_id' => $cat_id,
            'created_by' => Auth::id()
        ]);
        return $data->id;
    }

    public static function create_keyword($cat_id = false, $keyword = false)
    {
        $keywords = new Keyword();
        $keywords->category_id = $cat_id;
        $keywords->keyword_name = trim($keyword);
        $keywords->status = 'Active';
        $keywords->created_by = Auth::id();
        $keywords->save();
        return $keywords->id;
    }

    public static function create_multi_keyword($instance_id = false, $keyword_id = false, $cat_id = false)
    {
        $data = multiKeywords::create([
            'instance_id' => $instance_id,
            'category_id' => $cat_id,
            'keyword_id' => $keyword_id,
            'created_by' => Auth::id()
        ]);
        return $data->id;
    }


    public static function create_multi_images($instance_id = false, $images = false, $cat_id = false, $folder = false,$order_no = false,$image_order = false)
    {
        $implode_img = explode(',', $images);
        foreach ($implode_img as $img_obj1) {
            //$img_obj = explode('.',$img_obj1);
            if (strchr(@$img_obj1, $folder) != false) {

                $img = @$img_obj1;
            } else {
                if(!empty($image_order))
                {
                    $img = $folder . '/' .$order_no.@$img_obj1;
                }
                else{
                    $img = $folder . '/' . @$img_obj1;
                }

            }
            $data = Photo::create([
                'photo' =>$img ,
                'category_id' => $cat_id,
                'instance_id' => $instance_id,
            ]);
        }

        return $data->id;
    }


    public static function json_success($msg = false, $data = false)
    {
        return response()->json(array('status' => true,'date' => date('Y-m-d'),'message' => $msg, 'data' => $data));
    }

    public static function json_error($error = false)
    {
        return response()->json(array('status' => false, 'message' => $error));
    }

    public static function addressToLT($address)
    {
        if (!empty($address)) {
            $result = array();
            $str = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address);
            //$data = json_decode($str);
            //$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=india";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $str);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response);
            if (isset($data->results[0]->address_components)) {
                foreach ($data->results[0]->address_components as $cityobj) {
                    if ($cityobj->types[0] == 'locality') {
                        $result['city'] = $cityobj->long_name;
                    }
                    if ($cityobj->types[0] == 'country') {
                        $result['country'] = $cityobj->short_name;
                    }
                }
            }
            if (isset($data->results[0]->geometry->location)) {
                $result['lat'] = $data->results[0]->geometry->location->lat;
                $result['lng'] = $data->results[0]->geometry->location->lng;
                $result['address'] = $data->results[0]->formatted_address;
                return $result;
            } else {
                return false;
            }
            unset($address);
        } else {
            return false;
        }

    }

    static function curl_operations($url,$headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
       return $result = json_decode($response);
    }

}
