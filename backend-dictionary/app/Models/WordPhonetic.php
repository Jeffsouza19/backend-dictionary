<?php

namespace App\Models;

use Database\Factories\WordPhoneticFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WordPhonetic extends Model
{
    /** @use HasFactory<WordPhoneticFactory> */
    use HasFactory;

    protected $table = 'word_phonetics';

    protected $fillable = [
        'word_id',
        'text',
        'audio',
        'sourceUrl'
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(WordPhoneticLicense::class, 'word_phonetic_id', 'id');
    }
}
