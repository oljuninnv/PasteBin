<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RestorePasswordController;
use App\Http\Controllers\Api\EmailConfirmController;
use App\Http\Controllers\Api\PasteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/logout',[AuthController::class,'logout']);

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    //Востановление пароля
    Route::post('/restore', [RestorePasswordController::class, 'forgetPassword']);
    // Route::post('/restore/confirm', [RestorePasswordController::class, 'resetPassword']);

});

Route::post('confirm_email', [EmailConfirmController::class, 'send_mail'])
    ->middleware('auth:api')
    ->name('send_mail');

Route::post('/create_paste', [PasteController::class, 'store']);