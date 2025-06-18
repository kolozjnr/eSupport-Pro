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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('email')->nullable()->after('amount');
            $table->string('reference')->unique()->after('payment_gateway_ref');
            $table->string('virtual_assistance_points')->nullable()->after('payment_gateway_ref');
            $table->string('call_service_points')->nullable()->after('payment_gateway_ref');
            $table->integer('general_support_points')->nullable()->after('payment_gateway_ref');
            $table->integer('paymentReference')->nullable()->after('payment_gateway_ref');
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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['reference', 'virtual_assistance_points', 'call_service_points', 'general_support_points', 'email']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('reason_for_rejection');
        });
    }
};
