<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('response_set_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('question_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->longText('answer_text')
                  ->nullable();

            $table->string('answer_value')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};