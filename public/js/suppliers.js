$(document).ready(function () {
    // Initialize DataTable
    $('#suppliers-table').DataTable();

    // Fetch and Display Suppliers
    $.ajax({
        type: "GET",
        url: "/api/suppliers",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);

                var tr = $("<tr>").attr("data-id", value.id); // Add data-id attribute to the row

                tr.append($("<td>").html(value.supplier_name));
                tr.append($("<td>").html(value.contact_number));
                tr.append($("<td>").html(value.address));
                var img = value.image_path ? "<img src='/storage/" + value.image_path + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(value.prod_id));
                tr.append("<td align='center'><a href='/admin/suppliers/" + value.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + value.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                $("#suppliers-table tbody").append(tr);
            });

            // Bind Delete Button Click Event
            $("#suppliers-table").on('click', '.deletebtn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                if (confirm("Are you sure you want to delete this supplier?")) { // Add confirmation dialog
                    $.ajax({
                        type: "DELETE",
                        url: "/api/suppliers/" + id,
                        dataType: 'json',
                        success: function (response) {
                            alert("Supplier deleted successfully.");
                            $("tr[data-id='" + id + "']").remove(); // Remove the row from the table without reloading
                        },
                        error: function () {
                            alert("Error deleting supplier.");
                        }
                    });
                }
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("Error loading suppliers data.");
        }
    });

    // Add Supplier Form Submission
    $('#supplierForm').on('submit', function (e) {
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
                alert("Supplier added successfully.");
                var tr = $("<tr>").attr("data-id", response.id); // Ensure the new row has a data-id attribute
                tr.append($("<td>").html(response.supplier_name));
                tr.append($("<td>").html(response.contact_number));
                tr.append($("<td>").html(response.address));
                var img = response.image_path ? "<img src='/storage/" + response.image_path + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(response.prod_id));
                tr.append("<td align='center'><a href='/admin/suppliers/" + response.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + response.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                $("#suppliers-table tbody").append(tr);

                $('#supplierForm')[0].reset(); // Clear form fields
            },
            error: function () {
                alert("Error adding supplier.");
            }
        });
    });

    // Edit Supplier Form Submission
    $('#supplierEditForm').on('submit', function (e) {
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
                alert("Supplier updated successfully.");

                var row = $("tr[data-id='" + response.id + "']");

                row.find("td:eq(0)").html(response.supplier_name);
                row.find("td:eq(1)").html(response.contact_number);
                row.find("td:eq(2)").html(response.address);
                var img = response.image_path ? "<img src='/storage/" + response.image_path + "' width='50'/>" : 'No Image';
                row.find("td:eq(3)").html(img);
                row.find("td:eq(4)").html(response.prod_id);

                $('#supplierEditForm')[0].reset(); // Clear form fields
            },
            error: function () {
                alert("Error updating supplier.");
            }
        });
    });

    // Supplier Form Validation
    $("#supplierForm").validate({
        rules: {
            supplier_name: {
                required: true,
                minlength: 3
            },
            contact_number: {
                required: true,
                digits: true
            },
            address: {
                required: true,
                minlength: 3
            },
            image_path: {
                required: true
            },
            prod_id: {
                required: true
            }
        },
        messages: {
            supplier_name: {
                required: "The supplier name field is required",
                minlength: "The supplier name must be at least 3 characters"
            },
            contact_number: {
                required: "The contact number field is required",
                digits: "The contact number must be a number"
            },
            address: {
                required: "The address field is required",
                minlength: "The address must be at least 3 characters"
            },
            image_path: {
                required: "The image path field is required"
            },
            prod_id: {
                required: "The product field is required"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Supplier Edit Form Validation
    $("#supplierEditForm").validate({
        rules: {
            supplier_name: {
                required: true,
                minlength: 3
            },
            contact_number: {
                required: true,
                digits: true
            },
            address: {
                required: true,
                minlength: 3
            },
            image_path: {
                required: true
            },
            prod_id: {
                required: true
            }
        },
        messages: {
            supplier_name: {
                required: "The supplier name field is required",
                minlength: "The supplier name must be at least 3 characters"
            },
            contact_number: {
                required: "The contact number field is required",
                digits: "The contact number must be a number"
            },
            address: {
                required: "The address field is required",
                minlength: "The address must be at least 3 characters"
            },
            image_path: {
                required: "The image path field is required"
            },
            prod_id: {
                required: "The product field is required"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});