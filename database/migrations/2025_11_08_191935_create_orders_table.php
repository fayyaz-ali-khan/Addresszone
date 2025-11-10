<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('check_out_no');
            $table->bigInteger('agent_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('payment_method')->nullable()->comment('1=> Paypal, 2=> Credit Card, 3=> DirectBank Transfer');
            $table->text('payment_details')->nullable();
            $table->string('PayerID')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_price', 10, 2)->default(0.0);
            $table->tinyInteger('coupon_type')->nullable();
            $table->tinyInteger('coupon_criteria')->nullable();
            $table->decimal('discounted_price', 10, 2)->default(0.0);
            $table->decimal('discount', 10, 2)->default(0.0);
            $table->decimal('grand_total', 10, 2)->default(0.0);
            $table->decimal('pak_price', 10, 2)->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('name')->nullable();
            $table->string('country')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->boolean('paid')->default(0)->comment('0=> Unpaid, 1=> Paid');
            $table->boolean('expired_status')->default(0)->comment('0=> Not Expired, 1=> Expired');
            $table->string('status')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->integer('packageType')->default(0);
            $table->string('service_name', 255)->nullable();
            $table->string('stripe_customer_id', 255)->nullable();
            $table->string('stripe_subsription_id', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
