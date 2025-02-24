<?php

namespace App\Http\Controllers\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*use Illuminate\Http\Request;*/
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class ProfileController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {
   
        if (Auth::id()) {
            $country = Country::all();
            $edit_user = User::find(Auth::id());
  

            return view('admin/profile/edit_profile', compact('edit_user','country'));
        } else {
            return redirect('admin');
        }
    }
    public function check_password(Request $request)
    {
        $edit_user = User::find(Auth::user()->user_id);
        if (Hash::check($request->password, $edit_user->password))
        {

        }else {
            echo "Your current password is invalid";
        };
    }

    protected function validator($request, $rules)
    {
        return $validator = Validator::make($request, $rules);
        //return $validator->errors()->all();
    }
    public function update_profile(Request $request)
    {

 $validator = $this->validator($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/profile')->withErrors($validator);
        }
        $result = User::where('id', Auth::id())
            ->update(['first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country_code' => $request->country_code,
                'facebook_id' => $request->facebook_id,
                'twitter_id' => $request->twitter_id,
                'google_id' => $request->google_id,
                //'password' => bcrypt($request->password)
            ]);
        if ($result) {
            Session::flash('message', "Profile edit successfully");
            return redirect('admin/profile');
            //return redirect('admin')->withErrors('signup','You are signup successfully');
        } else {
            return redirect('admin/user')->withErrors('Error in edit user try again!');

        };
    }
    public function update_image(Request $request)
    {
        
        $validator = $this->validator($request->all(), [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect('admin/profile')->withErrors($validator);
        }
        $path = $request->file->store('profile');
        $result = User::where('id', Auth::id());
            


if($request->file)
        {
            $image  = $request->file;
           
             $filename = time().'.'.request()->file->getClientOriginalExtension();
             request()->file->move('uploads/profile', $filename);
             $cat_image['user_photo']='profile/'.$filename;   
              $result->update($cat_image);
        }


        if ($result) {
            Session::flash('message', "Profile Image edit successfully");
            return redirect('admin/profile');
            //return redirect('admin')->withErrors('signup','You are signup successfully');
        } else {
            return redirect('admin/profile')->withErrors('Error in edit profile image try again!');

        };

    }
    public function change_password(Request $request)
    {
   
        $validator =  Validator::make($request->all(), [
            // 'current_password' => 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return redirect('admin/profile')->withErrors($validator);
        }

        $edit_user = User::find(Auth::id());
        $result = User::where('id', Auth::id())
                ->update([
                    'password' => bcrypt($request->password)
                ]);
            // Session::flash('message', "Your password changed successfully");
               custom_flash("Your password changed successfully", "success");
            return redirect('admin/profile');
      /*  if (Hash::check($request->current_password, $edit_user->password))
        {
            


        }else {
            return redirect('admin/profile')->withErrors('Your Curent password is incorrect');

        };*/
    }

}
