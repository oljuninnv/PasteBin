<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpirationTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'value_in_minutes'
    ];

    /**
     * Получить все пасты, связанные с временем истечения.
     *
     * @return HasMany
     */
    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class);
    }
}