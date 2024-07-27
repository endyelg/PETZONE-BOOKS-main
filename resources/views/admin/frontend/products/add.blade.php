@extends('admin.layouts.app')

@section('title' , 'Admin-Add product')

@section('content')

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
        <form id="addProductForm" action="{{ route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
        @csrf 
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select name="category_id" class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input name="title" type="text" class="form-control" placeholder="Title" aria-label="title">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <textarea name="description" class="form-control" placeholder="Description" rows="1"></textarea>
                    </div>
                    <div class="col">
                        <input name="percent_discount" class="form-control" type="txt" placeholder="Percent">
                    </div>
                    <div class="col">
                        <input name="demo_url" class="form-control" type="file">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="author" class="form-control" placeholder="Author" type="text" aria-label="author">
                    </div>
                    <div class="col">
                        <input name="price" class="form-control" placeholder="Price" type="numeric" aria-label="price">
                    </div>
                    <div class="col">
                        <input name="stock" class="form-control" placeholder="Stock" type="numeric" aria-label="stock">
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Add product</button>
            </div>
        </form>
    </div>
</div>
@endsection