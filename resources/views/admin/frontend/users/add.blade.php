@extends('admin.layouts.app')

@section('title' , 'Admin-Add User')
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
        <form id="userForm" action="{{ route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="name" type="text" class="form-control" placeholder="Name" aria-label="name">
                    </div>
                    <div class="col">
                        <input name="email" type="text" class="form-control" placeholder="Email" aria-label="email">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="password" type="password" class="form-control" placeholder="Password" aria-label="password">
                    </div>
                    <div class="col">
                        <select name="role" id="inputState" class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="phone_number" type="text" class="form-control" placeholder="Phone number" aria-label="phone_number">
                    </div>
                    <div class="col">
                        <input name="address" type="text" class="form-control" placeholder="Address" aria-label="address">
                    </div>
                    <div class="col">
                        <input name="image_path" type="file" accept="image/*" aria-label="image_path">
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Add User</button>
            </div>
        </form>
    </div>
</div>
@endsection