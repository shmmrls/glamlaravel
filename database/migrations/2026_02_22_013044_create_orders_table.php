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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('transaction_id', 50);
            $table->foreignId('customer_id')->constrained('customers', 'customer_id')->cascadeOnDelete();
            $table->enum('payment_method', ['Cash on Delivery', 'GCash', 'Credit Card']);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->enum('payment_status', ['Pending', 'Paid', 'Refunded', 'Cancelled'])->default('Pending');
            $table->enum('order_status', ['Pending', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            $table->dateTime('date_shipped')->nullable();
            $table->timestamps(); // replaces order_date + updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
