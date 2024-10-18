<?php

use App\Models\WordMeaningDefinition;
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
        Schema::create('word_meaning_definition_antonyms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WordMeaningDefinition::class,'word_meaning_definition_id')->constrained();
            $table->string('antonym');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_meaning_definition_antonyms');
    }
};
