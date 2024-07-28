$(document).ready(function () {
    // Initialize DataTable
    $('#orders-table').DataTable();

    // Fetch and Display Orders
    $.ajax({
        type: "GET",
        url: "/api/orders",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);

                var tr = $("<tr>").attr("data-id", value.id);

                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(value.customer_id));
                tr.append($("<td>").html(value.price));
                tr.append($("<td>").html(value.status));
                tr.append($("<td>").html(value.shipping));
                tr.append($("<td>").html(value.date_placed ? new Date(value.date_placed).toLocaleDateString() : 'N/A'));
                tr.append($("<td>").html(value.date_shipped ? new Date(value.date_shipped).toLocaleDateString() : 'N/A'));
                tr.append("<td align='center'><a href='/admin/orders/" + value.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + value.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                $("#orders-table tbody").append(tr);
            });
        },
    });

    // Delete Order
    $("#orders-table").on('click', '.deletebtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

            {
            $.ajax({
                type: "DELETE",
                url: "/api/orders/" + id,
                dataType: 'json',
                success: function (response) {
                    alert("Order deleted successfully.");
                    $("tr[data-id='" + id + "']").remove();
                },
            });
        }
    });

    // Update Orders
    $(document).ready(function () {
        $('#orderEditForm').on('submit', function (e) {
            e.preventDefault();
    
            var formData = new FormData(this);
    
            $.ajax({
                type: "PUT",
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    alert("Order updated successfully.");
    
                    var row = $("tr[data-id='" + response.id + "']");
    
                    row.find("td:eq(1)").html(response.customer_id);
                    row.find("td:eq(2)").html(response.price);
                    row.find("td:eq(3)").html(response.status);
                    row.find("td:eq(4)").html(response.shipping);
                    row.find("td:eq(5)").html(response.date_placed ? new Date(response.date_placed).toLocaleDateString() : 'N/A');
                    row.find("td:eq(6)").html(response.date_shipped ? new Date(response.date_shipped).toLocaleDateString() : 'N/A');
    
                    $('#orderEditForm')[0].reset();
                },
            });
        });
    });
    
});
