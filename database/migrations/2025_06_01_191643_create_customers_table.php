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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('support_id')->nullable()->constrained('supports')->nullOnDelete();
            $table->boolean('is_subscribed')->default(false);
            $table->dateTime('subscription_date')->nullable();
            $table->dateTime('subscription_due_date')->nullable();
            $table->string('subscription_type')->nullable();
            $table->boolean('is_trial')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        //tickets table
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('support_id')->nullable()->constrained('supports')->nullOnDelete()->index();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamps();
        });

        //drafts table
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->timestamps();
        });

        //plans table
        Schema::create('plans', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan_name');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('NGN');
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        //plan_features table
        Schema::create('plan_features', function (Blueprint $table){
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->string('feature');
            $table->timestamps();
        });


        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('drafts');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('customers');
    }
};
