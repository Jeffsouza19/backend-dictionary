<?php

namespace App\Models;

use Database\Factories\WordMeaningDefinitionAntonymFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordMeaningDefinitionAntonym extends Model
{
    /** @use HasFactory<WordMeaningDefinitionAntonymFactory> */
    use HasFactory;


    protected $fillable = [
        'word_meaning_definition_id',
        'antonym'
    ];

    public function definition(): BelongsTo
    {
        return $this->belongsTo(WordMeaningDefinition::class, 'id', 'word_meaning_definition_id');
    }
}
