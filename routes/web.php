<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('customers')->name('customers/')->group(static function() {
            Route::get('/',                                             'CustomerController@index')->name('index');
            Route::get('/create',                                       'CustomerController@create')->name('create');
            Route::post('/',                                            'CustomerController@store')->name('store');
            Route::get('/{customer}/edit',                              'CustomerController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CustomerController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{customer}',                                  'CustomerController@update')->name('update');
            Route::post('/{customer}/edit',                                  'CustomerController@update')->name('update');
            Route::delete('/{customer}',                                'CustomerController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('vat-rates')->name('vat-rates/')->group(static function() {
            Route::get('/',                                             'VatRateController@index')->name('index');
            Route::get('/create',                                       'VatRateController@create')->name('create');
            Route::post('/',                                            'VatRateController@store')->name('store');
            Route::get('/{vatRate}/edit',                               'VatRateController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VatRateController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vatRate}',                                   'VatRateController@update')->name('update');
            Route::delete('/{vatRate}',                                 'VatRateController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('invoice-series')->name('invoice-series/')->group(static function() {
            Route::get('/',                                             'InvoiceSeriesController@index')->name('index');
            Route::get('/create',                                       'InvoiceSeriesController@create')->name('create');
            Route::post('/',                                            'InvoiceSeriesController@store')->name('store');
            Route::get('/{invoiceSeries}/edit',                         'InvoiceSeriesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'InvoiceSeriesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{invoiceSeries}',                             'InvoiceSeriesController@update')->name('update');
            Route::delete('/{invoiceSeries}',                           'InvoiceSeriesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('invoices')->name('invoices/')->group(static function() {
            Route::get('/',                                             'InvoiceController@index')->name('index');
            Route::get('/create',                                       'InvoiceController@create')->name('create');
            Route::post('/',                                            'InvoiceController@store')->name('store');
            Route::get('/{invoice}/edit',                               'InvoiceController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'InvoiceController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{invoice}',                                   'InvoiceController@update')->name('update');
            Route::delete('/{invoice}',                                 'InvoiceController@destroy')->name('destroy');
            Route::get('/{invoice}/pdf',                                'InvoiceController@generatePDF');

        });
    });
});