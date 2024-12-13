<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestoreConfirmRequest;
use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\PasswordReset;
use App\DTO\PasswordResetDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ConfirmEmailController extends Controller
{
    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $token = Str::random(40);
                $url = config('app.frontend-url.restore-password') . '?' . http_build_query(['token' => $token]);

                $data = new PasswordResetDTO(
                    $request->email,
                    $token,
                    $url,
                    'Подтверждение почты',
                    "Пожалуйста, нажмите ниже, чтобы сподтвердить вашу почту!"
                );

                Mail::send('orderMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data->email)->subject($data->title);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $data->email],
                    [
                        'email' => $data->email,
                        'token' => $data->token,
                        'created_at' => $datetime
                    ]
                );

                return response()->json(['success' => true, 'msg' => 'Please check your mail to confirm your email!']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User not found!']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->get();
        if (isset($request->token) && count($resetData) > 0) {
            $user = User::where('email', $resetData[0]['email'])->get();

            if ($user) {
                return response()->json(['msg' => 'User found', 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'User not found', 'success' => false], 404);
            }
        } else {
            return response()->json(['msg' => 'Invalid token', 'success' => false], 404);
        }
    }

    public function resetPassword(RestoreConfirmRequest $request)
    {
        // Проверка на наличие токена
        $resetData = PasswordReset::where('token', $request->get('token'))->first();

        if (!$resetData) {
            return response()->json(['msg' => 'Invalid token', 'success' => false], 404);
        }

        // Проверка на наличие пользователя
        $user = User::where('email', $resetData->email)->first();

        if (!$user) {
            return response()->json(['msg' => 'User not found', 'success' => false], 404);
        }

        // Изменение пароля
        $user->password = Hash::make($request->get('password'));
        $user->save();

        // Удаление записи о сбросе пароля
        PasswordReset::where('email', $user->email)->delete();

        $data = [
            'msg' => 'Confirm email successfully!',
            'success' => true,
        ];

        return $this->successResponse($data);
    }
}