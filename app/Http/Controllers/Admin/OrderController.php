<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller{
    /**
     * Show the orders main page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $orders = Order::with('user')->paginate(10); // Ensure user relationship is loaded
        
        return view('admin.frontend.orders' , compact('orders'));
    }

    /**
     * Show the user's orders
     *
     * @return \Illuminate\Http\Response
     */
    public function userOrders(){
        $user = auth()->user(); // Get the authenticated user
        $orders = Order::with(['products' => function($query) {
            $query->select('id', 'title', 'price')->withPivot('quantity'); // Fetch necessary fields including quantity
        }])
        ->where('customer_id', $user->id)
        ->get(['id', 'customer_id', 'shipping', 'date_placed', 'date_shipped', 'status', 'price']); // Fetch user's orders with additional fields including status and price

        return view('frontend.my-orders', compact('orders')); // Return the view with orders
    }
}