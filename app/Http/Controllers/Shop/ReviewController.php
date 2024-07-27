<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string',
        ]);

        $userEmail = Auth::user()->email; // Fetch the logged-in user's email

        $review = new Review;
        $review->product_id = $validatedData['product_id'];
        $review->comment = $validatedData['comment'];
        $review->user_email = $userEmail; // Save the user's email
        $review->save();

        return back()->with('success', 'Review submitted successfully!');
    }
}