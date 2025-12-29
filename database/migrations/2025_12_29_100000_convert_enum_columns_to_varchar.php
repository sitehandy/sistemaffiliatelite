<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // affiliate_programs table
        Schema::table('affiliate_programs', function (Blueprint $table) {
            $table->string('program_type', 20)->change();
            $table->string('commission_type', 20)->change();
            $table->string('visibility', 20)->default('open')->change();
        });

        // program_enrollments table
        Schema::table('program_enrollments', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->change();
        });

        // tracking_events table
        Schema::table('tracking_events', function (Blueprint $table) {
            $table->string('event_type', 20)->change();
        });

        // payment_methods table
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('type', 20)->change();
        });

        // commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->change();
        });

        // payouts table
        Schema::table('payouts', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->change();
        });

        // installation_logs table
        Schema::table('installation_logs', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->change();
        });

        // system_settings table
        Schema::table('system_settings', function (Blueprint $table) {
            $table->string('type', 20)->default('string')->change();
        });

        // announcements table
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('type', 20)->default('info')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: Converting back to ENUM is not recommended
        // as it may cause data loss if new values were added

        // affiliate_programs table
        DB::statement("ALTER TABLE affiliate_programs MODIFY program_type ENUM('sale', 'view', 'lead')");
        DB::statement("ALTER TABLE affiliate_programs MODIFY commission_type ENUM('flat', 'percentage')");
        DB::statement("ALTER TABLE affiliate_programs MODIFY visibility ENUM('hidden', 'open') DEFAULT 'open'");

        // program_enrollments table
        DB::statement("ALTER TABLE program_enrollments MODIFY status ENUM('pending', 'approved', 'rejected', 'suspended') DEFAULT 'pending'");

        // tracking_events table
        DB::statement("ALTER TABLE tracking_events MODIFY event_type ENUM('click', 'view', 'conversion')");

        // payment_methods table
        DB::statement("ALTER TABLE payment_methods MODIFY type ENUM('bank', 'paypal', 'wise')");

        // commissions table
        DB::statement("ALTER TABLE commissions MODIFY status ENUM('pending', 'approved', 'paid', 'cancelled') DEFAULT 'pending'");

        // payouts table
        DB::statement("ALTER TABLE payouts MODIFY status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending'");

        // installation_logs table
        DB::statement("ALTER TABLE installation_logs MODIFY status ENUM('pending', 'completed', 'failed') DEFAULT 'pending'");

        // system_settings table
        DB::statement("ALTER TABLE system_settings MODIFY type ENUM('string', 'integer', 'boolean', 'json') DEFAULT 'string'");

        // announcements table
        DB::statement("ALTER TABLE announcements MODIFY type ENUM('info', 'warning', 'success', 'danger') DEFAULT 'info'");
    }
};
