<?php

namespace App\Http\Controllers;

use App\Mail\Coupon;
use App\Models\Coupon as ModelsCoupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session ;
// use Razorpay\Api\Api;
use Razorpay\Api\Api;
class PaymentController extends Controller
{
     public function store(Request $request)
    {
        $input = $request->all();
        $validated = $request->validate([
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
    ]);
    $email = $input['email'];

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                $modelCall= ModelsCoupon::latest('created_at')->get()->first()  ;
                $coupon = $modelCall->coupon + 1;
                $input['coupon']= $coupon;

                Mail::to($email )->send(new Coupon($input));
                ModelsCoupon::create([
                    'name'=>$input['name'],
                    'email'=>$input['email'],
                    'phone'=>$input['phone'],
                    'coupon'=>$input['coupon'],
                    'razorpay_payment_id'=>$input['razorpay_payment_id']
                ]);
                return view('Confirmation')->with('inputs',$input);
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