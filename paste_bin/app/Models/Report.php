<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'paste_id',
        'user_id',
        'reason',
    ];

    /**
     * Получить пасту, к которой относится отчет.
     *
     * @return BelongsTo
     */
    public function paste(): BelongsTo
    {
        return $this->belongsTo(Paste::class);
    }

    /**
     * Получить пользователя, который создал отчет.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
