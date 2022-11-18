<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session ;
// use Razorpay\Api\Api;
use Razorpay\Api\Api;
class PaymentController extends Controller
{
     public function store(Request $request)
    {
        $input = $request->all();
        return $input;
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                // return redirect()->back();
            }
        }
          
        Session::put('success', 'Payment successful');
        // return redirect()->back();
    }
}