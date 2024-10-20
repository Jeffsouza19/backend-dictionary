<?php

namespace App\Models;

use Database\Factories\UserFavoriteWordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavoriteWord extends Model
{
    /** @use HasFactory<UserFavoriteWordFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'id', 'word_id');
    }
}
