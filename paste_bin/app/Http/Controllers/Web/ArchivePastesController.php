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


class ArchivePastesController extends Controller
{

    public function index(Request $request)
    {
        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();

        // Получаем последние 10 паст, соответствующих условиям
        $pastesQuery = Paste::where('visibility_id', 1)
            ->where(function ($query) {
                $query->where('expires_at', '<', now()) // Текущая дата > expires_at
                    ->orWhereNull('expires_at'); // Или expires_at = null
            });

        // Если пользователь аутентифицирован, добавляем условие по user_id
        if ($user) {
            $pastesQuery->where('user_id', '!=', $user->id); // Пасты не созданные пользователем
        }

        $pastes = $pastesQuery->orderBy('created_at', 'desc') // Сортировка по дате создания
            ->take(10) // Ограничение до 10 штук
            ->get();

        // Получаем все синтаксисы
        $languages = Language::all();
        
        // Проверяем, есть ли пасты
        if ($pastes->isEmpty()) {
          return view('pages.pastesListPage', compact('pastes', 'languages'))->with('message', 'Нет доступных паст.');
        }

        return view('pages.pastesListPage', compact('pastes', 'languages'));
    }

    public function show($short_link)
    {
        // Ищем пасту по short_link
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

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
        return view('pages/userPastePage', compact('paste', 'user', 'language', 'expirationTime', 'languages', 'comments', 'isUserPaste'));
    }

    public function personal_pastes(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return view('mypaste', ['pastes' => [], 'syntaxes' => [], 'categories' => [], 'rights' => []]);
        }

        // Получаем пасты, соответствующие условиям
        $pastesQuery = Paste::where(function($query) {
            $query->where('access_time', '<', now()) // Текущая дата > access_time
                ->orWhereNull('expires_at'); 
        });

        // Добавляем условие по user_id для аутентифицированного пользователя
        $pastesQuery->where('user_id', '=', $user->id); // Пасты, созданные пользователем

        // Пагинация: получаем пасты с пагинацией по 10 элементов
        $pastes = $pastesQuery->orderBy('created_at', 'desc')->paginate(10);

        $syntaxes = Language::all();
        $categories = Category::all(); 
        $rights = Visibility::all(); 

        return view('mypaste', compact('pastes', 'syntaxes', 'categories', 'rights', 'user'));
    }

    public function personal_paste(request $request,$short_link)
    {
        // Ищем пасту по short_link
        $paste = Paste::where('short_link', $short_link)->firstOrFail();

        $username = User::find($paste->user_id, 'name');
        $syntax = Language::find($paste->language_id, 'name');
        $category = Category::find($paste->category_id_id, 'name');

        // Передаем пасту в представление
        return view('userPastePage', compact('paste','username','syntax','category'));
    }
}
