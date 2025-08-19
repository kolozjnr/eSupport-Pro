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
            $table->integer('special_points')->nullable()->after('virtual_assistance_points');
            $table->boolean('is_special')->nullable()->after('virtual_assistance_points')->default(false);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('special_points')->nullable()->after('general_support_points');
        });
        
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('special_bronze')->nullable()->after('call_center_lite');
            $table->integer('special_gold')->nullable()->after('call_center_lite');
            $table->integer('special_silver')->nullable()->after('call_center_lite');
            $table->integer('special_bronze_amount')->nullable()->after('call_center_lite');
            $table->integer('special_gold_amount')->nullable()->after('call_center_lite');
            $table->integer('special_silver_amount')->nullable()->after('call_center_lite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::table('settings', function (Blueprint $table) {
                    $table->dropColumn([
                'special_bronze',
                'special_gold',
                'special_silver',
                'special_bronze_amount',
                'special_gold_amount',
                'special_silver_amount',
            ]);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('special_points');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_special');
            $table->dropColumn('special_points');
        });
    }
};
