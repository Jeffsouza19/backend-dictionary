<?php

namespace App\Models;

use Database\Factories\WordMeaningFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMeaning extends Model
{
    /** @use HasFactory<WordMeaningFactory> */
    use HasFactory;

    protected $fillable = [
        'word_id',
        'partOfSpeech'
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'id', 'word_id');
    }
}
