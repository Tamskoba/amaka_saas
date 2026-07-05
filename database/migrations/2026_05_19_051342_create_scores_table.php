<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {

            $table->id();

            $table->foreignId('response_set_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('scoring_group');

            $table->decimal('score_value', 10, 2);

            $table->text('interpretation')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};