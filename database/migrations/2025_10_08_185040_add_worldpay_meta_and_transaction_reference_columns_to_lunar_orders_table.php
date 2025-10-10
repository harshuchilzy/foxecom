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
        Schema::table('lunar_orders', function (Blueprint $table) {
            $table->string('transaction_reference')->nullable()->index()->after('meta');
            $table->json('worldpay_meta')->nullable()->after('meta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lunar_orders', function (Blueprint $table) {
            $table->dropIndex(['transaction_reference']);
            $table->dropColumn('transaction_reference');
            $table->dropColumn('worldpay_meta');
        });
    }
};
