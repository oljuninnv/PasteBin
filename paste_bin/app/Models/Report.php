<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'paste_id',
        'user_id',
        'reason',
    ];

    public function paste()
    {
        return $this->belongsTo(Paste::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
