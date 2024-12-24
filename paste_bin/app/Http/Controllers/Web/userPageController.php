<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\Visibility;
use App\Enums\VisibilityEnum;
use Illuminate\Support\Facades\Auth;

class userPageController extends Controller
{
    public function show(Request $request)
{
    $user = Auth::user();

    // Получаем идентификаторы видимости
    $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC)->value('id');
    $privateVisibilityId = Visibility::where('name', VisibilityEnum::PRIVATE)->value('id');

    // Обрабатываем поисковый запрос
    $searchQuery = $request->input('search'); // Поисковый запрос
    $perPage = $request->input('per_page', 5); // Количество элементов на странице (по умолчанию 10)

    // Получаем публичные пасты с учетом поиска
    $publicPastes = Paste::where('visibility_id', $publicVisibilityId)
        ->where(function ($query) {
            $query->where('expires_at', '>', now())
                ->orWhereNull('expires_at');
        })
        ->where(function ($query) {
            $query->where('user_id', '!=', Auth::id())
                ->orWhereNull('user_id');
        })
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', "%{$searchQuery}%")
                ->orWhere('content', 'LIKE', "%{$searchQuery}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Пагинация для публичных паст

    // Получаем пасты текущего пользователя с учетом поиска
    $userPastes = Paste::where('user_id', $user->id)
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', "%{$searchQuery}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)
        ->appends(['search' => $searchQuery, 'per_page' => $perPage]);

    // Подсчитываем количество паст
    $activePastes = $userPastes->total(); // Общее количество паст пользователя
    $publicPastesCount = $userPastes->where('visibility_id', $publicVisibilityId)->count();
    $privatePastesCount = $userPastes->where('visibility_id', $privateVisibilityId)->count();
    $allPastesCount = $userPastes->total(); // Общее количество паст пользователя

    return view('pages.userPage', compact(
        'publicPastes',
        'userPastes',
        'user',
        'activePastes',
        'publicPastesCount',
        'privatePastesCount',
        'allPastesCount',
        'searchQuery' // Передаем поисковый запрос в представление
    ));
}
}
