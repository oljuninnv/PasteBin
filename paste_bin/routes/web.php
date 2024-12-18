<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
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

// Страница авторизации пользователя
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('auth');

Route::get('/register', function () {
    return view('pages/registerPage');
});

Route::get('/reset_password', function () {
    return view('pages/restorePasswordPage');
});

Route::get('/user', function () {
    return view('pages/userPage');
});

Route::get('/edit_profile', function () {
    return view('pages/editProfilePage');
});

Route::get('/report', function () {
    return view('pages/sendReportPage');
});

Route::get('/paste', function () {
    return view('pages/userPastePage');
});

Route::get('/paste_list', function () {
    return view('pages/pastesListPage');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
