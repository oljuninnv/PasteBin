<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailConfirm;
use App\Http\Requests\Web\RestoreConfirmRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\DTO\EmailConfirmDTO;
use Mail;

class EmailConfirmController extends Controller
{
    public function send_mail(Request $request)
    {
        try {

            $user = Auth::user();

            if ($user) {
                $token = Str::random(40);
                $url = url('email/confirm') . '?' . http_build_query(['token' => $token]);

                // dd($user->email);

                $data = new EmailConfirmDTO(
                    $user->email,
                    $token,
                    $url,
                    'Подтверждение почты',
                    "Пожалуйста, нажмите ниже, чтобы подтвердить почту"
                );

                Mail::send('mail.orderMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data->email)->subject($data->title);
                });

                // Попытка обновить или создать запись в PasswordReset
                try {
                    $datetime = Carbon::now()->format('Y-m-d H:i:s');
                    EmailConfirm::updateOrCreate(
                        ['email' => $user->email],
                    [
                        'email' => $user->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                    );
                } catch (\Exception $dbException) {
                    return redirect()->back()->withErrors(['error' => 'Ошибка при обновлении базы данных: ' . $dbException->getMessage()]);
                }

                return redirect()->back()->with('success', 'Ссылка для подтверждения почты отправлена на вашу почту!');
            } else {
                return redirect()->back()->withErrors(['error' => 'Пользователь не найден.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка: ' . $e->getMessage()]);
        }
    }

    public function emailConfirm(Request $request)
    {

            $token = $request->get('token');
            
            $resetData = EmailConfirm::where('token', $token)->first();

            
            if (!$resetData) {
                return redirect()->route('edit_profile')->withErrors(['error' => 'Неверный токен.']);
            }

            // Проверка на наличие пользователя
            $user = User::where('email', $resetData->email)->first();


            if (!$user) {
                return redirect()->route('edit_profile')->withErrors(['error' => 'Пользователь не найден.']);
            }

            // Изменение пароля
            $user->email_verified_at = Carbon::now();
            $user->save();

            // Удаление записи о сбросе пароля
            EmailConfirm::where('email', $user->email)->delete();

            // Успешное сообщение
            return redirect()->route('edit_profile')->with('success', 'Почта успешно подтверждена!');
        
    }
}
