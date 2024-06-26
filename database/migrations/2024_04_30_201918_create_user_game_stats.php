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
        Schema::create('user_game_stats', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('game_id')->constrained('games');
            $table->integer('total');
            $table->integer('achieved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_game_stats');
    }
};
