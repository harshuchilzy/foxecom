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
        if (Schema::hasColumn('redemptions', 'rules')) {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->dropColumn('rules');
        });
    }

    Schema::table('redemptions', function (Blueprint $table) {
        $table->json('rules')->nullable()->after('discount');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->dropColumn('rules');
        });
    }
};
