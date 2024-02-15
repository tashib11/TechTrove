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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('description',1000);
            $table->string('rating',10);

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer_profiles')->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete()->restrictOnUpdate();
/*This means that if there is an attempt to update the id column in the customer_profiles or products table,
and there are corresponding records in the product_reviews table referencing those updated ids, the database will restrict the update. */

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
