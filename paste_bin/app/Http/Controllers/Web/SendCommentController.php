<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class SendCommentController extends Controller
{
    public function send_comment(Request $request)
    {
        // Валидация входящих данных
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        // Создаем новый комментарий
        $comment = new Comment();
        $comment->content = $request->comment; // Содержимое комментария
        $comment->user_id = Auth::id(); // ID авторизованного пользователя
        $comment->paste_id = $request->paste_id; // ID пасты, к которой относится комментарий

        // Сохраняем комментарий в базе данных
        $comment->save();

        // Перенаправляем обратно на страницу с пастой или возвращаем JSON-ответ
        return redirect()->back()->with('success', 'Комментарий добавлен!');
    }
}
