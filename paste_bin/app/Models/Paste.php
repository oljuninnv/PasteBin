<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paste extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'expires_at',
        'visibility_id',
        'expiration_time_id',
        'language_id',
        'category_id',
        'short_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function visibility()
    {
        return $this->belongsTo(Visibility::class);
    }

    public function expiration_time()
    {
        return $this->belongsTo(ExpirationTime::class);
    }
}