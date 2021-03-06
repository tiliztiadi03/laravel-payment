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
Route::patch('payments/{id}/activate', 'Api\PaymentController@activate');
Route::patch('payments/{id}/deactivate', 'Api\PaymentController@deactivate');
