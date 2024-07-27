<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    use HasFactory;

    public $timestamps = false; // Disable timestamps
    
    protected $fillable = ['customer_id' , 'price', 'date_placed', 'status', 'shipping'];

    /**
     * 1TON relationship between order and user
     *
     * @return array|null
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    /**
     * 1TO1 relationship between order and payment
     *
     * @return array|null
     */
    public function payment(){
        return $this->hasOne(Payment::class , 'order_id');
    }

    /**
     * NTON relationship between order and product
     *
     * @return array|null
     */
    public function products(){
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }
    
}