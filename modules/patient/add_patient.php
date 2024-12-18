<style>
    /* Custom styles for the accordion button */
    .accordion-button {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .accordion-button::after {
        margin-right: 1rem;
    }

    .accordion-button:not(.collapsed) {
        background-color: transparent !important;
        box-shadow: none !important;
        color: inherit !important;
    }

    .accordion-button:hover,
    .accordion-button:focus {
        background-color: transparent !important;
        box-shadow: none !important;
        border-color: rgba(0, 0, 0, .125) !important;
        z-index: 0 !important;
    }

    /* Remove default background color when expanded */
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23666'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .loader-wrapper {
        display: inline-block;
        width: 4px;
        /* Resize the loader specifically for the button */
        height: 4px;
        vertical-align: middle;
        /* Center-align the loader within the button */
    }

    .loader-wrapper .loader {
        width: 100%;
        /* Maintain proportional resizing */
        height: 100%;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18" style="font-family: inter, sans-serif;">Patient Management Page</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient Entry</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
        </div>
    </div>
</div>
<div class="col-12">

    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="route" value="/setupPatient">
        <input type="hidden" name="operation" value="new">
        <input type="hidden" name="address" value="my address">
        <input type="hidden" name="ts_phone" value="09088888888">
        <div class="card" style="border-radius: 16px 19px !important;">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> Care Entry Point</span>
                </div>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md">
                                        <label>Transferred In:</label>
                                        <select name="transferredIn" id="transferredIn" onchange="transferredInFunction()" class="form-select">
                                            <option value="Yes">Yes</option>
                                            <option value="No" selected>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md" id="careentrydiv">
                                        <label>Entry point option:</label>
                                        <select name="careentry" id="careentry" class="form-select">
                                            <option value="OPD">OPD</option>
                                            <option value="in-patient">In-Patient</option>
                                            <option value="HTS">HTS</option>
                                            <option value="TB DOTS">TB DOTS</option>
                                            <option value="STI Clinic">STI Clinic</option>
                                            <option value="ANC/PMTCT">ANC/PMTCT</option>
                                            <option value="Outreach">Outreach</option>
                                        </select>
                                    </div>
                                    <div class="col-md" id="priorArtdiv">
                                        <label>Prior ART:</label>
                                        <select name="priorArt" id="priorArt" class="form-select">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md" id="enrolmentdatediv">
                                        <label>Enrollment Date:</label>
                                        <input type="date" name="enrolmentDate" id="enrolmentDate" class="form-control">
                                    </div>
                                    <div class="col-md" id="transferTypediv">
                                        <label>Transfer Type:</label>
                                        <select name="transferType" id="transferType" class="form-select">
                                            <option value="" selected>Transfer Type</option>
                                            <option value="Intra">Intra</option>
                                            <option value="Inter">Inter</option>
                                        </select>
                                    </div>
                                    <div class="col-md" id="transferWithdiv">
                                        <label>Transfer With:</label>
                                        <select name="transferWith" id="transferWith" class="form-select">
                                            <option value="">Select Option</option>
                                            <option value="records">Records</option>
                                            <option value="norecords">No records</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2" id="careentrydiv2">
                                    <div class="col-md" id="clinicNameDiv">
                                        <label>Clinic Name:</label>
                                        <input type="text" name="clinicName" id="clinicName" class="form-control">
                                    </div>
                                    <div class="col-md" id="hivTestDateDiv">
                                        <label>Confirmed HIV Test Date:</label>
                                        <input type="date" name="hivConfirmed" id="hivConfirmed" class="form-control">
                                    </div>
                                    <div class="col-md" id="fileRecordDiv">
                                        <label>Upload Record(Excel):</label>
                                        <input type="file" id="fileRecord" name="fileRecord" class="form-control">
                                    </div>
                                    <div class="col-md" id="hivTestModeDiv">
                                        <label>Mode of HIV Test:</label>
                                        <input type="text" name="testMode" id="testMode" class="form-control">
                                    </div>
                                    <div class="col-md" id="transferredInDateDiv">
                                        <label>Transferred In Date:</label>
                                        <input type="date" name="transferredInDate" id="transferredInDate" class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-2" id="careentrydiv3">
                                    <div class="col-md" id="selectFacilityDiv">
                                        <label>Select Facility:</label>
                                        <select name="facility" id="facility" class="form-select">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="col-md" id="patientIdDiv">
                                        <label>Input Patient ID:</label>
                                        <input type="text" name="patientId" id="patientId" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- item two -->

        </div>

        <div class="card">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> Bio Data</span>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md">
                                        <label>Surname:</label>
                                        <input type="text" name="lname" id="lname" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Middlename:</label>
                                        <input type="text" name="oname" id="oname" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Firstname:</label>
                                        <input type="text" name="fname" id="fname" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Gender:</label>
                                        <select name="sex" id="sex" class="form-select">
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>Marital Status:</label>
                                        <select name="maritalStatus" id="maritalStatus" class="form-select">
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Occupation:</label>
                                        <input type="text" name="occupation" id="occupation" class="form-control" required>
                                    </div>
                                    <div class="col-md">
                                        <label>Education:</label>
                                        <select name="education" id="education" class="form-select">
                                            <option value="No Education">No Education</option>
                                            <option value="Primary Education">Primary Education</option>
                                            <option value="Secondary Education">Secondary Education</option>
                                            <option value="Tertiary Education">Tertiary Education</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>Drug Allergies:</label>
                                        <input type="text" name="" id="" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Date of Birth:</label>
                                        <input type="date" name="dob" id="dob" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Age:</label>
                                        <input type="text" name="age" id="age" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Phone Number I:</label>
                                        <input type="text" name="phone" id="phone" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Phone Number II:</label>
                                        <input type="text" name="phoneTwo" id="phoneTwo" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>State:</label>
                                        <select name="state" id="state" class="form-select">

                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>L.G.A:</label>
                                        <select name="lga" id="lga" class="form-select">

                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>House Number:</label>
                                        <input type="text" name="house_number" id="house_number" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Street Name:</label>
                                        <input type="text" name="street_name" id="street_name" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Description:</label>
                                        <input type="text" name="homeDescription" id="homeDescription" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Email Address:</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Mother Unique (If Infant): </label>
                                        <input type="text" name="mothersId" id="mothersId" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Patient Classification:</label>
                                        <input type="text" name="patient_classification" id="patient_classification" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Next of kin -->
        <div class="card">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> Next of KIN</span>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Surname:</label>
                                        <input type="text" name="nextOfKinLname" id="nextOfKinLname" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Middlename:</label>
                                        <input type="text" name="nok_middlename" id="nok_middlename" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Firstname:</label>
                                        <input type="text" name="nextOfKinFname" id="nextOfKinFname" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Relationship: </label>
                                        <!-- <input type="text" name="nextOfKinRel" id="nextOfKinRel" class="form-control"> -->
                                        <select name="nextOfKinRel" id="nextOfKinRel" class="form-select">
                                            <option value="brother">Brother</option>
                                            <option value="sister">Sister</option>
                                            <option value="wife">Wife</option>
                                            <option value="husband">Husband</option>
                                            <option value="son">Son</option>
                                            <option value="daughter">Daughter</option>
                                            <option value="parent">Parent</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>Phone Number I:</label>
                                        <input type="number" name="nextOfKinPhone" id="nextOfKinPhone" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Treatment Supporter -->
        <div class="card">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> Treatment Supporter</span>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md">
                                        <label>Surname:</label>
                                        <input type="text" name="ts_name" id="ts_name" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Middlename:</label>
                                        <input type="text" name="ts_mname" id="" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Firstname:</label>
                                        <input type="text" name="ts_fname" id="" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Phone:</label>
                                        <input type="text" name="ts_phone" id="ts_phone" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Relationship:</label>
                                        <!-- <input type="text" name="ts_relationship" id="ts_relationship" class="form-control"> -->
                                        <select name="ts_relationship" id="ts_relationship" class="form-select">
                                            <option value="brother">Brother</option>
                                            <option value="sister">Sister</option>
                                            <option value="wife">Wife</option>
                                            <option value="husband">Husband</option>
                                            <option value="son">Son</option>
                                            <option value="daughter">Daughter</option>
                                            <option value="parent">Parent</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ART -->
        <div class="card">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> ART Adherence Preparation</span>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Adherence Plan Started:</label>
                                        <input type="date" name="Ad_Plan_start" id="Ad_Plan_start" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Education of ART Essentials:</label>
                                        <input type="text" name="Ad_edu_Ess" id="Ad_edu_Ess" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Complete Adherence Needed:</label>
                                        <input type="text" name="Ad_complete_needed" id="Ad_complete_needed" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Dosage Detailed Explanation: </label>
                                        <!-- <input type="text" name="Dosage_det" id="Dosage_det" class="form-control"> -->
                                        <select name="Dosage_det" id="Dosage_det" class="form-select">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md">
                                        <label>Side Effect Strategies:</label>
                                        <!-- <input type="text" name="Side_effect" id="Side_effect" class="form-control"> -->
                                        <select name="Side_effect" id="Side_effect" class="form-select">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>Adherence Plan:</label>
                                        <input type="text" name="Ad_Plan" id="Ad_Plan" class="form-control">
                                    </div>
                                    <div class="col-md">
                                        <label>Treatment Supporter Provided:</label>
                                        <!-- <input type="text" name="Treatment_Support" id="Treatment_Support" class="form-control"> -->
                                        <select name="Treatment_Support" id="Treatment_Support" class="form-select">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <label>Indicate Patient ART Start Date: </label>
                                        <input type="date" name="Art_start" id="Art_start" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <label>Adherence Plan Completion: </label>
                                        <input type="date" name="Art_end" id="Art_end" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div class="card">
            <div class="position-relative">
                <div class="text-danger px-3 py-1 position-absolute" style="background-color: #fcecec; top: -10px; left: 15px; z-index: 1;">
                    <span style="color:#991002; font-weight: bold; font-family: Proxima Nova, sans-serif"> Notifications</span>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header border-bottom" id="headingOne">
                            <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p> Would you like to receive notifications? </p>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="notifyMe" id="yes" value="yes"> <label for="yes">Yes</label>

                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="notifyMe" id="no" value="no"> <label for="yes">No</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="" id=""> Email

                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="" id=""> SMS

                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" name="" id=""> Both Email and SMS notifications

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="row justify-content-end">
            <div class="col-auto">
                <button class="btn btn-lg text-white" style="background:#991002 !important;" onclick="getpage('modules/patient/patient_list.php')">Back to Main Page</button>
            </div>
            <div class="col-auto">
                <button class="btn btn-lg text-white" style="background:#991002 !important;" id="submitPatient" onclick="saveRecord()">Submit Record</button>
            </div>
        </div>

    </form>
</div>

<div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_div">

        </div>
    </div>
</div>

<script>
    function saveRecord() {
        // Replace button text with loader
        $('#submitPatient').html('<div class="table-loader-btn"></div> Processing...');

        // Optionally, you can disable the button to prevent multiple submissions
        $('#submitPatient').prop('disabled', true);

        var dd = $("#form1").serialize();
        $.post("controllers/gateway.php", dd, function(re) {
            $("#save_facility").text("Save");
            console.log(re);
            if (re.response_code == 200) {

                $("#submitPatient").html('Submit'); // Reset button text
                $("#submitPatient").prop('disabled', false); // Re-enable button
                toastr.success(re.response_message, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
                getpage('modules/patient/patient_list.php', 'page');
                $("#defaultModal").modal("hide");
                $('.modal-backdrop').remove();
                $('body').css('overflow', 'auto');

            } else {
                $("#submitPatient").html('Submit'); // Reset button text
                $("#submitPatient").prop('disabled', false); // Re-enable button

                toastr.error(re.response_message, 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
            }

        }, 'json')
    }

    function transferredInFunction() {

        const transferredIn = $('#transferredIn').val();
        const transferWithdiv = $('#transferWithdiv');
        const entrypoint = $('#careentrydiv');
        const priorart = $('#priorArtdiv');
        const enrollmentdate = $('#enrolmentdatediv');
        const transfertype = $('#transferTypediv');
        const priorartInput = $('#priorArt');
        const careentrydiv2 = $('#careentrydiv2');
        const careentrydiv3 = $('#careentrydiv3');
        $('#transferWith').val('');
        $('#transferType').val('');

        if (transferredIn === "No") {
            // Show entrypoint, priorart, and enrollmentdate
            entrypoint.show();
            priorart.show();
            enrollmentdate.show();
            careentrydiv2.hide();
            careentrydiv3.hide();

            // Enable priorart and clear its value
            priorartInput.prop('disabled', false).val("");
            transferWithdiv.hide();
            // Hide transfertype
            transfertype.hide();
        } else if (transferredIn === "Yes") {
            // Show priorart and transfertype
            priorart.show();
            transfertype.show();
            enrollmentdate.hide();
            careentrydiv2.hide();
            careentrydiv3.hide();
            transferWithdiv.hide();

            // Set priorart to "Yes" and disable it
            priorartInput.val("Yes");

            // Hide entrypoint and enrollmentdate
            entrypoint.hide();
            enrollmentdate.hide();
        } else {
            // Hide everything if no valid selection
            entrypoint.hide();
            priorart.hide();
            enrollmentdate.hide();
            transfertype.hide();
            careentrydiv3.hide();


            // Reset priorart
            priorartInput.prop('disabled', false).val("");
        }
    }

    transferredInFunction();

    // Function to handle transferType changes
    function handleTransferType() {
        const transferType = $('#transferType').val();
        const transferWithContainer = $('#transferWithdiv');
        const careentrydiv3 = $('#careentrydiv3');
        const careentrydiv2 = $('#careentrydiv2');

        const transferredIn = $('#transferredIn').val();
        const entrypoint = $('#careentrydiv');
        const priorart = $('#priorArtdiv');
        const enrollmentdate = $('#enrolmentdatediv');
        const transfertype = $('#transferTypediv');
        const priorartInput = $('#priorArt');

        if (transferType === "Inter") {
            // Show transferWith input field
            transferWithContainer.show();
            careentrydiv2.hide();
            careentrydiv3.hide();
        } else if (transferType === "Intra") {
            // Hide transferWith input field
            transferWithContainer.hide();
            careentrydiv2.hide();
            careentrydiv3.show();
        } else {
            careentrydiv2.hide();
            careentrydiv3.hide();
        }
    }

    // Attach the onchange event to transferType
    $('#transferType').on('change', handleTransferType);

    // Call the function once on page load to apply the logic initially
    // handleTransferType();

    function handleWithRecords() {
        const transferWith = $('#transferWith').val();

        // Elements
        const clinicNameDiv = $('#clinicNameDiv');
        const fileRecordDiv = $('#fileRecordDiv'); // Assuming this is for uploading records
        const hivTestDateDiv = $('#hivTestDateDiv');
        const hivTestModeDiv = $('#hivTestModeDiv');
        const transferredInDateDiv = $('#transferredInDateDiv');
        const enrollmentDateDiv = $('#enrolmentdatediv');
        const careentrydiv3 = $('#careentrydiv3');
        const careentrydiv2 = $('#careentrydiv2');

        if (transferWith === "records") {
            // Show only clinic name, upload record, enrollment date, transferred in date
            clinicNameDiv.show();
            fileRecordDiv.show();
            enrollmentDateDiv.show();
            transferredInDateDiv.show();

            // Hide the other fields
            hivTestDateDiv.hide();
            hivTestModeDiv.hide();
            careentrydiv3.hide();
            careentrydiv2.show();
        } else if (transferWith === "norecords") {
            // Show only confirmed HIV test date, mode of HIV test, enrollment date, transferred in date
            hivTestDateDiv.show();
            hivTestModeDiv.show();
            enrollmentDateDiv.show();
            transferredInDateDiv.show();

            // Hide the other fields
            clinicNameDiv.hide();
            fileRecordDiv.hide();
            careentrydiv3.hide();
            careentrydiv2.show();
        } else {
            careentrydiv3.hide();
            careentrydiv2.hide();
        }
    }

    $('#transferWith').on('change', handleWithRecords);

    function getFacility() {

var route = "/fetchCodes";
var data = {
    route
};

$.post("controllers/gateway.php", data, function(re) {
    console.log(re); // Debug: Log the API response

    // Ensure re is an array
    
        const $select = $('#facility');
        $select.empty(); // Clear existing options
        $select.append($('<option>', {
            value: '',
            text: 'Select Facility'
        })); // Default option

        // Populate the dropdown
        $.each(re, function(index, role) {
            $select.append($('<option>', {
                value: role.facility_code, // Set role_id as the value
                text: role.hospital_name // Set role_name as the display text
            }));
        });

}, 'json')
}
getFacility();

function getStates() {
            $.ajax({
                url: "controllers/gateway.php",
                data: {
                    route: "/statesData"
                },
                type: "post",
                success: function(response) {
                    try {
                        // Parse the response if it's not already a JSON object
                        const data = typeof response === 'string' ? JSON.parse(response) : response;

                        // Populate the #states dropdown
                        let stateOptions = '<option value="">Select State</option>';
                        data.forEach(state => {
                            stateOptions += `<option value="${state.state_name}">${state.state_name}</option>`;
                        });
                        $('#state').html(stateOptions);

                        // Add change event listener to populate LGAs
                        $('#state').on('change', function() {
                            const selectedStateName = $(this).val();

                            if (selectedStateName) {
                                // Find the selected state object
                                const selectedState = data.find(state => state.state_name === selectedStateName);

                                if (selectedState && selectedState.lgas) {
                                    // Populate the #lgas dropdown
                                    let lgaOptions = '<option value="">Select LGA</option>';
                                    selectedState.lgas.forEach(lga => {
                                        lgaOptions += `<option value="${lga.lga_name}">${lga.lga_name}</option>`;
                                    });
                                    $('#lga').html(lgaOptions);
                                } else {
                                    $('#lga').html('<option value="">No LGAs Found</option>');
                                }
                            } else {
                                // Reset LGAs if no state is selected
                                $('#lga').html('<option value="">Select LGA</option>');
                            }
                        });
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

        getStates();
</script>