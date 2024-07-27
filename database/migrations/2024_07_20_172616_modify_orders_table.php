<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ensure the id column is an unsigned big integer and auto-increment
            $table->bigIncrements('id')->change();

            // Ensure customer_id is an unsigned big integer
            $table->unsignedBigInteger('customer_id')->change();

            // Ensure price is an unsigned decimal
            $table->unsignedDecimal('price', 10, 0)->change();

            // Check if the columns exist before adding them
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status', 100)->default('Pending')->after('price');
            }

            if (!Schema::hasColumn('orders', 'shipping')) {
                $table->string('shipping', 255)->default('Pending')->after('status');
            }

            // Drop the existing timestamp columns
            $table->dropColumn(['date_placed', 'date_shipped']);
        });

        Schema::table('orders', function (Blueprint $table) {
            // Add the timestamp columns again
            $table->timestamp('date_placed')->nullable();
            $table->timestamp('date_shipped')->nullable();

            // Ensure indexes
            $table->index('customer_id');

            // Ensure foreign key constraints
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['customer_id']);

            // Drop indexes
            $table->dropIndex(['customer_id']);

            // Drop the re-added timestamp columns
            $table->dropColumn(['date_placed', 'date_shipped']);
        });

        Schema::table('orders', function (Blueprint $table) {
            // Add the timestamp columns back
            $table->timestamp('date_placed')->nullable();
            $table->timestamp('date_shipped')->nullable();
        });
    }
}