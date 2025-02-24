<?php

namespace App\Http\Controllers\Api;

use App\Classes\Functions;
use App\Custom\Helpers\CustomHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiLoginController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        if (Auth::user()) {
            return redirect('admin/dashboard');
        }
        $data = array(
            'title' => 'Login'
        );
        return view("admin/auth/login", $data);
    }

    public function auth(Request $request)
    {
        $validator = Functions::validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $errors = $validator->errors();
        $error = implode(',', $errors->all());
        if ($validator->fails()) {
            return Functions::json_error($error);
        }
        $user = User::where('email', $request->email)->where('status', 1)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $user->token = $user->CreateToken('MyApp')->accessToken;
                return CustomHelper::json_success('You are successfully login', $user);
            } else {
                return CustomHelper::json_error('These credentials do not match our records');
            }
        } else {
            return CustomHelper::json_error('These credentials do not match our records');
        }
    }

    protected function register(Request $request)
    {
        $validator = Functions::validator($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);
        $errors = $validator->errors();
        $error = implode(',', $errors->all());
        if ($validator->fails()) {
            return Functions::json_error($error);
        }
        $formData = $request->all();
        $formData['status'] = 1;
        $formData['password'] = Hash::make($request->password);
        $user = User::create($formData);
        $user->token = $user->CreateToken('MyApp')->accessToken;
        if ($user) {
            //$signUp_template = EmailTemplates::where('template_type','sign_up_welcome')->first();
            //Mail::to($user)->send(new signUp($signUp_template,$user));
            return Functions::json_success('You are successfully register.', $user);
        } else {
            return Functions::json_error('Error in signup try again.');
        }

    }

    public function send_forget_link(Request $request)
    {
        $request = json_decode(file_get_contents("php://input"), true);
        $emailCheck = User::where('email', $request['email'])->where('status', 'Active')->get();
        //dd($emailCheck);
        if (sizeof($emailCheck)) {
            $emailCheck = Resetpassword::where('email', $request['email'])->first();
            if (sizeof($emailCheck)) {
                $emailCheck->token = str_random(60);
                $emailCheck->save();
            } else {
                $emailCheck = new Resetpassword();
                $emailCheck->email = $request['email'];
                $emailCheck->token = str_random(60);
                $emailCheck->save();
            }
            Mail::to($request['email'])->send(new PasswordResetFront($emailCheck));
            return Functions::json_success("Instructions to reset your password have been emailed to you.", array());
        } else {
            return Functions::json_error("Couldn't find an account for " . $request['email']);
        }

    }

    public function change_password(Request $request)
    {
        $request = json_decode(file_get_contents("php://input"), true);
        $validator = Validator::make($request, [
            'current_password' => 'required',
            'password' => 'required|min:5',
        ]);
        $errors = $validator->errors();
        $error = implode(',', $errors->all());
        if ($validator->fails()) {
            return Functions::json_error($error);
        }
        $edit_user = User::where('api_token', $_GET['api_token'])->first();
        if (Hash::check($request['current_password'], $edit_user->password)) {
            $result = User::where('user_id', $edit_user->user_id)
                ->update([
                    'password' => bcrypt($request['password'])
                ]);
            return Functions::json_success('Your password changed successfully', $edit_user);
        } else {
            return Functions::json_error('Your current password is incorrect');
        };
    }

    public function profile_update(Request $request)
    {

        if (isset($request->user_id) && $request->user_id > 0) {
            $validator = Validator::make($request->all(), [
                'user_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required'
            ]);
            $errors = $validator->errors();
            $error = implode(',', $errors->all());
            if ($validator->fails()) {
                return Functions::json_error($error);
            }

            $result = User::where('user_id', $request->user_id)->first();
            $result->update($request->all());

            $path = $request->user_photo->store('profile');
            $result->update([
                'user_photo' => $path
            ]);
        }
        $responce = User::where('user_id', $request->user_id)->first();
        $responce['user_photo'] = url('/uploads/' . $responce['user_photo']);
        if ($responce) {
            return Functions::json_success('Your profile update successfully.', $responce);
        } else {
            return Functions::json_error('Not Data Found');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('admin');
    }
    public function user_listing(){
        $user = User::all();
        return CustomHelper::json_success('You are successfully login', $user);
    }

}
