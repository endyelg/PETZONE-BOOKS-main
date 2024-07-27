@inject('basketAtViews', 'App\Support\Basket\BasketAtViews')

@foreach ($paginated as $categoryName => $products)
    <div id="{{$categoryName}}" data-tab-content class="{{ ($categoryName == 'All') ? 'active' : '' }}">
        <div class="row">
            <div class="products-grid grid" id="product-grid">
                @foreach ($products as $product)
                <figure class="product-style">
                <img src="{{ asset('images/products/' . $product->demo_url) }}" alt="Books" class="product-item">
                    <a href="{{ route('api.basket.add' , $product->id) }}"><button type="button" class="add-to-cart" data-product-tile="add-to-cart">Add to Cart</button></a>
                    <figcaption>
                        <h3><a href="{{ route('api.products.show' , $product->id ) }}">{{ $product->title }}</a></h3>
                        <p>{{ $product->author }}</p>
                        <div class="item-price">${{ $product->price }}</div>
                        @if($basketAtViews->hasQuantity($product->id))
                            <div>
                                <a href="{{ route('api.basket.add' , $product->id)}}" class="increase">+</a>
                                <span class="quantity">{{ $basketAtViews->getQuantity($product->id) }}</span>
                                <a href="{{ route('api.basket.remove' , $product->id) }}" class="decrease">-</a>
                            </div>
                        @endif
                    </figcaption>
                </figure>
                @endforeach
            </div>
        </div>
    </div>
@endforeach