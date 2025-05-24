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
        Schema::table('products', function (Blueprint $table) {
            // Convert price and discount_price to decimal(10,2)
            $table->decimal('price', 10, 2)->change();
            $table->decimal('discount_price', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback to string if needed
            $table->string('price')->change();
            $table->string('discount_price')->nullable()->change();
        });
    }
};
