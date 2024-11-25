<?php
session_start();
require_once('libs/dbfunctions.php');
// require_once('class/menu.php');
require_once('controllers/menu.php');
$dbobject = new dbobject();
$menu = new Menu();
if (!isset($_SESSION['username_sess'])) {
    header('location: web/logout.php');
}
$role =  $_SESSION['role_id_sess'];
$getRoleID = $dbobject->getitemlabel('userdata', 'username', $_SESSION['username_sess'], 'role_id');
$menu_list = $menu->generateMenu($getRoleID);
$menu_list = $menu_list['data'];
// print_r($menu_list['data']);
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | AHF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="AHF" name="description" />
    <meta content="AHF" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="logo/logo.png">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/toastr.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>
<style>
    /* Bootstrap's default active link style is blue, but we will override it */
    /* .nav-link.active {
    color: white !important;
}
.nav-link {
    color: black !important;
} */
    .nav-link[aria-expanded="false"] {
        color: #707D8A !important;
    }

    .nav-link[aria-expanded="false"] i {
        color: #707D8A !important;
    }

    .loader-container {
        display: none;
        /* Hide the loader by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Dark background */
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loader {
        width: 8px;
        height: 40px;
        border-radius: 4px;
        display: block;
        margin: 20px auto;
        position: relative;
        background: currentColor;
        color: #FFF;
        box-sizing: border-box;
        animation: animloader 0.3s 0.3s linear infinite alternate;
    }

    .loader::after,
    .loader::before {
        content: '';
        width: 8px;
        height: 40px;
        border-radius: 4px;
        background: currentColor;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 20px;
        box-sizing: border-box;
        animation: animloader 0.3s 0.45s linear infinite alternate;
    }

    .loader::before {
        left: -20px;
        animation-delay: 0s;
    }

    @keyframes animloader {
        0% {
            height: 48px
        }

        100% {
            height: 4px
        }
    }

    /* If you want the icon to also change to white */
    /* .nav-link.active i {
    color: white !important;
} */
</style>

<body data-layout="detached" data-topbar="colored">
                    <div class="loader-container">
                        <span class="loader"></span>
                    </div>
    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar" style="background: transparent">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">

                            <div class="dropdown d-inline-block d-lg-none ms-2">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>


                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-2.jpg"
                                        alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1">Patrick</span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> My
                                        Wallet</a>
                                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i
                                            class="bx bx-wrench font-size-16 align-middle me-1"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                                        Lock screen</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="web/logout.php"><i
                                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                                </div>
                            </div>

                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box" style="text-align:center">
                                <a href="index.html" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="logo/logo.png" alt="AHF" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="logo/logo.png" alt="AHF" height="17">
                                    </span>
                                </a>

                                <a href="index.html" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="logo/logo.png" alt="AHF" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="logo/logo.png" alt="AHF" height="60">
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </header> <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div class="h-100">

                    <div class="user-wid text-center py-4">
                        <div class="user-img">
                            <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-md mx-auto rounded-circle">
                        </div>

                        <div class="mt-3">

                            <a href="#" class="text-body fw-medium font-size-16">Patrick Becker</a>
                            <p class="text-muted mt-1 mb-0 font-size-13">UI/UX Designer</p>

                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="./dashboard" class="waves-effect nav-link">
                                    <i class="fas fa-th-large"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <?php
                            foreach ($menu_list as $value) {
                                if ($value['has_sub_menu'] == false) {
                                    echo '
                                <li>
                                    <a href="javascript: void(0);" onclick="getpage(\'' . $value['menu_url'] . '\', \'page\')" class="waves-effect nav-link">
                                        <i class="' . htmlspecialchars($value['icon'], ENT_QUOTES, 'UTF-8') . '"></i>
                                        <span>' . ucfirst($value['menu_name']) . '</span>
                                    </a>
                                </li>
                            ';
                                } else if ($value['has_sub_menu'] == true) {
                                    echo '
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect nav-link">
                                        <i class="' . htmlspecialchars($value['icon'], ENT_QUOTES, 'UTF-8') . '"></i>
                                        <span>' . ucfirst($value['menu_name']) . '</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                ';
                                    foreach ($value['sub_menu'] as $value_1) {
                                        echo '
                                            <li><a onclick="loadNavPage(\'' . $value_1['menu_url'] . '\', \'page\', \'' . $value_1['menu_id'] . '\')">' . ucfirst($value_1['name']) . '</a></li>
                                        ';
                                    }

                                    echo '   </ul>
                                </li>
                            ';
                                }
                            }
                            ?>

                            <li>
                                <a href="web/logout.php" class="waves-effect nav-link">
                                    <i class="fas fa-power-off"></i>
                                    <span>Logout</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content" id="page">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © AHF.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Designed & Develop by Access Solutions Limited
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->

    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body rightbar">
            <div class="right-bar">
                <div data-simplebar class="h-100">
                    <div class="rightbar-title px-3 py-4">
                        <a href="javascript:void(0);" class="right-bar-toggle float-end" data-bs-dismiss="offcanvas" aria-label="Close">
                            <i class="mdi mdi-close noti-icon"></i>
                        </a>
                        <h5 class="m-0">Settings</h5>
                    </div>

                    <!-- Settings -->
                    <hr class="mt-0" />
                    <h6 class="text-center mb-0">Choose Layouts</h6>

                    <div class="p-4">
                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                            <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                        </div>

                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch" />
                            <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                        </div>

                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>
                        <div class="form-check form-switch mb-5">
                            <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                            <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                        </div>

                    </div>

                </div>
                <!-- end slimscroll-menu-->
            </div>
        </div>

    </div>


    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/main.js" integrity="<?php echo $dbobject->CORS('assets/js/main.js') ?>"></script>
    <script src="assets/js/jquery.blockUI.js" integrity="<?php echo $dbobject->CORS('assets/js/jquery.blockUI.js') ?>"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- Chart JS -->
    <script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
    <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->
</body>

</html>