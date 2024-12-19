<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Web\RestorePasswordController;
use App\Http\Controllers\Web\EditUserController;

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
})->name('home');

Route::middleware('guest')->group(function () {

    // Страница авторизации пользователя
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('auth');

    // Авторизация пользователя через соц. сети

    Route::get('/auth/{provider}/redirect', [ProviderController::class,'redirect']);
    
    Route::get('/auth/{provider}/callback', [ProviderController::class,'callback']);

    // Регистрация пользователя

    Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register_form');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});

// Выход из аккаунта

Route::middleware('auth')->get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('reset_password', [RestorePasswordController::class, 'showResetPasswordrForm'])->name('resetPassword_form');
Route::post('reset_password', [RestorePasswordController::class, 'reset_password'])->name('reset_password');

Route::get('reset_password/confirm', [RestorePasswordController::class, 'showResetPasswordConfirmForm'])->name('resetPasswordConfirm_form');
Route::post('reset_password/confirm', [RestorePasswordController::class, 'resetPassword'])->name('reset_password_confirm');

Route::get('/user', function () {
    return view('pages/userPage');
})->name('user');

Route::get('edit_profile', [EditUserController::class, 'showEditForm'])->name('showEditForm');
Route::post('edit_profile', [EditUserController::class, 'edit_profile'])->name('edit_profile');

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
