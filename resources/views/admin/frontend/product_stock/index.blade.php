@extends('admin.layouts.app')

@section('title', 'Admin-Product Stock')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
            <!-- Include the CSS for styling -->
            <link rel="stylesheet" href="{{ asset('css/table.css') }}">

            <table id="product-stock-table" class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productStocks as $productStock)
                        <tr>
                            <td>{{ $productStock->id }}</td>
                            <td>{{ $productStock->product_id }}</td>
                            <td>{{ $productStock->stock }}</td>
                        </tr>
                    @endforeach

                    <!-- Fill remaining rows if necessary -->
                    @for ($i = 0; $i < (10 - count($productStocks)); $i++)
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <!-- Centered Pagination links -->
            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                {{ $productStocks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
