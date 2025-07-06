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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('plan_name', 100)->nullable()->after('is_active');
            $table->unsignedInteger('virtual_assistance_points')->nullable()->after('is_active');
            $table->unsignedInteger('call_service_points')->nullable()->after('is_active');
            $table->unsignedInteger('general_support_points')->nullable()->after('is_active');

        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('public_id')->nullable()->after('customer_id');
            $table->string('proof_of_payment')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('public_id');
            $table->dropColumn('proof_of_payment');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('plan_name');
            $table->dropColumn('virtual_assistance_points');
            $table->dropColumn('call_service_points');
            $table->dropColumn('general_support_points');
        });

    }
};
