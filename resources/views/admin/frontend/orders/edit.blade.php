@extends('admin.layouts.app')

@section('title', 'Admin-Edit Orders')

@section('content')
<!-- Edit order form start -->
<div class="col-12 mt-5">
    <div class="card">
        <form id="orderEditForm" action="{{ route('admin.orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $order->customer_id }}" name="customer_id" type="text" class="form-control" placeholder="Customer ID" readonly>
                    </div>
                    <div class="col">
                        <input value="{{ $order->price }}" name="price" type="text" class="form-control" placeholder="Price" readonly>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select name="status" class="form-control">
                            <option value="Pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Out for Delivery" {{ $order->status === 'outfordelivery' ? 'selected' : '' }}>Out for Delivery</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="shipping" class="form-control">
                            <option value="Shopee Express" {{ $order->shipping === 'shopee_express' ? 'selected' : '' }}>Shopee Express</option>
                            <option value="J&T express" {{ $order->shipping === 'jnt_express' ? 'selected' : '' }}>J&T Express</option>
                            <option value="Flash Express" {{ $order->shipping === 'flash_express' ? 'selected' : '' }}>Flash Express</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $order->date_placed ? $order->date_placed->format('Y-m-d') : '' }}" name="date_placed" type="date" class="form-control" placeholder="Date Placed" readonly>
                    </div>
                    <div class="col">
                        <input value="{{ $order->date_shipped }}" name="date_shipped" type="date" class="form-control" placeholder="Date Shipped">
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Edit Order</button>
            </div>
        </form>
    </div>
</div>
@endsection