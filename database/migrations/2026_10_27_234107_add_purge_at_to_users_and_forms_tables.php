<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'purge_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('purge_at')->nullable();
            });
        }

        if (Schema::hasTable('forms') && !Schema::hasColumn('forms', 'purge_at')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->timestamp('purge_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'purge_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('purge_at');
            });
        }

        if (Schema::hasColumn('forms', 'purge_at')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->dropColumn('purge_at');
            });
        }
    }
};