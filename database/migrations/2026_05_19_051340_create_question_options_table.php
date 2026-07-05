<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {

            $table->id();

            $table->foreignId('question_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('option_label');

            $table->string('option_value');

            $table->decimal('option_score', 8, 2)
                  ->default(0);

            $table->integer('sort_order')
                  ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};