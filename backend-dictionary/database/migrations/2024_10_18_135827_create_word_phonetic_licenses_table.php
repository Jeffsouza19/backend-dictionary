<?php

use App\Models\WordPhonetic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('word_phonetic_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WordPhonetic::class, 'word_phonetic_id')->constrained();
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_phonetic_licenses');
    }
};
