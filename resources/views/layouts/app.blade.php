<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="/icomoon/icomoon.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Link to your CSS file -->
</head>
<body>
@include('partials.navbar')

@include('partials.alerts')

@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var shopProductsIndexRoute = "{{ route('api.products.index') }}";
</script>

<script src="{{ asset('js/shop.js') }}"></script>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia-autocomplete.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/my-orders.js') }}"></script>

@extends('layouts.footer')