<?php
namespace App\Http\Controllers;
use App\Mail\PasswordReset;
use App\Mail\signUp;
use App\Models\Country;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use DB;
use App\Models\EmailTemplates;
use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller {

    public function __construct() {
      
    }

    public function login(){

    }
    protected function validator($request, $rules) {
        return $validator = Validator::make($request, $rules);
        //return $validator->errors()->all();
    }

    public function loginVerfi(Request $request){
        $email = $request->email;
        $password = $request->password;


        // echo DB::enableQueryLog();
        $user = User::where('email',$email)->where('user_type','!=',"Admin")->first();
if(!empty($user->email)){
    if(Hash::check($password, $user->password)){
        Auth::loginUsingId($user->id);
       // return Redirect::intended();
        echo '';
    }else{
        echo 'your email and password does not match';
    }
}else{
    echo 'Please register first';
}

    }

    public function auth(Request $request) {
       // dd($request->all());
        $validator = $this->validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
           
            return redirect('/')->withErrors($validator,'login');
        }
        $email = $request->email;
        $password = $request->password;
        // echo DB::enableQueryLog();
        $user = User::where('email',$email)->where('user_type','!=',"Admin")->first();

        if($user)
        {
            if (Hash::check($password, $user->password))
            {
               // echo 'yes'; exit;

                 // Auth::login($user);
                Auth::loginUsingId($user->id);
                  return Redirect::intended();
                  // return Redirect::back();
                //Session(['user_id' => $user->id]);
              //  dd('loginss');
                return redirect('home');
               // return redirect()->intended('succes');

            } else {
              //  echo 'no'; exit;;
                return redirect('/')->withErrors('These credentials do not match our records.','login');
            }
        }
        else{
            return redirect('/')->withErrors('These credentials do not match our records.','login');
        }
    }
//    public function signup(){
//        dd('sdsdsdssds');
//        return view('auth/register');
//    }
    
    public function test() {
        $user = User::find(1);
     if ($user) {
            $signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
            $setting_result = Setting::find(1);
            //dd(config('mail')); 
            Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));
         // echo 'ffff';
          Session::flash('message', "Confirm your email to logged in. ");
          return redirect('signup');
        } 
    }
    public function check_email_register(Request $request){

        $email = $request->email;
       // $password = $request->password;

        // echo DB::enableQueryLog();
        $user = User::where('email',$email)->first();


        if(!empty($user)){
            echo 'You already register please login';
        }else{

            $req_data = Arr::except($request->all(), ['_token']);
           // dd($req_data);
           /* $validator = $this->validator($req_data, [
                //  'email' => 'required|email|max:255|unique:users,email,NULL,user_id,deleted_at,NULL',
                //  'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
                'address' => 'required|max:255',
                'city' => 'required',
                'country_code' => 'required',
                'zip' => 'max:10'
                // 'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
            ]);
            if ($validator->fails()) {

                 redirect('/')->withErrors($validator,'register');
            }*/
            // dd($req);
            $formData = $req_data;
            //dd($formData);
            $formData['password'] = Hash::make($formData['password']);
            $formData['api_token'] = str_random(60);
            $formData['status'] = 'Active';
            // dd($formData);
            $user = User::create($formData);
            // dd($user);
            // Auth::loginUsingId($user->id);
            if ($user) {
                Auth::loginUsingId($user->id);
                //$signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
                // $setting_result = Setting::find(1);
                // dd(config('mail'));
                //Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));
                //Session::flash('message', "Please login here. ");
                //return redirect('/')->with('success','You have successfully signed up!');
            } else {
                Session::flash('signup', "1");
                return redirect('description.html')->withErrors('Error in signup try again!');
            }
        }

    }
    public function news_letter_register(Request $request) {
        // print_r($request->all());exit;
        $req_data = Arr::except($request->all(), ['_token']);
        // dd($req_data);
        $validator = $this->validator($req_data, [
            'first_name' => 'required|max:255',

            'email' => 'required|email|max:255|unique:users',

            // 'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
        ]);
        if ($validator->fails()) {

            return redirect('/')->withErrors($validator,'/');
        }
        // dd($req);
        $formData = $req_data;
//        $formData['password'] = Hash::make($formData['password']);
        $formData['api_token'] = str_random(60);
        $formData['status'] = 'Active';
        $formData['user_type'] = 'news_letter';
        // dd($formData);
        $user = User::create($formData);
        // dd($user);
        // Auth::loginUsingId($user->id);
        if ($user) {
            // Auth::loginUsingId($user->id);
            //$signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
            // $setting_result = Setting::find(1);
            // dd(config('mail'));
            //Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));

            Session::flash('message', "Thank You");
            return redirect('/')->with('success','You have successfully signed up!');
        } else {
            Session::flash('signup', "1");
            return redirect('/')->withErrors('Error in signup try again!');
        }
    }
    protected function register(Request $request) {
        // dd($request);
        $req_data = Arr::except($request->all(), ['_token']);
        // dd($req_data);
        $validator = $this->validator($req_data, [
          //  'email' => 'required|email|max:255|unique:users,email,NULL,user_id,deleted_at,NULL',
          //  'email' => 'required|email|unique:users,email,NULL,user_id,deleted_at,NULL',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4',
            'address' => 'required|max:255',
            'city' => 'required',
            'country_code' => 'required',
            'zip' => 'max:10'
          // 'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/|confirmed',
        ]);
                if ($validator->fails()) {

            return redirect('/')->withErrors($validator,'register');
        }
        // dd($req);
        $formData = $req_data;
        $formData['password'] = Hash::make($formData['password']);
        $formData['api_token'] = str_random(60);
        $formData['status'] = 'Active';
        // dd($formData);
        $user = User::create($formData);
       // dd($user);
        // Auth::loginUsingId($user->id);
        if ($user) {
               Auth::loginUsingId($user->id);
            //$signUp_template = EmailTemplates::where('template_type','email_confirmation')->first();
           // $setting_result = Setting::find(1);
           // dd(config('mail')); 
           //Mail::to($user)->send(new signUp($signUp_template,$user,$setting_result));
          
            Session::flash('message', "Please login here. ");
            return redirect('/')->with('success','You have successfully signed up!');
        } else {
            Session::flash('signup', "1");
            return redirect('description.html')->withErrors('Error in signup try again!');
        }
    }


    protected function account_setup($code) {
        $user = User::where('api_token',$code)->where('status','Inactive')->first();
        $country = Country::all();
        if (sizeof($user)) {
            $id = $user->user_id;
            return view('auth/register_detail',compact('id','country'));
        } else {
            return redirect('login')->withErrors('Error in signup try again!');
        }
    }
    protected function store_register(Request $request ,$id) {
         $this->validator($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'country_code' => 'required',
            // 'state' => 'required',
            'city' => 'required',
            'address' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4',
            // 'phone_no' => 'required|numeric',
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
    public function forget_password(){
        return view('auth/passwords/forgotpassword',compact('id','country'));
    }
    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->intended('home');
    }
///////////////////   forget password /////////////////
    public function send_forget_email(Request $request) {
        $emailCheck = User::where('email',$request->email)->where('status','Active')->first();
        /*->where('user_type','!=',"admin")*/

       // dd($emailCheck);
        if(!empty($emailCheck))
        {
          /*  $emailCheck = Resetpassword::where('email',$request->email)->first();
            if(sizeof($emailCheck))
            {
                $emailCheck->token =  str_random(60);
                $emailCheck->save();
            }
            else{
                $emailCheck = new Resetpassword();
                $emailCheck->email = $request->email;
                $emailCheck->token = str_random(60);
                $emailCheck->save();
            }*/
            Mail::to($request->email)->send(new PasswordReset($emailCheck));
            echo "Instructions to reset your password have been emailed to you.";
//            Session::flash('message', "Instructions to reset your password have been emailed to you.");
           // return redirect('/');
        }
        else{
            echo "Couldn't find an account for ".$request->email." or you are not allowed for this action";
        }

    }
    public function reset_password(Request $request ){
        $email=$request->email;
        return view('auth/passwords/reset',compact('email'));
    }
    public function password_reset_change(Request $request ){
        $email=$request['email'];
        $emailCheck = User::where('email',$request['email'])->where('status','Active')->first();


        if(sizeof($emailCheck))
        {
            $emailCheck->password = Hash::make($request['password']);
            $emailCheck->api_token =  str_random(60);
            $emailCheck->save();
            Session::flash('message', "Your password reset successfully");
            Auth::loginUsingId($emailCheck->id);
            return redirect('/');
        }


    }
}
