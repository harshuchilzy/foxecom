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
            $table->string('code')->unique();
            $table->enum('discount_type', ['percent', 'fixed_cart', 'fixed_product'])->default('percent');
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('free_shipping')->default(false);
            $table->date('expiry_date')->nullable();
            $table->decimal('minimum_amount', 10, 2)->nullable();
            $table->decimal('maximum_amount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->boolean('individual_use')->default(false);
            $table->boolean('exclude_sale_items')->default(false);
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
