<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('user_forms')
            && !Schema::hasColumn('user_forms', 'is_visible')
        ) {
            Schema::table('user_forms', function (Blueprint $table) {
                $table->boolean('is_visible')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('user_forms')
            && Schema::hasColumn('user_forms', 'is_visible')
        ) {
            Schema::table('user_forms', function (Blueprint $table) {
                $table->dropColumn('is_visible');
            });
        }
    }
};