<?php

namespace App\Models;

use Database\Factories\WordLicenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordLicense extends Model
{
    /** @use HasFactory<WordLicenseFactory> */
    use HasFactory;

    protected $fillable = [
        'word_id',
        'name',
        'url'
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'id', 'word_id');
    }
}
