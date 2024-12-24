<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RestorePasswordController;
use App\Http\Controllers\Api\EmailConfirmController;
use App\Http\Controllers\Api\PasteController;
use App\Http\Controllers\Api\ProfileController;

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


// Группируем маршруты, требующие аутентификации
Route::middleware(['auth'])->group(function () {
    Route::delete('/delete_paste/{short_link}', [PasteController::class, 'destroy']);
    Route::put('/update_paste/{short_link}', [PasteController::class, 'update']);

    Route::post('comment_paste/{short_link}', [PasteController::class, 'comment']);
    
    Route::post('report_paste/{short_link}', [PasteController::class, 'report']);

    Route::put('edit_profile/{user_id}', [ProfileController::class, 'edit']);
});

// Открытые маршруты
Route::get('comments_paste/{short_link}', [PasteController::class, 'get_comments']);
Route::get('/pastes', [PasteController::class, 'index']);
Route::get('/paste/{short_link}', [PasteController::class, 'show']);
Route::get('reports_paste/{short_link}', [PasteController::class, 'get_reports']);

//