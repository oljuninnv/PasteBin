<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function pastes(): HasMany
    {
        return $this->hasMany(Paste::class);
    }
}