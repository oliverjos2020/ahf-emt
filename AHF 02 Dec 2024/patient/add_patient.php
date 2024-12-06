
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
    width: 4px; /* Resize the loader specifically for the button */
    height: 4px;
    vertical-align: middle; /* Center-align the loader within the button */
}

.loader-wrapper .loader {
    width: 100%; /* Maintain proportional resizing */
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
                                <div class="col-md-3">
                                    <label>Transferred In:</label>
                                    <select name="transferredIn" id="transferredIn" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <label>Prior ART:</label>
                                    <select name="priorArt" id="priorArt" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Enrollment Date:</label>
                                    <input type="date" name="enrolmentDate" id="enrolmentDate" class="form-control">
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
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
                                    <select name="maritalStatus" id="maritalStatus" class="form-control">
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
                                    <input type="text" name="education" id="education" class="form-control">
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
                                    <input type="text" name="state" id="state" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>L.G.A:</label>
                                    <input type="text" name="lga" id="lga" class="form-control">
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label>Surname:</label>
                                    <input type="text" name="nextOfKin" id="nextOfKin" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Middlename:</label>
                                    <input type="text" name="nok_middlename" id="nok_middlename" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Firstname:</label>
                                    <input type="text" name="nok_firstname" id="nok_firstname" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Relationship: </label>
                                    <input type="text" name="nextOfKinRel" id="nextOfKinRel" class="form-control">
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Surname:</label>
                                    <input type="text" name="ts_name" id="ts_name" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Middlename:</label>
                                    <input type="text" name="" id="" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Firstname:</label>
                                    <input type="text" name="" id="" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Relationship:</label>
                                    <input type="text" name="ts_relationship" id="ts_relationship" class="form-control">
                                    
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
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
                                    <input type="text" name="Dosage_det" id="Dosage_det" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label>Side Effect Strategies:</label>
                                    <input type="text" name="Side_effect" id="Side_effect" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Adherence Plan:</label>
                                    <input type="text" name="Ad_Plan" id="Ad_Plan" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Treatment Supporter Provided:</label>
                                    <input type="text" name="Treatment_Support" id="Treatment_Support" class="form-control">
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
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
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
        <button class="btn bg-soft-danger text-white">Back to Main Page</button>
    </div>
    <div class="col-auto">
        <button class="btn  text-white" style="background:#991002 !important;" id="submitPatient" onclick="saveRecord()">Submit Data</button>
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
            $('#submitPatient').html('<span class="loader-wrapper"><span class="loader"></span></span>'); 
            
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
  
</script>