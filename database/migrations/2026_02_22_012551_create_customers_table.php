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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->char('title', 4)->nullable();
            $table->string('fullname', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->char('zipcode', 10)->nullable();
            $table->string('town', 255)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->cascadeOnDelete();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
