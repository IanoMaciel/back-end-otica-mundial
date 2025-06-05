<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', 'FrameController@generateQrCode');

Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('password/update', [PasswordResetController::class, 'resetPassword'])
    ->name('password.update');

Route::get('service-order/{id}', 'ServiceOrderController@exportPdf');
Route::get('frame-report', 'FrameController@exportPdf');
Route::get('sale-report', 'SaleController@exportPdf');
Route::get('warranty', function() { return view('pdf.warranty'); });


# Mexendo nesse aqui
Route::get('/lens-report', 'LensController@exportPdf');
Route::get('/lens-saller-report', 'LensController@exportLensSaller');

