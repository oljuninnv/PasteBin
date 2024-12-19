<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditUserController extends Controller
{
    public function showEditForm(Request $request)
{
    // Получаем текущего аутентифицированного пользователя
    $user = $request->user();

    // Передаем данные пользователя в представление
    return view('pages/EditProfilePage', [
        'user' => $user,
        'showEmailVerificationButton' => is_null($user->email_verified_at),
    ]);
}
}
