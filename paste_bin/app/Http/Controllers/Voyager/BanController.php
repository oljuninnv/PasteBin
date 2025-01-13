<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Models\User;

class BanController extends VoyagerBaseController
{
    public function ban(Request $request)
    {
        // Получить пользователя по ID
        $user = User::where('id', request("id"))->firstOrFail();
        
        // Переключить статус banUserController;ned
        $user->banned = $user->banned ? 0 : 1; // 0 - не забанен, 1 - забанен
        $user->save();

        // Перенаправить обратно на страницу редактирования пользователя
        return redirect()->route('voyager.users.index')->with('success', 'User status updated successfully.');
    }
}