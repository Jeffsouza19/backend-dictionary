<?php

namespace App\Models;

use Database\Factories\WordSourceUrlFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordSourceUrl extends Model
{
    /** @use HasFactory<WordSourceUrlFactory> */
    use HasFactory;

    protected $fillable = [
        'word_id',
        'url'
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id');
    }
}
