@extends('admin.layouts.app')

@section('title', 'Admin-Order Products')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
            <!-- Include the CSS for styling -->
            <link rel="stylesheet" href="{{ asset('css/table.css') }}">
            <table id="order-product-table" class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderProducts as $orderProduct)
                        <tr>
                            <td>{{ $orderProduct->order_id }}</td>
                            <td>{{ $orderProduct->product_id }}</td>
                            <td>{{ $orderProduct->quantity }}</td>
                        </tr>
                    @endforeach

                    <!-- Fill remaining rows if necessary -->
                    @for ($i = 0; $i < (10 - count($orderProducts)); $i++)
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <!-- Centered Pagination links -->
            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                {{ $orderProducts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
