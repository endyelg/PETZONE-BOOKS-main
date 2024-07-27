<!-- suppliers.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Admin - Suppliers')

@section('content')
<!-- Suppliers table start -->
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
        <table id="ctable" class="table table-striped table-hover custom-table">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
                <thead>
                    <tr>
                    <th>Supplier Name</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Image</th>
                    <th>Product ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="suppliers-table">
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>
                            @if($supplier->image_path)
                                <img src="{{ asset('storage/' . $supplier->image_path) }}" alt="Supplier Image" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $supplier->prod_id }}</td>
                        <td>
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @for ($i = 0; $i < (10 - count($suppliers)); $i++) <tr>
                    <td colspan="6">&nbsp;</td>
                    </tr>
                    @endfor
            </tbody>
        </table> 
                <!-- Centered Pagination links -->
                <div class="pagination-wrapper" style="display: flex; justify-content: right;">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
<!-- Suppliers table end -->
@endsection