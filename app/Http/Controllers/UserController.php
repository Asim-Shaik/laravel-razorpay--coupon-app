<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\HasApiTokens;
class UserController extends Controller
{
    use HasApiTokens;

    public function create(Request $request){
        request()->validate([
        'name'=> 'required',
        'email'=>'required',
        'password'=>'required'
    ]);

    $user= User::create([
        'name'=>request('name'),
        'email'=>request('email'),
        'password'=>Hash::make(request('password'))
    ]);
     $token= $user->createToken('Token')->accessToken;

    return response()->json(['token'=>$token,'user'=>$user],200);
    }

    public function updateUser(User $user){
        request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $success = $user->update([
            'name' => request('name'),
            'email' => request('email'),
        ]);

        return [
            'success' => $success
        ];
    }
    public function otp (){
         try{

            $api_key = '3636B555FAD47A';
            $contacts = '9814542731';
            $from = 'Pharmseva';
            $sms_text = urlencode('This is a test OTP 756887');

            $api_url = "https://samayasms.com.np/smsapi/index.php?key=".$api_key."&campaign=XXXXXX&routeid=XXXXXX&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ])->get($api_url);
    
            return $response;
        }catch(Exception $e){
            return response()->json([
                "status"=> 500,
                "message" => $e->getMessage(),
            ]);
        }
    }
}
