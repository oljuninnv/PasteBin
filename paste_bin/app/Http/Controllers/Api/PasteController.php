<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePasteRequest;
use App\Models\Paste;
use App\Models\ExpirationTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function store(StorePasteRequest $request) // Отправка данных с формы пасты
    {
        try{
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
         
        if (!$request->input('guest')){
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
        }
        catch (Exception){
            return $this->failureResponse('Ошибка при создании пасты');
        }
    }
}
