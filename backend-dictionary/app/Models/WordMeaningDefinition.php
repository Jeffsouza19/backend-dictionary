<?php

namespace App\Models;

use Database\Factories\WordMeaningDefinitionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WordMeaningDefinition extends Model
{
    /** @use HasFactory<WordMeaningDefinitionFactory> */
    use HasFactory;

    protected $fillable = [
        'word_meaning_id',
        'definition',
        'example'
    ];

    protected $hidden = [
        'word_meaning_id',
        'id',
        'created_at',
        'updated_at'
    ];

    public function meaning(): BelongsTo
    {
        return $this->belongsTo(WordMeaning::class, 'id', 'word_meaning_id');
    }

    public function synonyms(): HasMany
    {
        return $this->hasMany(WordMeaningDefinitionSynonym::class, 'word_meaning_definition_id', 'id');
    }

    public function antonyms(): HasMany
    {
        return $this->hasMany(WordMeaningDefinitionAntonym::class, 'word_meaning_definition_id', 'id');
    }
}
