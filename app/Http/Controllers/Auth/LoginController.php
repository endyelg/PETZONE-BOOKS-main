<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Fetch the admin record based on the email
        $admin = DB::table('admin')->where('email', $credentials['email'])->first();

        // Check if the admin exists and verify the password
        if ($admin && password_verify($credentials['password'], $admin->password)) {
            // Log the admin in
            Auth::loginUsingId($admin->admin_id);
            return response()->json([
                'status' => true,
                'redirect' => route('admin.categories.index'), // Redirect to admin categories index
            ]);
        }

        // Check if the credentials match a regular user account
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'redirect' => route('api.products.index'),
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => ['email' => 'Invalid Email or Password. Please try again.']
        ], 422);
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'status' => true,
            'redirect' => route('api.products.index'),
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'status' => false,
            'errors' => ['email' => 'Invalid Email or Password. Please try again.']
        ], 422);
    }

}