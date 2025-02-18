<?php

namespace App\Http\Controllers\Web;

use App\Models\ExpirationTime;
use Illuminate\Http\Request;
use App\Models\Paste;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Visibility;
use App\Http\Controllers\Controller;
use App\Enums\VisibilityEnum;

class ArchivePastesController extends Controller
{

    public function index(Request $request)
    {
        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();

        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC )->value('id');

        // Получаем текст поиска из запроса
        $searchTerm = $request->input('search');

        // Получаем значение per_page из запроса или сессии
        $perPage = $request->input('per_page', $request->session()->get('per_page', 5));

        // Сохраняем значение per_page в сессии, если оно было передано
        if ($request->has('per_page')) {
            $request->session()->put('per_page', $perPage);
        }

        // Начинаем формировать запрос для публичных паст
        $pastesQuery = Paste::where('visibility_id', $publicVisibilityId)
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            });

        $userPastes = [];
        if ($user) {
            $userPastes = Paste::where('user_id', $user->id)
                ->where('expires_at', '>', now())
                ->orWhereNull('expires_at')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        // Если пользователь аутентифицирован, добавляем условие по user_id
        if ($user) {
            $pastesQuery->where('user_id', '!=', $user->id)->orWhereNull('user_id'); // Пасты не созданные пользователем
        }

        // Добавляем условие поиска, если введен текст
        if ($searchTerm) {
            $pastesQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%') // Поиск по заголовку
                    ->orWhere('content', 'like', '%' . $searchTerm . '%'); // Поиск по содержимому
            });
        }

        // Получаем последние 10 паст, соответствующих условиям
        $pastes = $pastesQuery->orderBy('created_at', 'desc') // Сортировка по дате создания
            ->paginate($perPage);

        // Получаем все синтаксисы
        $languages = Language::all();

        // Проверяем, есть ли пасты
        if ($pastes->isEmpty()) {
            return view('pages.pastesListPage', compact('pastes', 'languages', 'userPastes'))->with('message', 'Нет доступных паст.');
        }

        return view('pages.pastesListPage', compact('pastes', 'languages', 'userPastes'));
    }


    public function show($short_link)
    {
        // Ищем пасту по short_link
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        // Получаем id для публичной видимости
        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC )->value('id');

        $publicPastes = Paste::where('visibility_id', $publicVisibilityId)
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->where('user_id', '!=', Auth::id())
            ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Получаем пользователя, который создал пасту
        $user = User::find($paste->user_id, ['name', 'avatar']);
        $language = Language::find($paste->language_id, 'name');
        $languages = Language::all();
        $expirationTime = ExpirationTime::find($paste->visibility_id, 'name');

        // Получаем все комментарии, связанные с пастой
        $comments = Comment::where('paste_id', $paste->id)->get();

        // Проверяем, принадлежит ли паста авторизованному пользователю
        $isUserPaste = auth()->check() && auth()->id() === $paste->user_id;

        // Передаем пасту в представление
        return view('pages/userPastePage', compact('paste', 'user', 'language', 'expirationTime', 'languages', 'comments', 'isUserPaste', 'publicPastes'));
    }
}
