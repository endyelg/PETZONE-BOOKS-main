@extends('layouts.app')

@section('title' , 'Petzone')

@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Offer books start -->
<section id="special-offer" class="bookshelf">
    <div class="section-header align-center">
        <div class="title">
            <span>Paws, Purrs, and Beyond: Where Every Pet's Tale Begins!</span>
        </div>
        <h2 class="section-title">Discounted Pet Books</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="inner-content">    
                <div class="product-list" data-aos="fade-up">
                    <div class="grid product-grid" id="product-grid">
                        <!-- Products will be loaded here by jQuery -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Offer books end -->

<!-- quote of the day start -->
<section id="quotation" class="align-center">
    <div class="inner-content" id="margin-t-200">
        <h2 class="section-title divider">Inspirational Insight</h2>
        <blockquote data-aos="fade-up">
            <q>Animals are such agreeable friends—they ask no questions; they pass no criticisms.</q>
            <div class="author-name">George Eliot</div>            
        </blockquote>
    </div>        
</section>
<!-- quote of the day end -->


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection