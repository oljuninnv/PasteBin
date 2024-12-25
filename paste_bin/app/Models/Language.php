<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Получить все пасты, связанные с языком.
     *
     * @return HasMany
     */
    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class);
    }
}