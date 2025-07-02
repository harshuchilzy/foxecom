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
        Schema::create('collection_redemption', function (Blueprint $table) {
            $table->foreignId('redemption_id')->constrained()->onDelete('cascade');
            $table->foreignId('collection_id')->constrained('lunar_collections')->onDelete('cascade');
            $table->primary(['redemption_id', 'collection_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_redemption');
    }
};
