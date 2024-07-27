@extends('admin.layouts.app')

@section('title' , 'Admin-Edit supplier')

@section('content')
<!-- Edit user form start -->
<div class="col-12 mt-5">
    <div class="card">
        <form id="supplierEditForm" action="{{ route('admin.suppliers.update' , $supplier->id) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $supplier->supplier_name }}" name="supplier_name" type="text" class="form-control" placeholder="Supplier Name" aria-label="supplier_name">
                    </div>
                    <div class="col">
                        <input value="{{ $supplier->contact_number }}" name="contact_number" type="text" class="form-control" placeholder="Contact Number" aria-label="contact_number">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $supplier->address }}" name="address" type="text" class="form-control" placeholder="Address" aria-label="address">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="image_path" type="file" class="form-control" placeholder="image_path" aria-label="image_path">
                    </div>
                    <div class="col">
                        <select name="prod_id" class="form-control">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $supplier->prod_id == $product->id ? 'selected' : '' }}>{{ $product->id }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Edit Supplier</button>
            </div>
        </form>
    </div>
</div>
@endsection