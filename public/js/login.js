$(function() {
    $(document).on("submit", "#handleAjax", function(event) {
        event.preventDefault();

        var e = this;
        $(this).find("[type='submit']").html("Login...");

        $.ajax({
            url: '/api/login', // Ensure this points to the API route
            data: $(this).serialize(),
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $(e).find("[type='submit']").html("Login");

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
                $(e).find("[type='submit']").html("Login");
                var response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    $.each(response.errors, function (key, val) {
                        $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                    });
                } else {
                    $("#errors-list").append("<div class='alert alert-danger'>Invalid Email or Password. Please try again.</div>");
                }
            }
        });

        return false;
    });
});