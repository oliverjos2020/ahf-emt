<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password | AHF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AHF" name="description" />
    <meta content="Themesbrand" name="AH" />
    <link rel="shortcut icon" href="logo/logo.png">
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/toastr.min.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            background-color: #ffffff; /* Set background color to white */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            /* font-family: Arial, sans-serif; Optional: Set a default font */
        }


        /* Left section with background image */
        .login-left {
            background: url('assets/images/bg-index.png') no-repeat center center;
            background-size: cover;
            min-height: 100vh;
        }

        /* Login-right section */
        .login-right {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            border-radius: 30px;
            background-color: white;
            overflow: hidden;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); */
            position: relative; /* Enable relative positioning */
            z-index: 2; /* Keeps the right section above the left */
            margin-left: -50px; /* Extend into the left section */
        }


        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            background-color: #fff;
        }

        .login-card img {
            max-width: 150px;
            /* Ensure logo is not too large */
            height: auto;
        }

        .login-card h4 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .login-card .form-control {
            margin-bottom: 15px;
        }

        .login-card .forgot-password {
            text-align: right;
        }

        /* Hide left section on smaller screens */
        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                min-height: 100vh;
            }

            .login-right {
                margin-left: 0; /* Remove overlay on small screens */
                justify-content: center; /* Center horizontally */
                align-items: center; /* Center vertically */
            }

            .login-card {
                max-width: 90%; /* Adjust width for smaller screens */
            }
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Left Section -->
            <div class="col-md-6 login-left"></div>

            <!-- Right Section -->
            <div class="col-md-6 d-flex login-right">
                <div class="login-card">
                    <!-- Logo -->
                    <div class="text-center mb-3">
                        <img src="logo/logo_1.png" alt="Logo" width="250%" class="img-fluid">
                    </div>
                    <!-- Login Heading -->
                    <h4 class="text-center">Reset Password</h4>
                    <!-- Login Form -->
                    <!-- <form> -->
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username" id="username" required>
                        <div class="forgot-password mt-2">  
                            <a href="./" class="text-primary ahf-text-primary">I remember now Sign In!</a>
                        </div>
                        <button type="submit" id="resetBtn" onclick="resetPassword()" class="btn btn-ahf w-100 mt-3">Reset</button>
                    <!-- </form> -->
                </div>
            </div>

        </div>
    </div>
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script>
        function resetPassword()
        {
            $('#resetBtn').text('Processing...');
            $("#resetBtn").attr("disabled", true);
            // var data = $("#form1").serialize();
            var username  = $("#username").val();
            if(username == "")
            {
                toastr.error('Username field is required', 'Error', { timeOut: 2000 });
                $("#resetBtn").attr("disabled", false);
                $('#resetBtn').text('Reset');
            }else{
                $.ajax({
                    type: "post",
                    url: "controllers/gateway.php",
                    data: {
                        username,
                        'route': '/resetPassword'
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.response_code === 200) {
                            $("#LoginBtn").attr("disabled", true);
                            toastr.success(data.response_message, 'Success', { timeOut: 1000 });
                            setTimeout(function() {
                                window.location.href = 'dashboard';
                            }, 1000);
                        } else {
                            $("#resetBtn").attr("disabled", false);
                            $('#resetBtn').text('Reset');
                            toastr.error(data.response_message, 'Error', { timeOut: 2000 });
                        }
                    },
                    error: function() {
                        toastr.error('Unable to process request at the moment!', 'Error', { timeOut: 2000 });
                    }
                });
            }
        }
    </script>
</body>

</html>