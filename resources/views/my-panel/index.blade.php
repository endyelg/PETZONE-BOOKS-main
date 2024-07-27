UPDATING USER PROFILE 


@extends('layouts.app')

@section('title', 'My Panel')

@section('content')
<!-- My Panel area start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">USER INFORMATION</div>
                <div class="card-body">
                    <!-- Display user's profile image -->
                    <div class="profile-image">
                        @if($user->image_path)
                        <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image" width="250" height="250">
                        @else
                        <p>No profile image available</p>
                        @endif
                    </div>
                    <!-- Form for editing user information -->
                    <form method="POST" action="{{ route('update-user') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Editable name field -->
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <!-- Editable email field -->
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <!-- File input for uploading a new profile picture -->
                        <div class="form-group">
                            <label for="image_path">Profile Picture:</label>
                            <input type="file" id="image_path" name="image_path" class="form-control-file">
                        </div><br>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Update Information</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Panel area end -->
@endsection