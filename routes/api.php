<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PasswordResetController;

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

Route::post('login', 'AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');

    Route::apiResource('user', 'UserController');

    // frame
    Route::apiResource('material', 'MaterialController');
    Route::apiResource('brand', 'BrandController');
    Route::apiResource('supplier', 'SupplierController');

    Route::apiResource('frame', 'FrameController');
    Route::delete('frame-delete-multiple','FrameController@deleteMultiple');
    Route::get('frame-export-pdf', 'FrameController@exportPdf');

    // customer
    Route::apiResource('agreement', 'AgreementController');
    Route::apiResource('customer', 'CustomerController');
    Route::delete('customer-delete-multiple', 'CustomerController@deleteMultiple');
    Route::apiResource('address', 'AddressController');

    // services
    Route::apiResource('service', 'ServiceController');
    Route::delete('service-delete-multiple', 'ServiceController@deleteMultiple');

    // financial
    Route::apiResource('payment-method', 'PaymentMethodController');
    Route::apiResource('sale', 'SaleController');
});

Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);
Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);
