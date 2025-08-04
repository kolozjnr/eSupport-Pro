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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('call_center_lite', 50)->nullable()->after('premium_amount');
            $table->string('virtual_support_lite', 50)->nullable()->after('premium_amount');
            $table->string('general_support_lite', 50)->nullable()->after('premium_amount');

            
            $table->string('call_center_standard', 50)->nullable()->after('premium_amount');
            $table->string('virtual_support_standard', 50)->nullable()->after('premium_amount');
            $table->string('general_support_standard', 50)->nullable()->after('premium_amount');
            
            $table->string('call_center_advanced', 50)->nullable()->after('premium_amount');
            $table->string('virtual_support_advanced', 50)->nullable()->after('premium_amount');
            $table->string('general_support_advanced', 50)->nullable()->after('premium_amount');

            
            $table->string('call_center_business', 50)->nullable()->after('premium_amount');
            $table->string('virtual_support_business', 50)->nullable()->after('premium_amount');
            $table->string('general_support_business', 50)->nullable()->after('premium_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('call_center_business');
            $table->dropColumn('virtual_support_business');
            $table->dropColumn('general_support_business');
            
            $table->dropColumn('call_center_advanced');
            $table->dropColumn('virtual_support_advanced');
            $table->dropColumn('general_support_advanced');
            
            $table->dropColumn('call_center_standard');
            $table->dropColumn('virtual_support_standard');
            $table->dropColumn('general_support_standard');

            $table->dropColumn('call_center_lite');
            $table->dropColumn('virtual_support_lite');
            $table->dropColumn('general_support_lite');
            
        });
    }
};
