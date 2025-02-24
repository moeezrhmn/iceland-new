
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <h3>Hello!</h3>
                    You are receiving this email because we received a password reset request for your account.
                    <form action="{{url('password/reset')}}" method="post">
                        <input type="hidden" name="email" value="{{$emailCheck->email}}">
                    <button type="submit" href="">Reset</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

