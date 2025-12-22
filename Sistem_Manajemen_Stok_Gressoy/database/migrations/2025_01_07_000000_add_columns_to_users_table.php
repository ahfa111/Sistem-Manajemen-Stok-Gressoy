<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile Info
            $table->string('full_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('job_title')->nullable();

            // Company Info
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('business_type')->nullable();

            // Notification Settings
            $table->boolean('notify_low_stock')->default(true);
            $table->boolean('notify_stock_in')->default(true);
            $table->boolean('notify_transaction')->default(true);
            $table->boolean('notify_expiry')->default(false);
            $table->boolean('notify_daily_report')->default(false);
            $table->boolean('notify_email')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name', 'phone_number', 'job_title',
                'company_name', 'company_address', 'company_phone', 'company_email', 'business_type',
                'notify_low_stock', 'notify_stock_in', 'notify_transaction', 'notify_expiry', 'notify_daily_report', 'notify_email'
            ]);
        });
    }
};
