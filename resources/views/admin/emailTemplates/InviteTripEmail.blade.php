<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email</title>

    {!! Html::script('assets/web/js/bootstrap.min.js') !!}
</head>
<style>
    body {
        padding: 0;
        margin: 0;
    }

    @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
        *[class="table_width_100"] {
            width: 100% !important;
        }
        *[class="border-right_mob"] {
            border-right: 1px solid #dddddd;
        }
        *[class="mob_100"] {
            width: 100% !important;
        }
        *[class="mob_center"] {
            text-align: center !important;
        }
        *[class="mob_center_bl"] {
            float: none !important;
            display: block !important;
            margin: 0px auto;
        }
        .iage_footer a {
            text-decoration: none;
            color: #929ca8;
        }
        img.mob_display_none {
            width: 0px !important;
            height: 0px !important;
            display: none !important;
        }
        img.mob_width_50 {
            width: 40% !important;
            height: auto !important;
        }
    }
    .table_width_100 {
        width: 680px;
    }
</style>
<body>
<div id="mailsub" class="notification" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">

                <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%" style="max-width: 680px; min-width: 300px;">
                    <!--header -->
                    <tr>
                        <td align="center" bgcolor="#ffffff">
                            <!-- padding -->
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <div style="height: 30px; line-height: 30px; font-size: 10px;"></div>
                                <tr>
                                    <td align="center">
                                        <img src="{{url('assets/web')}}/img/visitanycity-logo.png" width="130" alt="logo" border="0" >
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" bgcolor="#fbfcfd">
                                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center">
                                                    <!-- padding --><div style="height: 10px;"></div>
                                                    <div style="line-height: 30px;">
                                                        <span style="text-align: center;font-family: Arial, Helvetica, sans-serif; font-size: 18px;">Welcome Dear User,</span>
                                                        <br>
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; ">
                                              <?php 
                                            if($user->first_name!= '' && $user->last_name!='')
                                            echo 'Dear '.$user->first_name.' '.$user->last_name; 
                                            else
                                                 echo 'Dear User'; 
                                              ?>
                                                <?php
                                                $date1 = date_create($trip['start_date']);
                                                $date2 = date_create($trip['end_date']);
                                                $diff = date_diff($date1, $date2);
                                                $days = $diff->format("%a");
                                                ?>
                                                 want to share <b>{{$days}} Days</b> trip with called <b><?php echo $trip->trip_name?></b> with you.
                                            </span>
                                                    </div>
                                                    <!-- padding --><div style="height: 40px;"></div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center">
                                                    <div style="line-height: 60px;">
                                                        <form action="{{url('/login')}}">
                                                            <input type="hidden" name="trip_id" value="{{$trip_id}}">
                                                            <input type="hidden" name="user_id" value="{{$user_id}}">
                                                            <a href="{{url('/invitetrip/'.$trip_id)}}"  class="btn" style="text-decoration:none;padding: 20px; font-size: 15px; color: white; background-color: #0099fd; border-color: #0099fd;">
                                                                ACCEPT INVITE
                                                            </a>
                                                        </form>

                                                    </div>
                                                    <!-- padding --><div style="height: 30px;"></div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center">
                                                    <div>
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
                                                You have been granted full access to this trip and are now allowed to modify it.
                                            </span>
                                                        <img src="{{url('trip/email_trip.png')}}" alt="image" style="height: 300px; padding-top: 20px;">
                                                    </div>
                                                    <!-- padding --><div style="height: 40px;"></div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center" style="padding:20px;flaot:left;width:100%; text-align:center;">
                                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 20px;">
                                            About Visit Any City Travel
                                        </span>
                                                    <p style="font-size: 15px; line-height: 25px;">
                                                        Visit Any City Travel is a free trip planner trusted by millions of travelers.
                                                        Build your own day-by-day trip plan in just minutes. Print or download your itinerary
                                                        or use it with the Visit Any City Travel mobile app on the road. As you put your itinerary
                                                        together, Visit Any City Travel automatically calculates the shortest routes and travel times
                                                        and suggests hotels and tours that match your trip. Give it a try!
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>