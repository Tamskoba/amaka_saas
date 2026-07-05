<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_forms', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('form_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('status', [
                'not_started',
                'in_progress',
                'completed'
            ])->default('not_started');

            $table->integer('progress_percentage')
                  ->default(0);

            $table->foreignId('assigned_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('assigned_at')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_forms');
    }
};