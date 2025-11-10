<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function CheckOut(Request $request, $id = null)
    {

        $Cart_Items = array();
        /*Generate SEssion ID if no exists*/
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {

            $Cart_Items = Carts::where('session_id', $session_id)->get()->toArray();

        }

        $pak_price = 0;
        $Currencies = Currencies::get()->first();
        if (!empty($Currencies)) {
            $pak_price = $Currencies['pak_price'];
        }

        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = array(
                'payment_method' => 'required',
            );

            $this->validate($request, $rules);

            DB::beginTransaction();

            $check_details = CheckOuts::select('check_out_no')->latest()->first();

            if (!empty($check_details)) {
                $check_out_no = $check_details['check_out_no'];
                if ($check_out_no > 0) {
                    $check_out_no = $check_out_no + 1;
                } else {
                    $check_out_no = 1000;
                }
            } else {
                $check_out_no = 1000;
            }

            if (isset($data['CreateAccountCheckbox']) && $data['CreateAccountCheckbox'] == 1) {

                $userCheck = User::where('email', $data['email'])->count();
                if ($userCheck > 0) {
                    $message = "Email Already exist";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }

                if ($data['password'] != $data['confirm_password']) {
                    $message = "Passwords not matched";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }

                $User = new User();
                $User->name = $data['name'] . ' ' . $data['last_name'];
                $User->first_name = $data['name'];
                $User->last_name = $data['last_name'];
                $User->email = $data['email'];
                $User->user_type = 2;
                $User->mobile = $data['mobile'];
                $User->company_name = $data['company_name'];
                $User->address = $data['address'];
                $User->country = $data['country'];
                $User->password = bcrypt($data['password']);
                $User->image = "default-admin.jpeg";
                $User->status = 1;
                $User->save();

                /*Send email to active account*/
                $email = $data['email'];
                $messageData = array(
                    'code'     => base64_encode($data['email']),
                    'email'    => $data['email'],
                    'name'     => $data['name'],
                    'password' => $data['password'],
                    'mobile'   => $data['mobile']

                );

                $sent = Mail::send('emails.confirmAccount', $messageData, function ($message) use ($email) {

                    $message->to($email)->subject('Confirm Account - addresszone ');
                    $message->bcc(ENV('BCC_EMAIL'));
                });

                if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password']))) {

                    /*Generate SEssion ID if no exists*/
                    $session_id = Session::get('session_id');
                    if (!empty($session_id)) {

                        Carts::where('session_id', $session_id)->update(['user_id' => Auth::user()->id]);
                    }

                    $total = 0;
                    $CheckOuts = new CheckOuts();
                    $CheckOuts->payment_method = $data['payment_method'];
                    $CheckOuts->packageType = $data['packageType'];
                    $CheckOuts->check_out_no = $check_out_no;
                    $CheckOuts->paid_unpaid = 0;
                    $CheckOuts->server_name = $_SERVER['SERVER_NAME'];

                    if (!empty($Cart_Items)) {
                        foreach ($Cart_Items as $Cart_Item) {

                            $ServicesDetails = Services::where('id', $Cart_Item['service_id'])->get()->first();
                            if (!empty($ServicesDetails)) {
                                $productSlug = $ServicesDetails['slug'];

                                $total += $ServicesDetails['price'];
                            }
                        }
                    }

                    $amount = number_format((float)$total, 2, '.', '');

                    if ($data['packageType'] == 1) {
                        $Addresses = CustomerLocations::orderBy('id', 'desc')->where('address_criteria', 3)->get()->first();
                        if (!empty($Addresses)) {
                            $last_address_digit = $Addresses['last_address_digit'];
                            $last_address_letter = $Addresses['last_address_letter'];

                            $last_address_digit = (int)$last_address_digit + 1;
                        } else {
                            $last_address_digit = 1;
                            $last_address_letter = "A10";
                        }

                        $address_criteria = 3; /*Regular Criteria*/

                        $complete_address = env('address_3') . $last_address_letter . ' ' . $last_address_digit . env('address_4');

                        $address_1 = env('address_3');
                        $address_2 = env('address_4');
                    } else {
                        // dd('working21');
                        $address_criteria = 4; /*Regular Criteria*/
                        for ($i = 1; $i <= 10000; $i++) {
                            if ($i == 1) {
                                $Addresses = CustomerLocations::orderBy('id', 'desc')->where('address_criteria', 4)->get()->first();
                                if (!empty($Addresses)) {
                                    $last_address_digit = $Addresses['last_address_digit'];
                                    $last_address_letter = $Addresses['last_address_letter'];
                                    $last_address_digit = (int)$last_address_digit + 1;
                                } else {
                                    $last_address_digit = 13;
                                    $last_address_letter = "7";
                                }
                            }
                            if ((int)$last_address_digit == 10000) {
                                $message = "Address not available please contact administration thanks.";
                                session::flash('error_message', $message);
                                return redirect()->back();
                            }
                        }
                        $complete_address = env('address_5') . $last_address_letter . $last_address_digit . env('address_6');
                        $address_1 = env('address_5');
                        $address_2 = env('address_6');
                    }

                    $CheckOuts->grand_total = $total;
                    $CheckOuts->user_id = Auth::user()->id;
                    $CheckOuts->session_id = $session_id;
                    $CheckOuts->pak_price = $pak_price;

                    $paid_unpaid = 0;

                    if ($data['payment_method'] == 2) {
                        $intervalCount = 0;
                        if ($productSlug == 'quarterly') {
                            $intervalCount = 3;
                        } elseif ($productSlug == 'semi-annually') {
                            $intervalCount = 6;
                        } elseif ($productSlug == 'annually') {
                            $intervalCount = 12;
                        }

                        $stripeStatusMessage = "";
                        try {

                            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                            $customer = \Stripe\Customer::create(array(
                                'email'  => $data['email'],
                                'source' => $request->stripeToken
                            ));
                            $plan = \Stripe\Plan::create(array(
                                "product"        => [
                                    "name" => "Tesing Plan"
                                ],
                                "amount"         => $amount * 100,
                                "currency"       => "GBP",
                                "interval"       => 'month',
                                "interval_count" => $intervalCount
                            ));
                            $stripe = \Stripe\Subscription::create(array(
                                "customer" => $customer->id,
                                "items"    => array(
                                    array(
                                        "plan" => $plan->id,
                                    ),
                                ),
                            ));

                            $stripeStatus = $stripe->status;
                        } catch (Exception $e) {
                            // Something else happened, completely unrelated to Stripe

                            $stripeStatus = $e->getHttpStatus();
                            $stripeStatusMessage = $e->getError()->message;
                        }

                        if (isset($stripeStatus) && $stripeStatus == "active") {

                            $CheckOuts->payment_details = json_encode($stripe);
                            $CheckOuts->paid_unpaid = 1;
                            $paid_unpaid = 1;

                            $CheckOuts->stripe_customer_id = $customer->id;
                            $CheckOuts->stripe_subsription_id = $stripe->id;
                        } else {

                            $message = $stripeStatusMessage;
                            session::flash('error_message', $message);
                            return redirect()->back();

                            $CheckOuts->paid_unpaid = 0;
                            $paid_unpaid = 0;
                        }
                    }

                    $CheckOuts->save();

                    /*get last inserted order ID*/
                    $CheckOutsID = DB::getPdo()->lastInsertId();

                    if (!empty($Cart_Items)) {
                        foreach ($Cart_Items as $Cart_Item) {

                            $CheckOutsItems = new CheckOutsItems();
                            $CheckOutsItems->check_out_id = $CheckOutsID;
                            $CheckOutsItems->service_id = $Cart_Item['service_id'];
                            $CheckOutsItems->service_quantity = $Cart_Item['service_quantity'];
                            $CheckOutsItems->session_id = $Cart_Item['session_id'];
                            $CheckOutsItems->price = $Cart_Item['price'];
                            $CheckOutsItems->paid_unpaid = $paid_unpaid;
                            $CheckOutsItems->user_id = Auth::user()->id;

                            if (Session::has('couponAmount')) {

                                $couponID = Session::get('couponID');

                                $CouponsDetails = Coupons::where('id', $couponID)->get()->first();

                                if (!empty($CouponsDetails)) {

                                    $CheckOutsItems->agent_id = $CouponsDetails['created_by'];
                                }
                            }

                            $ServicesDetails = Services::where('id', $Cart_Item['service_id'])->get()->first();
                            if (!empty($ServicesDetails)) {

                                $months = $ServicesDetails['months'];

                                $expire_date = date('Y-m-d', strtotime("+$months months"));
                                $CheckOutsItems->expire_date = $expire_date;

                            }
                            $CheckOutsItems->save();

                            $CheckOutsItemsID = DB::getPdo()->lastInsertId();

                            if ($data['payment_method'] == 2 && $paid_unpaid == 1) {

                                $CustomerLocations = new CustomerLocations;
                                $CustomerLocations->address_1 = $address_1;
                                $CustomerLocations->address_2 = $address_2;

                                $CustomerLocations->last_address_digit = $last_address_digit;
                                $CustomerLocations->last_address_letter = $last_address_letter;
                                $CustomerLocations->address_criteria = $address_criteria;
                                $CustomerLocations->complete_address = $complete_address;
                                $CustomerLocations->user_id = Auth::user()->id;
                                $CustomerLocations->check_out_id = $CheckOutsID;
                                $CustomerLocations->check_out_item_id = $CheckOutsItemsID;
                                $CustomerLocations->save();
                            }
                        }
                    }

                    $Cart_Items = Carts::where('session_id', $session_id)->delete();
                    $Cart_Items = Carts::where('user_id', Auth::user()->id)->delete();

                    DB::commit();

                    $CheckOutsDetails = CheckOuts::find($CheckOutsID);
                    $CheckOutsItemsDetails = CheckOutsItems::where('check_out_id', $CheckOutsID)->get()->toArray();

                    /*Send email to active account*/
                    $email = Auth::user()->email;
                    $messageData = array(
                        'CheckOutsDetails'      => $CheckOutsDetails,
                        'CheckOutsItemsDetails' => $CheckOutsItemsDetails,

                    );

                    $view = View::make('emails.checkOut', compact('CheckOutsDetails', 'CheckOutsItemsDetails'))->render();

                    // Create an instance of MPDF
                    $mpdf = new Mpdf();

                    $mpdf = new Mpdf([
                        'format'      => 'A4-P', // Set custom page size (A4-L for landscape, A4-P for portrait)
                        'orientation' => 'P', // Set landscape orientation
                    ]);
                    $pdfContent = view('emails.checkOut', compact('CheckOutsDetails', 'CheckOutsItemsDetails'))->render();

                    // Generate the PDF from the view content
                    $mpdf->WriteHTML($pdfContent);

                    // Get the PDF content as a string
                    $pdfString = $mpdf->Output('', 'S');

                    // Store the PDF temporarily
                    $pdfPath = storage_path('app/public/document.pdf');
                    file_put_contents($pdfPath, $pdfString);

                    // Compose the email
                    Mail::raw('Please see the attached PDF.', function ($message) use ($pdfPath, $email) {
                        $message->to($email)
                            ->subject('PDF Attachment');

                        $message->attach($pdfPath, [
                            'as'   => 'document.pdf',
                            'mime' => 'application/pdf',
                        ]);
                    });

                    // Delete the temporary PDF file
                    unlink($pdfPath);

                    $message = "Checkout  successfully.";
                    Session::flash("success_message", $message);
                    return redirect()->route('Thanks');
                } else {

                    $message = "Invalid Email or Password";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }

            } else {

                /*Generate SEssion ID if no exists*/
                $session_id = Session::get('session_id');
                if (!empty($session_id)) {

                    Carts::where('session_id', $session_id)->update(['user_id' => Auth::user()->id]);
                }

                $total = 0;
                $CheckOuts = new CheckOuts();
                $CheckOuts->payment_method = $data['payment_method'];
                $CheckOuts->packageType = $data['packageType'];
                $CheckOuts->check_out_no = $check_out_no;
                $CheckOuts->pak_price = $pak_price;
                $CheckOuts->paid_unpaid = 0;
                $CheckOuts->server_name = $_SERVER['SERVER_NAME'];

                $paid_unpaid = 0;

                if (!empty($Cart_Items)) {
                    foreach ($Cart_Items as $Cart_Item) {

                        $ServicesDetails = Services::where('id', $Cart_Item['service_id'])->get()->first();
                        if (!empty($ServicesDetails)) {
                            $productSlug = $ServicesDetails['slug'];
                            $total += $ServicesDetails['price'];
                        }
                    }
                }

                $amount = number_format((float)$total, 2, '.', '');

                if ($data['packageType'] == 1) {

                    $Addresses = CustomerLocations::orderBy('id', 'desc')->where('address_criteria', 3)->get()->first();
                    if (!empty($Addresses)) {

                        $last_address_digit = $Addresses['last_address_digit'];
                        $last_address_letter = $Addresses['last_address_letter'];

                        $last_address_digit = (int)$last_address_digit + 1;
                    } else {

                        $last_address_digit = 1;
                        $last_address_letter = "A10";
                    }

                    $address_criteria = 3; /*Regular Criteria*/

                    $complete_address = env('address_3') . $last_address_letter . ' ' . $last_address_digit . env('address_4');

                    $address_1 = env('address_3');
                    $address_2 = env('address_4');

                } else {
                    // dd('working24');
                    $address_criteria = 4; /*Regular Criteria*/
                    for ($i = 1; $i <= 10000; $i++) {
                        if ($i == 1) {
                            $Addresses = CustomerLocations::orderBy('id', 'desc')->where('address_criteria', 4)->get()->first();
                            if (!empty($Addresses)) {
                                $last_address_digit = $Addresses['last_address_digit'];
                                $last_address_letter = $Addresses['last_address_letter'];
                                $last_address_digit = (int)$last_address_digit + 1;
                            } else {
                                $last_address_digit = 13;
                                $last_address_letter = "7";
                            }
                        }
                        if ((int)$last_address_digit == 10000) {
                            $message = "Address not available please contact administration thanks.";
                            session::flash('error_message', $message);
                            return redirect()->back();
                        }
                    }
                    $complete_address = env('address_5') . $last_address_letter . $last_address_digit . env('address_6');
                    $address_1 = env('address_5');
                    $address_2 = env('address_6');
                }

                $CheckOuts->grand_total = $total;
                $CheckOuts->user_id = Auth::user()->id;

                $CheckOuts->session_id = $session_id;

                if ($data['payment_method'] == 2) {

                    if ($productSlug == 'quarterly') {
                        $intervalCount = 3;
                    } elseif ($productSlug == 'semi-annually') {
                        $intervalCount = 6;
                    } elseif ($productSlug == 'annually') {
                        $intervalCount = 12;
                    }
                    $stripeStatusMessage = "";
                    //  $amount = 0.25;
                    try {

                        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                        $customer = \Stripe\Customer::create(array(
                            'email'  => isset($data['email']) ? $data['email'] : "",
                            'source' => $request->stripeToken
                        ));
                        $plan = \Stripe\Plan::create(array(
                            "product"        => [
                                "name" => "Tesing Plan"
                            ],
                            "amount"         => $amount * 100,
                            "currency"       => "GBP",
                            "interval"       => 'month',
                            "interval_count" => $intervalCount
                        ));

                        $stripe = \Stripe\Subscription::create(array(
                            "customer" => $customer->id,
                            "items"    => array(
                                array(
                                    "plan" => $plan->id,
                                ),
                            ),
                        ));

                        $stripeStatus = $stripe->status;
                    } catch (\Stripe\Exception\CardException $e) {

                        $stripeStatus = $e->getHttpStatus();
                        $stripeStatusMessage = $e->getError()->message;

                    }

                    $stripeStatus = $stripe->status;

                    if ($stripeStatus == "active") {

                        $CheckOuts->payment_details = json_encode($stripe);
                        $CheckOuts->paid_unpaid = 1;
                        $paid_unpaid = 1;

                        $CheckOuts->stripe_customer_id = $customer->id;
                        $CheckOuts->stripe_subsription_id = $stripe->id;
                    } else {

                        $message = $stripeStatusMessage;
                        session::flash('error_message', $message);
                        return redirect()->back();

                        $CheckOuts->paid_unpaid = 0;
                        $paid_unpaid = 0;
                    }
                }

                $CheckOuts->save();

                /*get last inserted order ID*/
                $CheckOutsID = DB::getPdo()->lastInsertId();

                if (!empty($Cart_Items)) {
                    foreach ($Cart_Items as $Cart_Item) {

                        $CheckOutsItems = new CheckOutsItems();
                        $CheckOutsItems->check_out_id = $CheckOutsID;
                        $CheckOutsItems->service_id = $Cart_Item['service_id'];
                        $CheckOutsItems->service_quantity = $Cart_Item['service_quantity'];
                        $CheckOutsItems->session_id = $Cart_Item['session_id'];
                        $CheckOutsItems->price = $Cart_Item['price'];
                        $CheckOutsItems->user_id = Auth::user()->id;
                        $CheckOutsItems->paid_unpaid = $paid_unpaid;

                        $ServicesDetails = Services::where('id', $Cart_Item['service_id'])->get()->first();
                        if (!empty($ServicesDetails)) {

                            $months = $ServicesDetails['months'];

                            $expire_date = date('Y-m-d', strtotime("+$months months"));

                            $CheckOutsItems->expire_date = $expire_date;
                        }

                        $CheckOutsItems->save();
                    }
                }

                /*get last inserted $CheckOutsItemsID*/
                $CheckOutsItemsID = DB::getPdo()->lastInsertId();

                if ($data['payment_method'] == 2 && $paid_unpaid == 1) {

                    $CustomerLocations = new CustomerLocations;

                    $CustomerLocations->address_1 = $address_1;
                    $CustomerLocations->address_2 = $address_2;

                    $CustomerLocations->last_address_digit = $last_address_digit;
                    $CustomerLocations->last_address_letter = $last_address_letter;
                    $CustomerLocations->address_criteria = $address_criteria;
                    $CustomerLocations->complete_address = $complete_address;
                    $CustomerLocations->user_id = Auth::user()->id;
                    $CustomerLocations->check_out_id = $CheckOutsID;
                    $CustomerLocations->check_out_item_id = $CheckOutsItemsID;
                    $CustomerLocations->save();
                }

                $Cart_Items = Carts::where('session_id', $session_id)->delete();
                $Cart_Items = Carts::where('user_id', Auth::user()->id)->delete();

                DB::commit();

                if (Session::has('session_id')) {

                    Session::forget('session_id');
                }

                $CheckOutsDetails = CheckOuts::find($CheckOutsID);
                $CheckOutsItemsDetails = CheckOutsItems::where('check_out_id', $CheckOutsID)->get()->toArray();
                /*Send email to active account*/
                $email = Auth::user()->email;
                $messageData = array(
                    'CheckOutsDetails'      => $CheckOutsDetails,
                    'CheckOutsItemsDetails' => $CheckOutsItemsDetails,

                );

                $view = View::make('emails.checkOut', compact('CheckOutsDetails', 'CheckOutsItemsDetails'))->render();

                // Create an instance of MPDF
                $mpdf = new Mpdf();

                $mpdf = new Mpdf([
                    'format'      => 'A4-P', // Set custom page size (A4-L for landscape, A4-P for portrait)
                    'orientation' => 'P', // Set landscape orientation
                ]);
                $pdfContent = view('emails.checkOut', compact('CheckOutsDetails', 'CheckOutsItemsDetails'))->render();

                // Generate the PDF from the view content
                $mpdf->WriteHTML($pdfContent);

                // Get the PDF content as a string
                $pdfString = $mpdf->Output('', 'S');

                // Store the PDF temporarily
                $pdfPath = storage_path('app/public/document.pdf');
                file_put_contents($pdfPath, $pdfString);

                // Compose the email
                Mail::raw('Please see the attached PDF.', function ($message) use ($pdfPath, $email) {
                    $message->to($email)
                        ->subject('PDF Attachment');

                    $message->attach($pdfPath, [
                        'as'   => 'document.pdf',
                        'mime' => 'application/pdf',
                    ]);
                });

                // Delete the temporary PDF file
                unlink($pdfPath);

                $message = "Checkout  successfully.";
                Session::flash("success_message", $message);

                return redirect()->route('Thanks');

            }

            return view('addresszone.CheckOut')->with(compact('Cart_Items'));
        }
    }
