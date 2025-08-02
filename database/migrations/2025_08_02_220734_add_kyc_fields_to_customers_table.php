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
            $table->string('phone_number1', 30)->nullable()->after('business_developer_id');
            $table->string('phone_number', 30)->nullable()->after('business_developer_id');
            $table->integer('is_kyced')->nullable()->after('business_developer_id');
            $table->string('nin', 25)->nullable()->after('business_developer_id');
            $table->text('address')->nullable()->after('business_developer_id');
            $table->text('land_mark')->nullable()->after('business_developer_id');
            $table->string('nok_name')->nullable()->after('business_developer_id');
            $table->text('nok_address')->nullable()->after('business_developer_id');
            $table->string('nok_phone')->nullable()->after('business_developer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('nok_phone');
            $table->dropColumn('nok_address');
            $table->dropColumn('nok_name');
            $table->dropColumn('land_mark');
            $table->dropColumn('address');
            $table->dropColumn('nin');
            $table->dropColumn('is_kyced');
            $table->dropColumn('phone_number');
            $table->dropColumn('phone_number1');
        });
    }
};
