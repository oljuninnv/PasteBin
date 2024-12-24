<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePasteRequest;
use App\Models\Paste;
use App\Models\ExpirationTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    public function store(StorePasteRequest $request) // Отправка данных с формы пасты
    {
        try {
            // Создаем новую пасту
            $paste = new Paste();
            $paste->content = $request->input('content');
            $paste->category_id = $request->input('category_id');

            // Обработка access_time
            $accessTime = $request->input('expiration_time');
            $duration = ExpirationTime::where('id', $accessTime)->value('value_in_minutes'); // the_duration хранится в минутах
            if ($duration > 0) {
                $paste->expiration_time_id = $accessTime;
                $paste->expires_at = now()->addMinutes($duration); // Добавляем минуты к текущему времени
            } else {
                $paste->expires_at = null; // Если не нашли duration, оставляем пустым
            }

            $paste->tags = $request->input('tags');
            $paste->language_id = $request->input('language');
            $paste->visibility_id = $request->input('visibility');
            $paste->title = $request->input('title');

            if (!$request->input('guest')) {
                $paste->user_id = Auth::id();
            }


            do {
                $short_link = Str::random(15);
            } while (Paste::where('short_link', $short_link)->exists());

            $paste->short_link = $short_link;

            // Сохранение пасты
            $paste->save();

            // Перенаправление после успешного сохранения
            return $this->successResponse('Паста успешно создана');
        } catch (Exception) {
            return $this->failureResponse('Ошибка при создании пасты');
        }
    }

    public function destroy($short_link)
    {
        $user = Auth::user();
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Проверка, является ли пользователь владельцем пасты
        if ($paste->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Удаление пасты
        $paste->delete();

        return response()->json(['message' => 'Paste deleted successfully'], 200);
    }

    public function comment(Request $request, $short_link)
    {
        $user = Auth::user();
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Проверка, является ли пользователь владельцем пасты
        if ($paste->user_id === $user->id) {
            return response()->json(['error' => 'You cannot comment on your own paste'], 403);
        }

        // Валидация входящих данных
        $validatedData = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        // Создание комментария
        $comment = new Comment();
        $comment->paste_id = $paste->id;
        $comment->user_id = $user->id;
        $comment->content = $validatedData['comment'];
        $comment->save();

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
    }

    public function report(Request $request, $short_link)
    {
        $user = Auth::user();
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Проверка, является ли пользователь владельцем пасты
        if ($paste->user_id === $user->id) {
            return response()->json(['error' => 'You cannot report your own paste'], 403);
        }

        // Валидация входящих данных
        $validatedData = $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Создание отчета
        $report = new Report();
        $report->paste_id = $paste->id;
        $report->user_id = $user->id;
        $report->reason = $validatedData['reason'];
        $report->save();

        return response()->json(['message' => 'Report submitted successfully', 'report' => $report], 201);
    }

    public function update(Request $request, $short_link)
    {
        $user = Auth::user();
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Проверка, является ли пользователь владельцем пасты
        if ($paste->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Валидация входящих данных
        $validatedData = $request->validate([
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'expiration_time' => 'nullable|exists:expiration_times,id',
            'tags' => 'nullable|string',
            'language' => 'required|exists:languages,id',
            'visibility_id' => 'required|exists:visibilities,id',
            'title' => 'required|string|max:255',
        ]);

        // Обновление пасты
        $paste->update($validatedData);

        return response()->json(['message' => 'Paste updated successfully', 'paste' => $paste], 200);
    }

    public function get_comments($short_link)
    {
        // Находим пасту по короткой ссылке
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Получаем комментарии, связанные с пастой
        $comments = $paste->comments()->with('user')->get();

        // Формируем ответ с необходимыми полями
        $formattedComments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
                'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                    ],
                'paste' => [
                    'id' => $comment->paste->id,
                    'title' => $comment->paste->title,
                    'content' => $comment->content,
                ]
            ];
        });

        return response()->json(['comments' => $formattedComments], 200);
    }

    public function get_reports($short_link)
    {
        // Находим пасту по короткой ссылке
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Получаем комментарии, связанные с пастой
        $reports = $paste->reports()->with('user')->get();

        // Формируем ответ с необходимыми полями
        $formattedReports = $reports->map(function ($report) {
            return [
                'id' => $report->id,
                'content' => $report->content,
                'created_at' => $report->created_at,
                'updated_at' => $report->updated_at,
                'user' => [
                        'id' => $report->user->id,
                        'name' => $report->user->name,
                    ],
                'paste' => [
                    'id' => $report->paste->id,
                    'title' => $report->paste->title,
                    'content' => $report->content,
                ]
            ];
        });

        return response()->json(['report' => $formattedReports], 200);
    }

    public function show($short_link)
    {
        // Находим пасту по короткой ссылке
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Формируем ответ с необходимыми полями
        $pasteData = [
            'id' => $paste->id,
            'title' => $paste->title,
            'content' => $paste->content,
            'expires_at' => $paste->expires_at,
            'language_id' => $paste->language->name,
            'category_id' => $paste->category->name,
            'short_link' => $paste->short_link,
            'created_at' => $paste->created_at,
            'updated_at' => $paste->updated_at,
            'visibility_id' => $paste->visibility->name,
            'expiration_time_id' => $paste->expiration_time->name,
            'tags' => $paste->tags,
        ];

        return response()->json(['paste' => $pasteData], 200);
    }
}
