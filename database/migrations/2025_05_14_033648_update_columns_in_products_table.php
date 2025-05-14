<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
               // Make 'star' nullable
            $table->float('star')->nullable()->change();

            // Change 'stock' from boolean to string
            $table->string('stock')->change();
        });

        // Modify ENUM values for 'remark'
        DB::statement("ALTER TABLE products MODIFY COLUMN remark ENUM('popular','new','top','trending') NOT NULL");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
           // Revert 'star' back to not nullable
            $table->float('star')->nullable(false)->change();

            // Revert 'stock' back to boolean
            $table->boolean('stock')->change();
        });

        // Revert ENUM values back (if needed)
        DB::statement("ALTER TABLE products MODIFY COLUMN remark ENUM('popular','new','top','specail','trending','regular') NOT NULL");
    }
};
