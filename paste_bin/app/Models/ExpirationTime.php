<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','value_in_minutes'
    ];

    public function pastes()
    {
        return $this->hasMany(Paste::class);
    }
}
