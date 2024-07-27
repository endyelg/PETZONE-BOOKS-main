@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">My Orders</h1>
    <div class="list-group">
        @foreach($orders as $order)
            <div class="list-group-item d-flex justify-content-between align-items-center border rounded shadow-sm mb-1">
                <div>
                    <strong>Order ID: {{ $order->id }}</strong><br>
                    <span>Products: 
                        @foreach($order->products as $product)
                            {{ $product->title }} ({{ $product->pivot->quantity }}),
                        @endforeach
                    </span><br>
                    <span>Status: {{ $order->status }}</span><br>
                    <strong>Total Cost: {{ $order->price ?? 'Price not available' }}</strong>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">View</button>
            </div>

            <!-- Modal for Order Details -->
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg custom-modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order Details for Order ID: {{ $order->id }}</h5>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Shipping</th>
                                        <th>Order Date</th>
                                        <th>Shipment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td>{{ $product->title }}</td>
                                            <td>${{ $product->price }}</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->shipping }}</td>
                                            <td>{{ $order->date_placed }}</td>
                                            <td>{{ $order->date_shipped }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection