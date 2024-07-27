@extends('admin.layouts.app')

@section('title' , 'Admin-Categories')

@section('content')

<div class="col-12 mt-5"> 

{{-- import button --}}
     {{-- for add.blade --}}
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
    <form action="{{ route('admin.categories.storage') }}" method="POST">
    @csrf
      <div class="card-body">
          <div class="row">
              <div class="col">
                <input type="text" name="slug" class="form-control" placeholder="Website Genre" aria-label="slug">
              </div>
              <div class="col">
                <input type="text" name="title" class="form-control" placeholder="Category" aria-label="title">
              </div>
          </div>
      </div>
      <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-primary" type="txt">Add Category</button>
      </div>
    </form>
  </div>
</div>

<hr>

<!-- Categories list start -->
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
            <link rel="stylesheet" href="{{ asset('css/table.css') }}">
            <table id="categories-table" class="table table-striped table-hover custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Website Genre</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="categories-table">
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->title }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{ $categories->links() }}
            </ul>
        </nav>
    </div>
</div>
@endsection