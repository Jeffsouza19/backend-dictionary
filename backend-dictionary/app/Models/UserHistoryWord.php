<?php

namespace App\Models;

use Database\Factories\UserHistoryWordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserHistoryWord extends Model
{
    /** @use HasFactory<UserHistoryWordFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id', 'id');
    }
}
