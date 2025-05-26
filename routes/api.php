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
Route::post('auth', 'AuthController@auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');


    // users
    Route::get('user', 'UserController@index');
    Route::post('user', 'UserController@store');
    Route::get('user/{id}', 'UserController@show');
    Route::patch('user/{id}', 'UserController@update');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('user/{id}', 'UserController@destroy');
        Route::delete('user-delete-multiple', 'UserController@deleteAll');
    });

    // customer
    Route::apiResource('agreement', 'AgreementController');

    Route::get('customer', 'deleteMultiple@index');
    Route::post('customer', 'deleteMultiple@store');
    Route::get('customer/{id}', 'deleteMultiple@show');
    Route::patch('customer/{id}', 'deleteMultiple@update');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('customer/{id}', 'deleteMultiple@destroy');
        Route::delete('customer-delete-multiple', 'deleteMultiple@deleteMultiple');
    });

    Route::apiResource('address', 'AddressController');

    // lenses
    Route::apiResource('surfacing', 'SurfacingController');
    Route::delete('surfacing-delete-multiple', 'SurfacingController@deleteAll');

    Route::apiResource('index', 'IndexController');
    Route::delete('index-delete-multiple', 'IndexController@deleteAll');

    Route::apiResource('diameter', 'DiameterController');
    Route::delete('diameter-delete-multiple', 'IndexController@deleteAll');

    Route::apiResource('height', 'HeightController');
    Route::delete('height-delete-multiple', 'HeightController@deleteAll');

    Route::apiResource('type-lens', 'TypeLensController');
    Route::delete('type-lens-delete-multiple', 'TypeLensController@deleteAll');

    Route::apiResource('treatment', 'TreatmentController');
    Route::delete('treatment-delete-multiple', 'TreatmentController@deleteAll');

    Route::apiResource('sensitivity', 'SensitivityController');
    Route::delete('sensitivity-delete-multiple', 'SensitivityController@deleteAll');

    Route::apiResource('laboratory', 'LaboratoryController');
    Route::delete('laboratory-delete-multiple', 'LaboratoryController@deleteAll');

    Route::get('lens', 'LensController@index');
    Route::post('lens', 'LensController@store');
    Route::get('lens/{id}', 'LensController@show');
    Route::patch('lens/{id}', 'LensController@update');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('lens/{id}', 'LensController@destroy');
        Route::delete('lens-delete-multiple', 'LensController@deleteMultiple');
    });
    Route::get('lens-export-pdf', 'LensController@exportPdf');

    Route::apiResource('single-vision', 'SingleVisionController');
    Route::apiResource('multifocal-lens', 'MultifocalLensController');

    // accessory
    Route::apiResource('accessory', 'AccessoryController');
    Route::delete('accessory-delete-multiple', 'AccessoryController@deleteAll');

    // frame
    Route::apiResource('material', 'MaterialController');
    Route::apiResource('brand', 'BrandController');

    Route::apiResource('supplier', 'SupplierController');
    Route::delete('supplier-delete-multiple', 'SupplierController@deleteAll');

    Route::get('supplier-get-all', 'SupplierController@getAll');

    Route::get('frame', 'FrameController@index');
    Route::post('frame', 'FrameController@store');
    Route::get('frame/{id}', 'FrameController@show');
    Route::patch('frame/{id}', 'FrameController@update');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('frame/{id}', 'FrameController@destroy');
        Route::delete('frame-delete-multiple', 'FrameController@deleteMultiple');
    });
    Route::get('frame-report', 'FrameController@exportPdf');
    Route::get('frame-download-qrcode', 'FrameController@downloadQrCode');

    // services
    Route::get('service', 'ServiceController@index');
    Route::post('service', 'ServiceController@store');
    Route::get('service/{id}', 'ServiceController@show');
    Route::patch('service/{id}', 'ServiceController@update');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('service/{id}', 'ServiceController@destroy');
        Route::delete('service-delete-multiple', 'ServiceController@deleteMultiple');
    });

    // financial
    Route::apiResource('payment-method', 'PaymentMethodController'); //Método de pagamento principal
    Route::apiResource('form-payment', 'FormPaymentController'); //Forma de pagamento secundária

    Route::apiResource('card', 'CardController'); //juros do cartão
    Route::get('find-all', 'CardController@all'); //juros do cartão
    Route::delete('card-delete-multiple', 'CardController@deleteAll'); //juros do cartão

    Route::apiResource('discount', 'DiscountController'); // tipos de descontos

    Route::get('sale-search-stock', 'SaleController@searchStock');

    Route::get('sale', 'SaleController@index');
    Route::post('save-sale', 'SaveSaleController@createSale'); // save sale
    Route::get('sale/{id}', 'SaleController@show');
    Route::group(['middleware' => 'admin'], function () {
        Route::delete('sale/{id}', 'SaleController@destroy');
        Route::delete('sale-delete-multiple', 'SaleController@deleteMultiple');
    });

    Route::apiResource('credit-card', 'CreditCardController'); // pagamento no crédito
    Route::apiResource('combined-payment', 'CombinedPaymentController'); // pagamento combinado

    Route::apiResource('payment-credit', 'PaymentCreditController'); // Payment on Credit
    Route::apiResource('installment', 'InstallmentController'); // Manager Installments

    // Expenses
    Route::apiResource('category-expense', 'CategoryExpenseController');
    Route::apiResource('expense', 'ExpenseController');
    Route::delete('expense-delete-multiple', 'ExpenseController@deleteAll');

    // cash flow
    Route::get('cash-flow', 'CashFlowController@cashFlow');

    // API Communication
    Route::get('api-stock-lens', 'StockLensController@getData');
    Route::get('api-stock-lens/{id}', 'StockLensController@showData');

    // Service Order
    Route::apiResource('service-order', 'ServiceOrderController');
    Route::get('export-service-order/{id}', 'ServiceOrderController@exportPdf');

    Route::apiResource('promotion', 'PromotionController');
    Route::delete('promotion-delete-all', 'PromotionController@deleteAll');

    Route::apiResource('dashboard', 'DashboardController');

    // Cancellations
    Route::apiResource('cancellation', 'CancellationController');
});

Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink']);
Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);
