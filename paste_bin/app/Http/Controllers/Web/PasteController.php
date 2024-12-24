<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StorePasteRequest;
use App\Models\Paste;
use App\Models\Category;
use App\Models\Language;
use App\Models\Visibility;
use App\Models\ExpirationTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Enums\VisibilityEnum;

class PasteController extends Controller
{

    public function index() // Заполнение формы по созданию пасты
    {
        $user = Auth::user();
        $visibilitys = Visibility::all();

        // Получаем id для публичной видимости
        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC)->value('id');

        // Получаем публичные пасты
        $publicPastes = Paste::where('visibility_id', $publicVisibilityId)
            ->where(function ($query) {
                $query->where('expires_at', '<', now())
                    ->orWhereNull('expires_at');
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Получаем пасты пользователя
        $userPastes = [];
        if ($user) {
            $userPastes = Paste::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        $categories = Category::all();
        $languages = Language::all();
        $expiration_times = ExpirationTime::all();

        // Передаем обе коллекции в представление
        return view('pages.mainPage', compact('categories', 'languages', 'visibilitys', 'expiration_times', 'userPastes', 'publicPastes'));
    }
    public function store(StorePasteRequest $request) // Отправка данных с формы пасты
    {
        // Создаем новую пасту
        $paste = new Paste();
        $paste->content = $request->input('content');
        $paste->category_id = $request->input('category_id');

        // Обработка access_time
        $accessTime = $request->input('expiration_time');
        $duration = ExpirationTime::where('id', $accessTime)->value('value_in_minutes'); // the_duration хранится в минутах
        if ($duration > 0) {
            $paste->expires_at = now()->addMinutes($duration); // Добавляем минуты к текущему времени
        } else {
            $paste->expires_at = null; // Если не нашли duration, оставляем пустым
        }

        $paste->tags = $request->input('tags');
        $paste->language_id = $request->input('language');
        $paste->visibility_id = $request->input('visibility_id');
        $paste->title = $request->input('title');

        if (!$request->input('guest')) {
            $paste->user_id = Auth::id();
        }

        do {
            $short_link = Str::random(15);
        } while (Paste::where('short_link', $short_link)->exists());

        // Присвоение уникального short_link
        $paste->short_link = $short_link;

        // Сохранение пасты
        $paste->save();

        // Перенаправление после успешного сохранения
        return redirect()->route('home')->with('success', 'Паста успешно создана!');
    }
}
