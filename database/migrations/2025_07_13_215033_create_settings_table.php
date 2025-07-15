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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->nullable();
            $table->string('long_name', 100)->nullable();
            $table->string('short_name', 50)->nullable();
            $table->string('support_email', 100)->nullable();
            $table->string('billing_email', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('dark_logo')->nullable();
            $table->string('light_logo')->nullable();
            $table->string('dark_logo_sm')->nullable();
            $table->string('light_logo_sm')->nullable();
            $table->string('favicon')->nullable();
            $table->decimal('general_support_charge', 15, 2)->nullable();
            $table->decimal('call_center_charge', 15, 2)->nullable();
            $table->decimal('virtual_support_charge', 15, 2)->nullable();
            $table->decimal('citizen_desk_plan_amount', 15, 2)->nullable();
            $table->decimal('startup_up_amount', 15, 2)->nullable();
            $table->decimal('team_amount', 15, 2)->nullable();
            $table->decimal('enterprise_amount', 15, 2)->nullable();
            $table->decimal('premium_amount', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
