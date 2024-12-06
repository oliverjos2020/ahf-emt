<?php
require_once('controllers/cookieManager.php');
$cookieManager = new cookieManager();
$details = $cookieManager->pickCookie();
// print_r($details);exit;
if (!isset($details['username'])) {
    header('location: web/logout.php');
}

$firstname = $details['firstname'] ?? '';
$lastname = $details['lastname'] ?? '';
$role_name = $details['role'] ?? '';
$facility = $details['facilityName'] ?? '';
// print_r($details['menu']);exit;
$menu_list = $details['menu'];

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
    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Anton&display=swap" rel="stylesheet"> -->
    <!-- Preloading Bebas Neue Pro Bold -->
<link rel="preload" href="assets/fonts/bebas-neue-pro-bold-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

<!-- Preloading Bebas Neue Pro Book -->
<link rel="preload" href="assets/fonts/bebas-neue-pro-book-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

<!-- Preloading Proxima Nova Bold -->
<link rel="preload" href="assets/fonts/proxima-nova-bold-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

<!-- Preloading Proxima Nova Regular -->
<link rel="preload" href="assets/fonts/proxima-nova-webfont.woff2" as="font" type="font/woff2" crossorigin="anonymous">

    <style>
    .nav-link[aria-expanded="false"] {
        color: #707D8A !important;
    }

    .nav-link[aria-expanded="false"] i {
        color: #707D8A !important;
    }

    .loader-container {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background: rgba(255, 255, 255, 0.8); */
        background: #991002;
        backdrop-filter: blur(5px);
        /* Apply blur effect to the background */
        z-index: 9999;
        /* Ensure it is above all other content */
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
        color: white;
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

    #page_list_x {
        border-collapse: collapse;
        /* Ensure proper cell collapse */
        border-spacing: 0;
    }

    #page_list_x th,
    #page_list_x td {
        border: 1px solid #000 !important;
        /* Visible border for all cells */
    }

    #page_list_x thead th {
        background-color: #f8f9fa;
        font-size: large;
        /* Light header background */
    }
    #page_list {
        border-collapse: collapse;
        /* Ensure proper cell collapse */
        border-spacing: 0;
    }

    #page_list th,
    #page_list td {
        border: 1px solid #000 !important;
        /* Visible border for all cells */
    }

    #page_list thead th {
        background-color: #f8f9fa;
        font-size: large;
        /* Light header background */
    }
    /* Split Screen Styles */
    #split-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9998;
    }

    #split-top,
    #split-bottom {
        position: absolute;
        left: 0;
        width: 100%;
        height: 50%;
        background-color: #991002;
        /* Adjust to your desired color */
        transform-origin: center center;
        transition: transform 0.8s ease-in-out;
    }

    #split-top {
        top: 0;
        transform: translateY(0);
        /* Initially at its default position */
    }

    #split-bottom {
        bottom: 0;
        transform: translateY(0);
        /* Initially at its default position */
    }

    #container-fluid {
        display: none;
        /* Hidden initially */
        opacity: 0;
        transition: opacity 0.5s ease;
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

/* Style the processing loader */
div.dataTables_processing {
    position: absolute;
    top: calc(100px); /* Adjust this value to push it below the headers */
    left: 50%;
    transform: translateX(-50%);
    background: none; /* Remove default background */
    border: none; /* Remove default border */
    color: transparent; /* Hide default text */
    z-index: 2; /* Ensure it appears above the table content */
}

/* Loader spinner */
.table-loader {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #991002;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: auto;
}
.table-loader-btn {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #991002;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: auto;
}
/* Spinner animation */
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}




    </style>
</head>

<body data-layout="detached" data-topbar="colored">
    <div class="loader-container">
        <span class="loader"></span>
    </div>

    <!-- Split Screen Animation -->
    <div id="split-wrapper">
        <div id="split-top"></div>
        <div id="split-bottom"></div>
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
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>


                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img class="rounded-circle header-profile-user"
                                        src="assets/images/users/avatar-2.jpg" alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1"><?php echo $firstname ?></span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i
                                            class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="bx bx-wallet font-size-16 align-middle me-1"></i> My
                                        Wallet</a>
                                    <a class="dropdown-item d-block" href="#"><span
                                            class="badge bg-success float-end">11</span><i
                                            class="bx bx-wrench font-size-16 align-middle me-1"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                                        Lock screen</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="./web/logout.php"><i
                                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                        Logout</a>
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

                            <button type="button"
                                class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
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

                            <a href="#"
                                class="text-body fw-medium font-size-16"><?php echo $firstname . ' ' . $lastname ?></a>
                            <p class="text-muted mt-1 mb-0 font-size-13"><?php echo $role_name ?></p>

                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="javascript:void(0)" onclick="location.reload();" class="waves-effect"
                                    style="color: #707d8a !important">
                                    <i class="fas fa-th-large" style="color: #991002 !important"></i>
                                    <span>Dashboard</span>
                                </a>

                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="getpage('modules/tracker/tracker_management.php', 'page')";" class="waves-effect"
                                    style="color: #707d8a !important">
                                    <i class="fas fa-th-large" style="color: #991002 !important"></i>
                                    <span>Tracker Management</span>
                                </a>

                            </li>
                            <?php
                            foreach ($menu_list as $value) {
                                if ($value['has_sub_menu'] == false) {
                                    echo '
                                <li>
                                    <a href="javascript: void(0);" onclick="loadNavPage(\'' . $value['menu_url'] . '\', \'page\')" class="waves-effect">
                                        <i class="fas fa-th-large"></i>
                                        <span>' . ucfirst($value['menu_name']) . '</span>
                                    </a>
                                </li>
                            ';
                                } else if ($value['has_sub_menu'] == true) {
                                    echo '
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="fas fa-th-large"></i>
                                        <span>' . ucfirst($value['menu_name']) . '</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                ';
                                    foreach ($value['sub_menu'] as $value_1) {
                                        echo '
                                            <li><a style="cursor:pointer;" onclick="loadNavPage(\'' . $value_1['menu_url'] . '\', \'page\', \'' . $value_1['menu_id'] . '\')">' . ucfirst($value_1['name']) . '</a></li>
                                        ';
                                    }

                                    echo '   </ul>
                                </li>
                            ';
                                }
                            }
                            ?>
                            <!-- 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="fa fa-users"></i>
                                    <span>Patients</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a style="cursor:pointer;" onclick="loadNavPage('modules/patient/add_patient', 'page', '006')" aria-expanded="false">Add Patient</a></li>

                                    <li><a style="cursor:pointer;" onclick="loadNavPage('modules/patient/patient_list', 'page', '007')" aria-expanded="false">Patient List</a></li>

                                    <li class=""><a style="cursor:pointer;" onclick="loadNavPage('modules/patient/view_patient', 'page', '028')" aria-expanded="false">View Patient</a></li>
                                </ul>
                            </li>

                            <li class="">
                                <a href="javascript: void(0);" class="waves-effect nav-link" aria-expanded="true" onclick="loadNavPage('modules/tracker/tracker_management', 'page', '006')">
                                    <i class="dripicons-graph-line"></i>
                                    <span>Tracker Management</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript: void(0);" class="waves-effect nav-link" aria-expanded="true" onclick="loadNavPage('modules/tracker/tracker_management_individual_tracker', 'page', '006')">
                                    <i class="fas fa-user-md"></i>
                                    <span>Individual Tracker</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript: void(0);" class="waves-effect nav-link" aria-expanded="true" onclick="loadNavPage('modules/tracker/missed_appointment', 'page', '006')">
                                    <i class="dripicons-calendar"></i>
                                    <span>Missed Appointment</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript: void(0);" class="waves-effect nav-link" aria-expanded="true" onclick="loadNavPage('modules/inventory/dispensory_log', 'page', '006')">
                                    <i class="fas fa-pills"></i>
                                    <span>Dispensory Log</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript: void(0);" class="waves-effect nav-link" aria-expanded="true" onclick="loadNavPage('modules/inventory/inventory_management', 'page', '006')">
                                    <i class="fas fa-box-open"></i>
                                    <span>Inventory</span>
                                </a>
                            </li> -->
                            <li class="menu-title">Components</li>

                            <li>
                                <a href="./web/logout.php" class="waves-effect">
                                    <i class="mdi mdi-file-tree"></i>
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

                                <!-- <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="ahf-text-primary fw-bold">Facility: <?php echo $facility ?? '' ?></h3>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-ahf btn-sm"><i class="fa fa-print"></i> Print Report</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="background: #fff; border-bottom: 1px solid #eee;">
                            <div class="row p-3">
                                <div class="col-md-6"
                                    style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                    <label for="start-date" style="margin: 0;">Start Date</label>
                                    <input type="date" id="start-date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6"
                                    style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                    <label for="end-date" style="margin: 0;">End Date</label>
                                    <input type="date" id="end-date" name="end_date" class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row p-2">
                                <div class="col-md ahf-border p-3">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-0 p-2">
                                <div class="col-md ahf-border p-3">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md ahf-border p-3 mx-2">
                                    <p class="ahf-text-14">Total Patient Enrolled</p>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4>5076</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="ahf-icon-pill">
                                                <i class="fa fa-users"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">Statistical Analysis</h5>
                                    <canvas id="statistical-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">Gender Distribution</h5>
                                    <!-- <canvas id="gender-distribution"></canvas> -->
                                    <div class="chart-container mt-3">
                                        <canvas id="gender-distribution"></canvas>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">950</h3>
                                            <p>Total Male Patient Enrolled</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">2400</h3>
                                            <p>Total Female Patient Enrolled</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card"> -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">% Active Patient</h5>
                                    <div class="mt-4">
                                        <canvas id="active-patient"></canvas>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">75</h3>
                                            <p>In-Active Patients</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">15</h3>
                                            <p>Active Patient </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="fw-bold">Viral Loads Level Chart</h5>
                                        </div>
                                        <div class="col-md-6"
                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                            <label for="end-date" style="margin: 0;">Filter By</label>
                                            <input type="date" id="viral_date" name="viral_date" class="form-control">
                                        </div>
                                    </div>

                                    <canvas id="viral-load-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="fw-bold">CD4 Count Status Chart</h5>
                                        </div>
                                        <div class="col-md-6"
                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                            <label for="end-date" style="margin: 0;">Filter By</label>
                                            <input type="date" id="viral_date" name="viral_date" class="form-control">
                                        </div>
                                    </div>
                                    <h5 class="fw-bold">CD4 Count Status Chart</h5>
                                    <canvas id="cd4-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">Gender Distribution</h5>
                                    <!-- <canvas id="gender-distribution"></canvas> -->
                                    <div class="chart-container mt-3">
                                        <canvas id="gender-distribution"></canvas>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">950</h3>
                                            <p>Total Male Patient Enrolled</p>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <h3 class="fw-bold">2400</h3>
                                            <p>Total Female Patient Enrolled</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                document.write(new Date().getFullYear())
                                </script> © AHF NIGERIA
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

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="assets/js/pages/sweet-alerts.init.js"></script>
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
    <script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
    <!-- <script src="assets/js/pages/chartjs.init.js"></script> -->
    <!-- App js -->
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
         function openModal(id)
        {
            $("#"+id+"").modal("show");
        }
        
    const ctx = document.getElementById('statistical-chart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Deceased Patient', 'Missed Appointment', 'New Enrollment', 'Lost to Follow-Up'],
            datasets: [{
                label: '# of Votes',
                data: [5, 10, 19, 12],
                backgroundColor: [
                    '#f57878', // Red
                    '#991002', // Blue
                    '#CC8780', // Yellow
                    '#ced4da', // Green
                ],
                borderWidth: 1
            }]
        },
        options: {

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const ctxViralLoad = document.getElementById('viral-load-chart');
    new Chart(ctxViralLoad, {
        type: 'line',
        data: {
            labels: ['0', '<=20', '21 - 999', '>=1000'],
            datasets: [{
                label: '# of Votes',
                data: [0, 500, 999, 800],
                backgroundColor: [
                    '#f5787852',
                ],
                borderWidth: 1
            }]
        },
        options: {

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const ctxCD4Chart = document.getElementById('cd4-chart');
    new Chart(ctxCD4Chart, {
        type: 'line',
        data: {
            labels: ['Deceased Patient', 'Missed Appointment', 'New Enrollment', 'Lost to Follow-Up'],
            datasets: [{
                label: '# of Votes',
                data: [5, 10, 19, 12],
                backgroundColor: [
                    '#f5787852',
                ],
                borderWidth: 1
            }]
        },
        options: {

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxGenderDistribution = document.getElementById('gender-distribution');
    new Chart(ctxGenderDistribution, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: '# of Votes',
                data: [2400, 950],
                backgroundColor: [
                    '#CC8780', // Yellow
                    '#ced4da', // Green
                ],
                borderWidth: 1
            }]
        }
    });

    const ctxActivePatient = document.getElementById('active-patient');
    new Chart(ctxActivePatient, {
        type: 'pie',
        data: {
            labels: ['In-Active Patients', 'Active Patient'],
            datasets: [{
                label: 'Active PatientS',
                data: [75, 15],
                backgroundColor: [
                    '#991002', // Yellow
                    '#DDAFAB', // Green
                ],
                borderWidth: 1
            }]
        }
    });


    $(document).ready(function() {
        // The loader is already visible due to default CSS.
        hideLoader();
        // Simulate a delay for loader (e.g., fetching data)
        setTimeout(function() {
            // Start the split animation
            $('#split-top').css('transform', 'translateY(-100%)'); // Move the top section upward
            $('#split-bottom').css('transform', 'translateY(100%)'); // Move the bottom section downward

            // After the split animation is done
            setTimeout(function() {
                $('#split-wrapper').fadeOut('slow', function() {

                    // Show the container-fluid content with fade-in
                    $('#container-fluid').fadeIn('slow').css('opacity', 1);

                });
            }, 800); // Match this timeout to the CSS transition duration (0.8s)
        }, 2000); // Simulated loader delay (2 seconds)
    });
    </script>



</body>

</html>