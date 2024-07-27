$(document).ready(function () {
    // Initialize DataTable
    $('#expenses-table').DataTable();

    // Fetch and Display Expenses
    $.ajax({
        type: "GET",
        url: "/api/expenses",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);

                // Create a new table row with a data-id attribute
                var tr = $("<tr>").attr("data-id", value.id);

                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(value.expense_name));
                tr.append($("<td>").html(value.expense_date));
                tr.append($("<td>").html(value.expense_amount));
                tr.append($("<td>").html(value.payment || 'No Payment Info'));
                var img = value.expense_img ? "<img src='/storage/" + value.expense_img + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append("<td align='center'><a href='/admin/expenses/" + value.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + value.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                // Append the new row to the table body
                $("#expenses-table tbody").append(tr);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("Error loading expenses data.");
        }
    });

    // Delete Expense
    $("#expenses-table").on('click', '.deletebtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        if (confirm("Are you sure you want to delete this expense?")) { // Confirmation dialog
            $.ajax({
                type: "DELETE",
                url: "/api/expenses/" + id,
                dataType: 'json',
                success: function (response) {
                    alert("Expense deleted successfully.");
                    $("tr[data-id='" + id + "']").remove(); // Remove the row without reloading
                },
                error: function () {
                    alert("Error deleting expense.");
                }
            });
        }
    });

    // Add Expense
    $('#expenseForm').on('submit', function (e) {
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
                alert("Expense added successfully.");

                // Create a new table row
                var tr = $("<tr>").attr("data-id", response.id);
                tr.append($("<td>").html(response.id));
                tr.append($("<td>").html(response.expense_name));
                tr.append($("<td>").html(response.expense_date));
                tr.append($("<td>").html(response.expense_amount));
                tr.append($("<td>").html(response.expense_payment || 'No Payment Info'));
                var img = response.expense_img ? "<img src='/storage/" + response.expense_img + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append("<td align='center'><a href='/admin/expenses/" + response.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + response.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                // Append the new row to the table body
                $("#expenses-table tbody").append(tr);

                // Clear form fields
                $('#expenseForm')[0].reset();
            },
            error: function () {
                alert("Error adding expense.");
            }
        });
    });

    // Update Expense
    $('#expenseEditForm').on('submit', function (e) {
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
                alert("Expense updated successfully.");

                // Find the corresponding table row
                var row = $("tr[data-id='" + response.id + "']");

                // Update row data
                row.find("td:eq(1)").html(response.expense_name);
                row.find("td:eq(2)").html(response.expense_date);
                row.find("td:eq(3)").html(response.expense_amount);
                row.find("td:eq(4)").html(response.expense_payment || 'No Payment Info');
                var img = response.expense_img ? "<img src='/storage/" + response.expense_img + "' width='50'/>" : 'No Image';
                row.find("td:eq(5)").html(img);

                // Clear form fields
                $('#expenseEditForm')[0].reset();
            },
            error: function () {
                alert("Error updating expense.");
            }
        });
    });

    // Expenses Form Validation
    $("#expenseForm").validate({
        rules: {
            expense_name: {
                required: true,
                minlength: 3
            },
            expense_date: {
                required: true,
                date: true
            },
            expense_amount: {
                required: true,
                number: true
            },
            expense_payment: {
                required: true,
                minlength: 3
            },
            expense_img: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            expense_name: {
                required: "The expense name field is required",
                minlength: "The expense name must be at least 3 characters long"
            },
            expense_date: {
                required: "The expense date field is required",
                date: "Please enter a valid date"
            },
            expense_amount: {
                required: "The expense amount field is required",
                number: "The expense amount must be a number"
            },
            expense_payment: {
                required: "The expense payment field is required",
                minlength: "The expense payment must be at least 3 characters long"
            },
            expense_img: {
                required: "The expense image field is required",
                extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Expenses Edit Form Validation
    $("#expenseEditForm").validate({
        rules: {
            expense_name: {
                required: true,
                minlength: 3
            },
            expense_date: {
                required: true,
                date: true
            },
            expense_amount: {
                required: true,
                number: true
            },
            expense_payment: {
                required: true,
                minlength: 3
            },
            expense_img: {
                required: "The expense image field is required",
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            expense_name: {
                required: "The expense name field is required",
                minlength: "The expense name must be at least 3 characters long"
            },
            expense_date: {
                required: "The expense date field is required",
                date: "Please enter a valid date"
            },
            expense_amount: {
                required: "The expense amount field is required",
                number: "The expense amount must be a number"
            },
            expense_payment: {
                required: "The expense payment field is required",
                minlength: "The expense payment must be at least 3 characters long"
            },
            expense_img: {
                required: "The expense image field is required",
                extension: "Please upload a valid image file (jpg, jpeg, png, gif)"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});