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
        Schema::create('invoices', function (Blueprint $table) {
             $table->id();

            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->string('shipping_alt_phone')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_division');
            $table->text('shipping_address');

            $table->boolean('gift_wrap')->default(0);
            $table->integer('shipping_fee');
            $table->integer('total');
            $table->string('tran_id')->unique();
            $table->enum('order_status', ['Pending', 'Processing', 'Shifted', 'Delivered','Cancelled'])->default('Pending');
            $table->enum('payment_status', ['Pending', 'Paid', 'Delivered'])->default('Pending');
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
