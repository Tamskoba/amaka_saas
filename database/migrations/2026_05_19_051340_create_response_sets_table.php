<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('response_sets', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('form_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('version_number')
                  ->default(1);

            $table->timestamp('completed_at')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('response_sets');
    }
};