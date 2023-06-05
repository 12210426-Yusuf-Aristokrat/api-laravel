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

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('login','UsersController@login');
    Route::get('logout','UsersController@logout');

    Route::prefix('user')->group(function () {
        Route::patch('/','UsersController@updateProfilePhoto')

    });


    Route::prefix('user-details')->group(function () {
        Route::post('/', 'UserDetailController@store')->name('user-details.store');
        Route::get('/{id}', 'UserDetailController@show')->name('user-details.show');
        Route::put('/{id}', 'UserDetailController@update')->name('user-details.update');
        Route::delete('/{id}', 'UserDetailController@destroy')->name('user-details.destroy');
    });
});

