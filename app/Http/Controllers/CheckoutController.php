<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Favourite;
use App\Models\Reviews;
use Illuminate\Support\Facades\Input;
use App\Models\Category;
use Session;
use DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        //@@@@@@@@@@@@@@@@@@@@@@@@   Get single activity  @@@@@@@@@@@@@@@@@@@@@///
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "5d768e471b3844209b824181f6f5aa3bGET/checkout.json/options/shopping-cart/" . $_GET['sessionId'];
        $seceret = "e4d8295c87314700b0d437116149e1b5";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $ch = curl_init("https://api.bokun.io/checkout.json/options/shopping-cart/" . $_GET['sessionId']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :5d768e471b3844209b824181f6f5aa3b',
                'Content-Type: application/json',
                //'Content-Length:' . strlen($data)
            )
        );

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $item = json_decode($result);
      //  dump($item);

        if($_GET['sessionId'] !='')
            $sessionId= $_GET['sessionId'];
        else
            $sessionId='';

        if(isset($item->questions->activityBookings))
        {
        }else
            return redirect('/');
            $data= array();
        //  $data['currency']= $item1->options[0]->currency;
        //$data['total']= $item1->options[0]->amount;
        //$data['formattedAmount']= $item1->options[0]->formattedAmount;

//        $item1->place_detail = $place_detail;
//        if (isset($_GET['id']) && !empty($_GET['id'])) { ////check if activity exist or not
//            return view('activity/check-availabilities', compact('product_id', 'listing', 'item1', 'pickup_places'))->with('external_id', $_GET['id']);
//        } else {
//            return redirect('home');
//        }
        //dump($item);

        return view("activities.checkout",compact('result','item','sessionId'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        dd($request->all());
    }
    public function store(Request $request)
    {
     //  dump($request->all());

        if(isset($request->EXTRAS_QUESTION) && sizeof($request->EXTRAS_QUESTION) )
            {
                for($i=0; $i<count($request->EXTRAS_QUESTION); $i++)
                {
                    $extras = $request->EXTRAS_QUESTION[$i];
                    $extras_answer = $request->EXTRAS_ANSWER[$i];
                    //dd($extras);

                    $request->activity_data =str_replace('EXTRAS_QUESTION_'.$extras,$extras_answer,$request->activity_data);
                }


            }
        $checkout_data = json_decode($request->activity_data);
       // dd($checkout_data);

//            if(sizeof($checkout_data->questions->activityBookings)) {
//                foreach ($checkout_data->questions->activityBookings as $activityBookings) {
//                    //dump($activityBookings);
//
////           "extras": [
////                {
////                    "bookingId": "2158"
////                    "extraTitle": "Flight number",
////                    "extraId": 0,
////                    "answers": [
////                   {
////                        "questionId": "2158",
////                      "values": [
////                                     "string"
////                            ]
////                    }
////                  ]
////
////                }
////              ]
////
////
//                    foreach($activityBookings->passengers as $passengers  ){
//
//                        $passenger_arr[] = array( "bookingId" => $passengers->bookingId,
//                            "pricingCategoryId" => $passengers->pricingCategoryId,
//                            "passengerDetails" => [],
//                            "answers" => [],
//
//                            "extras" => []
//                        );
//                    }
//
//                    $ACTdata[] = array("activityId" => $activityBookings->activityId,
//                        "bookingId" => $activityBookings->bookingId,
//                        "answers" => [],
//                        "pickupAnswers" => [],
//                        "dropoffAnswers"=> [],
//                        "passengers"=> $passenger_arr
//
//                    );
//                }
//
//            }

        $requestKey = date('Y-m-d H:i:s') . "5d768e471b3844209b824181f6f5aa3bPOST/checkout.json/submit";
        $seceret = "e4d8295c87314700b0d437116149e1b5";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));

if($request->sessionId !='') {

    $data = array(
        'checkoutOption' => 'CUSTOMER_FULL_PAYMENT',
        'paymentMethod' => 'CARD',
        'source' => 'SHOPPING_CART',
        'shoppingCart' =>
            array(
                'uuid' => $request->sessionId,
                'externalBookingReference' => 'Northern Adventures ehf',
                'bookingAnswers' =>
                    array(
                        'mainContactDetails' =>
                            array(
                                0 =>
                                    array(
                                        'questionId' => 'firstName',
                                        'values' =>
                                            array(
                                                0 => $request->first_name,
                                            ),
                                    ),
                                1 =>
                                    array(
                                        'questionId' => 'lastName',
                                        'values' =>
                                            array(
                                                0 => $request->first_name,
                                            ),
                                    ),
                                2 =>
                                    array(
                                        'questionId' => 'email',
                                        'values' =>
                                            array(
                                                0 => $request->email,
                                            ),
                                    ),
                                3 =>
                                    array(
                                        'questionId' => 'phoneNumber',
                                        'values' =>
                                            array(
                                                0 => $request->phone,
                                            ),
                                    ),

                            ),

                        //'activityBookings' =>$checkout_data->questions->activityBookings
                        'activityBookings' =>$checkout_data

                    ),
            ),
                    'sendNotificationToMainContact' => true,
                    'showPricesInNotification' => true,
                    'amount' => $request->amount,
                    'currency' => $request->currency,
                    'uti' => $request->uti,
                    'paymentCard' =>
                        array(
                            'name' => $request->first_name,
                            'cardNumber' => $request->card_number,
                            'expiryMonth' => $request->expiry_month,
                            'expiryYear' =>  $request->expiry_year,
                            'cvc' => $request->cvc
//                        'name' => 'Yngvi o Stefansson',
//                        'cardNumber' => '5206 1840 0919 0102',
//                        'expiryMonth' => 11,
//                        'expiryYear' => 19,
//                        'cvc' => '996'
                        ),
                    'acceptDccQuote' => false,
                    'providerPaymentParameters' =>(Object)[],
                   // 'providerPaymentParameters' =>'',
                    'cardPaymentProviderAnswers' =>
                        array(),
                    'checkoutOptionAnswers' =>
                        array(),
                    );
                }else
                    return 'empty data';

        $data_string = json_encode($data);
      //  dump($data_string);

        $ch = curl_init("https://api.bokun.io/checkout.json/submit");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :5d768e471b3844209b824181f6f5aa3b',
                'Content-Type: application/json',
                'Content-Length:' . strlen($data_string)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result1 = curl_exec($ch);


        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
            }
        curl_close($ch);

        //dd($result1);
        if (isset($error_msg)) {
            return redirect('/checkout?sessionId='. $request->sessionId)->withErrors(array('error_msg' => $error_msg));
           // dump($error_msg);
        }

        $booking= json_decode($result1);
       // $result1= $this->booking_data();
       // $booking= json_decode($result1);
        //dd($booking);


        if (isset($booking->booking) && $booking->booking->bookingId > 0 &&  $booking->booking->status== "CONFIRMED") {
            // Order::where('track_id', $id)->delete();
            Session::flash('success_msg', 'Your booking has been confirmed successfully');
            return redirect('/booking-success/'.$booking->booking->bookingId);
        } else {
            //dd($booking);
           // Session::flash('message', 'ttttttttttttttttttttttttttttt');
            //Session::flash('alert-class', 'alert-danger');
            return redirect('/checkout?sessionId='. $request->sessionId)->withErrors($booking);

        }




    }


    public function booking_success($id)
    {

        $result['booking_id']= $id;
        return view("booking.success",compact('result'));


    }

    public function remove_booking($sessionId,$id)
    {
        //dd($sessionId);
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "5d768e471b3844209b824181f6f5aa3bGET/shopping-cart.json/session/".$sessionId."/remove-activity/".$id."?currency=USD&lang=EN";
        $seceret = "e4d8295c87314700b0d437116149e1b5";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        //https://api.bokun.io/shopping-cart.json/session/b6690158-9f95-435b-b292-e01a0a626344/remove-activity/9121842?currency=USD&lang=EN

        $ch = curl_init("https://api.bokun.io/shopping-cart.json/session/".$sessionId."/remove-activity/".$id."?currency=USD&lang=EN");
      //  dd($ch);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :5d768e471b3844209b824181f6f5aa3b',
                'Content-Type: application/json'
            )
        );

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $item1 = json_decode($result);

       // dd($item1);
        if (isset($item1)) {

            //Order::where('track_id', $id)->delete();
            Session::flash('success_msg', 'Your booking has been Canceled successfully');
            return redirect('/checkout?sessionId='.$sessionId);
        } else {
            return redirect('/checkout?sessionId='.$sessionId)->withErrors(array('error_msg' => 'Error in Removing activity from Cart'));
        }

    }
        public function cancel_booking($id)
    {
        date_default_timezone_set('Asia/Karachi');
        $requestKey = date('Y-m-d H:i:s') . "49cfb5a0430b403795d6c687c1b0686cPOST/booking.json/cancel-booking/$id";
        $seceret = "656b1a3490c74789b025fead9a88c084";
        $signature = base64_encode(hash_hmac('sha1', $requestKey, $seceret, true));
        $data = array(
            "note" => "We had to cancel this due to weather.",
            "refund" => true,
            "notify" => true
        );
        $data_string = json_encode($data);
        $ch = curl_init("https://api.bokuntest.com/booking.json/cancel-booking/$id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Bokun-Signature:' . $signature,
                'X-Bokun-Date:' . date('Y-m-d H:i:s'),
                'X-Bokun-AccessKey :49cfb5a0430b403795d6c687c1b0686c',
                'Content-Type: application/json',
                'Content-Length:' . strlen($data_string)
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $item1 = json_decode($result);
        if ($item1->message == "OK") {
            Order::where('track_id', $id)->delete();
            Session::flash('success_msg', 'Your booking has been cancel successfully');
            return redirect('/profile');
        } else {
            return redirect('/profile')->withErrors(array('error_msg' => $item1->message));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function booking_data(){

       return  $result1 ='{
            "booking": {
            "creationDate": 1560762710000,
		"bookingId": 5165423,
		"language": "en",
		"confirmationCode": "NAG-5165423",
		"externalBookingReference": "Northern Adventures ehf",
		"status": "CONFIRMED",
		"currency": "USD",
		"totalPrice": 29.0,
		"totalPaid": 29.0,
		"totalDue": 0.0,
		"totalPriceConverted": 29.0,
		"customer": {
                "contactDetailsHidden": false,
			"contactDetailsHiddenUntil": null,
			"id": 11046772,
			"created": null,
			"uuid": "d66e20d3-53dc-4c31-bc95-2407a973280a",
			"email": "waseemmcs786@gmail.com",
			"title": null,
			"firstName": "Keegan",
			"lastName": "Graves",
			"personalIdNumber": null,
			"language": null,
			"nationality": null,
			"sex": null,
			"dateOfBirth": null,
			"phoneNumber": null,
			"phoneNumberCountryCode": null,
			"address": null,
			"postCode": null,
			"state": null,
			"place": null,
			"country": null,
			"organization": null,
			"passportId": null,
			"passportExpDay": null,
			"passportExpMonth": null,
			"passportExpYear": null,
			"credentials": null
		},
		"invoice": {
                "id": 15781391,
			"issueDate": 1560762710000,
			"currency": "USD",
			"includedAppliedTaxes": [],
			"excludedAppliedTaxes": [],
			"issuer": {
                    "id": 3038,
				"title": "Northern Adventures ehf",
				"externalId": "",
				"flags": []
			},
			"issuerCompany": {
                    "registrationNumber": "6111170430",
				"vatRegistrationNumber": "132287"
			},
			"recipient": {
                    "contactDetailsHidden": false,
				"contactDetailsHiddenUntil": null,
				"id": 11046772,
				"created": null,
				"uuid": "d66e20d3-53dc-4c31-bc95-2407a973280a",
				"email": "waseemmcs786@gmail.com",
				"title": null,
				"firstName": "Keegan",
				"lastName": "Graves",
				"personalIdNumber": null,
				"language": null,
				"nationality": null,
				"sex": null,
				"dateOfBirth": null,
				"phoneNumber": null,
				"phoneNumberCountryCode": null,
				"address": null,
				"postCode": null,
				"state": null,
				"place": null,
				"country": null,
				"organization": null,
				"passportId": null,
				"passportExpDay": null,
				"passportExpMonth": null,
				"passportExpYear": null,
				"credentials": null
			},
			"customLineItems": [],
			"productInvoices": [{
                    "id": 9735098,
				"currency": "USD",
				"includedAppliedTaxes": [],
				"excludedAppliedTaxes": [],
				"productBookingId": 9091665,
				"title": "Flybus - BSI to Airport - Thu 08.Aug 2019 @ 04:00",
				"product": {
                        "id": 15501,
					"title": "Flybus - BSI to Airport",
					"flags": [],
					"keyPhoto": {
                            "id": 49740,
						"originalUrl": "https://bokun.s3.amazonaws.com/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg",
						"description": "Flybus",
						"alternateText": "flybus",
						"flags": [],
						"derived": [{
                                "name": "large",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660"
						}, {
                                "name": "preview",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300"
						}, {
                                "name": "thumbnail",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop"
						}],
						"fileName": "/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg"
					}
				},
				"productCategory": "ACTIVITIES",
				"productConfirmationCode": "REY-T9091665",
				"dates": "Thu 08.Aug 2019 @ 04:00",
				"customLineItems": [],
				"lineItems": [{
                        "id": 12958350,
					"title": "Adults",
					"currency": "USD",
					"unitPriceDate": 1560762710000,
					"quantity": 1,
					"unitPrice": 29.0,
					"calculatedDiscount": 0.0,
					"customDiscount": 0.0,
					"calculatedDiscountAmount": 0.0,
					"taxAmount": 0.0,
					"taxesAsMoney": [],
					"itemBookingId": "15501_3646",
					"costItemId": 224349,
					"costItemTitle": "Adults (16+)",
					"costGroupTitle": "Flybus - BSI to Airport",
					"supportsDiscount": true,
					"people": 1,
					"total": 29.0,
					"totalDiscountedAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"totalAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"totalDue": 29.0,
					"unitPriceAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"discountedUnitPrice": 29.0,
					"totalDueAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"discount": 0.0,
					"totalDiscounted": 29.0,
					"totalAsText": "$29.00",
					"totalDiscountedAsText": "$29.00",
					"totalDueAsText": "$29.00",
					"taxAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					},
					"discountedUnitPriceAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"taxAsText": "$0.00",
					"discountedUnitPriceAsText": "$29.00",
					"unitPriceAsText": "$29.00",
					"discountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					},
					"discountAmountAsText": "$0.00",
					"calculatedDiscountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					}
				}],
				"free": false,
				"totalDiscountedAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalDueAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalDiscountAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalAsText": "$29.00",
				"totalDiscountedAsText": "$29.00",
				"totalDueAsText": "$29.00",
				"excludedTaxes": false,
				"totalExcludedTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalExcludedTaxAsText": "$0.00",
				"includedTaxes": false,
				"totalIncludedTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalIncludedTaxAsText": "$0.00",
				"totalTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalTaxAsText": "$0.00"
			}],
			"payments": [],
			"issuerName": "Northern Adventures ehf",
			"lodgingTaxes": [],
			"invoiceNumber": "C-15781391",
			"recipientName": "Keegan Graves",
			"free": false,
			"totalDiscountedAsMoney": {
                    "amount": 29.0,
				"currency": "USD"
			},
			"totalAsMoney": {
                    "amount": 29.0,
				"currency": "USD"
			},
			"totalDueAsMoney": {
                    "amount": 29.0,
				"currency": "USD"
			},
			"totalDiscountAsMoney": {
                    "amount": 0.0,
				"currency": "USD"
			},
			"totalAsText": "$29.00",
			"totalDiscountedAsText": "$29.00",
			"totalDueAsText": "$29.00",
			"excludedTaxes": false,
			"totalExcludedTaxAsMoney": {
                    "amount": 0.0,
				"currency": "USD"
			},
			"totalExcludedTaxAsText": "$0.00",
			"includedTaxes": false,
			"totalIncludedTaxAsMoney": {
                    "amount": 0.0,
				"currency": "USD"
			},
			"totalIncludedTaxAsText": "$0.00",
			"totalTaxAsMoney": {
                    "amount": 0.0,
				"currency": "USD"
			},
			"totalTaxAsText": "$0.00"
		},
		"customerPayments": [{
                "id": 3571982,
			"amount": 29.0,
			"currency": "USD",
			"comment": "Payment for booking #5165423, performed by Northern Adventures ehf: Api Key Development keys ",
			"transactionDate": 1560762619000,
			"authorizationCode": "091150",
			"activeCustomerInvoiceId": 15781391,
			"paymentType": "WEB_PAYMENT",
			"cardNumber": "520618******0102",
			"paymentId": 3176023,
			"paymentContractId": 6204,
			"paymentReferenceId": "744f727a-cb16-41e9-b7db-850eeba4d854",
			"paymentProviderType": "VALITOR_SERVER_TO_SERVER",
			"isRefundable": true,
			"totalRefundedAmount": 0.0,
			"useDcc": false,
			"amountAsMoney": {
                    "amount": 29.0,
				"currency": "USD"
			},
			"remainingRefundableAmount": 29.0,
			"refundable": true,
			"amountAsText": "$29.00",
			"refundedAmountAsText": "$0.00"
		}],
		"paymentType": "PAID_IN_FULL",
		"seller": {
                "id": 3038,
			"title": "Northern Adventures ehf",
			"description": "Northern Adventures has specialized in serving tourists visiting Iceland and offers companies a powerful way to market their products and services.",
			"currencyCode": "ISK",
			"countryCode": "IS",
			"phoneNumber": "+3547754100",
			"emailAddress": "guide@guide.is",
			"website": "www.guide.is",
			"logoStyle": "",
			"invoiceIdNumber": "6111170430",
			"logo": {
                    "id": 149492,
				"originalUrl": "https://bokun.s3.amazonaws.com/photo149492original",
				"description": null,
				"alternateText": null,
				"flags": [],
				"derived": [{
                        "name": "large",
					"url": "https://bokunprod.imgix.net/photo149492original?w=660&h=660",
					"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=660&h=660"
				}, {
                        "name": "preview",
					"url": "https://bokunprod.imgix.net/photo149492original?w=300&h=300",
					"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=300&h=300"
				}, {
                        "name": "thumbnail",
					"url": "https://bokunprod.imgix.net/photo149492original?w=80&h=80&fit=crop",
					"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=80&h=80&fit=crop"
				}],
				"fileName": "/photo149492original"
			},
			"showInvoiceIdOnTicket": true,
			"showAgentDetailsOnTicket": false,
			"showPaymentsOnInvoice": false,
			"companyEmailIsDefault": true
		},
		"bookingChannel": {
                "id": 7092,
			"uuid": "9d1c7257-c452-49e1-a2ee-79b0275ea726",
			"title": "https://www.guide.is",
			"backend": false,
			"overrideVoucherHeader": true,
			"voucherName": "Northern Adventures",
			"voucherPhoneNumber": "+3547754100",
			"voucherEmailAddress": "activity.guide.iceland@gmail.com",
			"voucherLogoStyle": "",
			"voucherWebsite": "https://www.guide.is",
			"voucherLogo": {
                    "id": 244797,
				"originalUrl": "https://bokun.s3.amazonaws.com/photo244797original",
				"description": null,
				"alternateText": null,
				"flags": [],
				"derived": [{
                        "name": "large",
					"url": "https://bokunprod.imgix.net/photo244797original?w=660&h=660",
					"cleanUrl": "https://bokunprod.imgix.net/photo244797original?w=660&h=660"
				}, {
                        "name": "preview",
					"url": "https://bokunprod.imgix.net/photo244797original?w=300&h=300",
					"cleanUrl": "https://bokunprod.imgix.net/photo244797original?w=300&h=300"
				}, {
                        "name": "thumbnail",
					"url": "https://bokunprod.imgix.net/photo244797original?w=80&h=80&fit=crop",
					"cleanUrl": "https://bokunprod.imgix.net/photo244797original?w=80&h=80&fit=crop"
				}],
				"fileName": "/photo244797original"
			},
			"paymentProviderAdded": true,
			"flags": [],
			"shoppingCartPosition": "RIGHT"
		},
		"accommodationBookings": [],
		"carRentalBookings": [],
		"activityBookings": [{
                "bookingId": 9091665,
			"parentBookingId": 5165423,
			"confirmationCode": "NAG-5165423",
			"productConfirmationCode": "REY-T9091665",
			"barcode": {
                    "value": "REY-T9091665",
				"barcodeType": "QR_CODE"
			},
			"hasTicket": false,
			"boxBooking": false,
			"startDateTime": 1565236800000,
			"endDateTime": 1565239500000,
			"status": "CONFIRMED",
			"includedOnCustomerInvoice": false,
			"title": "Flybus - BSI to Airport",
			"totalPrice": 29.0,
			"priceWithDiscount": 29.0,
			"discountPercentage": 0.0,
			"discountAmount": 0.0,
			"productCategory": "ACTIVITIES",
			"paidType": "PAID_IN_FULL",
			"product": {
                    "id": 15501,
				"title": "Flybus - BSI to Airport",
				"flags": [],
				"vendor": {
                        "id": 34,
					"title": "Reykjavik Excursions",
					"currencyCode": "ISK",
					"showInvoiceIdOnTicket": false,
					"showAgentDetailsOnTicket": false,
					"showPaymentsOnInvoice": false,
					"companyEmailIsDefault": false
				},
				"externalId": "FB01",
				"productCategory": "ACTIVITIES",
				"cancellationPolicy": {
                        "id": 3656,
					"title": "Default",
					"penaltyRules": [{
                            "id": 4280,
						"cutoffHours": 24,
						"charge": 100.0,
						"chargeType": "percentage"
					}],
					"tax": null
				}
			},
			"supplier": {
                    "id": 34,
				"title": "Reykjavik Excursions",
				"description": "",
				"currencyCode": "ISK",
				"countryCode": "IS",
				"phoneNumber": "+354 580 5400",
				"emailAddress": "main@re.is",
				"website": "www.re.is",
				"logoStyle": "width:70px",
				"invoiceIdNumber": "560269-3829",
				"logo": {
                        "id": 109,
					"originalUrl": "https://bokun.s3.amazonaws.com/photo109original",
					"description": null,
					"alternateText": null,
					"flags": [],
					"derived": [{
                            "name": "large",
						"url": "https://bokun.s3.amazonaws.com/photo109large",
						"cleanUrl": "//bokun.s3.amazonaws.com/photo109large"
					}, {
                            "name": "preview",
						"url": "https://bokun.s3.amazonaws.com/photo109preview",
						"cleanUrl": "//bokun.s3.amazonaws.com/photo109preview"
					}, {
                            "name": "thumbnail",
						"url": "https://bokun.s3.amazonaws.com/photo109thumbnail",
						"cleanUrl": "//bokun.s3.amazonaws.com/photo109thumbnail"
					}],
					"fileName": "/photo109original"
				},
				"showInvoiceIdOnTicket": true,
				"showAgentDetailsOnTicket": false,
				"showPaymentsOnInvoice": false,
				"companyEmailIsDefault": true,
				"linkedExternalCustomers": []
			},
			"seller": {
                    "id": 3038,
				"title": "Northern Adventures ehf",
				"description": "Northern Adventures has specialized in serving tourists visiting Iceland and offers companies a powerful way to market their products and services.",
				"currencyCode": "ISK",
				"countryCode": "IS",
				"phoneNumber": "+3547754100",
				"emailAddress": "guide@guide.is",
				"website": "www.guide.is",
				"logoStyle": "",
				"invoiceIdNumber": "6111170430",
				"logo": {
                        "id": 149492,
					"originalUrl": "https://bokun.s3.amazonaws.com/photo149492original",
					"description": null,
					"alternateText": null,
					"flags": [],
					"derived": [{
                            "name": "large",
						"url": "https://bokunprod.imgix.net/photo149492original?w=660&h=660",
						"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=660&h=660"
					}, {
                            "name": "preview",
						"url": "https://bokunprod.imgix.net/photo149492original?w=300&h=300",
						"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=300&h=300"
					}, {
                            "name": "thumbnail",
						"url": "https://bokunprod.imgix.net/photo149492original?w=80&h=80&fit=crop",
						"cleanUrl": "https://bokunprod.imgix.net/photo149492original?w=80&h=80&fit=crop"
					}],
					"fileName": "/photo149492original"
				},
				"showInvoiceIdOnTicket": true,
				"showAgentDetailsOnTicket": false,
				"showPaymentsOnInvoice": false,
				"companyEmailIsDefault": true,
				"linkedExternalCustomers": []
			},
			"productId": 15501,
			"linksToExternalProducts": [{
                    "externalProductId": "f67b624f-29a5-4d51-9c01-dddab9cc5dd5",
				"externalProductTitle": "One Way Flybus",
				"systemConfigId": 8,
				"flags": ["CRM"]
			}],
			"answers": [],
			"invoice": {
                    "id": 9735098,
				"currency": "USD",
				"includedAppliedTaxes": [],
				"excludedAppliedTaxes": [],
				"productBookingId": 9091665,
				"title": "Flybus - BSI to Airport - Thu 08.Aug 2019 @ 04:00",
				"product": {
                        "id": 15501,
					"title": "Flybus - BSI to Airport",
					"flags": [],
					"keyPhoto": {
                            "id": 49740,
						"originalUrl": "https://bokun.s3.amazonaws.com/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg",
						"description": "Flybus",
						"alternateText": "flybus",
						"flags": [],
						"derived": [{
                                "name": "large",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660"
						}, {
                                "name": "preview",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300"
						}, {
                                "name": "thumbnail",
							"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop",
							"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop"
						}],
						"fileName": "/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg"
					}
				},
				"productCategory": "ACTIVITIES",
				"productConfirmationCode": "REY-T9091665",
				"dates": "Thu 08.Aug 2019 @ 04:00",
				"customLineItems": [],
				"lineItems": [{
                        "id": 12958350,
					"title": "Adults",
					"currency": "USD",
					"unitPriceDate": 1560762710000,
					"quantity": 1,
					"unitPrice": 29.0,
					"calculatedDiscount": 0.0,
					"customDiscount": 0.0,
					"calculatedDiscountAmount": 0.0,
					"taxAmount": 0.0,
					"taxesAsMoney": [],
					"itemBookingId": "15501_3646",
					"costItemId": 224349,
					"costItemTitle": "Adults (16+)",
					"costGroupTitle": "Flybus - BSI to Airport",
					"supportsDiscount": true,
					"people": 1,
					"total": 29.0,
					"totalDiscountedAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"totalAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"totalDue": 29.0,
					"unitPriceAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"discountedUnitPrice": 29.0,
					"totalDueAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"discount": 0.0,
					"totalDiscounted": 29.0,
					"totalAsText": "$29.00",
					"totalDiscountedAsText": "$29.00",
					"totalDueAsText": "$29.00",
					"taxAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					},
					"discountedUnitPriceAsMoney": {
                            "amount": 29.0,
						"currency": "USD"
					},
					"taxAsText": "$0.00",
					"discountedUnitPriceAsText": "$29.00",
					"unitPriceAsText": "$29.00",
					"discountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					},
					"discountAmountAsText": "$0.00",
					"calculatedDiscountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "USD"
					}
				}],
				"free": false,
				"totalDiscountedAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalDueAsMoney": {
                        "amount": 29.0,
					"currency": "USD"
				},
				"totalDiscountAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalAsText": "$29.00",
				"totalDiscountedAsText": "$29.00",
				"totalDueAsText": "$29.00",
				"excludedTaxes": false,
				"totalExcludedTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalExcludedTaxAsText": "$0.00",
				"includedTaxes": false,
				"totalIncludedTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalIncludedTaxAsText": "$0.00",
				"totalTaxAsMoney": {
                        "amount": 0.0,
					"currency": "USD"
				},
				"totalTaxAsText": "$0.00"
			},
			"sellerInvoice": {
                    "id": 3095622,
				"issueDate": 1560762710000,
				"currency": "ISK",
				"includedAppliedTaxes": [{
                        "title": "VAT 11%",
					"tax": 295.0,
					"currency": "ISK",
					"taxAsMoney": {
                            "amount": 295.0,
						"currency": "ISK"
					},
					"taxAsText": "ISK 295"
				}, {
                        "title": "Pick up ",
					"tax": 295.0,
					"currency": "ISK",
					"taxAsMoney": {
                            "amount": 295.0,
						"currency": "ISK"
					},
					"taxAsText": "ISK 295"
				}],
				"excludedAppliedTaxes": [],
				"title": "Flybus - BSI to Airport (Standard rate) - Thu 08.Aug 2019 @ 04:00",
				"issuer": {
                        "id": 34,
					"title": "Reykjavik Excursions",
					"externalId": "",
					"flags": []
				},
				"recipient": {
                        "id": 3038,
					"title": "Northern Adventures ehf",
					"externalId": "",
					"flags": []
				},
				"product": {
                        "id": 15501,
					"title": "Flybus - BSI to Airport",
					"externalId": "FB01",
					"flags": []
				},
				"productConfirmationCode": "REY-T9091665",
				"dates": "Thu 08.Aug 2019 @ 04:00",
				"customLineItems": [],
				"lineItems": [{
                        "id": 3551539,
					"title": "Adults",
					"currency": "ISK",
					"unitPriceDate": 1560762710000,
					"quantity": 1,
					"unitPrice": 3499.0,
					"calculatedDiscount": 0.0,
					"customDiscount": 0.0,
					"calculatedDiscountAmount": 0.0,
					"tax": {
                            "id": 49,
						"ownerId": 34,
						"title": "VAT 11%",
						"percentage": 22.0,
						"included": true,
						"roundingMode": "HALF_UP"
					},
					"taxAmount": 590.0,
					"taxesAsMoney": [{
                            "title": "VAT 11%",
						"tax": 295.0,
						"currency": "ISK",
						"taxAsMoney": {
                                "amount": 295.0,
							"currency": "ISK"
						},
						"taxAsText": "ISK 295"
					}, {
                            "title": "Pick up ",
						"tax": 295.0,
						"currency": "ISK",
						"taxAsMoney": {
                                "amount": 295.0,
							"currency": "ISK"
						},
						"taxAsText": "ISK 295"
					}],
					"commission": 15.0,
					"totalDiscountedAsMoney": {
                            "amount": 2974.0,
						"currency": "ISK"
					},
					"totalAsMoney": {
                            "amount": 2974.0,
						"currency": "ISK"
					},
					"totalWithoutCommissionAsMoney": {
                            "amount": 3499.0,
						"currency": "ISK"
					},
					"discountedUnitPriceAsMoney": {
                            "amount": 2974.0,
						"currency": "ISK"
					},
					"totalWithoutCommissionAsText": "ISK 3,499",
					"total": 2974.0,
					"totalDue": 2974.0,
					"unitPriceAsMoney": {
                            "amount": 3499.0,
						"currency": "ISK"
					},
					"discountedUnitPrice": 2974.0,
					"totalDueAsMoney": {
                            "amount": 2974.0,
						"currency": "ISK"
					},
					"discount": 0.0,
					"totalDiscounted": 2974.0,
					"totalAsText": "ISK 2,974",
					"totalDiscountedAsText": "ISK 2,974",
					"totalDueAsText": "ISK 2,974",
					"taxAsMoney": {
                            "amount": 590.0,
						"currency": "ISK"
					},
					"taxAsText": "ISK 590",
					"discountedUnitPriceAsText": "ISK 2,974",
					"unitPriceAsText": "ISK 3,499",
					"discountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "ISK"
					},
					"discountAmountAsText": "ISK 0",
					"calculatedDiscountAmountAsMoney": {
                            "amount": 0.0,
						"currency": "ISK"
					}
				}],
				"issuerName": "Reykjavik Excursions",
				"invoiceNumber": "S-3095622",
				"recipientName": "Northern Adventures ehf",
				"free": false,
				"totalDiscountedAsMoney": {
                        "amount": 2974.0,
					"currency": "ISK"
				},
				"totalAsMoney": {
                        "amount": 2974.0,
					"currency": "ISK"
				},
				"totalDueAsMoney": {
                        "amount": 2974.0,
					"currency": "ISK"
				},
				"totalDiscountAsMoney": {
                        "amount": 0.0,
					"currency": "ISK"
				},
				"totalAsText": "ISK 2,974",
				"totalDiscountedAsText": "ISK 2,974",
				"totalDueAsText": "ISK 2,974",
				"excludedTaxes": false,
				"totalExcludedTaxAsMoney": {
                        "amount": 0.0,
					"currency": "ISK"
				},
				"totalExcludedTaxAsText": "ISK 0",
				"includedTaxes": true,
				"totalIncludedTaxAsMoney": {
                        "amount": 590.0,
					"currency": "ISK"
				},
				"totalIncludedTaxAsText": "ISK 590",
				"totalTaxAsMoney": {
                        "amount": 590.0,
					"currency": "ISK"
				},
				"totalTaxAsText": "ISK 590"
			},
			"notes": [],
			"supplierContractFlags": ["Account:611117-0430"],
			"sellerContractFlags": [],
			"cancellationPolicy": {
                    "id": 3656,
				"title": "Default",
				"penaltyRules": [{
                        "id": 4280,
					"cutoffHours": 24,
					"charge": 100.0,
					"chargeType": "percentage"
				}],
				"tax": null
			},
			"bookingRoles": ["NONE", "SELLER"],
			"date": 1565222400000,
			"startTime": "04:00",
			"startTimeId": 46605,
			"rateId": 17168,
			"rateTitle": "Standard rate",
			"activity": {
                    "id": 15501,
				"externalId": "FB01",
				"productGroupId": 238,
				"productCategory": "ACTIVITIES",
				"box": false,
				"inventoryLocal": true,
				"inventorySupportsPricing": false,
				"inventorySupportsAvailability": false,
				"creationDate": null,
				"lastModified": "Wed May 22 15:31:48 UTC 2019",
				"lastPublished": "Wed May 22 15:32:00 UTC 2019",
				"published": true,
				"title": "Flybus - BSI to Airport",
				"description": "Transfer from <b>BSÍ Bus Terminal </b>to KEF Airport. Departs from KEF Airport in connection with all arriving flights.",
				"excerpt": "The Flybus airport shuttle takes you from Keflavik International Airport to downtown Reykjavik & back. Seats are guaranteed & buses operate for every flight departure & arrival.",
				"cancellationPolicy": null,
				"overrideBarcodeFormat": false,
				"barcodeType": "QR_CODE",
				"timeZone": "UTC",
				"mainContactFields": [],
				"requiredCustomerFields": [],
				"keywords": ["flybus", "hotel", "fb", "airport"],
				"flags": ["flybus"],
				"slug": null,
				"baseLanguage": "en",
				"languages": ["en"],
				"paymentCurrencies": ["ISK"],
				"customFields": [],
				"tagGroups": [],
				"categories": [],
				"keyPhoto": {
                        "id": 49740,
					"originalUrl": "https://bokun.s3.amazonaws.com/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg",
					"description": "Flybus",
					"alternateText": "flybus",
					"flags": [],
					"derived": [{
                            "name": "large",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660"
					}, {
                            "name": "preview",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300"
					}, {
                            "name": "thumbnail",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop"
					}],
					"fileName": "/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg"
				},
				"photos": [{
                        "id": 49740,
					"originalUrl": "https://bokun.s3.amazonaws.com/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg",
					"description": "Flybus",
					"alternateText": "flybus",
					"flags": [],
					"derived": [{
                            "name": "large",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=660&h=660"
					}, {
                            "name": "preview",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=300&h=300"
					}, {
                            "name": "thumbnail",
						"url": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop",
						"cleanUrl": "https://bokunprod.imgix.net/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg?w=80&h=80&fit=crop"
					}],
					"fileName": "/b1e50ba4-5fcf-4f94-9813-ebd4ba83a791.jpg"
				}],
				"videos": [],
				"vendor": {
                        "id": 34,
					"title": "Reykjavik Excursions",
					"currencyCode": "ISK",
					"showInvoiceIdOnTicket": false,
					"showAgentDetailsOnTicket": false,
					"showPaymentsOnInvoice": false,
					"companyEmailIsDefault": false
				},
				"boxedVendor": null,
				"storedExternally": false,
				"pluginId": null,
				"reviewRating": null,
				"reviewCount": 0,
				"activityType": "DAY_TOUR_OR_ACTIVITY",
				"bookingType": "DATE_AND_TIME",
				"scheduleType": "RECURRING",
				"capacityType": "LIMITED",
				"passExpiryType": "NEVER",
				"fixedPassExpiryDate": null,
				"meetingType": "MEET_ON_LOCATION",
				"privateActivity": false,
				"passCapacity": 0,
				"passValidForDays": null,
				"passesAvailable": 0,
				"dressCode": false,
				"passportRequired": false,
				"supportedAccessibilityTypes": [],
				"startPoints": [{
                        "id": 1183,
					"created": [2019, 6, 17, 9, 11, 51, 702000000],
					"type": null,
					"title": "BSI Bus Terminal",
					"code": null,
					"address": {
                            "id": 59072,
						"created": [2017, 6, 14, 13, 12, 8],
						"addressLine1": "",
						"addressLine2": "",
						"addressLine3": null,
						"city": "Reykjavík",
						"state": null,
						"postalCode": "101",
						"countryCode": "IS",
						"mapZoomLevel": 16,
						"geoPoint": {
                                "latitude": 64.1376866,
							"longitude": -21.934434399999986
						},
						"unLocode": {
                                "country": "IS",
							"city": "REY"
						}
					},
					"pickupTicketDescription": null,
					"dropoffTicketDescription": null,
					"labels": []
				}],
				"bookingQuestions": [],
				"passengerFields": [],
				"inclusions": [],
				"included": "",
				"exclusions": [],
				"excluded": null,
				"requirements": "",
				"knowBeforeYouGoItems": [],
				"attention": "",
				"locationCode": null,
				"googlePlace": {
                        "id": 3092,
					"country": "Iceland",
					"countryCode": "IS",
					"city": "Reykjavík",
					"cityCode": "REY",
					"geoLocationCenter": {
                            "lat": 0.0,
						"lng": 0.0
					}
				},
				"bookingCutoffMinutes": 0,
				"bookingCutoffHours": 2,
				"bookingCutoffDays": 0,
				"bookingCutoffWeeks": 0,
				"requestDeadlineMinutes": 0,
				"requestDeadlineHours": 0,
				"requestDeadlineDays": 2,
				"requestDeadlineWeeks": 0,
				"boxedActivityId": null,
				"comboActivity": false,
				"comboParts": [],
				"pickupActivityId": null,
				"allowCustomizedBookings": false,
				"dayBasedAvailability": false,
				"selectFromDayOptions": false,
				"dayOptions": [],
				"activityCategories": [],
				"activityAttributes": [],
				"guidanceTypes": [],
				"defaultRateId": 17168,
				"rates": [{
                        "id": 17168,
					"title": "Standard rate",
					"description": null,
					"index": 0,
					"rateCode": null,
					"pricedPerPerson": true,
					"minPerBooking": 1,
					"maxPerBooking": null,
					"cancellationPolicy": {
                            "id": 3656,
						"created": [2019, 6, 17, 9, 11, 51, 711000000],
						"title": "Default",
						"tax": null,
						"penaltyRules": [{
                                "id": 4280,
							"created": [2019, 6, 17, 9, 11, 51, 711000000],
							"cutoffHours": 24,
							"percentage": 100.0
						}]
					},
					"fixedPassExpiryDate": null,
					"passValidForDays": null,
					"pickupSelectionType": "UNAVAILABLE",
					"pickupPricingType": "INCLUDED_IN_PRICE",
					"pickupPricedPerPerson": false,
					"dropoffSelectionType": "OPTIONAL",
					"dropoffPricingType": "INCLUDED_IN_PRICE",
					"dropoffPricedPerPerson": false,
					"extraConfigs": [],
					"startTimeIds": [],
					"tieredPricingEnabled": false,
					"tiers": [],
					"pricingCategoryIds": [],
					"details": []
				}, {
                        "id": 446578,
					"title": "FlexibleFlybus One-Way KEF-BSI",
					"description": "",
					"index": 1,
					"rateCode": null,
					"pricedPerPerson": true,
					"minPerBooking": 1,
					"maxPerBooking": 15,
					"cancellationPolicy": {
                            "id": 3656,
						"created": [2019, 6, 17, 9, 11, 51, 717000000],
						"title": "Default",
						"tax": null,
						"penaltyRules": [{
                                "id": 4280,
							"created": [2019, 6, 17, 9, 11, 51, 717000000],
							"cutoffHours": 24,
							"percentage": 100.0
						}]
					},
					"fixedPassExpiryDate": null,
					"passValidForDays": null,
					"pickupSelectionType": "UNAVAILABLE",
					"pickupPricingType": "INCLUDED_IN_PRICE",
					"pickupPricedPerPerson": false,
					"dropoffSelectionType": "UNAVAILABLE",
					"dropoffPricingType": "INCLUDED_IN_PRICE",
					"dropoffPricedPerPerson": false,
					"extraConfigs": [],
					"startTimeIds": [50447],
					"tieredPricingEnabled": false,
					"tiers": [],
					"pricingCategoryIds": [],
					"details": []
				}],
				"ticketPerPerson": false,
				"durationType": "MINUTES",
				"duration": 45,
				"durationMinutes": 45,
				"durationHours": 0,
				"durationDays": 0,
				"durationWeeks": 0,
				"durationText": "45 minutes",
				"minAge": 0,
				"nextDefaultPrice": null,
				"nextDefaultPriceMoney": null,
				"pickupService": false,
				"pickupAllotment": false,
				"pickupAllotmentType": "NO_ALLOTMENT",
				"useComponentPickupAllotments": false,
				"pickupFlags": [],
				"customPickupAllowed": false,
				"pickupMinutesBefore": 0,
				"noPickupMsg": "",
				"ticketMsg": null,
				"showGlobalPickupMsg": false,
				"showNoPickupMsg": false,
				"pickupPlaceGroups": [{
                        "id": 267,
					"active": true,
					"title": "BSI",
					"inclusionType": "HANDPICKED",
					"includedFlags": "",
					"includedPlaces": [],
					"excludedFlags": "",
					"excludedPlaces": [],
					"places": []
				}],
				"dropoffService": true,
				"dropoffFlags": [],
				"customDropoffAllowed": false,
				"useSameAsPickUpPlaces": false,
				"dropoffPlaceGroups": [{
                        "id": 46,
					"active": true,
					"title": "kef",
					"inclusionType": "FLAGGED",
					"includedFlags": "kef",
					"includedPlaces": [],
					"exclusionType": "NONE",
					"excludedPlaces": [],
					"places": [{
                            "id": 34946,
						"title": "Keflavík International Airport (KEF)",
						"type": "AIRPORT",
						"askForRoomNumber": false,
						"externalId": "7a3cde69-3dd7-e111-9521-00505685224a",
						"location": {
                                "address": null,
							"city": "Reykjanes",
							"countryCode": "is",
							"postCode": "230",
							"latitude": null,
							"longitude": null,
							"zoomLevel": 0,
							"wholeAddress": "230 Reykjanes"
						},
						"unLocode": {},
						"flags": ["flybus", "flybus-default-pickup", "flybus-plus", "kef"]
					}]
				}],
				"difficultyLevel": "VERY_EASY",
				"pricingCategories": [{
                        "id": 3646,
					"title": "Adults",
					"ticketCategory": "ADULT",
					"occupancy": 1,
					"ageQualified": true,
					"minAge": 16,
					"maxAge": null,
					"dependent": false,
					"masterCategoryId": 8977,
					"maxPerMaster": 0,
					"sumDependentCategories": false,
					"maxDependentSum": 0,
					"internalUseOnly": false,
					"flags": ["Adults"],
					"defaultCategory": true,
					"fullTitle": "Adults (16+)"
				}, {
                        "id": 3647,
					"title": "Teenagers",
					"ticketCategory": "TEENAGER",
					"occupancy": 1,
					"ageQualified": true,
					"minAge": 12,
					"maxAge": 15,
					"dependent": false,
					"masterCategoryId": 3646,
					"maxPerMaster": 0,
					"sumDependentCategories": false,
					"maxDependentSum": 0,
					"internalUseOnly": false,
					"flags": ["Teenagers"],
					"defaultCategory": false,
					"fullTitle": "Teenagers (12 - 15)"
				}, {
                        "id": 3648,
					"title": "Children",
					"ticketCategory": "CHILD",
					"occupancy": 1,
					"ageQualified": true,
					"minAge": 1,
					"maxAge": 11,
					"dependent": false,
					"masterCategoryId": 3646,
					"maxPerMaster": 0,
					"sumDependentCategories": false,
					"maxDependentSum": 0,
					"internalUseOnly": false,
					"flags": ["Children"],
					"defaultCategory": false,
					"fullTitle": "Children (1 - 11)"
				}],
				"agendaItems": [],
				"startTimes": [{
                        "id": 46605,
					"label": null,
					"hour": 4,
					"minute": 0,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46604,
					"label": null,
					"hour": 4,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46603,
					"label": null,
					"hour": 5,
					"minute": 0,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46602,
					"label": null,
					"hour": 5,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46601,
					"label": null,
					"hour": 6,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46600,
					"label": null,
					"hour": 7,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46599,
					"label": null,
					"hour": 8,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46598,
					"label": null,
					"hour": 9,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46597,
					"label": null,
					"hour": 10,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46596,
					"label": null,
					"hour": 11,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46595,
					"label": null,
					"hour": 12,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46594,
					"label": null,
					"hour": 13,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46593,
					"label": null,
					"hour": 14,
					"minute": 0,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 46592,
					"label": null,
					"hour": 14,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 140754,
					"label": null,
					"hour": 15,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "M",
					"voucherPickupMsg": null,
					"externalId": "",
					"duration": 45,
					"durationMinutes": 45,
					"durationHours": 0,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 140755,
					"label": null,
					"hour": 16,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "M",
					"voucherPickupMsg": null,
					"externalId": "",
					"duration": 45,
					"durationMinutes": 45,
					"durationHours": 0,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 50447,
					"label": null,
					"hour": 18,
					"minute": 0,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 50445,
					"label": null,
					"hour": 20,
					"minute": 0,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "H",
					"voucherPickupMsg": null,
					"externalId": null,
					"duration": 1,
					"durationMinutes": 0,
					"durationHours": 1,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}, {
                        "id": 255871,
					"label": "",
					"hour": 21,
					"minute": 30,
					"overrideTimeWhenPickup": false,
					"pickupHour": 0,
					"pickupMinute": 0,
					"durationType": "M",
					"voucherPickupMsg": "",
					"externalId": "",
					"duration": 45,
					"durationMinutes": 45,
					"durationHours": 0,
					"durationDays": 0,
					"durationWeeks": 0,
					"flags": []
				}],
				"bookableExtras": [],
				"route": null,
				"hasOpeningHours": false,
				"defaultOpeningHours": null,
				"seasonalOpeningHours": [],
				"displaySettings": {
                        "showPickupPlaces": false,
					"showRouteMap": false,
					"selectRateBasedOnStartTime": false,
					"customFields": []
				},
				"hasBoxes": true,
				"bookingCutoff": 120,
				"requestDeadline": 172800000,
				"actualId": 15501,
				"nextDefaultPriceAsText": "",
				"actualVendor": {
                        "id": 34,
					"title": "Reykjavik Excursions",
					"currencyCode": "ISK",
					"showInvoiceIdOnTicket": false,
					"showAgentDetailsOnTicket": false,
					"showPaymentsOnInvoice": false,
					"companyEmailIsDefault": false
				}
			},
			"bookingAnswers": [],
			"pickupAnswers": [],
			"dropoffAnswers": [],
			"flexible": false,
			"customized": false,
			"customizedDurationMinutes": 0,
			"customizedDurationHours": 0,
			"customizedDurationDays": 0,
			"customizedDurationWeeks": 0,
			"ticketPerPerson": false,
			"pricingCategoryBookings": [{
                    "id": 24794722,
				"pricingCategoryId": 3646,
				"pricingCategory": {
                        "id": 3646,
					"title": "Adults",
					"ticketCategory": "ADULT",
					"occupancy": 1,
					"ageQualified": true,
					"minAge": 16,
					"maxAge": null,
					"dependent": false,
					"masterCategoryId": null,
					"maxPerMaster": 0,
					"sumDependentCategories": false,
					"maxDependentSum": 0,
					"internalUseOnly": false,
					"flags": ["Adults"],
					"defaultCategory": false,
					"fullTitle": "Adults (16+)"
				},
				"leadPassenger": false,
				"age": 0,
				"passengerInfo": {
                        "contactDetailsHidden": false,
					"contactDetailsHiddenUntil": null,
					"id": 11046773,
					"created": null,
					"uuid": "f919a54e-6f5a-45d2-bb65-3054355df140",
					"email": null,
					"title": null,
					"firstName": null,
					"lastName": null,
					"personalIdNumber": null,
					"language": null,
					"nationality": null,
					"sex": null,
					"dateOfBirth": null,
					"phoneNumber": null,
					"phoneNumberCountryCode": null,
					"address": null,
					"postCode": null,
					"state": null,
					"place": null,
					"country": null,
					"organization": null,
					"passportId": null,
					"passportExpDay": null,
					"passportExpMonth": null,
					"passportExpYear": null,
					"credentials": null
				},
				"bookingAnswers": [],
				"bookedTitle": "Adults",
				"quantity": 1,
				"extras": [],
				"answers": [],
				"flags": ["Adults"]
			}],
			"extras": [],
			"bookingFields": [],
			"pickup": false,
			"dropoff": false,
			"inventoryConfirmFailed": false,
			"bookedPricingCategories": [{
                    "id": 3646,
				"title": "Adults",
				"ticketCategory": null,
				"occupancy": 1,
				"ageQualified": false,
				"minAge": null,
				"maxAge": null,
				"dependent": false,
				"masterCategoryId": null,
				"maxPerMaster": 0,
				"sumDependentCategories": false,
				"maxDependentSum": 0,
				"internalUseOnly": false,
				"flags": [],
				"defaultCategory": false,
				"fullTitle": "Adults"
			}],
			"totalParticipants": 1,
			"quantityByPricingCategory": {
                    "3646": 1
			},
			"savedAmount": 0.0
		}],
		"routeBookings": [],
		"bookingFields": []
	},
	"bookingHash": "JDJhJDEwJDFDVEVKaldkQ3g1WlJCZk91WjZLdWUvNnJyeFZRWkk0Rm9pYlEveERaak1LeXdXYWEwLmRP",
	"travelDocuments": {
            "invoice": "/traveldocs/5165423/JDJhJDEwJDFDVEVKaldkQ3g1WlJCZk91WjZLdWUvNnJyeFZRWkk0Rm9pYlEveERaak1LeXdXYWEwLmRP/invoice/invoice-NAG-5165423.pdf",
		"activityTickets": [{
                "bookingId": 5165423,
			"productTitle": "Flybus - BSI to Airport (Standard rate)",
			"productConfirmationCode": "REY-T9091665",
			"ticket": "/traveldocs/activities/9091665/JDJhJDEwJDFDVEVKaldkQ3g1WlJCZk91WjZLdWUvNnJyeFZRWkk0Rm9pYlEveERaak1LeXdXYWEwLmRP/ticket/ticket-REY-T9091665.pdf"
		}],
		"accommodationTickets": [],
		"rentalTickets": [],
		"transportTickets": []
	}
}';

    }
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
