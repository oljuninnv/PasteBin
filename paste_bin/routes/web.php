<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Auth\ProviderController;
use Laravel\Socialite\Facades\Socialite;
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

    // Авторизация пользователя через github

    Route::get('/auth/{provider}/redirect', [ProviderController::class,'redirect']);
    
    Route::get('/auth/{provider}/callback', [ProviderController::class,'callback']);

    Route::get('/register', function () {
        return view('pages/registerPage');
    });
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    // $user->token
});

Route::middleware('auth')->get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reset_password', function () {
    return view('pages/restorePasswordPage');
});

Route::get('/reset_password/confirm', function () {
    return view('pages/restorePasswordConfirmPage');
});

Route::get('/user', function () {
    return view('pages/userPage');
})->name('user');

Route::get('/edit_profile', function () {
    return view('pages/editProfilePage');
})->name('edit_profile');

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
