<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('response_sets', function (Blueprint $table) {
            $table->string('status')
                ->default('progress');

            $table->unsignedInteger('progress')
                ->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('response_sets', function (Blueprint $table) {
            $table->dropColumn(['status', 'progress']);
        });
    }
};