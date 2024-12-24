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
        if ($authenticatedUser->id !== (int) $user_id) {
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

    public function show(Request $request, $user_id)
{
    //Проверка, авторизован ли пользователь
    $authenticatedUser = Auth::user();

    // Проверка, совпадает ли user_id с идентификатором авторизованного пользователя
    if ($authenticatedUser->id !== (int) $user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Находим пользователя по user_id
    $user = User::findOrFail($user_id);

    // Формируем ответ с необходимыми полями
    $userData = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role->name,
        'avatar' => $user->avatar,
        'location' => $user->location,
        'website' => $user->website,
        'email_verified_at' => $user->email_verified_at,
        'created_at' => $user->created_at,
        'updated_at' => $user->updated_at,
        'provider' => $user->provider,
        'banned' => $user->banned,
    ];

    return response()->json(['message' => 'Profile retrieved successfully', 'user' => $userData], 200);
}
}