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
        Schema::table('product_details', function (Blueprint $table) {
            // ALT fields
            $table->string('img1_alt', 255)->nullable()->after('img1');
            $table->string('img2_alt', 255)->nullable()->after('img2');
            $table->string('img3_alt', 255)->nullable()->after('img3');
            $table->string('img4_alt', 255)->nullable()->after('img4');

            // Width & Height fields
            $table->integer('img1_width')->default(600)->after('img1_alt');
            $table->integer('img1_height')->default(600)->after('img1_width');

            $table->integer('img2_width')->default(600)->after('img2_alt');
            $table->integer('img2_height')->default(600)->after('img2_width');

            $table->integer('img3_width')->default(600)->after('img3_alt');
            $table->integer('img3_height')->default(600)->after('img3_width');

            $table->integer('img4_width')->default(600)->after('img4_alt');
            $table->integer('img4_height')->default(600)->after('img4_width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
             $table->dropColumn([
                'img1_alt', 'img1_width', 'img1_height',
                'img2_alt', 'img2_width', 'img2_height',
                'img3_alt', 'img3_width', 'img3_height',
                'img4_alt', 'img4_width', 'img4_height',
            ]);
        });
    }
};
