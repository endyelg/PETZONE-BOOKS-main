<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['product_id', 'comment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}