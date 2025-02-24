@extends('layouts.app')

@section('content')
<div class="main_wrapper">
    <div class="order_container">
      <div class="container">
        <form action="{{url('update-profile')}}" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="grid_section"  style="margin-bottom: 50px;">
            <h2 class="text-center">
                            <span>My Profile</span>
                        </h2>
            <div class="checkout_wrapper">
              <div class="row">
                <div class="col-md-4 col-12 border-right">
                  <h5 class="mb-3">Edit Photo</h5>
                  <div class="profile_pic">
                    <div class="box">
                      <input type="file" name="file" value="" id="file-6" class="inputfile inputfile-5" data-multiple-caption="{count} files selected"  />
                      <label for="file-6">
                        <div class="profile_image">
                          <img src="{{url('public/uploads/'.$edit_user->user_photo)}}">
                          <i class="fas fa-camera"></i>
                        </div>
                        <span></span>
                      </label>
                    </div>
                    <button type="submit" class="btn   view_all text-danger" >Update</button>
                  </div>
                </div>

                <div class="col-md-8 col-12">
                  <h5 class="mb-3">Account Details</h5>

                    @csrf
                    <div class="row">
                      <div class="form-group col-md-6">
                        <input type="text" name="first_name" value="{{@$edit_user->first_name}}" class="form-control" id="inputAddress" placeholder="First name">
                      </div>
                      <div class="form-group col-md-6">
                        <input type="text" name="last_name" value="{{@$edit_user->last_name}}"  class="form-control"  id="inputAddress" placeholder="Last name">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-6">
                        <input type="email"  value="{{@$edit_user->email}}" disabled="disabled" class="form-control" id="inputEmail4" placeholder="Email">
                      </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" value="{{@$edit_user->phone_no}}" name="phone_no" id="inputEmail4" placeholder="Phone number">
                        </div>
                    </div>

                      <div class="row">
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" value="{{@$edit_user->address}}" name="address" id="inputAddress" placeholder="Addresss">
                    </div>
                      <div class="form-group col-md-6">
                          <input type="text" class="form-control" value="{{@$edit_user->city}}" name="city" placeholder="City" id="inputCity">
                      </div>
                      </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" value="{{@$edit_user->zip}}" name="zip" id="inputZip" placeholder="Zip">
                        </div>
                      <div class="form-group col-md-6">
                          <select id="" name="country_code" class="selectpicker">
                              <option >Choose Country</option>
                              @if(!empty($country))
                                  @foreach($country as $obj)
                              <option @if(isset($obj->code) && $obj->code == $edit_user->country_code) selected="selected" @endif name="{{$obj->code}}">{{$obj->name}}</option>
                                  @endforeach
                              @endif

                          </select>
                        </div>
                    </div>
                      <!-- <div class="form-group col-md-6">
                        <select id="inputState" class="selectpicker">
                          <option selected>Choose State</option>
                          <option>option 1</option>
                          <option>option 2</option>
                          <option>option 3</option>
                        </select>
                      </div> -->



                    <button type="submit" class="btn  hvr-float-shadow view_all text-danger">Update</button>


                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection
