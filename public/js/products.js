$(document).ready(function () {
    // Initialize DataTable
    var table = $('#products-table').DataTable();

    // Fetch and display products
    $.ajax({
        type: "GET",
        url: "/api/products", 
        dataType: 'json',
        success: function (data) {
            console.log(data);

            $.each(data, function (key, product) {
                console.log(product);

                var tr = $("<tr>").attr("data-id", product.id);

                tr.append($("<td>").html(product.id));
                tr.append($("<td>").html(product.title));
                tr.append($("<td>").html(product.category.title));
                tr.append($("<td>").html(product.author));
                tr.append($("<td>").html(product.description ? product.description.substring(0, 15) + '...' : 'No Description'));

                var img = product.demo_url ? "<img src='/images/products/" + product.demo_url + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));

                tr.append($("<td>").html("$" + product.price));
                tr.append($("<td>").html(product.percent_discount + "%"));
                tr.append($("<td>").html(product.stock));

                var actions = "<td align='center'>";
                actions += "<a href='/admin/products/" + product.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a> ";
                actions += "<a href='#' class='btn btn-danger deletebtn' data-id='" + product.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a>";
                actions += "</td>";

                tr.append(actions);

                table.row.add(tr).draw();
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("Error loading products data.");
        }
    });

    // Delete Product
    $("#products-table").on('click', '.deletebtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        {
            $.ajax({
                type: "DELETE",
                url: "/api/products/" + id, 
                dataType: 'json',
                success: function (response) {
                    alert("Product deleted successfully.");
                    table.row($("tr[data-id='" + id + "']")).remove().draw();
                },
            });
        }
    });

    // Add Product
    $('#addProductForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'), 
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                alert("Product added successfully.");

                var tr = $("<tr>").attr("data-id", response.id);
                tr.append($("<td>").html(response.id));
                tr.append($("<td>").html(response.title));
                tr.append($("<td>").html(response.category.title));
                tr.append($("<td>").html(response.author));
                tr.append($("<td>").html(response.description ? response.description.substring(0, 15) + '...' : 'No Description'));

                var img = response.demo_url
                    ? "<img src='/images/products/" + response.demo_url + "' width='50'/>"
                    : 'No Image';
                tr.append($("<td>").html(img));

                tr.append($("<td>").html("$" + response.price));
                tr.append($("<td>").html(response.percent_discount + "%"));
                tr.append($("<td>").html(response.stock));

                var actions = "<td align='center'>";
                actions += "<a href='/admin/products/" + response.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a> ";
                actions += "<a href='#' class='btn btn-danger deletebtn' data-id='" + response.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a>";
                actions += "</td>";

                tr.append(actions);

                table.row.add(tr).draw();

                $('#addProductForm')[0].reset();
            },
        });
    });

    // Update Product
    $('#editProductForm').on('submit', function (e) {
        e.preventDefault(); 

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'), 
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                alert("Product updated successfully.");

                var tr = $("#products-table tbody").find("tr[data-id='" + response.id + "']");

                tr.find("td:eq(1)").html(response.title);
                tr.find("td:eq(2)").html(response.category.title);
                tr.find("td:eq(3)").html(response.author);
                tr.find("td:eq(4)").html(response.description ? response.description.substring(0, 15) + '...' : 'No Description');

                var img = response.demo_url
                    ? "<img src='/images/products/" + response.demo_url + "' width='50'/>"
                    : 'No Image';
                tr.find("td:eq(5)").html(img);

                tr.find("td:eq(6)").html("$" + response.price);
                tr.find("td:eq(7)").html(response.percent_discount + "%");
                tr.find("td:eq(8)").html(response.stock);

                $('#editProductForm')[0].reset();
            },
        });
    });

    // Add Product Form Validation
    $("#addProductForm").validate({
        rules: {
            category_id: {
                required: true
            },
            title: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 10
            },
            percent_discount: {
                required: true,
                number: true,
            },
            demo_url: {
                required: true,
                url: true
            },
            author: {
                required: true,
                minlength: 3
            },
            price: {
                required: true,
                number: true,
            },
            stock: {
                required: true,
                number: true
            }
        },
        messages: {
            category_id: {
                required: "Please select a category"
            },
            title: {
                required: "The title field is required",
                minlength: "The title must be at least 3 characters"
            },
            description: {
                required: "The description field is required",
                minlength: "The description must be at least 10 characters"
            },
            percent_discount: {
                required: "The percent discount field is required",
                number: "Please enter a valid number"
            },
            demo_url: {
                required: "The demo URL must be a valid URL"
            },
            author: {
                required: "The author field is required",
                minlength: "The author must be at least 3 characters"
            },
            price: {
                required: "The price field is required",
                number: "The price must be a number"
            },
            stock: {
                required: "The stock field is required",
                number: "The stock must be a number"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Edit Product Form Validation
    $("#editProductForm").validate({
        rules: {
            category_id: {
                required: true
            },
            title: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 10
            },
            percent_discount: {
                required: true,
                number: true,
            },
            demo_url: {
                required: true,
                url: true
            },
            author: {
                required: true,
                minlength: 3
            },
            price: {
                required: true,
                number: true,
            },
            stock: {
                required: true,
                number: true
            }
        },
        messages: {
            category_id: {
                required: "The category field is required"
            },
            title: {
                required: "The title field is required",
                minlength: "The title must be at least 3 characters"
            },
            description: {
                required: "The description field is required",
                minlength: "The description must be at least 10 characters"
            },
            percent_discount: {
                required: "The percent discount field is required",
                number: "Please enter a valid number"
            },
            demo_url: {
                required: "The demo URL must be a valid URL"
            },
            author: {
                required: "The author field is required",
                minlength: "The author must be at least 3 characters"
            },
            price: {
                required: "The price field is required",
                number: "The price must be a number"
            },
            stock: {
                required: "The stock field is required",
                number: "The stock must be a number"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});