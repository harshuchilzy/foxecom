<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('admin_new_order_email')->nullable();
            $table->boolean('admin_new_order_email_enabled')->default(false);
            $table->string('wholesale_new_customer_email')->nullable();
            $table->boolean('wholesale_new_customer_email_enabled')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
};
