<?php

namespace App\Models;

use Database\Factories\WordMeaningSynonymFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMeaningSynonym extends Model
{
    /** @use HasFactory<WordMeaningSynonymFactory> */
    use HasFactory;

    protected $fillable = [
        'word_meaning_id',
        'synonym'
    ];

    public function meaning(): BelongsTo
    {
        return $this->belongsTo(WordMeaning::class, 'id', 'word_meaning_id');
    }
}
