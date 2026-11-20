<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('functional_syntheses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('session_id')
                ->unique()
                ->constrained('user_sessions')
                ->cascadeOnDelete();

            $table->longText('content')->nullable();

            $table->longText('practitioner_notes')->nullable();

            $table->string('pdf_path')->nullable();

            $table->timestamp('generated_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('functional_syntheses');
    }
};