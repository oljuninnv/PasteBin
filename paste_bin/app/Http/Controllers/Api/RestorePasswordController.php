<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\PasswordReset;
use App\DTO\PasswordResetDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class RestorePasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $token = Str::random(40);
                $url = url('reset_password/confirm'). '?' . http_build_query(['token' => $token]);

                $data = new PasswordResetDTO(
                    $request->email,
                    $token,
                    $url,
                    'Смена пароля',
                    "Пожалуйста, нажмите ниже, чтобы перейти на сайт и сменить пароль"
                );

                Mail::send('mail.orderMail', ['data' => $data], function ($message) use ($data) {
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

                return response()->json(['success' => true, 'msg' => 'Пожалуйста проверьте почту, чтобы сменить пароль!!!']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User not found!']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}