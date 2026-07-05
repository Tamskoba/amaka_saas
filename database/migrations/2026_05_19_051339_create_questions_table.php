<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('form_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('section_id')
                  ->nullable()
                  ->constrained('form_sections')
                  ->nullOnDelete();

            $table->text('question_text');

            $table->enum('question_type', [
                'text',
                'textarea',
                'radio',
                'checkbox',
                'select',
                'number',
                'scale',
                'date'
            ]);

            $table->boolean('is_required')
                  ->default(false);

            $table->integer('sort_order')
                  ->default(0);

            $table->string('scoring_group')
                  ->nullable();

            $table->decimal('scoring_weight', 8, 2)
                  ->default(1);

            $table->json('conditional_logic')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};