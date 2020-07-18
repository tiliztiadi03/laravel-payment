<?php

use Illuminate\Support\Facades\Route;

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

// Route payments
Route::resource('payments', 'Api\PaymentController')->except(['create', 'edit']);
Route::patch('payments/{id}/active', 'Api\PaymentController@active');
Route::patch('payments/{id}/deactive', 'Api\PaymentController@deactive');
