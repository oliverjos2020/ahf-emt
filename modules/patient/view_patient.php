<?php
require_once('../../controllers/cookieManager.php');
$cookieManager = new cookieManager();
// $details = $cookieManager->pickCookie();
// // print_r($details);exit;
// if (!isset($details['username'])) {
//     header('location: web/logout.php');
// }
// print_r($_REQUEST);
$id = $_REQUEST['id'];
$triage = isset($_REQUEST['triage']) ? $_REQUEST['triage'] : null;
$options = $cookieManager->pickCookieOptions();
$symptoms = $cookieManager->pickCookieSymptoms();

?>
<style>
    /* Targeting only the activity logs container */
    #activity_logs {
        overflow-y: scroll;
    }

    /* Custom Scrollbar for #activity_logs */
    #activity_logs::-webkit-scrollbar {
        width: 3px !important;
        /* Reduced scrollbar width */
    }

    #activity_logs::-webkit-scrollbar-thumb {
        background-color: #991002 !important;
        /* Color of the scrollbar */
        border-radius: 15px !important;
        /* Rounded corners */
    }

    #activity_logs::-webkit-scrollbar-thumb:hover {
        background-color: #991002 !important;
        /* Darker color when hovered */
    }

    /* Firefox support for #activity_logs */
    #activity_logs {
        scrollbar-width: thin !important;
        /* Thin scrollbar in Firefox */
        scrollbar-color: #991002 !important;
        /* Color of the thumb and track */
    }

    .nav-tabs .nav-link.active {
        background: #991002 !important;
        color: #fff !important;
    }

    .accordion-button {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    table.table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #eee;
        /* Ensure the border color matches your design */
    }

    table.table th,
    table.table td {
        border: 1px solid #eee;
        /* Add border to all cells */
        padding: 8px;
        /* Adjust padding for better readability */
    }

    table.table thead th {
        background-color: #f9f9f9;
        /* Optional: Add background color to the header */
    }

    .custom-switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    .custom-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .custom-switch .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    .custom-switch .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #02A055;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<div class="container-fluid p-0">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h3 class="page-title mb-0">PATIENT MANAGEMENT PAGE</h3>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Patient Entry</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation and Back Button -->
    <div class="row mt-4" style="margin-top: 2rem !important;">
        <div class="col-md-4 mt-0 mb-2 mb-md-0"
            style="font-size:18px; display: flex; align-content: center; align-items: center;">
            <a href="javascript:void(0);" class="text-black"
                onclick="getpage('modules/patient/patient_list.php', 'page');">
                <i class="fa fa-arrow-left"></i> Back to Patient List
            </a>
        </div>
        <div class="col-md-8">
            <nav class="px-0 bg-white border rounded" style="border: 2px solid #991002 !important;">
                <div class="nav nav-tabs nav-fill flex-wrap" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active text-black" id="nav-test_result-tab" data-toggle="tab"
                        href="#nav-test_result" role="tab" aria-controls="nav-test_result"
                        aria-selected="true">Dashboard</a>
                    <a class="nav-item nav-link text-black" id="nav-patient-tab" data-toggle="tab" href="#nav-patient"
                        role="tab" aria-controls="nav-patient" aria-selected="false">Patient Info</a>
                    <a class="nav-item nav-link text-black" id="nav-visit-tab" data-toggle="tab" href="#nav-visit"
                        role="tab" aria-controls="nav-visit" aria-selected="false">Triage</a>
                    <a class="nav-item nav-link text-black" id="nav-clinician-tab" data-toggle="tab"
                        href="#nav-clinician" role="tab" aria-controls="nav-consult" aria-selected="false">Clinician</a>
                    <a class="nav-item nav-link text-black" id="nav-lab-tab" data-toggle="tab" href="#nav-lab"
                        role="tab" aria-controls="nav-lab" aria-selected="false">Laboratory</a>
                    <a class="nav-item nav-link text-black" id="nav-pharmacy-tab" data-toggle="tab" href="#nav-pharmacy"
                        role="tab" aria-controls="nav-pharmacy" aria-selected="false">Pharmacy</a>
                    <a class="nav-item nav-link text-black" id="nav-activity_log-tab" data-toggle="tab"
                        href="#nav-activity_log" role="tab" aria-controls="nav-activity_log"
                        aria-selected="false">Activity Log</a>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 mt-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h5 class="card-title mb-0 fw-bolder">Bio Data</h5>
                        <span class="text-danger badge bg-soft-danger" style="font-size: 0.875rem; color:#991002;">Lost
                            to follow up</span>
                    </div>

                    <div class="row gy-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Name:</div>
                                <div class="col-6 text-muted" id="name"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Gender:</div>
                                <div class="col-6 text-muted" id="gender"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Marital status:</div>
                                <div class="col-6 text-muted" id="maritalStatus"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Occupation:</div>
                                <div class="col-6 text-muted" id="occupation"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Education:</div>
                                <div class="col-6 text-muted" id="education"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Date of Birth:</div>
                                <div class="col-6 text-muted" id="dob">10-03-1994</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Age:</div>
                                <div class="col-6 text-muted" id="age"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Email Address:</div>
                                <div class="col-6 text-muted" id="email"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Patient ID:</div>
                                <div class="col-6 text-muted" id="patient_id"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Duration on ART:</div>
                                <div class="col-6 text-muted">12 months</div>
                            </div>
                        </div>
                        <!--<div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Entry Mode:</div>
                                <div class="col-6 text-muted">OPD</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Nutri Status:</div>
                                <div class="col-6 text-muted">Underweight</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">State:</div>
                                <div class="col-6 text-muted">Abuja</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">LGA:</div>
                                <div class="col-6 text-muted">AMAC</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Notification:</div>
                                <div class="col-6 text-muted">Email</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Phone 1:</div>
                                <div class="col-6 text-muted">+234 701 234 5678 </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Phone 2:</div>
                                <div class="col-6 text-muted">+234 701 234 5678 </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Address:</div>
                                <div class="col-6 text-muted">House 10, 69 Road, <br> Galadimawa, Abuja</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 fw-bolder">Last Visit:</div>
                                <div class="col-6 text-muted">10th Oct, 2024</div>
                            </div>
                        </div> -->
                        <!-- <div class="col-12">
                            <button type="submit" style="background:#991002; border: none; margin-left:95px;" class="btn btn-danger">
                                Update Bio
                            </button>
                        </div> -->

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="row g-3" style="margin-left:5px; padding:11px;">
                    <div class="col-12 p-2">
                        <h5 style="font-weight:bold;" class="mt-2">Discontinuations</h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 " style="text-wrap:nowrap">ART Interruptions Date:</div>
                                    <div class="col-6 text-muted">08-08-2024</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">Why:</div>
                                    <div class="col-6 text-muted">Nil</div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 ">Date of Restart:</div>
                                    <div class="col-6 text-muted">Nil</div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 ">Occupation:</div>
                                    <div class="col-6 text-muted">Teacher</div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 ">Patient Outcome:</div>
                                    <div class="col-6 text-muted">Transferred Out</div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 ">Type:</div>
                                    <div class="col-6 text-muted">Intra Clinic</div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 ">Facility:</div>
                                    <div class="col-6 text-muted">AHF Lokoja</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <section id="tabs">
                <div class="container-x">
                    <div class="row">
                        <div class="col-xs-12 ">
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-test_result" role="tabpanel"
                                    aria-labelledby="nav-test_result-tab">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="card py-md-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="assets/images/test_result.png" class="mt-2"
                                                        alt="Test Result" class="mb-3">
                                                    <h4 class="mt-2">Viral Load</h4>
                                                    <h6 class="text-black fw-bolder">20 Copies/ml</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="card py-md-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="assets/images/heart.png" class="mt-2" alt="Blood Pressure"
                                                        class="mb-3">
                                                    <h4 class="mt-2">Blood Pressure</h4>
                                                    <h6 class="text-black fw-bolder">110/78 mmHg</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="card py-md-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <img src="assets/images/cells.png" class="mt-2" alt="Blood Pressure"
                                                        class="mb-3">
                                                    <h4 class="mt-2">CD4 Level</h4>
                                                    <h6 class="text-black fw-bolder"> > 200 cells/ml</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2>Status Report</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card-body">
                                                    <p class="m-0">DSD Status:</p>
                                                    <strong id="dsd_status">N/A</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body">
                                                    <p class="m-0">TPT Status:</p>
                                                    <strong id="tpt_status">N/A</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body">
                                                    <p class="m-0">Cervical Cancer Status:</p>
                                                    <strong id="cervical_cancer_status">N/A</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body">
                                                    <p class="m-0">ARV Medication:</p>
                                                    <strong id="arv_medication">N/A</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card" style="padding:25px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Body Mass Index</h3>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-6">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/weight.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">Weight
                                                                </h5>
                                                                <p class="card-text" id="weight">N/A</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/height.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Height">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">Height
                                                                </h5>
                                                                <p class="card-text" id="height">N/A</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/bmi.png" class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="BMI">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">BMI
                                                                </h5>
                                                                <p class="card-text" id="bmi">N/A</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card" style="padding:32px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Test Reports</h3>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">
                                                                    Creatinine</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">WBC +
                                                                    Differential</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">Chest
                                                                    X-ray</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">Sputum
                                                                    AFB</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">ALT
                                                                    Test</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <img src="assets/images/test_filter.png"
                                                                    class="card-img-left"
                                                                    style="width:120%; height: auto;" alt="Weight">
                                                            </div>
                                                            <div class="col-lg-8 col-md-6 col-sm-12">
                                                                <h5 class="card-title" style="font-weight:bold;">AST
                                                                    Test</h5>
                                                                <p class="card-text text-black"
                                                                    style="text-wrap:nowrap">
                                                                    48.6% <span style="opacity: 0.9;"
                                                                        class="text-muted">12 Oct, 2024</span>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card " style="padding:20px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Test Report History</h3>

                                            <div class="col-lg-12 abovecol-md-6 col-sm-12 ">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>

                                                            <th scope="col" class="fw-bolder">Test Name</th>
                                                            <th scope="col" class="fw-bolder">Result </th>
                                                            <th scope="col" class="fw-bolder">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td>Viral Load Test</td>
                                                            <td>850 Copies/ml</td>
                                                            <td>8th, July, 2024</td>
                                                        </tr>
                                                        <tr>

                                                            <td>Chest X-ray</td>
                                                            <td>0.25 mSv</td>
                                                            <td>8th, July, 2024</td>
                                                        </tr>
                                                        <tr>

                                                            <td>Chest X-ray</td>
                                                            <td>0.25 mSv</td>
                                                            <td>8th, July, 2024</td>
                                                        </tr>
                                                        <tr>

                                                            <td>Chest X-ray</td>
                                                            <td>0.25 mSv</td>
                                                            <td>8th, July, 2024</td>
                                                        </tr>

                                                    </tbody>
                                                </table>


                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-clinician" role="tabpanel"
                                    aria-labelledby="nav-clinician-tab">
                                    <div class="card">
                                        <!-- Ezekiel Tab -->

                                        <ul class="nav nav-pills nav-justified" role="tablist"
                                            style="border: 2px solid #991002 !important;">
                                            <li class="nav-item waves-effect waves-light" role="presentation">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#consultation-1"
                                                    role="tab" aria-selected="true" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">Consultation</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#request-test-1"
                                                    role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Request Test</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#diagnosis-1" role="tab"
                                                    aria-selected="false">
                                                    <span class="d-block d-sm-none"><i
                                                            class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">Test Result & Diagnosis</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#prescription-1"
                                                    role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Prescription</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content p-0 mt-4 text-muted">
                                            <div class="tab-pane active show" id="consultation-1" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body p-3">
                                                        <div class="position-relative">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Vital Records</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingOne">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseOne"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseOne">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseOne"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingOne"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <div class="row p-2">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Height(m)</label>
                                                                                        <input type="text" name="height"
                                                                                            class="form-control"
                                                                                            placeholder="0.0m" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Weight(kg)</label>
                                                                                        <input type="text" name="weight"
                                                                                            class="form-control"
                                                                                            placeholder="0.00kg"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 mt-3">
                                                                                    <div class="form-group">
                                                                                        <label>BMI(kg/m<sup>2</sup>)</label>
                                                                                        <input type="text" name="height"
                                                                                            class="form-control"
                                                                                            placeholder="0.0kg/m2"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 mt-3">
                                                                                    <div class="form-group">
                                                                                        <label>MUAC()</label>
                                                                                        <input type="text" name="weight"
                                                                                            class="form-control"
                                                                                            placeholder="0000" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body p-0 mt-4">
                                                            <div class="position-relative">
                                                                <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                    <p>ART Commencement</p>
                                                                </div>
                                                                <div class="accordion" id="accordionExample">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header border-bottom"
                                                                            id="headingTwo">
                                                                            <button class="accordion-button py-4"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseTwo"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapseTwo">
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseTwo"
                                                                            class="accordion-collapse collapse show"
                                                                            aria-labelledby="headingTwo"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body">
                                                                                <form id="artCommencement" onsubmit="return false">
                                                                                    <div class="row p-2">
                                                                                        <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                        <input type="hidden" name="route" value="/artForm">
                                                                                        <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>Clinical Stage at the
                                                                                                    start of ART:</label>
                                                                                                <input type="text" name="clinical_stage_at_start" class="form-control"
                                                                                                    placeholder="Input clinical stage at the start of ART">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>Input CD4 Level at
                                                                                                    start of ART:</label>
                                                                                                <input type="text"
                                                                                                    name="cd4_level"
                                                                                                    class="form-control"
                                                                                                    placeholder="CD4 level at the start of ART">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>CD4 LFA:</label>
                                                                                                <input type="text"
                                                                                                    name="cd4_lfa"
                                                                                                    class="form-control"
                                                                                                    placeholder="Below reference">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>Date Initial
                                                                                                    Adherence Counselling
                                                                                                    was Completed:</label>
                                                                                                <input type="date"
                                                                                                    name="initial_adherence"
                                                                                                    class="form-control"
                                                                                                    placeholder="Input CD4 level at the start of ART"
                                                                                                    value="<?php echo date('d-m-Y') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>ART Start
                                                                                                    Date:</label>
                                                                                                <input type="date"
                                                                                                    name="art_start_date"
                                                                                                    class="form-control"
                                                                                                    placeholder="Below reference"
                                                                                                    value="<?php echo date('d-m-Y') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label>First ART
                                                                                                    Regimen:</label>
                                                                                                <select name="first_art_regimen" class="form-select">
                                                                                                    <option value="">Select Option</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <button onclick="artCommencement()" class="artCommencement btn btn-ahf float-end">Save Record</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body p-0 mt-4">
                                                            <div class="position-relative">
                                                                <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                    <p>Clinical Assessments</p>
                                                                </div>
                                                                <div class="accordion" id="accordionExample">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header border-bottom"
                                                                            id="headingThree">
                                                                            <button class="accordion-button py-4"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseThree"
                                                                                aria-expanded="true"
                                                                                aria-controls="collapseThree">
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseThree"
                                                                            class="accordion-collapse collapse show"
                                                                            aria-labelledby="headingThree"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body">
                                                                                <div class="row p-2">
                                                                                    <form id="clinicalAssesment" onsubmit="return false">
                                                                                        <div class="col-md-12">
                                                                                            <!-- <label>Visit ID</label> -->
                                                                                            <input type="hidden" name="visit_id" class="form-control visit_id">
                                                                                            <input type="hidden" name="patient_id" value="<?= $id ?>" class="form-control">
                                                                                            <input type="hidden" name="route" value="/clinicalAssesment">
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="mt-2">Select
                                                                                                    Patient
                                                                                                    Symptoms:</label>

                                                                                                <select id="optionContainer" multiple name="symptoms[]" class="form-select">
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group"
                                                                                                style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                                <label class="mt-2">New
                                                                                                    Opportunistic Infections
                                                                                                    or Other
                                                                                                    Problems:</label>
                                                                                                <select
                                                                                                    name="opportunistic_infections"
                                                                                                    class="form-select">
                                                                                                    <option value="" select>
                                                                                                        Select Option
                                                                                                    </option> <?php
                                                                                                                foreach ($options['opportunisticInfection'] as $opportunistic) {
                                                                                                                    echo "<option value='$opportunistic[option]'>$opportunistic[option]</option>";
                                                                                                                }
                                                                                                                ?>

                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-3 mt-4">
                                                                                                <label class="fw-bold mt-3">Is
                                                                                                    Patient</label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4">
                                                                                                <label class="mt-3">Pregnant:
                                                                                                    <input type="radio"
                                                                                                        name="pregnancy_status" value="Pregnant" onclick="is_pregnant()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4 is_breast_feeding">
                                                                                                <label class="mt-3">Breast Feeding:
                                                                                                    <input type="radio"
                                                                                                        name="pregnancy_status" value="Breast Feeding" onclick="breast_feeding()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4 is_pregnant">
                                                                                                <div class="form-group"
                                                                                                    style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                                    <label
                                                                                                        class="mt-2 fw-bold">Last
                                                                                                        Period Date:</label>
                                                                                                    <input type="date"
                                                                                                        name="last_period"
                                                                                                        class="form-control">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 mt-4">
                                                                                                <label>Family Planning:</label>
                                                                                                <select name="family_planning" class="form-select">
                                                                                                    <option value="">Select Option</option>
                                                                                                    <?php
                                                                                                    foreach ($options['familyPlanning'] as $familyPlanning) {
                                                                                                        echo "<option value='$familyPlanning[option]'>$familyPlanning[option]</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 mt-4">
                                                                                                <label>Functional
                                                                                                    Status:</label>
                                                                                                <select name="functional_status" class="form-select">
                                                                                                    <option value="">Select Option</option>
                                                                                                    <?php
                                                                                                    foreach ($options['functionalStatus'] as $functionalStatus) {
                                                                                                        echo "<option value='$functionalStatus[option]'>$functionalStatus[option]</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 mt-4">
                                                                                                <label>Patient WHO Clinical
                                                                                                    State:</label>
                                                                                                <input type="text" name="who_state" placeholder="Input Details" class="form-control">

                                                                                            </div>
                                                                                            <div class="col-md-6 mt-4">
                                                                                                <label>TB Screening:</label>
                                                                                                <select name="tb_screening"
                                                                                                    class="form-select">
                                                                                                    <option value="">Select Option</option>
                                                                                                    <?php
                                                                                                    foreach ($options['tbScreening'] as $tbScreening) {
                                                                                                        echo "<option value='$tbScreening[option]'>$tbScreening[option]</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group"
                                                                                                style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                                <label
                                                                                                    class="mt-2">Cryptococcal
                                                                                                    Screening
                                                                                                    Status:</label>
                                                                                                <select name="cryptococcal_screening"
                                                                                                    class="form-select">
                                                                                                    <option value="" select> Select option</option>
                                                                                                    <?php
                                                                                                    foreach ($options['cryptococcal'] as $cryptococcal) {
                                                                                                        echo "<option value='$cryptococcal[option]'>$cryptococcal[option]</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mt-4">
                                                                                                <label
                                                                                                    class="fw-bold mt-3">Eligible
                                                                                                    for Cervical Cancer
                                                                                                    Screening?</label>
                                                                                            </div>
                                                                                            <div class="col-md-2 mt-4">
                                                                                                <label class="mt-3">Eligible:
                                                                                                    <input type="radio" value="Eligible"
                                                                                                        name="eligible_cervical_cancer_screening" onclick="eligible()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4">
                                                                                                <label class="mt-3">Not
                                                                                                    Eligible: <input
                                                                                                        type="radio"
                                                                                                        name="eligible_cervical_cancer_screening" value="Not Eligible" onclick="not_eligible()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4">
                                                                                                <label class="mt-3">Not
                                                                                                    Applicable: <input
                                                                                                        type="radio"
                                                                                                        name="eligible_cervical_cancer_screening" value="Not Applicable" onclick="not_eligible()"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mt-4 is_patient_screened">
                                                                                                <label class="fw-bold mt-3">Is
                                                                                                    Patient Screened?</label>
                                                                                            </div>
                                                                                            <div class="col-md-4 mt-4 is_patient_screened">
                                                                                                <label class="mt-3">Yes: <input
                                                                                                        type="radio"
                                                                                                        name="is_patient_screened" value="Yes" onclick="is_cervical_cancer()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-4 mt-4 is_patient_screened">
                                                                                                <label class="mt-3">No: <input
                                                                                                        type="radio"
                                                                                                        name="is_patient_screened" value="No" onclick="no_cervical_cancer()"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mt-4 is_cervical_cancer">
                                                                                                <label
                                                                                                    class="fw-bold mt-3">Cervical
                                                                                                    Cancer Screening
                                                                                                    Result:</label>
                                                                                            </div>
                                                                                            <div class="col-md-4 mt-4 is_cervical_cancer">
                                                                                                <label class="mt-3">Positive:
                                                                                                    <input type="radio"
                                                                                                        name="cervical_cancer_screening_result" value="Positive" onclick="positive()"></label>
                                                                                            </div>
                                                                                            <div class="col-md-4 mt-4 is_cervical_cancer">
                                                                                                <label class="mt-3">Negative:
                                                                                                    <input type="radio"
                                                                                                        onclick="negative()" value="Negative" name="cervical_cancer_screening_result"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-4 mt-4 positive">
                                                                                                <label
                                                                                                    class="fw-bold mt-3">Cervical
                                                                                                    Cancer Screening
                                                                                                    Treatment?</label>
                                                                                            </div>
                                                                                            <div class="col-md-2 mt-4 positive">
                                                                                                <label class="mt-3">Treated:
                                                                                                    <input type="radio" value="Treated"
                                                                                                        name="cervical_cancer_screening_treatment"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4 positive">
                                                                                                <label class="mt-3">Not Treated:
                                                                                                    <input type="radio"
                                                                                                        name="cervical_cancer_screening_treatment" value="Not Treated"></label>
                                                                                            </div>
                                                                                            <div class="col-md-3 mt-4 positive">
                                                                                                <label class="mt-3">Referred:
                                                                                                    <input type="radio"
                                                                                                        name="cervical_cancer_screening_treatment" value="Referred"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="mt-0">Treatment
                                                                                                    Provided:</label>
                                                                                                <input type="text" name="treatment_provided" class="form-control">

                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <div class="form-group"
                                                                                                style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                                <label
                                                                                                    class="mt-2">Hepatitis
                                                                                                    Screening
                                                                                                    Status:</label>
                                                                                                <select name="hepatitis_screening" class="form-select">
                                                                                                    <option value="" select> Select option </option>
                                                                                                    <?php
                                                                                                    foreach ($options['hepatitis'] as $hepatitis) {
                                                                                                        echo "<option value='$hepatitis[option]'>$hepatitis[option]</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-4">
                                                                                            <button onclick="clinicalAssesment()" class="clinical_assesment btn btn-ahf float-end">Save Record</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Clinical Note</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingFour">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseFour"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseFour">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseFour"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingFour"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <div class="row p-2">
                                                                                <div class="col-md-12">
                                                                                    <form id="noteForm" onsubmit="return false">
                                                                                        <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                        <input type="hidden" name="route" value="/sendNotes">
                                                                                        <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                        <div class="form-group">
                                                                                            <textarea name="note" class="form-control" placeholder="Write note here ..."></textarea>
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button onclick="saveNote()" class="saveNote btn btn-ahf float-end">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Diagnosis</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingFive">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseFive"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseFive">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseFive"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingFive"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <div class="row p-2">
                                                                                <form id="diagnosisForm" onsubmit="return false">
                                                                                    <div class="col-md-12 mt-4">

                                                                                        <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                        <input type="hidden" name="route" value="/diagnosis">
                                                                                        <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                        <div class="form-group">
                                                                                            <label class="mt-2">Select
                                                                                                Diagnosis:</label>
                                                                                            <select id="optionillness" name="diagnosis" multiple class="form-select">
                                                                                                <option>Headache</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button onclick="saveDiagnosis()"
                                                                                                    class="diagnosisBtn btn btn-ahf float-end">Save
                                                                                                    Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Level of Adherence to Treatment</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingSix">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseSix"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseSix">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <div class="row p-2">
                                                                                <h3>ARV Drugs</h3>
                                                                                <form id="arvDrugs" onsubmit="return false">
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group">
                                                                                            <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                            <input type="hidden" name="route" value="/levelAdTreat">
                                                                                            <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                            <label class="mt-2">Indicators:</label>
                                                                                            <select name="avr_drugs_indicators" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Good (G) = ≥ 95% adherence (≤ 1 missed dose)">Good (G) = ≥ 95% adherence (≤ 1 missed dose)</option>
                                                                                                <option value="Fair (F) = 85-94% adherence (2-4 missed doses)">Fair (F) = 85-94% adherence (2-4 missed doses)</option>
                                                                                                <option value="Poor (P) = < 85% adherence (≥ 5 missed doses)">Poor (P) = < 85% adherence (≥ 5 missed doses)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label class="mt-2">Reasons for Adherence level:</label>
                                                                                            <select name="avr_drugs_reason_for_Adherance" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Forget">Forget</option>
                                                                                                <option value="Fell asleep">Fell asleep</option>
                                                                                                <option value="Change in routine">Change in routine</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <h3 class="mt-4">Cotrimoxazole</h3>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label
                                                                                                class="mt-2">Indicators:</label>
                                                                                            <select name="cotrimoxazole_indicators" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Good (G) = ≥ 95% adherence (≤ 1 missed dose)">Good (G) = ≥ 95% adherence (≤ 1 missed dose)</option>
                                                                                                <option value="Fair (F) = 85-94% adherence (2-4 missed doses)">Fair (F) = 85-94% adherence (2-4 missed doses)</option>
                                                                                                <option value="Poor (P) = < 85% adherence (≥ 5 missed doses)">Poor (P) = < 85% adherence (≥ 5 missed doses)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Reasons for
                                                                                                Adherence level:</label>
                                                                                            <select name="cotrimoxazole_reason_for_Adherance" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Forget">Forget</option>
                                                                                                <option value="Fell asleep">Fell asleep</option>
                                                                                                <option value="Change in routine">Change in routine</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <h3 class="mt-4">TPT</h3>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label
                                                                                                class="mt-2">Indicators:</label>
                                                                                            <select name="tpt_indicators" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Good (G) = ≥ 95% adherence (≤ 1 missed dose)">Good (G) = ≥ 95% adherence (≤ 1 missed dose)</option>
                                                                                                <option value="Fair (F) = 85-94% adherence (2-4 missed doses)">Fair (F) = 85-94% adherence (2-4 missed doses)</option>
                                                                                                <option value="Poor (P) = < 85% adherence (≥ 5 missed doses)">Poor (P) = < 85% adherence (≥ 5 missed doses)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Reasons for
                                                                                                Adherence level:</label>
                                                                                            <select name="tpt_reason_for_Adherance" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <option value="Forget">Forget</option>
                                                                                                <option value="Fell asleep">Fell asleep</option>
                                                                                                <option value="Change in routine">Change in routine</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="adherenceBtn btn btn-ahf float-end" onclick="saveARV()">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Substitution/Switches Management</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingSeven">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseSeven"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseSeven">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseSeven"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingSeven"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="substitution" onsubmit="return false">
                                                                                <div class="row p-2">

                                                                                    <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                    <input type="hidden" name="route" value="/sub_dis">
                                                                                    <input type="hidden" name="status" value="substitution">
                                                                                    <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                    <div class="col-md-4">
                                                                                        <label class="fw-bold">Substitution
                                                                                            Within:</label>
                                                                                        <select name="sub_within" class="form-select">
                                                                                            <option value="">Select Option</option>
                                                                                            <option value="1st Line">1st Line</option>
                                                                                            <option value="2nd Line">2nd Line</option>
                                                                                            <option value="3rd Line">3rd Line</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label class="fw-bold">Date of New
                                                                                            Regimen:</label>
                                                                                        <input type="date" name="date_new_regi" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <labe class="fw-bold" l>Why?</label>
                                                                                            <select name="why_sub" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <?php
                                                                                                foreach ($options['why'] as $why) {
                                                                                                    echo "<option value='$why[option]'>$why[option]</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">Switch To:</label>
                                                                                        <select name="switch_to" class="form-select">
                                                                                            <option value="">Select Option</option>
                                                                                            <option value="2nd Line">2nd Line</option>
                                                                                            <option value="3rd Line">3rd Line</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">Date of New
                                                                                            Regimen:</label>
                                                                                        <input type="date" name="date_switch_to" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <labe class="fw-bold" l>Why?</label>
                                                                                            <select name="why" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <?php
                                                                                                foreach ($options['why'] as $why) {
                                                                                                    echo "<option value='$why[option]'>$why[option]</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button onclick="substitution()" class="substitution btn btn-ahf float-end">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Discontinuations and Interruptions</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingThirteen">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseThirteen"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseThirteen">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseThirteen"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingThirteen"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="discontinuation" onsubmit="return false">
                                                                                <div class="row p-2">
                                                                                    <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                    <input type="hidden" name="route" value="/sub_dis">
                                                                                    <input type="hidden" name="status" value="discontinuation">
                                                                                    <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">Date of ART
                                                                                            Interruption:</label>
                                                                                        <input type="date" name="date_of_art_interruption" class="form-control">

                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">ART
                                                                                            Interruptions:</label>
                                                                                        <select name="art_interruption" class="form-select">
                                                                                            <option value="">Select Option </option>
                                                                                            <option value="Stopped">Stopped</option>
                                                                                            <option value="Default">Default</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <labe class="fw-bold" l>Why?</label>
                                                                                            <select name="why_interruption" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                                <?php
                                                                                                foreach ($options['why'] as $why) {
                                                                                                    echo "<option value='$why[option]'>$why[option]</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">Date of
                                                                                            Restart:</label>
                                                                                        <input type="date" name="date_of_restart" class="form-control">

                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold">Patient
                                                                                            Outcome:</label>
                                                                                        <select name="patient_outcome" class="form-select">
                                                                                            <option value="">Select Option</option>
                                                                                            <option value="Deceased"></option>
                                                                                            <option value="Transferred Out">Transferred Out</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <labe class="fw-bold" l>Date of
                                                                                            Transferred Out:</label>

                                                                                            <input type="date" name="date_trans_out" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <labe class="fw-bold" l>Facility Transferred To:</label>
                                                                                            <input type="text" class="form-control" name="facility_trans_to">
                                                                                            <!-- <select name="facility_trans_to" class="form-select">
                                                                                            <option>Self Transferred</option>
                                                                                        </select> -->
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="discontinuation btn btn-ahf float-end" onclick="discontinuation()">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Differentiated Service Delivery (DSD) Models</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingDSD">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseDSD"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseDSD">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseDSD"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingDSD"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="dsdModel" onsubmit="return false">
                                                                                <div class="row p-2">
                                                                                    <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                    <input type="hidden" name="route" value="/dsdData">
                                                                                    <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                    <div class="col-md-6 mt-4">
                                                                                        <label
                                                                                            class="fw-bold mt-3">Differentiated
                                                                                            Service Delivery (DSD)
                                                                                            Models:</label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">Facility-Based:
                                                                                            <input value="Facility Based" type="radio" name="dsdModel"></label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">Community-Based:
                                                                                            <input type="radio" value="Community Based" name="dsdModel"></label>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Community Based Model Type:</label>
                                                                                            <select name="type" class="form-select">
                                                                                                <option value="" disabled selected>Select an option</option>
                                                                                                <option value="CBM1">CBM1 - Community Pharmacy ART Refill</option>
                                                                                                <option value="CBM2">CBM2 - Community ART Refill Group (Healthcare Worker Led)</option>
                                                                                                <option value="CBM3">CBM3 - Community ART Refill Group (PLHIV Led)</option>
                                                                                                <option value="CBM4">CBM4 - Adolescent Community ART (Peer-Led)</option>
                                                                                                <option value="CBM5">CBM5 - Home Delivery</option>
                                                                                                <option value="CBM6">CBM6 - OSS Community Platforms</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="dsdModel btn btn-ahf float-end" id="dsdModelBtn">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Enhanced Adherence Counselling</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingNine">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseNine"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseNine">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseNine"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingNine"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="eac" onsubmit="return false">
                                                                                <div class="row p-2">
                                                                                    <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                    <input type="hidden" name="route" value="/enhancedAdherance">
                                                                                    <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Viral Load
                                                                                                Test Result:</label>
                                                                                            <input type="text"
                                                                                                name="viral_load"
                                                                                                value=">1000 cells/ul"
                                                                                                readonly
                                                                                                class="form-control">

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Session of enhanced adherence counselling provided:</label>
                                                                                            <select name="session_ea_provied" class="form-select">
                                                                                                <option value="">Select option</option>
                                                                                                <option value="None">None</option>
                                                                                                <option value="1st EAC">1st EAC</option>
                                                                                                <option value="2nd EAC">2nd EAC</option>
                                                                                                <option value="3rd EAC">3rd EAC</option>
                                                                                                <option value="Additional EAC">Additional EAC</option>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 mt-4">
                                                                                        <label class="fw-bold mt-3">Status of Enhanced Adherence Counselling provided:</label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">Completed:
                                                                                            <input type="radio" value="Completed" name="status_ea_provided"></label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">Not Completed:
                                                                                            <input type="radio" value="Not Completed" name="status_ea_provided"></label>
                                                                                    </div>
                                                                                    <div class="col-md-6 mt-4">
                                                                                        <label class="fw-bold mt-3">Refer Patient to Laboratory for Targeted Viral Load Test:</label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">Yes:
                                                                                            <input type="radio" value="Yes" name="refer_to_lab"></label>
                                                                                    </div>
                                                                                    <div class="col-md-3 mt-4">
                                                                                        <label class="mt-3">No:
                                                                                            <input type="radio" name="refer_to_lab" value="No"></label>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Reason for rdering Viral Load Test:</label>
                                                                                            <select name="reason_for_test" class="form-select">
                                                                                                <option value="">Select option </option>
                                                                                                <option value="Targeted">Targeted </option>
                                                                                                <option value="Routine">Routine</option>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="eac btn btn-ahf float-end" onclick="eac()">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Consult, Hospitalize, or Refer</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingTen">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseTen"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseTen">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseTen"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingTen"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="hospitalize" onsubmit="return false">
                                                                                <div class="row p-2">
                                                                                    <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                    <input type="hidden" name="route" value="/hospitalizeOption">
                                                                                    <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="fw-bold mt-3">Patient
                                                                                            needs to be:</label>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="mt-3">Hospitalize:
                                                                                            <input type="radio" value="Hospitalize" name="hospitalize_status"></label>
                                                                                    </div>
                                                                                    <div class="col-md-4 mt-4">
                                                                                        <label class="mt-3">Referred to
                                                                                            another
                                                                                            facility:
                                                                                            <input type="radio" value="Referred to another facility" name="hospitalize_status"></label>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Input Facility:</label>
                                                                                            <input type="text" name="treatment_provided" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="hospitalize btn btn-ahf float-end" onclick="hospitalize()">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="position-relative mt-4">
                                                            <div class="fw-bold fs-4 px-3 py-3 position-absolute">
                                                                <p>Next Appointment</p>
                                                            </div>
                                                            <div class="accordion" id="accordionExample">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header border-bottom"
                                                                        id="headingEleven">
                                                                        <button class="accordion-button py-4"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseEleven"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseEleven">
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseEleven"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingEleven"
                                                                        data-bs-parent="#accordionExample">
                                                                        <div class="accordion-body">
                                                                            <form id="appointment" onsubmit="return false">
                                                                                <div class="row p-2">
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <input type="hidden" name="visit_id" readonly class="form-control visit_id">
                                                                                        <input type="hidden" name="route" value="/setNextAppointment">
                                                                                        <input type="hidden" name="patient_id" value="<?= $id ?>">
                                                                                        <div class="form-group" style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Next Appointment Duration:</label>
                                                                                            <select name="appointment_duration" class="form-select">
                                                                                                <option value="">Select Option</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <div class="form-group"
                                                                                            style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                                            <label class="mt-2">Next
                                                                                                Appointment Date:</label>
                                                                                            <input type="date" name="appointment_date" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div class="col-md-12 mt-4">
                                                                                                <button class="appointment btn btn-ahf float-end" onclick="appointment()">Save Record</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            </div>
                                            <div class="tab-content p-0 mt-0 text-muted">
                                                <div class="tab-pane" id="request-test-1" role="tabpanel">
                                                    <!-- <div class="card"> -->
                                                    <div class="card-body p-3">
                                                        <div class="col-md-12 mt-0">
                                                            <div class="form-group"
                                                                style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                                <label class="mt-0 fw-bold">Select Tests:</label>

                                                                <select style="border: 1px solid gray !important"
                                                                    class="js-example-basic-multiple form-control"
                                                                    name="states[]" multiple="multiple">
                                                                    <option value="AL">Alabama</option>
                                                                    <option value="WY">Wyoming</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-content p-0 mt-0 text-muted">
                                                    <div class="tab-pane" id="diagnosis-1" role="tabpanel">
                                                        <div class="card-body p-3">
                                                            <table class="table table-bordered table-striped">
                                                                <tr>
                                                                    <th>Test Requested</th>
                                                                    <th>Result</th>
                                                                    <th>Result Date</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Viral Load Test</td>
                                                                    <td>850 copies/ml</td>
                                                                    <td>8th July,2024</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Viral Load Test</td>
                                                                    <td>850 copies/ml</td>
                                                                    <td>8th July,2024</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Viral Load Test</td>
                                                                    <td>850 copies/ml</td>
                                                                    <td>8th July,2024</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-content p-0 mt-0 text-muted">
                                                    <div class="tab-pane" id="prescription-1" role="tabpanel">
                                                        <div class="card-body p-3">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <i class="fa fa-plus float-end text-light p-2 rounded-circle"
                                                                        style="background:#991002"
                                                                        onclick="add_row()"></i>
                                                                </div>
                                                            </div>
                                                            <div id="myDiv" class="mt-2 mb-2"></div>
                                                            <div class="row mb-4 p-2">
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Age Group</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>Adult</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Drug Type</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>ARV Drug</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Drug Name</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>Select Option</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Category</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>Select Category</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Formation</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>Select Option</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Frequency</label>
                                                                        <select name="age_group" class="form-select">
                                                                            <option>Select Category</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Quantity</label>
                                                                        <input type="text" placeholder="00"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Duration</label>
                                                                        <select name="duration" class="form-select">
                                                                            <option>Twice daily</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-4">
                                                                    <div class="form-group">
                                                                        <label class="fw-bold">Illness</label>
                                                                        <select name="duration" class="form-select">
                                                                            <option>HIV</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-patient" role="tabpanel"
                                    aria-labelledby="nav-patient-tab">
                                    <div class="card" style="padding:5px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Next of Kin</h3>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">

                                                            <h5 class="card-title" style="font-weight:bold;">Surname
                                                            </h5>
                                                            <p class="card-text" id="bminextOfKinLname">N/A</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Middlename <br>
                                                                N/A
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h5 class="card-title" style="font-weight:bold;">
                                                                Firstname
                                                            </h5>
                                                            <p class="card-text" id="nextOfKinFname">N/A</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h5 class="card-title" style="font-weight:bold;">
                                                                Relationship</h5>
                                                            <p class="card-text" id="relationship">N/A</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <h5 class="card-title" style="font-weight:bold;">Phone
                                                                Number 1</h5>
                                                            <p class="card-text" id="nextOfKinPhone">N/A</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Phone Number 2 <br>
                                                                <span class="fw-bolder"> Nil </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card mt-2" style="padding:5px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Treatment Supporter</h3>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Surname <br>
                                                                Jajalu
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Middlename <br>
                                                                John
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Firstname <br>
                                                                Doe
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Relationship <br>
                                                                Nephew
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Phone Number 1 <br>
                                                                <span class="fw-bolder"> +234 701 234 5678 </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <p class="text-muted">Phone Number 2 <br>
                                                                <span class="fw-bolder"> Nil </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-2" style="padding:43px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-8 fw-bolder">ART Adherence Preparation</h3>
                                            <div class="row g-3">
                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Adherence
                                                            Plan Started:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">
                                                            09-04-2024
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Education
                                                            ART
                                                            Essentials:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">Lorem
                                                            ipsum
                                                            dolor sit amet consectetur adipisicing elit. </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Complete
                                                            Adherence Needed:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">Lorem
                                                            ipsum
                                                            dolor sit amet consectetur, adipisicing elit. </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Dosage
                                                            Detailed Explanation:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 text-muted">Yes</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Side
                                                            Effects
                                                            Strategies Explained:</div>
                                                        <div class="col-6 text-muted">Yes</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Adherence
                                                            Plan:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">Lorem,
                                                            ipsum
                                                            dolor sit amet consectetur adipisicing elit. </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-6">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Treatment
                                                            Supporter Provided:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">Yes
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Patient
                                                            ART
                                                            Start Date:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">
                                                            09-04-2024
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 fw-bolder">Adherence
                                                            Plan Completed:</div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 text-muted">
                                                            09-04-2024
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-visit" role="tabpanel"
                                    aria-labelledby="nav-visit-tab">
                                    <div class="card" style="padding:10px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Vital Records</h3>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="duration"
                                                                    style="text-wrap: nowrap;">Duration on ARTS (in
                                                                    months)</label>
                                                                <input type="text" class="form-control" name="duration_art"
                                                                    placeholder="0" id="duration_art">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="blood_pressure">Blood Pressure</label>
                                                                <input type="text" class="form-control"
                                                                    name="blood_pressure" placeholder="00/00 mmHg"
                                                                    id="blood_pressure">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="weight">Weight</label>
                                                                <input type="text" class="form-control" name="triage_weight"
                                                                    id="triage_weight" placeholder="0.0 kg">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="height">Height</label>
                                                                <input type="text" class="form-control" name="triage_height"
                                                                    id="triage_height" placeholder="0.00 m" onclick="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="pulse_rate">Pulse rate</label>
                                                                <input type="text" class="form-control"
                                                                    name="pulse_rate" id="pulse_rate"
                                                                    placeholder="Input Pulse Rate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="pulse_rate">BMI
                                                                    (kg/m<sup>2</sup>):</label>
                                                                <input type="text" class="form-control" name="triage_bmi"
                                                                    id="triage_bmi" readonly placeholder="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="Nutritional Status"
                                                                    style="text-wrap: nowrap;">TB Screening</label>
                                                                <select class="form-select" name="tb_screening"
                                                                    id="tb_screening">
                                                                    <!-- <option value="" selected disabled>Select</option> -->
                                                                    <option value="well_nourished">Presumptive TB
                                                                    </option>
                                                                    <!-- <option value="mal_nourished">Mal Nourished</option> -->

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="Nutritional Status"
                                                                    style="text-wrap: nowrap;">Nutritional
                                                                    Status</label>
                                                                <input type="text" class="form-control"
                                                                    id="nutritional_status" name="nutritional_status">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="card-body">
                                                        <button type="submit"
                                                            style="background:#991002; float:right; border: none;"
                                                            class="btn btn-danger" id="submitTriage" onclick="submitTriage()">
                                                            Save Record
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-2 p-3" style="padding:10px;">
                                        <div class="row-12 container">
                                            <h3 class="mt-4 fw-bolder">Next Stage of Visit</h3>
                                            <div class="d-flex">
                                                Refer Patient to:
                                                <input class="ms-4 me-2" type="checkbox" name="clinician"
                                                    id="clinician">
                                                Clinician <input class="ms-4 me-2" type="checkbox" name="laboratory"
                                                    id="laboratory">
                                                Laboratory <input class="ms-4 me-2" type="checkbox" name="pharmacy"
                                                    id="pharmacy"> Pharmacy
                                            </div>
                                            <!-- <div class="row p-3"> -->
                                            <div class="col-md-12 mt-4"
                                                style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                                <label for="start-date" style="margin: 0;">Select Baseline
                                                    test:</label>
                                                <select name="baselineTest" id="baselineTest" class="form-select">
                                                    <option value="">Select as many that are applicable</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div style="background: #FFE7E7; padding: 10px; text-align: center;">CD4
                                                Level Count <span class="text-danger fw-bold ms-3"
                                                    style="color: #991002 !important; font-size: 15px;">x</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <button type="submit"
                                                    style="background:#991002; float:right; border: none;"
                                                    class="btn btn-danger">
                                                    Submit
                                                </button>
                                            </div>

                                        </div>
                                        <!-- </div> -->
                                    </div>


                                </div>

                                <div class="tab-pane fade" id="nav-consult" role="tabpanel" aria-labelledby="nav-consult-tab">
                                    <div class="card" style="border-radius: 16px 19px !important; ">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;"> ART Commencement
                                                                    (Vital Records)</h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-6 col-sm-12 mb-3">
                                                                    <div class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="clinical stage" class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Clinical
                                                                            Stage at the start of ART:</label>
                                                                        <input type="text" name="clinical_stage_at_start" class="form-control" id="clinical_stage"
                                                                            placeholder="Input clinical stage at the start of ART">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                                                        <label for="input_cd4"
                                                                            class="mb-2 mb-md-0 me-0 me-md-2 text-nowrap fw-bold">
                                                                            Input CD4 Level at start of ART:
                                                                        </label>
                                                                        <input type="text" name="input_cd4"
                                                                            class="form-control" id="input_cd4"
                                                                            placeholder="Input CD4 Level at start of ART">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 col-lg-6 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="CD4 LFA" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">CD4
                                                                            LFA:</label>
                                                                        <input type="text" name="cd4_lfa"
                                                                            class="form-control" id="cd4_lfa"
                                                                            placeholder="Below Reference">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-lg-6 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="Art Start Date" class="me-2" style="text-wrap: nowrap;font-weight: bold;">
                                                                            Art Start Data:
                                                                        </label>
                                                                        <input type="date" name="first_art_regimen" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-lg-12 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="First Regimen"
                                                                            class="me-2 fw-bolder"
                                                                            style="text-wrap: nowrap; font-weight: bold;">First
                                                                            Regimen:</label>
                                                                        <select class="form-select"
                                                                            name="first_regimen" id="first_regimen">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="Height" class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Height(m):</label>
                                                                        <input type="text" name="height"
                                                                            class="form-control" id="height"
                                                                            placeholder="0.00m">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="Weight" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Weight
                                                                            (kg):</label>
                                                                        <input type="text" name="weight"
                                                                            class="form-control" id="weight"
                                                                            placeholder="0.00kg">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="BMI" class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">BMI(Kg/m2):</label>
                                                                        <input type="text" name="bmi"
                                                                            class="form-control" id="bmi"
                                                                            placeholder="0.00kg/m2">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="muac" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Muac:</label>
                                                                        <input type="text" name="muac"
                                                                            class="form-control" id="muac"
                                                                            placeholder="0000">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-colum flex-md-row align-items-center">
                                                                        <label for="First Regimen"
                                                                            class="me-2 fw-bolder"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Functional
                                                                            Status:</label>
                                                                        <select class="form-select"
                                                                            name="functional_status"
                                                                            id="functional_status">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-3 mb-3">
                                                                    <iv
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="First Regimen"
                                                                            class="me-2 fw-bolder"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Is
                                                                            Patient:</label>
                                                                        <span
                                                                            style="font-weight:bold;">Pregnant</span>
                                                                        <input type="checkbox">
                                                                        </s>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="First Regimen"
                                                                            class="me-2 fw-bolder"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Breastfeeding:</label>
                                                                        <input type="checkbox">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="form-group">
                                                                        <label for="Last Period Date"
                                                                            class="me-2 fw-bolder">Last
                                                                            Period Date:</label>
                                                                        <input type="date" class="form-select"
                                                                            name="last_period_date"
                                                                            id="last_period_date">
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-md-6 col-lg-6 col-sm-12 ">
                                                                    <p
                                                                        style="text-wrap: nowrap; font-weight: bold;">
                                                                        Would you like to receive notifications?
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <input type="checkbox" name="yes" id="yes">
                                                                    Yes

                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <input type="checkbox" name="no" id="no"> No

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3 col-lg-3 col-sm-12 mb-3">
                                                                    <input type="checkbox" name="email" id="email">
                                                                    Email

                                                                </div>
                                                                <div class="col-md-3 collg-3 col-sm-12">
                                                                    <input type="checkbox" name="sms" id="sms">
                                                                    SMS

                                                                </div>
                                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                                    <input type="checkbox" name="both_e_and_s"
                                                                        id="both_e_and_s"> <span
                                                                        style="text-wrap: nowrap; font-weight: bold;">Both
                                                                        Email and SMS notifications</span>

                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="muac" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Clinician
                                                                            in Attendance:</label>
                                                                        <input type="text"
                                                                            name="clinician_in_attendance"
                                                                            class="form-control"
                                                                            id="clinician_in_attendance"
                                                                            placeholder="Input clinician name here">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <button type="submit"
                                                                    style="background:#991002; border: none; margin-left:530px;"
                                                                    class="btn btn-danger">
                                                                    Save Record
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;"> TB and other
                                                                    Clinical
                                                                    Assessments</h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <label for="tb_status" class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">TB
                                                                            Status:</label>
                                                                        <select class="form-select" name="tb_status"
                                                                            id="tb_status">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="d-flex flex-column flex-md-row align-items-center">
                                                                    <label for="cryptococcal_status" class="me-2"
                                                                        style="text-wrap: nowrap; font-weight: bold;">Cryptococcal
                                                                        Screening Status :</label>
                                                                    <select class="form-select"
                                                                        name="cryptococcal_status"
                                                                        id="cryptococcal_status">
                                                                        <option value="" disabled selected>
                                                                            Select
                                                                            Option</option>
                                                                        <option value="option_1">Option 1
                                                                        </option>
                                                                        <option value="option_2">Option 2
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class="row mt-4">
                                                                <div class="col-md-7 col-lg-7 col-sm-12">

                                                                    <label for="cryptococcal_status" class="me-2"
                                                                        style="text-wrap: nowrap; font-weight: bold;">Eligible
                                                                        for Cervical Cancer Screening? :</label>
                                                                    <input type="checkbox" name="eligible"
                                                                        id="eligible"> Eligible
                                                                </div>
                                                                <div class="col-md-2 col-lg-2 col-sm-12">
                                                                    <input type="checkbox" name="not_eligible"
                                                                        id="not_eligible"> Not Eligible

                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <input type="checkbox" name="not_eligible"
                                                                        id="not_applicable"> Not Applicable

                                                                </div>

                                                            </div>
                                                            <div class="row mt-4">
                                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                                    <label for="patient_screening" class="me-2"
                                                                        style="text-wrap: nowrap; font-weight: bold;">Is
                                                                        Patient Screened? :</label>
                                                                    <input type="checkbox" name="eligible" id="yes">
                                                                    Yes
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="checkbox" name="no_screening"
                                                                        id="not_eligible"> No
                                                                </div>
                                                            </div>



                                                            <div class="row mt-4">
                                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                                    <label for="cervical_cancer_screening_result"
                                                                        class="me-2"
                                                                        style="text-wrap: nowrap; font-weight: bold;">Cervical
                                                                        Cancer Screening Result:</label>
                                                                    <input type="checkbox" name="positive"
                                                                        id="positive"> Positive
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="checkbox" name="negative"
                                                                        id="negative"> Negative
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                                    <label for="cervical_cancer_treatment"
                                                                        class="me-2"
                                                                        style="text-wrap: nowrap; font-weight: bold;">Cervical
                                                                        Cancer Treatment:</label>
                                                                    <input type="checkbox" name="treated"
                                                                        id="treated"> Treated
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <input type="checkbox" name="not_treated"
                                                                        id="not_treated"> Not Treated
                                                                </div>
                                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                                    <input type="checkbox" name="referred"
                                                                        id="referred"> Referred
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                    <div class="d-flex align-items-center">
                                                                        <label for="muac" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Treatment
                                                                            Provided:</label>
                                                                        <select name="treatment_provided"
                                                                            id="treatment_provided"
                                                                            class="form-select">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="yes">Yes</option>

                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="muac" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">
                                                                            Hepatitis Screening Status:</label>
                                                                        <!-- <select name="treatment_provided" id="treatment_provided" class="form-select">
                                                                                    <option value="" disabled selected> Select option</option>
                                                                                    <option value="yes">Yes</option>
                                                                                </select> -->
                                                                        <input type="text" name="" class="form-control">
                                                                    </div>

                                                                </div>
                                                            </div>


                                                            <div class="col-lg-12 col-md-6 col-sm-12">
                                                                <button type="submit"
                                                                    style="background:#991002; border: none; margin-left:530px;"
                                                                    class="btn btn-danger">
                                                                    Save Record
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;"> Additional
                                                                    Diagnoses
                                                                    & Side Effects </h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label
                                                                            for="new opportunistic or Other problems"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">New
                                                                            Opportunistic or Other
                                                                            Problems:</label>
                                                                        <select class="form-select"
                                                                            name="cryptococcal_status"
                                                                            id="cryptococcal_status">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-6 col-sm-12">

                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label
                                                                            for="new opportunistic or Other problems"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Side
                                                                            Effects:</label>
                                                                        <select class="form-select"
                                                                            name="side_effects" id="side_effects">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-6 cold-sm-12 mt-2">
                                                                <button type="submit"
                                                                    style="background:#991002; border: none; margin-left:530px;"
                                                                    class="btn btn-danger">
                                                                    Save Record
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;"> Differentiated
                                                                    Service Delivery (DSD) Models </h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-7 col-lg-7 col-sm-12 mb-2">
                                                                        <label for="dsd" class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Differentiated
                                                                            Service Delivery :</label>
                                                                        <input type="checkbox" name="facility_base"
                                                                            id="facility_base"> Facility-Based
                                                                    </div>
                                                                    <div class="col-md-5 col-md-5 col-sm-12">
                                                                        <input type="checkbox" name="community_base"
                                                                            id="community_base"> Community-Based
                                                                    </div>

                                                                </div>

                                                                <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label
                                                                            for="new opportunistic or Other problems"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Community
                                                                            Based Model Type:</label>
                                                                        <select class="form-select"
                                                                            name="cryptococcal_status"
                                                                            id="cryptococcal_status">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="option_1">Option 1
                                                                            </option>
                                                                            <option value="option_2">Option 2
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Prescription</h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 col-lg-6 col-sm-6 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Drug
                                                                                Type:</label>
                                                                            <input type="text" name="drug_type"
                                                                                class="form-control" id="drug_type"
                                                                                placeholder="Drug Type">
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <label for="age_group" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">
                                                                                Age Group:</label>
                                                                            <select class="form-select"
                                                                                name="age_group" id="age_group">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="adult">Adult
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Line
                                                                                Code:</label>
                                                                            <select class="form-select"
                                                                                name="line_code" id="line_code">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="line code">2nd
                                                                                    Line
                                                                                    code </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                                                                        <div class="d-flex align-items-center">
                                                                            <label for="line section" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Line
                                                                                Section:</label>
                                                                            <select class="form-select"
                                                                                name="age_group" id="age_group">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="ABC">ABC I 3TC
                                                                                    (600mg/300mg) </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_two" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Drug
                                                                                Two:</label>
                                                                            <select class="form-select"
                                                                                name="line_code" id="line_code">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="line code">
                                                                                    COTRIMOXAZOLE </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="line section" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Dose:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="dosage" id="dosage"
                                                                                placeholder="Enter drug dose here">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-6 col-sm-12 mt-2">
                                                                        <button type="submit"
                                                                            style=" border: none; margin-left:520px;"
                                                                            class="btn btn-outline-danger">
                                                                            <i class="bi bi-plus"> </i> Add More
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Level of Adherence
                                                                    to
                                                                    Treatment</h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_level" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">ARV
                                                                                Drugs Level:</label>
                                                                            <input type="text" name="drug_level"
                                                                                class="form-control" id="drug_level"
                                                                                placeholder="Inout ARV drug level">
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="age_group" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Indicators:</label>
                                                                            <select class="form-select" name="fair"
                                                                                id="fair">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="fair">Fair
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Reasons
                                                                                for Adherence Level:</label>
                                                                            <select class="form-select"
                                                                                name="reasons_of_adherence_level"
                                                                                id="reasons_of_adherence_level">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="line code">2nd
                                                                                    Line
                                                                                    code </option>

                                                                            </select>
                                                                        </div>
                                                                        <hr>

                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 col-lg-12 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_level" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Cotrimoxazole
                                                                                Level:</label>
                                                                            <input type="text"
                                                                                name="cotrimaxazole_level"
                                                                                class="form-control"
                                                                                id="cotrimaxazole_level"
                                                                                placeholder="Input Cotri drug level">
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="age_group" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Indicators:</label>
                                                                            <select class="form-select" name="fair"
                                                                                id="fair">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="fair">Fair
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-12 col-sm-12  mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="drug_type" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Reasons
                                                                            for Adherence Level:</label>
                                                                        <select class="form-select"
                                                                            name="reasons_of_adherence_level"
                                                                            id="reasons_of_adherence_level">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="line code">2nd Line
                                                                                code
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                    <hr>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="line section" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">TB
                                                                                Preventive Level:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="tb_preventive_level"
                                                                                id="tb_preventive_level"
                                                                                placeholder="Enter TBT drug level">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="indicators" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Indicators:</label>
                                                                            <select class="form-select"
                                                                                name="tb_indicators"
                                                                                id="tb_indicators">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="poor">Poor
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 col-ld-6 col-sm-12  mb-3">
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-center">
                                                                        <label for="drug_type" class="me-2"
                                                                            style="text-wrap: nowrap;font-weight: bold;">Reasons
                                                                            for Adherence Level:</label>
                                                                        <select class="form-select"
                                                                            name="reasons_of_adherence_level"
                                                                            id="reasons_of_adherence_level">
                                                                            <option value="" disabled selected>
                                                                                Select Option</option>
                                                                            <option value="line code">2nd Line
                                                                                code
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                    <hr>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Other Tests Done
                                                                </h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-5 col-lg-5 col-sm-12">
                                                                        <label for="cryptococcal_status"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Other
                                                                            Test Done :</label>
                                                                        <input type="checkbox" name="hb_pcv"
                                                                            id="hb_pcv"> HB/PCV
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                                                        <input type="checkbox" name="wbc" id="wbc">
                                                                        WBC + Differential

                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-12">
                                                                        <input type="checkbox" name="alt" id="alt">
                                                                        ALT

                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-12">
                                                                        <input type="checkbox" name="alt" id="ast">
                                                                        AST

                                                                    </div>

                                                                </div>
                                                            </div>



                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                                                        <input type="checkbox" name="creatinine"
                                                                            id="hb_pcv">Creatinine
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                                                        <input type="checkbox" name="HBCs_HCV"
                                                                            id="HBCs_HCV"> HBCsAg/HCV

                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                                                        <input type="checkbox" name="chest_xray"
                                                                            id="chest_xray"> Chest X-ray
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input type="checkbox" name="sputum"
                                                                            id="sputum"> Sputum AFB

                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-4 col-lg-4 col-sm-12">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="hb-pcv" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">HB/PCV
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="hb_pcv_result"
                                                                                id="hb_pcv_result" placeholder="00">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-4 col-sm-12">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row  align-items-center">
                                                                            <label for="hb-pcv" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Creatinine
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="creatinine_result"
                                                                                id="creatinine_result"
                                                                                placeholder="00">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-4 col-sm-12">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="sputum_result" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Sputum
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="sputum_result"
                                                                                id="sputum_result"
                                                                                placeholder="Text here">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Viral Load Test
                                                                </h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                                                        <label for="cryptococcal_status"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Viral
                                                                            Load Test Ordered :</label>
                                                                        <input type="checkbox"
                                                                            name="viral_load_test"
                                                                            id="viral_load_test"> Yes
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                                                        <input type="checkbox" name="no" id="no"> No

                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Reason
                                                                                for ordering Viral Load
                                                                                Test1:</label>
                                                                            <select class="form-select"
                                                                                name="reasons_of_adherence_level"
                                                                                id="reasons_of_adherence_level">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="line code">2nd
                                                                                    Line
                                                                                    code </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12 col-md-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Viral
                                                                                Load Test Result (Lab
                                                                                Technician):</label>

                                                                            <input type="text" name="lab_technician"
                                                                                id="lab_technician"
                                                                                class="form-control">

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="drug_type" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Level
                                                                                of enhanced adherence
                                                                                counselling
                                                                                provided:</label>
                                                                            <select class="form-select"
                                                                                name="enahnce_adherence"
                                                                                id="enahnce_adherence">
                                                                                <option value="" disabled selected>
                                                                                    Select Option</option>
                                                                                <option value="line code">2nd
                                                                                    Line
                                                                                    code </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-4 col-lg-4 col-sm-12 ">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="hb-pcv" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">HB/PCV
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="hb_pcv_result"
                                                                                id="hb_pcv_result" placeholder="00">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-4 col-sm-12 ">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="hb-pcv" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Creatinine
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="creatinine_result"
                                                                                id="creatinine_result"
                                                                                placeholder="00">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-lg-4 col-sm-12">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="sputum_result" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Sputum
                                                                                Result:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="sputum_result"
                                                                                id="sputum_result"
                                                                                placeholder="Text here">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Consult,
                                                                    Hospitalize
                                                                    or Refer</h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-6 col-lg-6 col-sm-12 mb-3">
                                                                        <label for="cryptococcal_status"
                                                                            class="me-2"
                                                                            style="text-wrap: nowrap; font-weight: bold;">Patient
                                                                            need to be :</label>
                                                                        <input type="checkbox"
                                                                            name="patient_need_to_be"
                                                                            id="patient_need_to_be"> Hospitalize
                                                                    </div>

                                                                    <div class="col-md-6 col-lg-6 col-sm-12  mb-3">
                                                                        <input type="checkbox"
                                                                            name="another_facility"
                                                                            id="another_facility"> Referred to
                                                                        another facility
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header border-bottom" id="headingOne">
                                                        <button class="accordion-button py-2" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="fw-bolder">
                                                                <h5 style="font-weight:bold;">Next Appointment
                                                                </h5>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row  align-items-center">
                                                                            <label for="sputum_result" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">Patient
                                                                                Status:</label>
                                                                            <input type="text" class="form-control"
                                                                                name="patient_status"
                                                                                id="patient_status"
                                                                                placeholder="Existing Patient">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-md-6 col-sm-12  mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="sputum_result" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">
                                                                                Next Appointment
                                                                                Duration:</label>
                                                                            <select class="form-select"
                                                                                name="next_appointment"
                                                                                id="next_appointment">
                                                                                <option value="" disbaled selected>
                                                                                    Select option</option>
                                                                                <option value="1 hour"> 1 Hour
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12 col-lg-12 col-sm-12 mb-3">
                                                                        <div
                                                                            class="d-flex flex-column flex-md-row align-items-center">
                                                                            <label for="sputum_result" class="me-2"
                                                                                style="text-wrap: nowrap;font-weight: bold;">
                                                                                Next Appointment Date:</label>

                                                                            <input type="date"
                                                                                name="next_appointment_date"
                                                                                id="next_appointment_date"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade card p-4" id="nav-lab" role="tabpanel"
                                    aria-labelledby="nav-lab-tab">
                                    <div class="col-md-8">
                                        <nav class="px-0 bg-white border rounded" style="border: 2px solid #991002 !important;">
                                            <div class="nav nav-tabs nav-fill flex-wrap" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active text-black" id="lab-request-tab" data-bs-toggle="tab"
                                                    href="#lab-request" role="tab" aria-controls="lab-request" aria-selected="true">Laboratory Request</a>
                                                <a class="nav-item nav-link text-black" id="lab-history-tab" data-bs-toggle="tab"
                                                    href="#lab-history" role="tab" aria-controls="lab-history" aria-selected="false">Laboratory History</a>
                                            </div>
                                        </nav>
                                    </div>
                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="tab-content">
                                            <!-- Lab request Tab Content -->
                                            <div class="tab-pane fade show active" id="lab-request" role="tabpanel" aria-labelledby="lab-request-tab">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-6 col-sm-12">
                                                        <!-- <h4>Laboratory</h4> -->
                                                        <table class="table table-bordered table-hover dt-responsive nowrap"
                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Test Requested</th>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Sample Required</th>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Result</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="lab-request-table">

                                                            </tbody>
                                                        </table>
                                                        <!-- Save Button Container -->
                                                        <div class="text-end mt-3">
                                                            <button type="submit" class="btn btn-danger" id="save-lab-request" onclick="updateLabResult()" style="background:#991002; border: none;">
                                                                Update Record
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- lab History Tab Content -->
                                            <div class="tab-pane fade" id="lab-history" role="tabpanel" aria-labelledby="lab-history-tab">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-6 col-sm-12">
                                                        <table class="table table-bordered table-hover dt-responsive nowrap"
                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Test Name</th>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Result</th>
                                                                    <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Date</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id="lab-request-history">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade card p-4" id="nav-pharmacy" role="tabpanel" aria-labelledby="nav-pharmacy-tab">
                                    <div class="col-md-8">
                                        <nav class="px-0 bg-white border rounded" style="border: 2px solid #991002 !important;">
                                            <div class="nav nav-tabs nav-fill flex-wrap" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active text-black" id="dispensing-tab" data-bs-toggle="tab"
                                                    href="#dispensing" role="tab" aria-controls="dispensing" aria-selected="true">Dispensing</a>
                                                <a class="nav-item nav-link text-black" id="refill-tab" data-bs-toggle="tab"
                                                    href="#refill" role="tab" aria-controls="refill" aria-selected="false">Refill</a>
                                            </div>
                                        </nav>
                                    </div>
                                    <div class="card mt-3" style="border-radius: 16px 19px !important;">
                                        <div class="tab-content">
                                            <!-- Dispensing Tab Content -->
                                            <div class="tab-pane fade show active" id="dispensing" role="tabpanel" aria-labelledby="dispensing-tab">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-6 col-sm-12">
                                                        <div class="table-responsive">
                                                            <!-- <h4>Dispensing</h4> -->
                                                            <table class="table table-bordered table-hover dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Category</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Drug Name</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Formation</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Quantity Prescribed</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Frequency</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Duration</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Quantity Dispensed</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Dispensed?</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="dispense-table">
                                                                    <tr>
                                                                        <td style="text-wrap:nowrap;">ARV Drug</td>
                                                                        <td style="text-wrap:nowrap;">Lorem</td>
                                                                        <td style="text-wrap:nowrap;">Tablet</td>
                                                                        <td style="text-wrap:nowrap;">00</td>
                                                                        <td style="text-wrap:nowrap;">Thrice Daily</td>
                                                                        <td style="text-wrap:nowrap;">2 months</td>
                                                                        <td style="text-wrap:nowrap;"> <label class="custom-switch">
                                                                                <input type="checkbox">
                                                                                <span class="slider"></span>
                                                                            </label>No</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-wrap:nowrap;">Anti-biotics</td>
                                                                        <td style="text-wrap:nowrap;">Ipsum</td>
                                                                        <td style="text-wrap:nowrap;">Injection</td>
                                                                        <td style="text-wrap:nowrap;">00</td>
                                                                        <td style="text-wrap:nowrap;">Twice Daily</td>
                                                                        <td style="text-wrap:nowrap;">6 months</td>
                                                                        <td style="text-wrap:nowrap;"><label class="custom-switch">
                                                                                <input type="checkbox">
                                                                                <span class="slider"></span>
                                                                            </label>Yes</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- Save Button Container -->
                                                        <div class="text-end mt-3">
                                                            <button type="submit" class="btn btn-danger" style="background:#991002; border: none;" id="dispense-drug-btn" onclick="dispenseDrug()">
                                                                Dispense
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Refill Tab Content -->
                                            <div class="tab-pane fade" id="refill" role="tabpanel" aria-labelledby="refill-tab">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-6 col-sm-12">
                                                        <div class="table-responsive">
                                                            <!-- <h4>Dispensing</h4> -->
                                                            <table class="table table-bordered table-hover dt-responsive nowrap"
                                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Category</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Drug Name</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Formation</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Frequency</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Duration</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Qty Filled</th>
                                                                        <th scope="col" class="fw-bolder" style="text-wrap:nowrap;">Dispensed?</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="refill-table">
                                                                    <tr>
                                                                        <td style="text-wrap:nowrap;">
                                                                            <select class="form-select" style="max-width: 150px;">
                                                                                <option value="ARV Drug" selected>ARV Drug</option>
                                                                                <option value="Antibiotics">Antibiotics</option>
                                                                                <option value="Pain Relievers">Pain Relievers</option>
                                                                                <option value="Supplements">Supplements</option>
                                                                            </select>
                                                                        </td>
                                                                        <td style="text-wrap:nowrap;">Lorem</td>
                                                                        <td style="text-wrap:nowrap;">Tablet</td>

                                                                        <td style="text-wrap:nowrap;">Thrice Daily</td>
                                                                        <td style="text-wrap:nowrap;">2 months</td>
                                                                        <td style="text-wrap:nowrap;"> <input type="number" class="form-control" style="max-width: 60px;" maxlength="2" min="0" max="99" placeholder="00" /></td>
                                                                        <td style="text-wrap:nowrap;"> <label class="custom-switch">
                                                                                <input type="checkbox">
                                                                                <span class="slider"></span>
                                                                            </label>No</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-wrap:nowrap;">
                                                                            <select class="form-select" style="max-width: 150px;">
                                                                                <option value="ARV Drug" selected>ARV Drug</option>
                                                                                <option value="Antibiotics">Antibiotics</option>
                                                                                <option value="Pain Relievers">Pain Relievers</option>
                                                                                <option value="Supplements">Supplements</option>
                                                                            </select>
                                                                        </td>
                                                                        <td style="text-wrap:nowrap;">Ipsum</td>
                                                                        <td style="text-wrap:nowrap;">Injection</td>
                                                                        <td style="text-wrap:nowrap;">Twice Daily</td>
                                                                        <td style="text-wrap:nowrap;">6 months</td>
                                                                        <td style="text-wrap:nowrap;"> <input type="number" class="form-control" style="max-width: 60px;" maxlength="2" min="0" max="99" placeholder="00" /></td>
                                                                        <td style="text-wrap:nowrap;"><label class="custom-switch">
                                                                                <input type="checkbox">
                                                                                <span class="slider"></span>
                                                                            </label>Yes</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- Save Button Container -->
                                                        <div class="text-end mt-3">
                                                            <button type="submit" class="btn btn-danger" id="refill-drug-btn" onclick="refillDrug()" style="background:#991002; border: none;">
                                                                Refill
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-activity_log" role="tabpanel" aria-labelledby="nav-activity_log-tab">

                                    <div class="card mt-3" style="border-radius: 5px !important;">
                                        <div class="position-relative">
                                            <div class="accordion" id="accordionExample">
                                                <div class="p-3 rounded">
                                                    <h3 class="text-left mb-0">Activity Log</h3>
                                                </div>
                                                <div class="accordion-body" id="activity_logs" style="height: 650px; overflow-y: auto;">
                                                    <div class="row">
                                                        <div class="col-md-2 col-lg-2 col-sm-12" style="margin-right: -60px;">
                                                            <img src="assets/images/visit_icon.png"
                                                                alt="Visit Icon"
                                                                style="width: 60%; height: auto;">
                                                        </div>
                                                        <div class="col-md-10 col-lg-10 col-sm-12">
                                                            <div class="card bg-soft-secondary"
                                                                style="border-radius: 14px;  padding: 15px;">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="fw-bold">Next
                                                                        Appointment:
                                                                        25th October, 2024</span>
                                                                    <span>
                                                                        Missed Appointment:
                                                                        <span
                                                                            class="badge bg-warning text-dark"
                                                                            style="border-radius: 10px; padding: 5px 10px;">Nil</span>
                                                                    </span>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <span>Last Visited: 25th July,
                                                                        2024</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row ">
                                                                <div class="col-md-2">
                                                                    <img src="assets/images/missed_appointment.png"
                                                                        alt="Missed Appointment Icon"
                                                                        style="width: 80%; height: auto;">
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="card bg-soft-danger"
                                                                        style="border-radius: 14px; padding: 15px;">
                                                                        <div class="d-flex justify-content-between">
                                                                            <span class="fw-bold">Next
                                                                                Appointment:
                                                                                25th October, 2024</span>
                                                                            <span>
                                                                                Tracked Status:
                                                                                <span
                                                                                    class="badge bg-success text-white"
                                                                                    style="border-radius: 10px; padding: 5px 10px;">Yes</span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <span class="d-block">Missed
                                                                                Appointment: Yes</span>
                                                                            <span class="d-block">Last Visited:
                                                                                25th
                                                                                July, 2024</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <img src="assets/images/doctor_visit.png"
                                                                        style="width:80%; height:auto">
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <div class="card bg-soft-success"
                                                                        style="border-radius: 14px; padding: 20px;">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-start">
                                                                            <div>
                                                                                <p class="mb-2">Date Visited:
                                                                                    25th
                                                                                    July, 2024</p>
                                                                                <p class="mb-2">Vitals Taken:
                                                                                    Blood
                                                                                    Pressure, Height, Weight,
                                                                                    Pulse
                                                                                    Rate</p>
                                                                                <p class="mb-2">Tests Carried
                                                                                    Out:
                                                                                    Hepatitis Test, Sputum AFB,
                                                                                    TB
                                                                                    Test, Viral Load</p>
                                                                                <p class="mb-2">Drugs Received:
                                                                                    ARV,
                                                                                    1st Line</p>
                                                                                <p class="mb-0">Next
                                                                                    Appointment:
                                                                                    12th January, 2025</p>
                                                                            </div>
                                                                            <span
                                                                                class="badge bg-success text-white"
                                                                                style="border-radius: 10px; padding: 5px 10px; margin-right:5px;">Dr.
                                                                                Ebuka Preacher</span>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <img src="assets/images/doctor_visit.png"
                                                                        style="width:80%; height:auto">
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <div class="card bg-soft-success"
                                                                        style="border-radius: 14px; padding: 20px;">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-start">
                                                                            <div>
                                                                                <p class="mb-2">Date Visited:
                                                                                    25th
                                                                                    July, 2024</p>
                                                                                <p class="mb-2">Vitals Taken:
                                                                                    Blood
                                                                                    Pressure, Height, Weight,
                                                                                    Pulse
                                                                                    Rate</p>
                                                                                <p class="mb-2">Tests Carried
                                                                                    Out:
                                                                                    Hepatitis Test, Sputum AFB,
                                                                                    TB
                                                                                    Test, Viral Load</p>
                                                                                <p class="mb-2">Drugs Received:
                                                                                    ARV,
                                                                                    1st Line</p>
                                                                                <p class="mb-0">Next
                                                                                    Appointment:
                                                                                    12th January, 2025</p>
                                                                            </div>
                                                                            <span
                                                                                class="badge bg-success text-white"
                                                                                style="border-radius: 10px; padding: 5px 10px; margin-right:5px;">Dr.
                                                                                Ebuka Preacher</span>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div> -->

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>

</div>
</div>

<div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_div">

        </div>
    </div>
</div>

<script>
    var pat_id;
    var visit_id;


    $('.is_pregnant').hide();
    $('.is_patient_screened').hide();
    $('.is_cervical_cancer').hide();
    $('.positive').hide();

    function positive() {
        $('.positive').show();
    }

    function negative() {
        $('.positive').hide();
    }

    function is_pregnant() {
        $('.is_pregnant').show();
    }

    function breast_feeding() {
        $('.is_pregnant').hide();
    }

    function eligible() {
        $('.is_patient_screened').show();
    }

    function not_eligible() {
        $('.is_patient_screened').hide();
    }

    function is_cervical_cancer() {
        $('.is_cervical_cancer').show();
    }

    function no_cervical_cancer() {
        $('.is_cervical_cancer').hide();
    }


    <?php if ($triage === 'yes') : ?>
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');
        // Activate the Triage tab
        $('#nav-visit-tab').addClass('active').attr('aria-selected', 'true');

        // Show the corresponding tab content
        $('#nav-visit').addClass('show active');

        // Deactivate the default active tab
        $('.nav-item.nav-link').not('#nav-visit-tab').removeClass('active').attr('aria-selected', 'false');
        $('.tab-pane').not('#nav-visit').removeClass('show active');
        $('#duration_art').focus();
    <?php endif; ?>

    // Attach input event listeners to height and weight fields
    $("#triage_height, #triage_weight").on("input", function() {
        const height = parseFloat($("#triage_height").val().trim());
        const weight = parseFloat($("#triage_weight").val().trim());

        if (height > 0 && weight > 0) {
            const bmi = (weight / (height * height)).toFixed(2); // BMI calculation
            $("#triage_bmi").val(bmi); // Populate BMI field
            $("#triage_bmi").removeClass("is-invalid").addClass("is-valid");
        } else {
            $("#triage_bmi").val(""); // Clear BMI if height or weight is invalid
            $("#triage_bmi").removeClass("is-valid").addClass("is-invalid");
        }
    });



    function submitTriage() {
        const inputs = [{
                id: "duration_art",
                label: "Duration on ARTS"
            },
            {
                id: "blood_pressure",
                label: "Blood Pressure"
            },
            {
                id: "triage_weight",
                label: "Weight"
            },
            {
                id: "triage_height",
                label: "Height"
            },
            {
                id: "pulse_rate",
                label: "Pulse Rate"
            },
            {
                id: "triage_bmi",
                label: "BMI"
            },
            {
                id: "tb_screening",
                label: "TB Screening"
            },
            {
                id: "nutritional_status",
                label: "Nutritional Status"
            }
        ];

        let isValid = true;
        const data = {
            visit_id: visit_id, // Add global visit_id
            patient_id: pat_id, // Add patient_id
            route: "/submitTriageVitals" // Add route
        };

        const height = parseFloat($("#triage_height").val().trim());
        const weight = parseFloat($("#triage_weight").val().trim());
        const bmi = parseFloat($("#triage_bmi").val().trim());

        data.bmi = bmi; // Assign calculated BMI to "bmi"
        data.height = height; // Assign height to "height"
        data.weight = weight; // Assign weight to "weight"

        inputs.forEach(input => {
            const $element = $("#" + input.id);
            const value = $element.val().trim();

            // Remove existing error message
            $element.removeClass("is-invalid").next(".invalid-feedback").remove();

            if (!value && input.id !== "bmi") {
                isValid = false;

                // Add Bootstrap invalid class and display error
                $element.addClass("is-invalid").after(
                    `<div class="invalid-feedback">${input.label} is required.</div>`
                );
            } else {
                $element.addClass("is-valid");
                data[input.id] = value;
            }
        });


        // If valid, log the data
        if (isValid) {
            // Replace button text with loader
            $('#submitTriage').html('<div class="table-loader-btn"></div> Processing...');
            $('#submitTriage').prop('disabled', true); // Disable button

            $.ajax({
                type: "post",
                url: "controllers/gateway.php",
                data: data,
                dataType: "json",
                success: function(data) {
                    $('#submitTriage').html('Save Record');
                    $('#submitTriage').prop('disabled', false); // Disable button
                    if (data.response_code === 200) {
                        toastr.success(data.response_message, 'Success', {
                            timeOut: 3000
                        });
                    } else {
                        toastr.error(data.response_message, 'Error', {
                            timeOut: 3000
                        });
                    }
                },
                error: function() {
                    // $('#saveMenuButton').text('Save Menu');
                    toastr.error('Unable to process request at the moment!', 'Error', {
                        timeOut: 3000
                    });
                }
            });
        } else {
            // Display error message using Toastr (optional)
            toastr.error("Please fill in all required fields.");
        }
    }

    symptoms();

    function symptoms() {

        const choices = new Choices('#optionContainer', {
            removeItemButton: true, // Allows removing selected items
            placeholder: true, // Enables placeholder support
            placeholderValue: 'Select an option', // Placeholder text
            searchEnabled: true, // Enables the search functionality
        });

        var data = {
            'route': '/allSymptoms'
        };
        // Your AJAX call to fetch options
        $.ajax({
            method: 'POST',
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(response) {
                // Clear the existing options
                choices.clearChoices();

                // Add new options dynamically
                response.forEach(item => {
                    choices.setChoices(
                        [{
                            value: item.option, // Set the value
                            label: item.option, // Set the display text
                            selected: false, // Set whether the option is selected
                        }],
                        'value', 'label', false
                    );
                });
            },
            error: function(xhr) {
                console.error('Error fetching symptoms:', xhr);
            }
        });
    }

    illness();

    function illness() {

        const choicesIllness = new Choices('#optionillness', {
            removeItemButton: true, // Allows removing selected items
            placeholder: true, // Enables placeholder support
            placeholderValue: 'Select an option', // Placeholder text
            searchEnabled: true, // Enables the search functionality
        });

        var data = {
            'route': '/get_illness_option'
        };
        // Your AJAX call to fetch options
        $.ajax({
            method: 'POST',
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(response) {
                // Clear the existing options
                choicesIllness.clearChoices();
                if (response.data && Array.isArray(response.data)) {
                    // Add new options dynamically
                    response.data.forEach(item => {
                        choicesIllness.setChoices(
                            [{
                                value: item.illness_name, // Set the value
                                label: item.illness_name, // Set the display text
                                selected: false, // Set whether the option is selected
                            }],
                            'value', 'label', false
                        );
                    });
                } else {
                    console.error('Invalid response format:', response);
                }
            },
            error: function(xhr) {
                console.error('Error fetching symptoms:', xhr);
            }
        });
    }

    function saveDiagnosis() {
        $('.diagnosisBtn').text('Processing...');
        var data = $("#diagnosisForm").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.diagnosisBtn').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#diagnosisForm")[0].reset();
                    // $("#createMenuModal").modal("hide");
                    // getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                // $('#saveMenuButton').text('Save Menu');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }

    function saveARV() {
        $('.adherenceBtn').text('Processing...');
        var data = $("#arvDrugs").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.adherenceBtn').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#arvDrugs")[0].reset();
                    // $("#createMenuModal").modal("hide");
                    // getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                // $('#saveMenuButton').text('Save Menu');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }

    function clinicalAssesment() {
        $('.clinical_assesment').text('processing...');
        var data = $("#clinicalAssesment").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.clinical_assesment').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#clinicalAssesment")[0].reset();
                    // $("#createMenuModal").modal("hide");
                    // getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.clinical_assesment').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }

    function saveNote() {
        $('.saveNote').text('processing...');
        var data = $("#noteForm").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.saveNote').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#noteForm")[0].reset();
                    // $("#createMenuModal").modal("hide");
                    // getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.saveNote').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }

    function substitution() {
        $('.substitution').text('processing...');
        var data = $("#substitution").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.substitution').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#substitution")[0].reset();
                    // $("#createMenuModal").modal("hide");
                    // getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.substitution').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }

    function discontinuation() {
        $('.discontinuation').text('processing...');
        var data = $("#discontinuation").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.discontinuation').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#discontinuation")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.discontinuation').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    }
    // function dsdModel(){
    $("#dsdModelBtn").click(function() {
        $('.dsdModel').text('processing...');
        var data = $("#dsdModel").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.dsdModel').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#dsdModel")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.dsdModel').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    });

    function eac() {
        $('.eac').text('processing...');
        var data = $("#eac").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.eac').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#eac")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.eac').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    };

    function hospitalize() {
        $('.hospitalize').text('processing...');
        var data = $("#hospitalize").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.hospitalize').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#hospitalize")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.hospitalize').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    };

    function appointment() {
        $('.appointment').text('processing...');
        var data = $("#appointment").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.appointment').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#appointment")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.appointment').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    };

    function artCommencement() {
        $('.artCommencement').text('processing...');
        var data = $("#artCommencement").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('.artCommencement').text('Save Record');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 3000
                    });
                    $("#artCommencement")[0].reset();;
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 3000
                    });
                }
            },
            error: function() {
                $('.artCommencement').text('Save Record');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 3000
                });
            }
        });
    };

    function add_row() {
        var template = `
        <div class="row mb-4 p-2">
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Age Group</label>
                        <select name="age_group" class="form-select">
                            <option>Adult</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Drug Type</label>
                        <select name="age_group" class="form-select">
                            <option>ARV Drug</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Drug Name</label>
                        <select name="age_group" class="form-select">
                            <option>Select Option</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Category</label>
                        <select name="age_group" class="form-select">
                            <option>Select Category</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Formation</label>
                        <select name="age_group" class="form-select">
                            <option>Select Option</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Frequency</label>
                        <select name="age_group" class="form-select">
                            <option>Select Category</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Quantity</label>
                        <input type="text" placeholder="00" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Duration</label>
                        <select name="duration" class="form-select">
                            <option>Twice daily</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label class="fw-bold">Illness</label>
                        <select name="duration" class="form-select">
                            <option>HIV</option>
                        </select>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <i class="fa fa-trash text-danger float-end" onclick='delete_div(this)' style="font-size:22px;margin-top: 40px !important;"></i>
            </div>
        </div>
    `;

        $("#myDiv").append(template);
    }
    viewPatient();

    function delete_div(el) {
        $(el).parents(".row")[0].remove()
    }



    function viewPatient() {
        $.ajax({
            url: 'controllers/gateway.php', // Your API endpoint
            type: 'POST',
            data: {
                route: '/patientsDataSingle',
                id: '<?= $id ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.response_code === 200) {
                    var data = response.data;
                    var fname = data.patientData[0].fname;
                    var lname = data.patientData[0].lname;
                    var othern = data.patientData[0].othern;

                    var fullname = fname + " " + lname + " " + othern;
                    var gender = data.patientData[0].sex;
                    var maritalStatus = data.patientData[0].maritalStatus;
                    var occupation = data.patientData[0].occupation;
                    var education = data.patientData[0].education;
                    var dob = data.patientData[0].dob;
                    var age = data.patientData[0].age;
                    var email = data.patientData[0].email;
                    var patient_id = data.patientData[0].patient_id;
                    pat_id = data.patientData[0].patient_id;
                    visit_id = data.patientData[0].currentVisit;

                    var arv_medication = data.currentLabTests.arv_medication;
                    var cervical_cancer_status = data.currentLabTests.cervical_cancer_status;
                    var dsd_status = data.currentLabTests.dsd_status;
                    var tpt_status = data.currentLabTests.tpt_status;

                    var height = data.vitals.height;
                    var weight = data.vitals.weight;
                    var bmi = data.vitals.bmi;

                    var nextOfKinFname = data.patientData[0].nextOfKinFname;
                    var nextOfKinLname = data.patientData[0].nextOfKinLname;
                    var nextOfKinPhone = data.patientData[0].nextOfKinPhone;
                    var relationship = data.patientData[0].relationship;
                    var currentVisit = data.patientData[0].currentVisit;

                    $("#name").html(fullname);
                    $("#gender").html(gender);
                    $("#maritalStatus").html(maritalStatus);
                    $("#occupation").html(occupation);
                    $("#education").html(education);
                    $("#dob").html(dob);
                    $("#age").html(age);
                    $("#email").html(email);
                    $("#patient_id").html(patient_id);
                    $("#arv_medication").html(arv_medication);
                    $("#cervical_cancer_status").html(cervical_cancer_status);
                    $("#dsd_status").html(dsd_status);
                    $("#tpt_status").html(tpt_status);
                    $("#height").html(height);
                    $("#weight").html(weight);
                    $("#bmi").html(bmi);
                    $("#nextOfKinFname").html(nextOfKinFname);
                    $("#nextOfKinLname").html(nextOfKinLname);
                    $("#nextOfKinPhone").html(nextOfKinPhone);
                    $("#relationship").html(relationship);
                    $(".visit_id").val(currentVisit);
                    // alert(fullname);

                    labTestRequests();
                }
            }
        });
    }

    function baseLineTests() {
        $.ajax({
            url: "controllers/gateway.php",
            data: {
                route: "/allTests"
            },
            type: "post",
            success: function(response) {
                try {
                    // Parse the response if it's not already a JSON object
                    const data = typeof response === 'string' ? JSON.parse(response) : response;

                    // Populate the #states dropdown
                    let baselineOptions = '<option value="">Select Test</option>';
                    data.forEach(baselineTests => {
                        baselineOptions += `<option value="${baselineTests.id}">${baselineTests.test_name}</option>`;
                    });
                    $('#baselineTest').html(baselineOptions);


                } catch (err) {
                    console.error("Error processing response:", err);
                    toastr.error("Unable to load states. Please try again.", "Error", {
                        closeButton: true,
                        progressBar: true,
                    });
                }
            },
            error: function() {
                toastr.error("Request could not be processed at the moment!", "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000,
                    extendedTimeOut: 3000,
                    escapeHtml: true,
                    tapToDismiss: false,
                });
            },
        });
    }

    baseLineTests();

    function labTestRequests() {
        // alert(visit_id);
        $.ajax({
            url: 'controllers/gateway.php', // Your API endpoint
            type: 'POST',
            data: {
                route: '/labTestRequests',
                patient_id: '<?= $id ?>',
                visit_id: visit_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.response_code === 200) {
                    testTableData = response.data.test_table;
                    $('#lab-request-table').empty();
                    $('#lab-request-history').empty();
                    testTableData.forEach((item, index) => {
                        var test_name = item.test_name;
                        var sample_required = item.sample_required;
                        var result = item.result;
                        var test_date = item.test_date;

                        var row = "<tr>" +
                            "<td style='text-wrap:nowrap;'>" + test_name + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + sample_required + "</td>" +
                            "<td style='text-wrap:nowrap;'>" +
                            "<input type='text' name='results[]' value='" + result + "' class='result-input' placeholder='Enter results' style='width:100%;'>" +
                            "</td>" +
                            "</tr>";

                        $('#lab-request-table').append(row);

                        var row1 = "<tr><td style='text-wrap:nowrap;'>" + test_name + "</td><td style='text-wrap:nowrap;'>" + result + "</td><td style='text-wrap:nowrap;'>" + test_date + "</td></tr>";

                        $('#lab-request-history').append(row1);
                    })
                } else {
                    $('#lab-request-history').empty();
                    $('#lab-request-table').empty();
                    $('#lab-request-table').html('<p>No recent data available</p>');
                    $('#lab-request-history').html('<p>No recent data available</p>');
                }
            }
        });
    }

    function updateLabResult() {

        // Replace button text with loader
        $('#save-lab-request').html('<div class="table-loader-btn"></div> Processing...');

        // Optionally, you can disable the button to prevent multiple submissions
        $('#save-lab-request').prop('disabled', true);
        let testResults = [];

        // Get the current date for the `test_date` field
        let testDate = new Date().toISOString().split('T')[0];

        // Iterate over each row in the table
        $('#lab-request-table tr').each(function(index) {

            // Extract data from the table cells and input field
            let testName = $(this).find('td:eq(0)').text().trim();
            let sampleRequired = $(this).find('td:eq(1)').text().trim();
            let result = $(this).find('input[name="results[]"]').val().trim();

            // Log extracted data
            console.log({
                testName,
                sampleRequired,
                result
            });

            // Check if result is not empty before pushing to array
            if (result !== '') {
                testResults.push({
                    test_name: testName,
                    sample_required: sampleRequired,
                    result: result,
                    test_date: testDate
                });
            }
        });

        $.ajax({
            url: 'controllers/gateway.php', // Your API endpoint
            type: 'POST',
            data: {
                route: '/labResults',
                patient_id: '<?= $id ?>',
                visit_id: visit_id,
                test_results: testResults
            },
            dataType: 'json',
            success: function(response) {
                // Replace button text with loader
                $('#save-lab-request').html('Update Record');

                // Optionally, you can disable the button to prevent multiple submissions
                $('#save-lab-request').prop('disabled', false);
                if (response.response_code === 200) {
                    labTestRequests();
                    toastr.success(response.message, "Success", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000,
                        extendedTimeOut: 3000,
                        escapeHtml: true,
                        tapToDismiss: false,
                    })
                } else {
                    toastr.error(response.message, "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000,
                        extendedTimeOut: 3000,
                        escapeHtml: true,
                        tapToDismiss: false,
                    })
                }
            }
        });


    }

    function loadActivityLog() {
        $.ajax({
            url: 'controllers/gateway.php', // Your API endpoint
            type: 'POST',
            data: {
                route: '/activityLog',
                patient_id: '<?= $id ?>'
            },
            dataType: 'json',
            success: function(response) {
                if (response.response_code === 200) {
                    activityData = response.data;
                    $('#activity_logs').empty();
                    activityData.forEach((item, index) => {
                        const html = `
        <div class="row mb-3">
            <div class="col-md-2 col-lg-2 col-sm-12" style="margin-right: -60px;">
                <img src="assets/images/visit_icon.png"
                    alt="Visit Icon"
                    style="width: 60%; height: auto;">
            </div>
            <div class="col-md-10 col-lg-10 col-sm-12">
               <div class="card bg-soft-secondary" style="background-color: #F8F7F5; border-radius: 5px; padding: 20px;">
    <div class="d-flex justify-content-between">
        <span class="fw-bold">Activity:<br> ${item.activity}</span>
    </div>
    <div class="mt-2">
        <span>Date: ${item.record_date}</span>
    </div>
</div>

            </div>
        </div>`;
                        $('#activity_logs').append(html);
                    })


                } else {
                    $('#activity_logs').empty();
                    $('#activity_logs').html('<p>No recent data available</p>');
                }
            }
        });
    }
    loadActivityLog();

    var prescription_id;

    function getPrescribedDrugs() {
        // alert(visit_id);
        $.ajax({
            url: 'controllers/gateway.php', // Your API endpoint
            type: 'POST',
            data: {
                route: '/get_prescribed_drugs',
                patient_id: '<?= $id ?>'
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response); return;
                if (response.response_code === 200) {
                    testTableData = response.data[0].prescriptions;
                    prescription_id = response.data[0].prescription_id;
                    $('#dispense-table').empty();
                    $('#refill-table').empty();
                    testTableData.forEach((item, index) => {
                        var category = item.drug_type;
                        var drug_name = item.drug_name;
                        var formation = item.formation;
                        var frequency = item.frequency;
                        var quantity = item.quantity;
                        var duration = item.duration;
                        var illness = item.illness;
                        var row = "<tr>" +
                            "<td style='text-wrap:nowrap;'>" + category + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + drug_name + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + formation + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + quantity + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + frequency + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + duration + "</td>" +
                            "<td style='text-wrap:nowrap;'><input type='text' style='width: 80px;' class='form-control' maxlength='2' min='0' max='99' placeholder='00'></td>" +
                            "<td style='text-wrap:nowrap;'>" +
                            "<label class='custom-switch'><input type='checkbox'><span class='slider'></span></label>" +
                            "</td>" +
                            "</tr>";

                        $('#dispense-table').append(row);

                        var row1 = "<tr>" +
                            "<td style='text-wrap:nowrap;'>" + category + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + drug_name + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + formation + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + frequency + "</td>" +
                            "<td style='text-wrap:nowrap;'>" + duration + "</td>" +
                            "<td style='text-wrap:nowrap;'><input type='text' style='width: 80px;' class='form-control' maxlength='2' min='0' max='99' placeholder='00'></td>" +
                            "<td style='text-wrap:nowrap;'>" +
                            "<label class='custom-switch'><input type='checkbox'><span class='slider'></span></label>" +
                            "</td>" +
                            "</tr>";

                        $('#refill-table').append(row1);
                    })
                } else {
                    $('#refill-table').empty();
                    $('#dispense-table').empty();
                    $('#dispense-table').html('<p>No recent data available</p>');
                    $('#refill-table').html('<p>No recent data available</p>');
                }
            }
        });
    }
    getPrescribedDrugs();



    function dispenseDrug() {
    // Replace button text with loader
    $('#dispense-drug-btn').html('<div class="table-loader-btn"></div> Processing...');
    $('#dispense-drug-btn').prop('disabled', true); // Disable the button

    var drugsArray = [];
    var isCheckboxChecked = false; // To check if at least one checkbox is selected
    var isValid = true; // To ensure all inputs are valid

    // Iterate over each row in the table
    $('#dispense-table tr').each(function(index) {
        var checkbox = $(this).find('input[type="checkbox"]');
        var quantityDispensed = $(this).find('input[type="text"]').val().trim(); // Quantity Dispensed

        // Check if the checkbox is checked
        if (checkbox.is(':checked')) {
            isCheckboxChecked = true; // At least one checkbox is selected

            // Validate the input quantity
            if (quantityDispensed === '' || parseInt(quantityDispensed) < 1) {
                toastr.error("Quantity dispensed must be at least 1.", "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
                isValid = false; // Invalid input
                return false; // Exit the iteration early
            }

            // Extract data from the table cells
            var drugName = $(this).find('td:eq(1)').text().trim(); // Drug Name

            // Add valid data to the array
            drugsArray.push({
                drug_name: drugName,
                quantity_dispensed: quantityDispensed
            });
        }
    });

    // Check if no checkbox is checked
    if (!isCheckboxChecked) {
        toastr.error("Please select at least one drug to dispense.", "Validation Error", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        });
        $('#dispense-drug-btn').html('Dispense');
        $('#dispense-drug-btn').prop('disabled', false);
        return; // Stop further execution
    }

    // If validation fails
    if (!isValid) {
        $('#dispense-drug-btn').html('Dispense');
        $('#dispense-drug-btn').prop('disabled', false);
        return; // Stop further execution
    }

    // Proceed with AJAX request if everything is valid
    $.ajax({
        url: 'controllers/gateway.php', // Your API endpoint
        type: 'POST',
        data: {
            route: '/despense_drug',
            patient_id: '<?= $id ?>',
            prescription_id: prescription_id,
            prescriptions: drugsArray
        },
        dataType: 'json',
        success: function(response) {
            $('#dispense-drug-btn').html('Dispense');
            $('#dispense-drug-btn').prop('disabled', false);

            if (response.response_code === 200) {
                getPrescribedDrugs();
                toastr.success(response.message, "Success", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
            } else {
                toastr.error(response.message, "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
            }
        }
    });
}

       function refillDrug() {
    // Replace button text with loader
    $('#refill-drug-btn').html('<div class="table-loader-btn"></div> Processing...');
    $('#refill-drug-btn').prop('disabled', true); // Disable the button

    var drugsArray = [];
    var isCheckboxChecked = false; // To check if at least one checkbox is selected
    var isValid = true; // To ensure all inputs are valid

    // Iterate over each row in the table
    $('#refill-table tr').each(function(index) {
        var checkbox = $(this).find('input[type="checkbox"]');
        var quantityDispensed = $(this).find('input[type="text"]').val().trim(); // Quantity Dispensed

        // Check if the checkbox is checked
        if (checkbox.is(':checked')) {
            isCheckboxChecked = true; // At least one checkbox is selected

            // Validate the input quantity
            if (quantityDispensed === '' || parseInt(quantityDispensed) < 1) {
                toastr.error("Quantity dispensed must be at least 1.", "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
                isValid = false; // Invalid input
                return false; // Exit the iteration early
            }

            // Extract data from the table cells
            var category = $(this).find('td:eq(0)').text().trim(); // Category
            var drugName = $(this).find('td:eq(1)').text().trim(); // Drug Name
            var formation = $(this).find('td:eq(2)').text().trim(); // Formation
            var frequency = $(this).find('td:eq(3)').text().trim(); // Frequency
            var duration = $(this).find('td:eq(4)').text().trim(); // Duration

            // Add valid data to the array
            drugsArray.push({
                drug_type: category,
                drug_name: drugName,
                formation: formation,
                frequency: frequency,
                duration: duration,
                quantity_dispensed: quantityDispensed
            });
        }
    });

    // Check if no checkbox is checked
    if (!isCheckboxChecked) {
        toastr.error("Please select at least one drug to refill.", "Validation Error", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        });
        $('#refill-drug-btn').html('Refill');
        $('#refill-drug-btn').prop('disabled', false);
        return; // Stop further execution
    }

    // If validation fails
    if (!isValid) {
        $('#refill-drug-btn').html('Refill');
        $('#refill-drug-btn').prop('disabled', false);
        return; // Stop further execution
    }

    // Proceed with AJAX request if everything is valid
    $.ajax({
        url: 'controllers/gateway.php', // Your API endpoint
        type: 'POST',
        data: {
            route: '/refill_drug',
            patient_id: '<?= $id ?>',
            prescription_id: prescription_id,
            prescriptions: drugsArray
        },
        dataType: 'json',
        success: function(response) {
            $('#refill-drug-btn').html('Refill');
            $('#refill-drug-btn').prop('disabled', false);

            if (response.response_code === 200) {
                getPrescribedDrugs();
                toastr.success(response.message, "Success", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
            } else {
                toastr.error(response.message, "Error", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000
                });
            }
        }
    });
}

</script>