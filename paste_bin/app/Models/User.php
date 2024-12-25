<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'website',
        'avatar',
        'email_verified_at',
        'provider',
        'provider_id',
        'provider_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Получить все пасты, связанные с пользователем.
     *
     * @return HasMany
     */
    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class);
    }

    /**
     * Получить все комментарии, связанные с пользователем.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить все отчеты, связанные с пользователем.
     *
     * @return HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Сгенерировать имя пользователя.
     *
     * @param string|null $username
     * @return string
     */
    public static function generateUserName(string $username = null): string
    {
        if ($username === null) {
            $username = Str::lower(Str::random(8));
        }

        if (self::where('name', $username)->exists()) {
            $newUsername = $username . Str::lower(Str::random(3));
            $username = self::generateUserName($newUsername);
        }

        return $username;
    }
}