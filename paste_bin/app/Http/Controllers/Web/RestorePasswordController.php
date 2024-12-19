<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Http\Requests\Web\RestoreConfirmRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\DTO\PasswordResetDTO;
use Mail;

class RestorePasswordController extends Controller
{
    public function showResetPasswordrForm()
    {
        return view('pages/resetPasswordPage');
    }

    public function reset_password(Request $request)
    {
        try {
            // Валидация входящих данных
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ], [
                'email.required' => 'Поле email обязательно для заполнения.',
                'email.email' => 'Введите корректный адрес электронной почты.',
                'email.exists' => 'Этот адрес электронной почты не зарегистрирован в системе.',
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user) {
                $token = Str::random(40);
                $url = url('reset_password/confirm') . '?' . http_build_query(['token' => $token]);

                $data = new PasswordResetDTO(
                    $request->email,
                    $token,
                    $url,
                    'Смена пароля',
                    "Пожалуйста, нажмите ниже, чтобы сменить пароль"
                );

                Mail::send('mail.orderMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data->email)->subject($data->title);
                });

                // Попытка обновить или создать запись в PasswordReset
                try {
                    $datetime = Carbon::now()->format('Y-m-d H:i:s');
                    PasswordReset::updateOrCreate(
                        ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                    );
                } catch (\Exception $dbException) {
                    return redirect()->back()->withErrors(['error' => 'Ошибка при обновлении базы данных: ' . $dbException->getMessage()]);
                }

                return redirect()->back()->with('success', 'Ссылка на восстановление пароля отправлена на вашу почту!');
            } else {
                return redirect()->back()->withErrors(['error' => 'Пользователь не найден.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка: ' . $e->getMessage()]);
        }
    }

    public function showResetPasswordConfirmForm(Request $request)
    {
        $token = $request->query('token');

        return view('pages/restorePasswordConfirmPage', ['token' => $token]);
    }

    public function resetPassword(RestoreConfirmRequest $request)
    {
        try {
            $token = $request->get('token');
            
            $resetData = PasswordReset::where('token', $token)->first();

            if (!$resetData) {
                return redirect()->back()->withErrors(['error' => 'Неверный токен.']);
            }

            // Проверка на наличие пользователя
            $user = User::where('email', $resetData->email)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['error' => 'Пользователь не найден.']);
            }

            // Изменение пароля
            $user->password = Hash::make($request->get('password'));
            $user->save();

            // Удаление записи о сбросе пароля
            PasswordReset::where('email', $user->email)->delete();

            // Успешное сообщение
            return redirect()->route('reset_password_confirm')->with('success', 'Пароль успешно изменён!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка: ' . $e->getMessage()]);
        }
    }
}
