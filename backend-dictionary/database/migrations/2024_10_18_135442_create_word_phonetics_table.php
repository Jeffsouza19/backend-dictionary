<?php

use App\Models\Word;
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
        Schema::create('word_phonetics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Word::class, 'word_id')->constrained();
            $table->string('text')->nullable();
            $table->string('audio')->nullable();
            $table->string('sourceUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_phonetics');
    }
};
