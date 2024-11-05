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
        Schema::create('travel_plans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unsignedInteger('status')
                ->default(1);

            $table->json('accommodation_coordinates');

            $table->integer('max_distance');

            $table->json('interests');

            $table->integer('spending');

            $table->text('result')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_plans');
    }
};
