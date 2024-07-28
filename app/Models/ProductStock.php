<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'product_stock'; // Use the actual table name here

    protected $fillable = ['product_id', 'stock'];
}
