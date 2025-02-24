@extends('layouts.app')

@section('content')
    <div class="main_wrapper">
        <div class="main_wrapper account_wrapper">
            <form>
                <a href="#" class="logo"><img src="{{asset('images/logo.png')}}" alt="Book Your Adventures"></a>
                <p>To redeem your password, please enter your Email</p>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <button type="submit" class="btn hvr-float-shadow view_all">Reset</button>
            </form>
        </div>
    </div>


@endsection