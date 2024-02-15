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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->String('img1',200);
            $table->String('img2',200);
            $table->String('img3',200);
            $table->String('img4',200);

            $table->longText('des');
            $table->string('color',200);// color gulo array hishebe rakte pari ,then fronted a ta drop down akare dekhabo
            $table->string('size',200);

            $table->unsignedBigInteger('product_id')->unique();//akta product ar agains aktai details thakbe
            $table->foreign('product_id')->references('id')->on('products')->restrictOnDelete()->restrictOnUpdate();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
