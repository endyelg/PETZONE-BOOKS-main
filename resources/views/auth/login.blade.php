@extends('layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/login-register.css') }} ">

@section('content')
<main class="login-form">

    <div class="form-contain">
        <div class="huh-log ">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="login-container">
                        {{-- <div class="">Login</div> --}}
                        <div class="card-body">

                            <form action="{{ route('api.login') }}" method="POST" id="handleAjax">
                                @csrf

                                <div id="errors-list"></div>

                                <div class="input_box form-group row">
                                    <label for="email_address" class="col-md-3 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email"
                                            placeholder="E-mail" required autofocus>
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="input_box form-group row">
                                    <label for="password" class="col-md-3 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Password" required>
                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="contain">
                                    <button type="submit" class="login-btn ">
                                        Login
                                    </button>
                                </div>

                                <div class="reg">
                                    <p>
                                        Don't have an account yet?
                                    </p>

                                    <p>
                                        <a class="tis nav-link" href="{{ route('register') }}">Register</a>
                                    </p>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/login.js') }}"></script>
@endsection