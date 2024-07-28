<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the product_stock table
        Schema::create('product_stock', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('product_id'); // Product ID as a foreign key
            $table->bigInteger('stock')->unsigned(); // Stock quantity
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraint
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        // Transfer data from PRODUCTS table to product_stock table
        DB::table('products')->chunkById(100, function ($products) {
            foreach ($products as $product) {
                DB::table('product_stock')->insert([
                    'product_id' => $product->id,
                    'stock' => $product->stock,
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock');
    }
}
