<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('syntheses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('response_set_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->longText('ai_analysis')
                  ->nullable();

            $table->longText('practitioner_notes')
                  ->nullable();

            $table->string('pdf_path')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syntheses');
    }
};