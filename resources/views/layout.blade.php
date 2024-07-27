<!DOCTYPE html>
<html>

<head>
    <title>Welcome to PetZone!</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-image: url('images/bg-log.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
        }

        .navbar-brand,
        .nav-link,
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }

        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        .login-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }

        /* CSS for profile picture placeholder */
        .profile-placeholder {
            width: 30px; /* Adjust size as needed */
            height: 30px; /* Adjust size as needed */
            border-radius: 50%; /* Makes it circular */
            background-color: #ccc; /* Placeholder color */
            display: inline-block; /* Aligns with the label */
            margin-right: 1px; /* Space between the circle and the label */
        }

        .rounded-profile {
            width: 50px; /* Adjust size as needed */
            height: 50px; /* Adjust size as needed */
            border-radius: 50%; /* Makes it circular */
            object-fit: cover; /* Ensures the image covers the area without distortion */
        }
    </style>
</head>

<body>


    @yield('content')

</body>

</html>