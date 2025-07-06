<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *    
     */
    public function up(): void
    {
        //subscriptions table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email', 80)->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->nullable()->default('NGN');
            $table->string('payment_method', 20)->nullable();
            $table->string('payment_gateway_ref')->unique();
            $table->string('reference')->unique();
            $table->string('virtual_assistance_points', 100)->nullable();
            $table->string('call_service_points', 100)->nullable();
            $table->string('general_support_points', 100)->nullable();
            $table->string('paymentReference')->nullable();
            $table->string('status')->nullable()->default('pending'); // pending, success, failed, refunded
            $table->string('plan_name', 100)->nullable();
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->string('channel', 20)->nullable();
            $table->string('payment_type', 20)->nullable(); // one-time, recurring
            $table->json('meta')->nullable(); // store raw response
            $table->timestamp('paid_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device', 100)->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_verified')->nullable()->default(false);
            $table->string('auth_token')->nullable();
            $table->timestamps();
        });

   

        Schema::table('tickets', function (Blueprint $table) {
            $table->text('reason_for_rejection')->after('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('reason_for_rejection');
        });
    }
};
