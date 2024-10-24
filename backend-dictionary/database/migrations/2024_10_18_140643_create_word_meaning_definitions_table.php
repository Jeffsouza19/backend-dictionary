<?php

use App\Models\WordMeaning;
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
        Schema::create('word_meaning_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WordMeaning::class, 'word_meaning_id')->constrained();
            $table->text('definition');
            $table->text('example')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_meaning_definitions');
    }
};
