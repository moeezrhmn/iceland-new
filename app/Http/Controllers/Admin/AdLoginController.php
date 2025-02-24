<?php

namespace App\Http\Controllers\Admin;

use App\Mail\signUp;
use App\Models\Country;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Session;
use DB;
use App\Models\EmailTemplates;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

//use App\Http\Requests;

class AdLoginController extends Controller {

    public function __construct() {
    }

    public function index() {
        
        if(Auth::user())
        {
            return redirect('admin/dashboard');
        }
        $data = array(
            'title' => 'Login'
        );

        return view("admin/auth/login", $data);
    }
    public function login(){

    }
    protected function validator($request, $rules) {
        return $validator = Validator::make($request, $rules);
        //return $validator->errors()->all();
    }

    public function auth(Request $request) {
      //  dd($request->all());
        $validator = $this->validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin')->withErrors($validator);
        }
        $email = $request->email;
        $password = $request->password;

        // echo DB::enableQueryLog();
        $user = User::where('email',$email)->where('status','Active')->where('user_type','!=',"user")->first();
        if($user)
        {
            if (Hash::check($password, $user->password))
            {
                Auth::loginUsingId($user->user_id);
                return redirect()->intended('admin/dashboard');
            } else {
                return redirect('admin')->withErrors('These credentials do not match our records.');
            }
        }
        else{
            return redirect('admin')->withErrors('These credentials do not match our records.');
        }
    }
    public function signup(){
        return view('admin/auth/register');
    }
    
    public function test() {
        $user = User::find(1);
     if ($user) {
            $signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
            $setting_result = Setting::find(1);
            //dd(config('mail')); 
            Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));
         // echo 'ffff';
          Session::flash('message', "Confirm your email to logged in. ");
          return redirect('admin/signup');
        } 
    }
    
    protected function register(Request $request) {
        
        $this->validator($request->all(), [
          //  'email' => 'required|email|max:255|unique:users,email,NULL,user_id,deleted_at,NULL',
          //  'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
           //'' 'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
          // 'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
        ])->validate();
        $formData = $request->all();
        $formData['password'] = Hash::make($request->password);
        $formData['api_token'] = str_random(60);
        $user = User::create($formData);
        Auth::loginUsingId($user->id);
        if ($user) {
           // $signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
           // $setting_result = Setting::find(1);
           // dd(config('mail')); 
          // Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));
          
            Session::flash('message', "Confirm your email to logged in. ");
            return redirect('admin/administrator');
        } else {
            Session::flash('signup', "1");
            return redirect('admin/signup')->withErrors('Error in signup try again!');
        }
    }
    protected function account_setup($code) {
        $user = User::where('api_token',$code)->where('status','Inactive')->first();
        $country = Country::all();
        if (sizeof($user)) {
            $id = $user->user_id;
            return view('admin/auth/register_detail',compact('id','country'));
        } else {
            return redirect('admin')->withErrors('Error in signup try again!');
        }
    }
    protected function store_register(Request $request ,$id) {
         $this->validator($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'country_code' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required|max:255',
            'phone_no' => 'required|numeric',
        ])->validate();
        $user = User::find($id);
        if ($user) {
            $user->user_type = $request->user_type;
            ////////////////assign role to user
            if($request->user_type == "restaurant")
            {
               $role= Role::where('name','restaurant-supplier')->first();
                if(!empty($role))
                {
                    $user->attachRole($role);
                }
            }elseif($request->user_type == "hotel")
            {
                $role= Role::where('name','hotel-supplier')->first();
                if(!empty($role))
                {
                    $user->attachRole($role);
                }
            }
            else
            {
                $role= Role::where('name','car-supplier')->first();
                if(!empty($role))
                {
                    $user->attachRole($role);
                }
            }
            $formData = $request->all();
            if($formData['user_type']=='hotel' || $formData['user_type']=='restaurant' || $formData['user_type']=='car') {
                $formData['status'] = 'Active';
                $user->update($formData);
                Session::flash('message', "You are signup successfully");
                Auth::loginUsingId($id);
                return redirect('admin/administrator');
            }
            else{
                return redirect('admin')->withErrors('Invalid buisness type');
            }
        } else {
            return redirect('admin')->withErrors('Error in signup try again!');
        }
    }
    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->intended('admin');
    }
}
