<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('agent_id')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->integer('service_quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0.0);
            $table->date('expire_date')->nullable();
            $table->boolean('paid_status')->default(0)->comment('0=> Unpaid, 1=> Paid');
            $table->boolean('expired_status')->nullable()->comment('0=> Not Expired, 1=> Expired');
            $table->boolean('status');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
