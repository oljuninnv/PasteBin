<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\EmailConfirm;
use App\DTO\EmailConfirmDTO;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class EmailConfirmController extends Controller
{
    public function send_mail(Request $request)
{
    try {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найден.'], 404);
        }

        // Проверка, подтверждена ли почта
        if ($user->email_verified_at !== null) {
            return response()->json(['message' => 'У пользователя почта подтверждена.'], 200);
        }

        // Получение email из запроса
        $email = $user->email;

        $token = Str::random(40);
        $url = url('email/confirm') . '?' . http_build_query(['token' => $token]);

        $data = new EmailConfirmDTO(
            $email,
            $token,
            $url,
            'Подтверждение почты',
            "Пожалуйста, нажмите ниже, чтобы подтвердить почту"
        );

        Mail::send('mail.orderMail', ['data' => $data], function ($message) use ($data) {
            $message->to($data->email)->subject($data->title);
        });

        // Попытка обновить или создать запись в EmailConfirm
        EmailConfirm::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        return response()->json(['success' => 'Ссылка для подтверждения почты отправлена на вашу почту!'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Произошла ошибка: ' . $e->getMessage()], 500);
    }
}
}
