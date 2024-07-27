$(document).ready(function () {
    // Initialize DataTable
    $('#users-table').DataTable();

    // Fetch and Display Users
    $.ajax({
        type: "GET",
        url: "/api/users",
        dataType: 'json',
        success: function (data) {
            console.log(data);

            $.each(data, function (key, value) {
                console.log(value);

                var tr = $("<tr>").attr("data-id", value.id); // Add data-id attribute to the row

                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(value.name));
                tr.append($("<td>").html(value.email));
                tr.append($("<td>").html(value.role));
                tr.append($("<td>").html(value.phone_number));
                tr.append($("<td>").html(value.address));
                var img = value.image_path ? "<img src='/storage/" + value.image_path + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append("<td align='center'><a href='/admin/users/" + value.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + value.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                $("#users-table tbody").append(tr);
            });

            // Bind Delete Button Click Event
            $("#users-table").on('click', '.deletebtn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                if (confirm("Are you sure you want to delete this user?")) { // Add confirmation dialog
                    $.ajax({
                        type: "DELETE",
                        url: "/api/users/" + id,
                        headers: { // Add CSRF token for security
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function (response) {
                            alert("User deleted successfully.");
                            $("tr[data-id='" + id + "']").remove(); // Remove the row from the table without reloading
                        },
                        error: function (error) {
                            alert("Error deleting user. Please try again.");
                            console.error("Error:", error);
                        }
                    });
                }
            });
        },
        error: function (error) {
            console.error("Error fetching users:", error);
            alert("An error occurred while fetching users.");
        }
    });

    // Add User Form Submission
    $('#userForm').on('submit', function (e) {
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
                alert("User added successfully.");

                var tr = $("<tr>").attr("data-id", response.id); // Ensure the new row has a data-id attribute
                tr.append($("<td>").html(response.id));
                tr.append($("<td>").html(response.name));
                tr.append($("<td>").html(response.email));
                tr.append($("<td>").html(response.role));
                tr.append($("<td>").html(response.phone_number));
                tr.append($("<td>").html(response.address));
                var img = response.image_path ? "<img src='/storage/" + response.image_path + "' width='50'/>" : 'No Image';
                tr.append($("<td>").html(img));
                tr.append("<td align='center'><a href='/admin/users/" + response.id + "/edit' class='btn btn-primary' title='Edit'><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td align='center'><a href='#' class='btn btn-danger deletebtn' data-id='" + response.id + "' title='Delete'><i class='fa fa-trash' style='font-size:24px; color:red'></i></a></td>");

                $("#users-table tbody").append(tr);

                $('#userForm')[0].reset(); // Clear form fields
            },
            error: function (error) {
                alert("Error adding user. Please check the form inputs.");
                console.error("Error:", error);
            }
        });
    });

    // Edit User Form Submission
    $('#userEditForm').on('submit', function (e) {
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
                alert("User updated successfully.");

                var row = $("tr[data-id='" + response.id + "']");

                row.find("td:eq(1)").html(response.name);
                row.find("td:eq(2)").html(response.email);
                row.find("td:eq(3)").html(response.role);
                row.find("td:eq(4)").html(response.phone_number);
                row.find("td:eq(5)").html(response.address);
                var img = response.image_path ? "<img src='/storage/" + response.image_path + "' width='50'/>" : 'No Image';
                row.find("td:eq(6)").html(img);

                $('#userEditForm')[0].reset(); // Clear form fields
            },
            error: function (error) {
                alert("Error updating user. Please check the form inputs.");
                console.error("Error:", error);
            }
        });
    });

    // Form Validation
    $("#userForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 3
            },
            role: {
                required: true
            },
            phone_number: {
                required: true,
                digits: true
            },
            address: {
                required: true,
                minlength: 3
            },
            image_path: {
                required: true
            }
        },
        messages: {
            name: {
                required: "The name field is required.",
                minlength: "The name must be at least 3 characters."
            },
            email: {
                required: "The email field is required.",
                email: "Please enter a valid email address."
            },
            password: {
                required: "The password field is required.",
                minlength: "The password must be at least 3 characters."
            },
            role: {
                required: "Please select a role."
            },
            phone_number: {
                required: "The phone number field is required.",
                digits: "Please enter a valid phone number."
            },
            address: {
                required: "The address field is required.",
                minlength: "The address must be at least 3 characters."
            },
            image_path: {
                required: "The image field is required."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Edit Form Validation
    $("#userEditForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                minlength: 3
            },
            role: {
                required: true
            },
            phone_number: {
                required: true,
                digits: true
            },
            address: {
                required: true,
                minlength: 3
            },
            image_path: {
                required: true
            }
        },
        messages: {
            name: {
                required: "The name field is required.",
                minlength: "The name must be at least 3 characters."
            },
            email: {
                required: "The email field is required.",
                email: "Please enter a valid email address."
            },
            password: {
                minlength: "The password must be at least 3 characters."
            },
            role: {
                required: "Please select a role."
            },
            phone_number: {
                required: "The phone number field is required.",
                digits: "Please enter a valid phone number."
            },
            address: {
                required: "The address field is required.",
                minlength: "The address must be at least 3 characters."
            },
            image_path: {
                required: "The image field is required."
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});