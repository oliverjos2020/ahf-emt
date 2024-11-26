<!doctype html>
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
    <link href="assets/css/app.min.css"  id="app-style"  rel="stylesheet" type="text/css" />
    <link href="assets/css/toastr.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Welcome Back!</h5>
                                <p class="text-white-50 mb-0">Sign in to continue to AHF Portal.</p>
                                <a href="./" class="logo logo-admin mt-4">
                                    <img src="logo/logo.png" alt="" height="80">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal" id="form1" onsubmit="return false;">
                                    <input type="hidden" name="op" value="Users.login">
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline">Remember me</label>
                                    </div>
                                    <div class="mt-3">
                                        <button id="LoginBtn" class="btn btn-ahf w-100 waves-effect waves-light">Log In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>&copy; <script>document.write(new Date().getFullYear())</script> AHF. Designed & Developed by Access Solutions Limited.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            var data = $("#form1").serialize();
            $.ajax({
                type: "post",
                url: "web/router_default.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    if (data.response_code === 0) {
                        $("#LoginBtn").attr("disabled", true);
                        toastr.success(data.response_message, 'Success', { timeOut: 1000 });
                        setTimeout(function() {
                            window.location.href = 'dashboard';
                        }, 1000);
                    } else {
                        toastr.error(data.response_message, 'Error', { timeOut: 2000 });
                    }
                },
                error: function() {
                    toastr.error('Unable to process request at the moment!', 'Error', { timeOut: 2000 });
                }
            });
        }
    </script>
</body>
</html>
