<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | AHF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AHF" name="description" />
    <meta content="Themesbrand" name="AH" />
    <link rel="shortcut icon" href="logo/logo.png">
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- Preloading Bebas Neue Pro Bold -->
    <link rel="preload" href="assets/fonts/bebas-neue-pro-bold-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

    <!-- Preloading Bebas Neue Pro Book -->
    <link rel="preload" href="assets/fonts/bebas-neue-pro-book-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

    <!-- Preloading Proxima Nova Bold -->
    <link rel="preload" href="assets/fonts/proxima-nova-bold-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

    <!-- Preloading Proxima Nova Regular -->
    <link rel="preload" href="assets/fonts/proxima-nova-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">
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

        
    @font-face {
    font-family: 'Bebas Neue Pro';
    src: url('assets/fonts/bebas-neue-pro-bold-webfont.woff2') format('woff2');
    font-weight: bold;
    font-style: normal;
}

@font-face {
    font-family: 'Proxima Nova';
    src: url('assets/fonts/proxima-nova-webfont.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}

body {
    font-family: 'Proxima Nova', sans-serif;
    color: #000 !important;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Bebas Neue Pro', sans-serif;
    font-weight: bold;

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
                    <h4 class="text-start">LOGIN</h4>
                    <!-- Login Form -->
                    <form id="form1" onsubmit="return false;">
                    <input type="hidden" name="route" value="/login">
                    <input type="hidden" name="webFlag" value="1">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" required>

                        <label for="password" class="form-label mt-3">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                        <div class="forgot-password mt-2">  
                            <a href="./forgot_password" class="text-primary ahf-text-primary">Forgot Password?</a>
                        </div>
                        <button id="LoginBtn" type="submit" class="btn btn-ahf w-100 mt-3">Login</button>
                        <!-- <a href="./dashboard" class="btn btn-ahf w-100 mt-3">Login</a> -->
                    </form>
                </div>
            </div>

        </div>
    </div>
  
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->
      <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("LoginBtn").addEventListener("click", Login);
        });

        function Login() {
            // alert('Login function is called'); // Confirm if function is called
            $('#LoginBtn').text('Logging you in...');
            $("#LoginBtn").attr("disabled", true);
            var data = $("#form1").serialize();
            $.ajax({
                type: "post",
                url: "controllers/gateway.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    if (data.response_code === 200) {
                        $("#LoginBtn").attr("disabled", true);
                        toastr.success(data.response_message, 'Success', { timeOut: 3000 });
                        setTimeout(function() {
                            window.location.href = 'dashboard';
                        }, 1000);
                    } else {
                        $("#LoginBtn").attr("disabled", false);
                        $('#LoginBtn').text('Login');
                        toastr.error(data.response_message, 'Error', { timeOut: 3000 });
                    }
                },
                error: function() {
                    $("#LoginBtn").attr("disabled", false);
                    $('#LoginBtn').text('Login');
                    toastr.error('Unable to process request at the moment!', 'Error', { timeOut: 3000 });
                }
            });
        }
    </script>
</body>

</html>