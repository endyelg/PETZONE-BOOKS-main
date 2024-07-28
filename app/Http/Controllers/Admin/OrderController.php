<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request; 

class OrderController extends Controller{
    /**
     * Show the orders main page
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        if ($request->ajax()) {
            // Fetch orders with pagination for AJAX requests
            $orders = Order::paginate(10);
            return response()->json($orders);
        }
    
        // Fetch orders with pagination for normal requests
        $orders = Order::paginate(10);
    
        // Return the orders view with the orders data
        return view('admin.frontend.orders.list', compact('orders'));
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10); // Fetch orders with pagination
        return view('admin.frontend.orders.list', compact('orders')); // Return the view with orders
    }

    public function store(Request $request)
    {
        $validator = $this->validateOrderForm($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new order
        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->price = $request->input('price');
        $order->status = $request->input('status');
        $order->shipping = $request->input('shipping');
        $order->date_placed = $request->input('date_placed');
        $order->date_shipped = $request->input('date_shipped');
        $order->save();

        return redirect()->route('admin.orders.index')->with('simpleSuccessAlert', 'Order added successfully');
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.frontend.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = $this->validateOrderForm($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update order details
        $order->customer_id = $request->input('customer_id');
        $order->price = $request->input('price');
        $order->status = $request->input('status');
        $order->shipping = $request->input('shipping');
        $order->date_placed = $request->input('date_placed'); // Ensure this is set correctly
        $order->date_shipped = $request->input('date_shipped');
        $order->save();

        return redirect()->route('admin.orders.index')->with('simpleSuccessAlert', 'Order updated successfully');
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('simpleSuccessAlert', 'Order removed successfully');
    }

    /**
     * Validate the order form input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateOrderForm(Request $request)
    {
        return \Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',  // Ensure the customer ID exists in the users table
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'shipping' => 'required|string',
            'date_placed' => 'required|date',
            'date_shipped' => 'nullable|date|after_or_equal:date_placed',
        ]);
    }

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