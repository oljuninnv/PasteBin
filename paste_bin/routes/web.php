<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PasteController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\Web\RestorePasswordController;
use App\Http\Controllers\Web\EditUserController;
use App\Http\Controllers\Web\EmailConfirmController;
use App\Http\Controllers\Web\ArchivePastesController;
use App\Http\Controllers\Web\SendCommentController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\userPageController;
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

Route::get('/',[PasteController::class,'index']) -> name('home');
Route::post('/', [PasteController::class, 'store'])->name('store');

// Route::get('/', function () {
//     return view('pages/mainPage');
// })->name('home');

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

Route::post('email', [EmailConfirmController::class, 'send_mail'])->name('send_mail');
Route::get('email/confirm', [EmailConfirmController::class, 'emailConfirm'])->name('emailConfirm');

Route::get('edit_profile', [EditUserController::class, 'showEditForm'])->name('showEditForm');
Route::post('edit_profile', [EditUserController::class, 'edit_profile'])->name('edit_profile');

Route::get('/user',[userPageController::class, 'show'])->name('user');

Route::get('report/{short_link}',[ReportController::class, 'show'])->name('report');
Route::post('report/{short_link}',[ReportController::class, 'send_report'])->name('send_report');

// Страница со списком паст
Route::get('/archive', [ArchivePastesController::class, 'index'])->name('archive');

Route::get('/paste/edit/{short_link}', [PasteController::class, 'edit'])->name('paste.edit');
Route::post('/paste/update/{short_link}', [PasteController::class, 'update'])->name('paste.update');
Route::post('/paste/delete/{short_link}', [PasteController::class, 'destroy'])->name('paste.delete');

// Страница с пастой выбранного пользователя
Route::get('paste/{short_link}', [ArchivePastesController::class, 'show'])->name('user_paste');

Route::get('/api', function () {
    return view('api');
})->name('api');

Route::post('send_comment', [SendCommentController::class, 'send_comment'])->name('send_comment');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

