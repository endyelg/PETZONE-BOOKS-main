$(document).ready(function () {
    // Initialize DataTable
    var table = $('#product-stock-table').DataTable();

    // Function to load product stock data
    function loadProductStock(url) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                table.clear(); 

                $.each(data.data, function (key, value) {
                    console.log(value);

                    var tr = $("<tr>");

                    tr.append($("<td>").html(value.id));
                    tr.append($("<td>").html(value.product_id));
                    tr.append($("<td>").html(value.stock));

                    table.row.add(tr).draw();
                });

                // Update pagination links
                $('.pagination-wrapper').html(data.links);
            },
        });
    }

    loadProductStock("{{ route('product-stocks.index') }}");

    // Handle Pagination
    $('.pagination-wrapper').on('click', 'a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        loadProductStock(url);
    });
});
