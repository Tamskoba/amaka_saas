<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->integer('session_number');

            $table->enum(
                'status',
                [
                    'active',
                    'completed'
                ]
            )->default('active');

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();
        });

        Schema::table('response_sets', function (Blueprint $table) {

            $table->foreignId('session_id')
                ->nullable()
                ->after('user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
