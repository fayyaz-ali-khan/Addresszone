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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->integer('user_type')->default(1);
            $table->string('mobile');
            $table->string('image')->default('default-admin.jpeg');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->binary('address')->nullable();
            $table->binary('document_delivery_address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('country')->nullable();
            $table->string('CNIC_Front_Image')->nullable();
            $table->string('CNIC_Back_Image')->nullable();
            $table->string('Passport_Front_Image')->nullable();
            $table->tinyInteger('verification_status')->default(0);
            $table->text('verification_msg')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignId('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
