@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="grid_section text-center" style="font-size: 25px; margin-top: 100px; margin-bottom: -80px;"><h2><span>Change your password</span></h2></div>
    </div>
</div>
 <div class="main_wrapper account_wrapper">
    <!--End PAGE BAR -->
        <form action="{{url('changepassword')}}" method="post">
                                 @if (Session::has('error'))
                                <p class="text-danger">{{ Session::get('error') }}</p>
                                @endif
                                @if (Session::has('message'))
                                <p class="text-success">{{ Session::get('message') }}</p>
                                @endif
            @csrf
            {{--<a href="#" class="logo"><img src="images/logo.png"></a>--}}
            <p>To redeem your password, please enter</p>
            <!-- <div class="form-group">
             <input type="password" name="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Old password">
            </div> -->
            <div class="form-group">
             <input type="password" name="password" class="form-control required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="New password">
              <p class="text-danger" style="color: red">{{$errors->first('password')}}</p>
            </div>
            <div class="form-group">
             <input type="password" name="password_confirmation" class="form-control required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Confirm password">
              <p class="text-danger" style="color: red">{{$errors->first('password_confirmation')}}</p>
            </div>
            <button type="submit" class="btn hvr-float-shadow view_all">Change</button>
        </form>
    </div>
@endsection
