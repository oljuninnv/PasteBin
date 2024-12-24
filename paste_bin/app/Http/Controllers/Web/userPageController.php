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
    public function show(Request $request) {
        $user = Auth::user();
    
        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC)->value('id');
        $privateVisibilityId = Visibility::where('name', VisibilityEnum::PRIVATE)->value('id');
    
        // Получаем публичные пасты, исключая пасты текущего пользователя
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
    
        // Получаем все пасты текущего пользователя
        $userPastes = Paste::where('user_id', $user->id)->get();
        
        // Подсчитываем количество паст
        $activePastes = $userPastes->count();
        $publicPastesCount = $userPastes->where('visibility_id','==',$publicVisibilityId)->count();
        $privatePastesCount = $userPastes->where('visibility_id','==',$privateVisibilityId)->count();
        $allPastesCount = $userPastes->count();
    
        return view('pages/userPage', compact('publicPastes', 'userPastes', 'user', 'activePastes', 'publicPastesCount', 'privatePastesCount', 'allPastesCount'));
    }
}
