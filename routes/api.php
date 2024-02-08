<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('verify.secret.key')->group(function () {
    Route::post('/store-invoice', [ApiController::class, 'storeInvoice']);
    Route::post('/store-consumer', [ApiController::class, 'storeCustomer']);
    Route::get('/vat-rates', [ApiController::class, 'getVatRates']);
    Route::get('/customer/{id}', [ApiController::class, 'customerInfo']);
    Route::get('/customers', [ApiController::class, 'customersList']);
    Route::get('/customers/{vatNumber}', [ApiController::class, 'customerInfoByVatNumber']);
    Route::get('/invoice-series', [ApiController::class, 'getAllSeries']);
    Route::get('/invoice-pdf/{invoiceId}', [InvoiceController::class, 'generatePDF']);
});