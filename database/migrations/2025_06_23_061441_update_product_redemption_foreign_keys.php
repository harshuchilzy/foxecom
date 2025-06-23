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
        Schema::table('product_redemption', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['product_id']);
            $table->dropForeign(['redemption_id']);

            // Re-add with correct tables and cascade
            $table->foreign('product_id')
                ->references('id')
                ->on('lunar_products')
                ->onDelete('cascade');

            $table->foreign('redemption_id')
                ->references('id')
                ->on('redemptions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_redemption', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['redemption_id']);

            // If needed, you can add the original constraints back
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('redemption_id')->references('id')->on('redemptions');
        });
    }
};
