@extends('layouts.app') 

@section('title', 'Order Placed!')

@section('content')

<div style="text-align: center; margin-top: 50px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16" style="animation: checkmark 1s ease-in-out;">
        <path d="M15.854 5.146a.5.5 0 0 0-.708-.708L7 12.293 3.854 9.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l8-8z"/>
        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
    </svg>

    <style>
        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .total-cost {
            color: #ff0000; /* Red color */
            font-size: 24px; /* Larger font size */
            font-weight: bold; /* Bold text */
            margin-top: 20px; /* Space above the text */
        }
    </style>

    <h1 style="color: green; font-size: 48px; margin-top: 20px;">Order Placed!</h1>
    <p class="total-cost">Total Cost: ${{ number_format($totalCost, 2) }}</p>
    <a href="{{ route('shop.home') }}" class="btn btn-primary" style="margin-top: 20px;">Back to Home</a>
</div>

@endsection