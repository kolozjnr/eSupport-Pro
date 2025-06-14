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
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('draft_id')->nullable()->constrained('drafts')->cascadeOnDelete();
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->cascadeOnDelete();
            $table->string('number');
            $table->enum('type', ['home', 'work', 'mobile'])->default('mobile');
            $table->boolean('is_primary')->default(true);
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->json('phone_numbers')->after('customer_id')->nullable();
            $table->string('name')->after('customer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('phone_numbers');
            $table->dropColumn('name');
        });
        Schema::dropIfExists('phone_numbers');
    }
};
