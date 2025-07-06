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
        Schema::create('identities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('support_id')->constrained('supports')->cascadeOnDelete();
            $table->string('public_id')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mname')->nullable();
            $table->string('display_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identities');
    }
};
