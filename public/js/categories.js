$(document).ready(function () {
    // Initialize DataTable
    $('#categories-table').DataTable();

    // Fetch and Display Categories
    $.ajax({
        type: "GET",
        url: "/api/categories",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);

                var tr = $("<tr>").attr("data-id", value.id);

                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(value.slug));
                tr.append($("<td>").html(value.title));
                tr.append(
                    $("<td>").html(
                        `<form action='/admin/categories/${value.id}' method='POST' id='prepare-form'>
                            <input type='hidden' name='_token' value='${$('meta[name="csrf-token"]').attr('content')}' />
                            <input type='hidden' name='_method' value='delete' />
                            <button type='submit' class='btn btn-danger deletebtn' data-id='${value.id}'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </form>
                        <a href='/admin/categories/${value.id}/edit' class='btn btn-primary'>
                            <i class='fa fa-pencil'></i>
                        </a>`
                    )
                );

                $("#categories-table tbody").append(tr);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching categories:", error);
        }
    });

    // Delete Category
    $("#categories-table").on('click', '.deletebtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var token = $('meta[name="csrf-token"]').attr('content');

        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                type: "DELETE",
                url: "/api/categories/" + id,
                dataType: 'json',
                data: {
                    _token: token
                },
                success: function (response) {
                    alert("Category deleted successfully.");
                    $("tr[data-id='" + id + "']").remove();
                },
                error: function (xhr, status, error) {
                    console.error("Error deleting category:", error);
                }
            });
        }
    });

    // Add Category
    $('#addCategoryForm').on('submit', function (e) {
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
                alert("Category added successfully.");

                var tr = $("<tr>").attr("data-id", response.id);
                tr.append($("<td>").html(response.id));
                tr.append($("<td>").html(response.slug));
                tr.append($("<td>").html(response.title));
                tr.append(
                    "<td align='center'>" +
                        "<a href='/admin/categories/" + response.id + "/edit' class='btn btn-primary' title='Edit'>" +
                            "<i class='fa fa-pencil' aria-hidden='true'></i>" +
                        "</a> " +
                        "<button class='btn btn-danger deletebtn' data-id='" + response.id + "' title='Delete'>" +
                            "<i class='fa fa-trash' aria-hidden='true'></i>" +
                        "</button>" +
                    "</td>"
                );

                $("#categories-table tbody").append(tr);

                $('#addCategoryForm')[0].reset();
            },
        });
    });

    // Update Category
    $('#edit-category-form').on('submit', function (e) {
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
                alert("Category updated successfully.");

                var tr = $("tr[data-id='" + response.id + "']");
                tr.find("td:eq(1)").html(response.slug);
                tr.find("td:eq(2)").html(response.title);
            },
        });
    });

    // Categories Form Validation
    $("#addCategoryForm").validate({
        rules: {
            slug: {
                required: true,
                minlength: 3
            },
            title: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            slug: {
                required: "The slug field is required",
                minlength: "The slug must be at least 3 characters"
            },
            title: {
                required: "The title field is required",
                minlength: "The title must be at least 3 characters"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    // Categories Edit Form Validation
    $("#edit-category-form").validate({
        rules: {
            slug: {
                required: true,
                minlength: 3
            },
            title: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            slug: {
                required: "The slug field is required",
                minlength: "The slug must be at least 3 characters"
            },
            title: {
                required: "The title field is required",
                minlength: "The title must be at least 3 characters"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});