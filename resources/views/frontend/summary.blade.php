@inject('cost', 'App\Support\Cost\Contract\CostInterface')
@inject('routes', 'App\Services\Setters\Routes')

<!-- Summary start -->
<div class="cart__total">
    <h6>Summary</h6>
    <ul style="padding-left: 0rem;">
        @foreach($cost->getSummary() as $key => $value)
            <li>{{ $key }} <span>${{ number_format($value) }}</span></li>
        @endforeach
        <li>Total <span>${{ number_format($cost->getTotalCost()) }}</span></li>
    </ul>
    @if($routes->view_SetRouteForSummaryBtn() === 'basket')
        <a class="primary-btn" id="btn-summary" href="#">CHECKOUT</a>
        <form id="checkout-form" style="display: none;">
            @csrf
            @foreach($basketAtViews->giveSelectedProducts() as $product)
                <input type="hidden" name="products[]" value="{{ $product['id'] }}">
                <input type="hidden" name="quantities[{{ $product['id'] }}]" value="{{ $product['quantity'] }}">
            @endforeach
        </form>
    @endif
</div>
<!-- Summary end -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var checkoutProcessUrl = "{{ route('api.checkout.process') }}"; // API route for checkout process
    var checkoutRedirectUrl = "{{ route('api.checkout.index') }}"; // Update this if you have a specific API route for checkout index
    var apiToken = "{{ Auth::user()->api_token }}";
    var csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/summary.js') }}"></script>