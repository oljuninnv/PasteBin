<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'paste_id',
        'views',
        'likes',
        'dislikes',
        'comments_enabled',
        'reports',
    ];

    public function paste()
    {
        return $this->belongsTo(Paste::class);
    }
}