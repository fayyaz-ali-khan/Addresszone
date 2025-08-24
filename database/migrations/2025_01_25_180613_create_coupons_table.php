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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->comment('By which Admin added this coupon');
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate()->comment('The customer who use the coupon');
            $table->string('title');
            $table->string('code', 24)->unique();
            $table->char('type')->default('fixed');
            $table->decimal('amount', 8, 2);
            $table->boolean('status')->default(true)->comment('0=>used,1=>active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
