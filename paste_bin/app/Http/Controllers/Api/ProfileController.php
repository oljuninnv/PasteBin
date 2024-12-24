<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit(Request $request, $user_id)
    {
        // Проверка, авторизован ли пользователь
        $authenticatedUser = Auth::user();

        // Проверка, совпадает ли user_id с идентификатором авторизованного пользователя
        if ($authenticatedUser->id !== (int)$user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Валидация входящих данных
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user_id,
            'website' => 'nullable|url',
            'location' => 'nullable|string|max:255',
        ]);

        // Обновление данных пользователя
        $user = User::findOrFail($user_id);
        $user->update($validatedData);

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    }
}
