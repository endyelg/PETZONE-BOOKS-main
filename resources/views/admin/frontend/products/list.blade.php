@extends('admin.layouts.app')

@section('title', 'Admin - Products')

@section('content')

<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
            <table id="ctable" class="table table-striped table-hover custom-table">
                <link rel="stylesheet" href="{{ asset('css/table.css') }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="products-table">
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->category->title }}</td>
                            <td>{{ $product->author }}</td>
                            <td>{{ Str::limit($product->description, 15) }}</td>
                            <td>
                                @if($product->demo_url)
                                    <img src="{{ asset('images/products/' . $product->demo_url) }}" alt="Demo Image" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>${{ $product->price }}</td>
                            <td>{{ $product->percent_discount }}%</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @for ($i = 0; $i < (10 - count($products)); $i++) <tr>
                        <td colspan="10">&nbsp;</td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        <!-- Centered Pagination links -->
        <div class="pagination-wrapper" style="display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
        </div>
    </div>
</div>
@endsection