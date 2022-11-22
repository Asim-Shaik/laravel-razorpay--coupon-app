<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/create', [UserController::class,'create']);
// // Route::post('/login', [UserController::class,'login']);
// Route::put('/user/{user}',[UserController::class, 'updateUser']);

Route::post('payment',[PaymentController::class, 'store'])->name('razorpay.payment.store');
Route::get('otp',[UserController::class, 'otp']);
