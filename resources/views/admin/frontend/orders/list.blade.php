@extends('admin.layouts.app')

@section('title', 'Admin-Orders')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
            <table id="orders-table" class="table table-striped table-hover custom-table">
                <link rel="stylesheet" href="{{ asset('css/table.css') }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Shipping</th>
                        <th>Date Placed</th>
                        <th>Date Shipped</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_id }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->shipping }}</td>
                            <td>{{ $order->date_placed ? $order->date_placed->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $order->date_shipped ? $order->date_shipped->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < (10 - count($orders)); $i++)
                        <tr>
                            <td colspan="8">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <!-- Centered Pagination links -->
            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
