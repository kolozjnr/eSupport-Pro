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
            $table->foreignId('business_developer_id')->nullable()->after('support_id')->constrained();
        });

        Schema::table('business_developers', function (Blueprint $table) {
            $table->string('referral_code')->nullable()->after('user_id');
            $table->dateTime('last_referral_at')->nullable()->after('user_id');
            $table->integer('referral_count')->default(0)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_developers', function (Blueprint $table) {
            $table->dropColumn('referral_code');
            $table->dropColumn('last_referral_at');
            $table->dropColumn('referral_count');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['business_developer_id']);
            $table->dropColumn('business_developer_id');
        });
    }
};
