<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Places;
use App\Models\Country;
use App\Models\Restaurants;
use Illuminate\Support\Facades\Storage;
use DB;
class SearchController extends Controller
{
    public function __construct()
    {
             $this->activityCategory = Category::where('id', '=', '3')->first();
    }
      public function searchPage()
    {

       $subcat_place = Category::where('parent_id','1')->orderBy('order_no','ASC')->where('status', 'Active')->get();
        $sub_category = Category::where('parent_id','2')->orderBy('order_no','ASC')->where('status', 'Active')->get();
         $activtySubcategory = Category::where('parent_id','3')->orderBy('order_no','ASC')->where('status', 'Active')->get();

        $ActivityData= Activity::select('activities.id', 'activity_name','price','slug', 'review_rating','duration',
         'excerpt','description','currency','activities.status', 'activities.order_no', 'activities.created_at')
            ->where('status', 'Active')
            ->orderBy('order_no','ASC')
            //->orderBy('updated_at', 'DESC')
           ->with('subCategories_edit')
           ->with([
               'single_photo' => function ($querys) {
                   $querys->select('photo', 'category_id', 'instance_id');
                   $querys->Where('category_id', '=',  $this->activityCategory->id);
//                   $querys->Where('main', '=', 1);
               }])
           ->with([
               'address' => function ($qury) {
                   $qury->select('address_id', 'email', 'address', 'city', 'country', 'instant_id');
                   $qury->Where('category_id', '=',  $this->activityCategory->id);
               }])->where('status','Active')->paginate(15);
        return view("search.index", compact('subcat_place','sub_category','ActivityData','activtySubcategory'));
    }

    ////////////////////////////////     autocomplete name //////////////////////
    public function SearchPlcAutoName(Request $request)
    {
       // echo 'zxz'; exit;
//        echo '<pre>';
// print_r($request->all());
// exit;

   
        $city = Country::selectRaw('countries.name as country_name,cities.name as city_name,cities.id as city_id')->join('cities', 'cities.country_code', '=', 'countries.code')
            ->where('cities.status', 'Active')->where(function ($query) use ($request) {
                $query->where('countries.name', 'LIKE', '%' . $request->term . '%');
                $query->orwhere('cities.name', 'LIKE', '%' . $request->term . '%');
            })->take(5)->get();

        $data_name = Places::select('id', 'place_name')
            ->where('place_name', 'LIKE', '%' . $request->term . '%')
            ->where('category_id', 1)
            ->groupBy('id')
            ->get();
            
 
        if (!empty($city)) {
            foreach ($city as $row) {
                $row_set[] = array(
                    "value" => $row['city_name'] . ', ' . $row['country_name'],
                    'id' => $row["city_id"], 'type' => 'city'
                );
            }
        }
        if (!empty($data_name)) {
            foreach ($data_name as $row) {
                $row_set[] = array("value" => $row['place_name'],
                    "id" => $row['id'], 'type' => 'place'); //build an array
            }
        }
        if (!empty($row_set)) {
            return json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            return json_encode($row_set);
        }

    }
     public function searchRstAutoName(Request $request)
    {

        $city = Country::selectRaw('countries.name as country_name,cities.name as city_name,cities.id as city_id')
            ->join('cities', 'cities.country_code', '=', 'countries.code')
            ->where('cities.status', 'Active')
            ->where(function ($query) use ($request) {
                $query->where('countries.name', 'LIKE', '%' . $request->term . '%');
                 $query->orwhere('cities.name', 'LIKE', '%' . $request->term . '%');
            })->take(5)->get();

        $data_name = Restaurants::select('restaurant_name', 'id')
            ->where('restaurant_name', 'LIKE', '%' . $request->term . '%')
            //  ->where('source','hotel_beds')
            //  ->orWhere('city', 'LIKE', '%' . $request->term . '%')
            ->groupBy('id')->take(5)
            ->get();

        if (!empty($city)) {
            foreach ($city as $row) {
                $row_set[] = array(
                    "value" => $row['city_name'] . ', ' . $row['country_name'],
                    'id' => $row["city_id"], 'type' => 'city'
                );
            }
        }
        if (!empty($data_name)) {
            foreach ($data_name as $row) {
                $row_set[] = array("value" => $row['restaurant_name'],
                    "id" => $row['id'], 'type' => 'restaurant'); //build an array
            }
        }
        if (!empty($row_set)) {
            return json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            return json_encode($row_set);
        }
    }
////// activity name //////
     public function searchActAutoName(Request $request)
    {

        $city = Country::selectRaw('countries.name as country_name,cities.name as city_name,cities.id as city_id')
            ->join('cities', 'cities.country_code', '=', 'countries.code')
            ->where('cities.status', 'Active')
            ->where(function ($query) use ($request) {
                // $query->where('countries.name', 'LIKE', '%' . $request->term . '%');
                 $query->where('cities.name', 'LIKE', '%' . $request->term . '%');
            })->take(5)->get();

        $data_name = activity::select('activity_name', 'id')
            ->where('activity_name', 'LIKE', '%' . $request->term . '%')
            //  ->where('source','hotel_beds')
            //  ->orWhere('city', 'LIKE', '%' . $request->term . '%')
            ->groupBy('id')->take(5)
            ->get();

        if (!empty($city)) {
            foreach ($city as $row) {
                $row_set[] = array(
                    "value" => $row['city_name'] . ', ' . $row['country_name'],
                    'id' => $row["city_id"], 'type' => 'city'
                );
            }
        }
        if (!empty($data_name)) {
            foreach ($data_name as $row) {
                $row_set[] = array("value" => $row['activity_name'],
                    "id" => $row['id'], 'type' => 'activity'); //build an array
            }
        }
        if (!empty($row_set)) {
            return json_encode($row_set); //format the array into json data
        } else {
            $row_set[] = "No records found";
            return json_encode($row_set);
        }
    }


}
