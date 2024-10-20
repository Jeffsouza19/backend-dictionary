<?php

namespace App\Models;

use Database\Factories\WordMeaningFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WordMeaning extends Model
{
    /** @use HasFactory<WordMeaningFactory> */
    use HasFactory;

    protected $fillable = [
        'word_id',
        'partOfSpeech'
    ];

    protected $hidden = [
        'word_id',
        'id',
        'created_at',
        'updated_at'
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'id', 'word_id');
    }

    public function definitions(): HasMany
    {
        return $this->hasMany(WordMeaningDefinition::class, 'word_meaning_id', 'id');
    }

    public function synonyms(): HasMany
    {
        return $this->hasMany(WordMeaningSynonym::class, 'word_meaning_id', 'id');
    }

    public function antonyms(): HasMany
    {
        return $this->hasMany(WordMeaningAntonym::class, 'word_meaning_id', 'id');
    }
}
