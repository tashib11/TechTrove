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
         Schema::table('customer_profiles', function (Blueprint $table) {
            // Make some fields nullable
            $table->string('cus_add', 500)->nullable()->change();
            $table->string('cus_city', 50)->nullable()->change();
            $table->string('cus_state', 50)->nullable()->change();
            $table->string('cus_country', 50)->nullable()->change();

            // Drop unwanted fields
            $table->dropColumn([
                'cus_postcode',
                'cus_fax',
                'ship_name',
                'ship_add',
                'ship_city',
                'ship_state',
                'ship_postcode',
                'ship_country',
                'ship_phone',
            ]);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('customer_profiles', function (Blueprint $table) {
            // Add back dropped columns
            $table->string('cus_postcode', 50)->nullable();
            $table->string('cus_fax', 50)->nullable();
            $table->string('ship_name', 100)->nullable();
            $table->string('ship_add', 500)->nullable();
            $table->string('ship_city', 50)->nullable();
            $table->string('ship_state', 50)->nullable();
            $table->string('ship_postcode', 50)->nullable();
            $table->string('ship_country', 50)->nullable();
            $table->string('ship_phone', 50)->nullable();


            // Revert nullable changes
            $table->string('cus_add', 500)->change();
            $table->string('cus_city', 50)->change();
            $table->string('cus_state', 50)->change();
            $table->string('cus_country', 50)->change();
        });
    }
};
