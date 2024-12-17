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
    return view('pages/mainPage');
});

Route::get('/auth', function () {
    return view('pages/authPage');
});

Route::get('/register', function () {
    return view('pages/registerPage');
});

Route::get('/reset_password', function () {
    return view('pages/restorePasswordPage');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
