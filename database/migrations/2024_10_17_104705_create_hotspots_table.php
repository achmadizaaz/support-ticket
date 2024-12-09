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
        Schema::create('hotspots', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('profile_user')->nullable('');
            $table->json('verify')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspots');
    }
};
