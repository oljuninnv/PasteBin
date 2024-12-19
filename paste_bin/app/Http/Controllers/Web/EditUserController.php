<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Web\EditProfileRequest;
use Illuminate\Support\Facades\Hash;

class EditUserController extends Controller
{
    public function showEditForm(Request $request)
    {
        // Получаем текущего аутентифицированного пользователя
        $user = $request->user();

        // Проверяем, установлен ли пароль у пользователя
        $hasPassword = !is_null($user->password);

        // Передаем данные пользователя в представление
        return view('pages/EditProfilePage', [
            'user' => $user,
            'showEmailVerificationButton' => is_null($user->email_verified_at),
            'hasPassword' => $hasPassword, // Передаем информацию о наличии пароля
        ]);
    }

    public function edit_profile(EditProfileRequest $request)
    {
        try {
            $user = $request->user(); // Получаем текущего аутентифицированного пользователя

            // Обновление данных пользователя
            // Проверка, изменился ли email
            if ($request->email !== $user->email) {
                $user->email = $request->email; // Обновляем email
                $user->email_verified_at = null; // Устанавливаем email_verified_at в null
            }
            $user->website = $request->website;
            $user->location = $request->location;

            // Обработка загрузки аватара
            if ($request->hasFile('avatar')) {
                // Удаляем старый аватар, если он есть
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                // Сохраняем новый аватар
                $avatarPath = $request->file('avatar')->store('users', 'public');
                $user->avatar = $avatarPath;
            }

            // Проверка, был ли передан пароль
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Хэшируем новый пароль
        }


            $user->save(); // Сохраняем изменения

            return redirect()->back()->with('success', 'Данные успешно обновлены!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка: ' . $e->getMessage()]);
        }
    }
}
