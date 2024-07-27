$(function() {
    $(document).on("submit", "#handleAjax", function(event) {
        event.preventDefault();

        var e = this;
        $(this).find("[type='submit']").html("Register...");

        console.log("Form submitted:", $(this).serialize());

        // Trim password fields
        $('#password').val($.trim($('#password').val()));
        $('#confirm_password').val($.trim($('#confirm_password').val()));

        $.ajax({
            url: '/api/register', // Update to API route
            data: $(this).serialize(),
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $(e).find("[type='submit']").html("Register");

                if (data.status) {
                    window.location.href = data.redirect; // Redirect to the new page
                } else {
                    $(".alert").remove();
                    $.each(data.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText); // Log the error response
                $("#errors-list").append("<div class='alert alert-danger'>An error occurred. Please try again.</div>");
            }
        });

        return false;
    });
});