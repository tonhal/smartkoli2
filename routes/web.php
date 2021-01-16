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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// Laundry API routes
Route::get('/laundries', 'LaundryController@index');
Route::post('/laundries', 'LaundryController@store');
Route::delete('/laundries/{id}', 'LaundryController@destroy');

// Guest API routes
Route::get('/guests', 'GuestController@index');
