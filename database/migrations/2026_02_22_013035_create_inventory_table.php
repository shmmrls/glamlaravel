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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('item_id');
            $table->foreignId('product_id')->unique()->constrained('products', 'product_id')->cascadeOnDelete();
            $table->integer('quantity');
            $table->string('unit', 20)->default('pcs');
            $table->integer('reorder_level')->default(10);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
