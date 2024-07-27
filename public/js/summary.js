$(document).ready(function() {
    console.log("Document is ready");

    $(document).on('click', '#btn-summary', function(event) {
        event.preventDefault();
        console.log("Checkout button clicked");

        var products = [];
        var quantities = {};
        $('#checkout-form input[name="products[]"]').each(function() {
            products.push($(this).val());
        });
        $('#checkout-form input[name^="quantities"]').each(function() {
            var productId = $(this).attr('name').match(/\d+/)[0];
            quantities[productId] = $(this).val();
        });

        console.log("Products:", products);
        console.log("Quantities:", quantities);

        $.ajax({
            url: checkoutProcessUrl,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + apiToken,
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                products: products,
                quantities: quantities
            },
            success: function(response) {
                if (response.message === 'Order placed successfully') {
                    window.location.href = response.redirect;
                } else {
                    alert('Error placing order: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error placing order: ' + xhr.responseText);
            }
        });
    });
});