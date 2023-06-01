<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/user','ApiUsersContronller');
//post :api/user dung để đăng kí tài khoản


Route::post('/user/login', 'ApiUsersContronller@login');// dùng để đăng nhập tài khoản 
Route::get('/userInfo', 'ApiUsersContronller@userInfo');// dùng để lấy thông tin người dùng

Route::get('/orderInfo', 'orderController@orderInfo');// dùng để lấy thông tin order hiện tại
Route::post('/orderSend', 'orderController@orderSend');// dùng để gửi thông tin order từ máy lên serve

Route::get('/momoPayment', 'momoPaymentController@momoPayment');// dùng để gửi thông tin đơn hàng lên serve của momo để tiến hành thanh toán
Route::post('/resultPayment', 'momoPaymentController@resultPayment');// dùng để gửi thông tin order từ máy bán hàng lên serve

Route::get('/zaloPayment', 'zaloPaymentController@zaloPayment');//dùng thanh toán zaloPay
// thanh toán vnpay
Route::get('/vnpayPayment', 'vnpayPaymentController@vnpayPayment');//url thanh toán
Route::get('/IPN', 'vnpayPaymentController@vnpayIPN');//url IPN


Route::post('/userphonelogin', 'apiUsersPhoneController@login');
Route::post('/payOrder', 'apiUsersPhoneController@PayOrder');