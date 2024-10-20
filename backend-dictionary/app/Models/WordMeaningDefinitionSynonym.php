<?php

namespace App\Models;

use Database\Factories\WordMeaningDefinitionSynonymFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMeaningDefinitionSynonym extends Model
{
    /** @use HasFactory<WordMeaningDefinitionSynonymFactory> */
    use HasFactory;

    protected $fillable = [
        'word_meaning_definition_id',
        'synonym',
    ];


    public function definition(): BelongsTo
    {
        return $this->belongsTo(WordMeaningDefinition::class, 'id', 'word_meaning_definition_id');
    }
}
