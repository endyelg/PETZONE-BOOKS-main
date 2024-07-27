$(document).ready(function() {
    var currentPage = 1;
    var loading = false;
    var lastPage = false;
    var scrollUpThreshold = 100; // Pixels from bottom where scroll-up will trigger
    var debounceTimeout;

    function loadMoreProducts() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - scrollUpThreshold && !loading && !lastPage) {
            loading = true;
            currentPage++;

            $.ajax({
                url: shopProductsIndexRoute,
                data: { page: currentPage },
                dataType: 'html', // Ensure the response is treated as HTML
                success: function(response) {
                    if (response.trim()) {
                        $('#infinite-scroll-placeholder').append(response);
                        loading = false;
                    } else {
                        lastPage = true;
                    }
                },
                error: function() {
                    loading = false; // Reset loading on error
                }
            });
        }
    }

    $(window).scroll(function() {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(loadMoreProducts, 200); // Debounce time in milliseconds
    });
});