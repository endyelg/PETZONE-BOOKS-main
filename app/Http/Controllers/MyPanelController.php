<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPanelController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        return view('my-panel.index', compact('user'));
    }

    public function updateUser(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file validation rules as needed
        ]);

        // Retrieve the logged-in user
        $user = auth()->user();

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle profile picture update if a new image is uploaded
        if ($request->hasFile('image_path')) {
            // Store the new image and update the user's image_path
            $imagePath = $request->file('image_path')->store('profile_images', 'public');
            $user->image_path = $imagePath;
        }

        // Save the updated user information
        $user->save();

        // Redirect back to the panel page with a success message
        return redirect()->route('my-panel')->with('success', 'User information updated successfully.');
    }
}