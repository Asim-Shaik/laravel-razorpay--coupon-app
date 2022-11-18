<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
}
