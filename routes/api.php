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

    // customer
    Route::apiResource('agreement', 'AgreementController');
    Route::apiResource('customer', 'CustomerController');
    Route::delete('customer-delete-multiple', 'CustomerController@deleteMultiple');
    Route::apiResource('address', 'AddressController');

    // lenses
    Route::apiResource('type-lens', 'TypeLensController');
    Route::apiResource('treatment', 'TreatmentController');
    Route::apiResource('sensitivity', 'SensitivityController');
    Route::apiResource('lens', 'LensController');
    Route::delete('lens-delete-multiple', 'LensController@deleteMultiple');
    Route::get('lens-export-pdf', 'LensController@exportPdf');

    // frame
    Route::apiResource('material', 'MaterialController');
    Route::apiResource('brand', 'BrandController');
    Route::apiResource('supplier', 'SupplierController');

    Route::apiResource('frame', 'FrameController');
    Route::delete('frame-delete-multiple','FrameController@deleteMultiple');
    Route::get('frame-export-pdf', 'FrameController@exportPdf');

    // services
    Route::apiResource('service', 'ServiceController');
    Route::delete('service-delete-multiple', 'ServiceController@deleteMultiple');

    // financial
    Route::apiResource('payment-method', 'PaymentMethodController'); //Método de pagamento principal
    Route::apiResource('form-payment', 'FormPaymentController'); //Forma de pagamento secundária
    Route::apiResource('card', 'CardController'); //juros do cartão

    Route::apiResource('sale', 'SaleController');
    Route::delete('sale-delete-multiple', 'SaleController@deleteMultiple');
    Route::get('sale-search-stock', 'SaleController@searchStock');

    Route::apiResource('credit-card', 'CreditCardController'); // pagamento no crédito
    Route::apiResource('combined-payment', 'CombinedPaymentController'); // pagamento combinado

    Route::apiResource('payment-credit', 'PaymentCreditController'); // Payment on Credit
    Route::apiResource('installment', 'InstallmentController'); // Manager Installments
});

Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);
Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);
