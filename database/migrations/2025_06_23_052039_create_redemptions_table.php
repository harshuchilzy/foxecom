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
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('offer_image')->nullable(); // store image path
            $table->string('product_image')->nullable();
            $table->decimal('discount', 8, 2)->default(0.00); // percentage or fixed
            $table->timestamps();
        });

        Schema::create('product_redemption', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('redemption_id')->constrained();
            $table->primary(['product_id', 'redemption_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};
