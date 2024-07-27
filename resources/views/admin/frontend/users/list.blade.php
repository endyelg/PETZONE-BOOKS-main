@extends('admin.layouts.app')

@section('title', 'Admin - Users')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
        <table id="ctable" class="table table-striped table-hover custom-table">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
        <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Number</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="users-table">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                @if($user->image_path)
                                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < (10 - count($users)); $i++) <tr>
                    <td colspan="8">&nbsp;</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
                    <!-- Centered Pagination links -->
        <div class="pagination-wrapper" style="display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>
        </div>
    </div>
</div>
@endsection
