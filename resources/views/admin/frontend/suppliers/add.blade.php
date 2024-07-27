@extends('admin.layouts.app')

@section('title' , 'Admin-Add supplier')

@section('content')
<!-- Add user form start -->
<div class="col-12 mt-5">

{{-- import button --}}
    <div class="container">
        <div>
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="messages">
                  @if (session('success'))
                    <div class="alert alert-success">
                      {{ session('success') }}
                    </div>
                  @endif
                </div>
                <div class="fields">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="import_csv" name="import_csv" accept=".csv">
                        <label class="input-group-text" for="import_csv">Upload</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Import CSV</button>
            </form>
        </div>
    </div>

    <div class="card">
        <form id="supplierForm" action="{{ route('admin.suppliers.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="supplier_name" type="text" class="form-control" placeholder="Supplier Name" aria-label="supplier_name">
                    </div>
                    <div class="col">
                        <input name="contact_number" type="text" class="form-control" placeholder="Contact Number" aria-label="contact_number">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="address" type="text" class="form-control" placeholder="Address" aria-label="address">
                    </div>
                    <div class="col">
                        <input name="image_path" type="file" accept="image/*" aria-label="image_path">
                    </div><br><br>
                    <div class="col">
                        <select name="prod_id" class="form-control" >
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Add Supplier</button>
            </div>
        </form>
    </div>
</div>
@endsection