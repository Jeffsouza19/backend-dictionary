<?php

namespace App\Models;

use Database\Factories\WordPhoneticLicenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordPhoneticLicense extends Model
{
    /** @use HasFactory<WordPhoneticLicenseFactory> */
    use HasFactory;

    protected $fillable = [
        'word_phonetic_id',
        'name',
        'url'
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(WordPhoneticLicense::class, 'id', 'word_phonetic_id');
    }
}
