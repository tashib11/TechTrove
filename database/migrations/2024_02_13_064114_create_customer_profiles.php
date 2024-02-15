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
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
//  customer detail
            $table->string('cus_name',100);
            $table->string('cus_add',500);
            $table->string('cus_city',50);
            $table->string('cus_state',50);
            $table->string('cus_postcode',50);
            $table->string('cus_country',50);
            $table->string('cus_phone',50);
            $table->string('cus_fax',50);
//shiping details
            $table->string('ship_name',100);
            $table->string('ship_add',500);
            $table->string('ship_city',50);
            $table->string('ship_state',50);
            $table->string('ship_postcode',50);
            $table->string('ship_country',50);
            $table->string('ship_phone',50);

 // customer ar against a akjon e user thakbe, so relation make kora holo
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
/* restrictOnDelete(): This sets the ON DELETE action to RESTRICT, meaning that if there is an attempt to delete a user referenced in the customer_profiles table, the database will restrict the deletion if there are still records in the customer_profiles table associated with that user.

cascadeOnUpdate(): This sets the ON UPDATE action to CASCADE, meaning that if the id of a user in the users table is updated, the corresponding user_id in the customer_profiles table will be automatically updated to match. */
$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
