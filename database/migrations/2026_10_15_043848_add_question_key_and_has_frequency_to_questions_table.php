<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'question_key')) {
                $table->string('question_key')->nullable();
            }

            if (!Schema::hasColumn('questions', 'has_frequency')) {
                $table->boolean('has_frequency')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'has_frequency')) {
                $table->dropColumn('has_frequency');
            }

            if (Schema::hasColumn('questions', 'question_key')) {
                $table->dropColumn('question_key');
            }
        });
    }
};