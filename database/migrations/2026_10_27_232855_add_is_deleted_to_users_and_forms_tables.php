<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'is_deleted')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }

        if (Schema::hasTable('forms') && !Schema::hasColumn('forms', 'is_deleted')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_deleted')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }

        if (Schema::hasColumn('forms', 'is_deleted')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
    }
};