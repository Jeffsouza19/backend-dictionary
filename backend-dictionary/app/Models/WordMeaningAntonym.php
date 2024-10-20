<?php

namespace App\Models;

use Database\Factories\WordMeaningAntonymFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMeaningAntonym extends Model
{
    /** @use HasFactory<WordMeaningAntonymFactory> */
    use HasFactory;

    protected $fillable = [
        'word_meaning_id',
        'antonym'
    ];

    public function meaning(): BelongsTo
    {
        return $this->belongsTo(WordMeaning::class, 'id', 'word_meaning_id');
    }
}
