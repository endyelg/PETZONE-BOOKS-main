$(document).ready(function () {
    // Initialize DataTable
    $('#order-product-table').DataTable();

    // Fetch and Display Order Products (if dynamic fetching is needed)
    $.ajax({
        type: "GET",
        url: "/api/order-products",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var table = $('#order-product-table').DataTable();
            table.clear();

            $.each(data, function (key, value) {
                console.log(value);

                table.row.add([
                    value.order_id,
                    value.product_id,
                    value.quantity
                ]).draw();
            });
        },
    });

    // Handle Pagination (if needed for custom pagination)
    $('.pagination-wrapper').on('click', 'a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                var table = $('#order-product-table').DataTable();
                table.clear();

                $.each(data.data, function (key, value) {
                    table.row.add([
                        value.order_id,
                        value.product_id,
                        value.quantity
                    ]).draw();
                });

                $('.pagination-wrapper').html(data.links);
            },
        });
    });
});
