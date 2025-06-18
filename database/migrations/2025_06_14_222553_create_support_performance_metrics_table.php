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
        Schema::create('support_performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_id')->nullable()->constrained('supports')->nullOnDelete();
            $table->integer('total_tickets_opened')->nullable()->default(0);
            $table->integer('total_tickets_resolved')->nullable()->default(0);
            $table->float('average_response_time')->nullable()->default(0);
            $table->float('average_resolution_time')->nullable()->default(0);
            $table->float('satisfaction_rating')->nullable();
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('assigned_at')->nullable()->after('status');
            $table->timestamp('first_response_at')->nullable()->after('status');
            $table->timestamp('resolved_at')->nullable()->after('status');
            $table->integer('response_time')->nullable()->after('status')->comment('In minutes');
            $table->integer('resolution_time')->nullable()->after('status')->comment('In minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('assigned_at');
            $table->dropColumn('first_response_at');
            $table->dropColumn('resolved_at');
            $table->dropColumn('response_time');
            $table->dropColumn('resolution_time');
        });

        Schema::dropIfExists('support_performance_metrics');
    }
};
