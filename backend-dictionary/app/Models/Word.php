<?php

namespace App\Models;

use Database\Factories\WordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    /** @use HasFactory<WordFactory> */
    use HasFactory;

    protected $fillable = [
        'word',
        'phonetic'
    ];


    /**
     * @return HasMany
     */
    public function phonetics(): HasMany
    {
        return $this->hasMany(WordPhonetic::class, 'word_id', 'id');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(WordLicense::class, 'word_id', 'id');
    }

    public function meanings(): HasMany
    {
        return $this->hasMany(WordMeaning::class, 'word_id', 'id');
    }

    public function sources(): HasMany
    {
        return $this->hasMany(WordSourceUrl::class, 'word_id', 'id');
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(UserFavoriteWord::class, 'user_id', 'id');
    }

    public function history(): HasMany
    {
        return $this->hasMany(UserHistoryWord::class, 'user_id', 'id');
    }
}
