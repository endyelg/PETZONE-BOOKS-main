<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
            'image_path' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    protected function create(array $data)
    {
        $imagePath = null;
        if (isset($data['image_path'])) {
            $imagePath = $data['image_path']->store('profile_images', 'public');
        }

        // Create the user with the role set to 'user'
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'image_path' => $imagePath,
            'role' => 'user', // Set the role to 'user'
        ]);
    }

    protected function registered(Request $request, $user)
    {
        return response()->json([
            'status' => true,
            'redirect' => route('api.products.index'), // Adjust this route as necessary
            'message' => 'Successfully registered!'
        ]);
    }
}