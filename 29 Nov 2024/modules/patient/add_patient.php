
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
                                    <input type="date" name="record_date" id="record_date" class="form-control">
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
                                    <input type="text" name="middlename" id="middlename" class="form-control">
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
                                    <input type="text" name="occupation" id="occupation" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Education:</label>
                                    <input type="text" name="education" id="education" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Drug Allergies:</label>
                                    <input type="text" name="drug_allergies" id="drug_allergies" class="form-control">
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
                                    <input type="text" name="phone_2" id="phone_2" class="form-control">
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
                                    <input type="text" name="street" id="street" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Description:</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Email Address:</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Mother Unique (If Infant): </label>
                                    <input type="text" name="mother_unique" id="mother_unique" class="form-control">
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
                                    <input type="text" name="nok_surname" id="nok_surname" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Middlename:</label>
                                    <input type="text" name="nok_middlename" id="nok_middlename" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Firstname:</label>
                                    <input type="email" name="nok_firstname" id="nok_firstname" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Relationship: </label>
                                    <input type="text" name="relationship" id="relationship" class="form-control">
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
                                    <label>Transferred In:</label>
                                    <select name="transferredIn" id="transferredIn" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Entry point option:</label>
                                    <select name="careentry" id="careentry" class="form-control">
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
                                    <input type="date" name="record_date" id="record_date" class="form-control">
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
                                    <input type="date" name="adherence_plan_started" id="adherence_plan_started" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Education of ART Essentials:</label>
                                    <input type="text" name="ed_art_essential" id="ed_art_essential" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Complete Adherence Needed:</label>
                                    <input type="email" name="com_ad_needed" id="com_ad_needed" class="form-control">
                                </div>
                                <div class="col-md">
                                    <label>Relationship: </label>
                                    <input type="text" name="relationship" id="relationship" class="form-control">
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
                                    <input type="checkbox" name="yes" id="yes"> Yes

                                </div>
                                <div class="col-md-4">
                                <input type="checkbox" name="no" id="no"> No

                                </div>
                              
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                <input type="checkbox" name="email" id="email"> Email
                                   
                                </div>
                                <div class="col-md-4">
                                    <input type="checkbox" name="sms" id="sms"> SMS

                                </div>
                                <div class="col-md-4">
                                <input type="checkbox" name="both_e_and_s" id="both_e_and_s"> Both Email and SMS notifications

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
        <button class="btn  text-white" style="background:#991002 !important;">Submit Data</button>
    </div>
</div>


</div>

<div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_div">

        </div>
    </div>
</div>

<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->
<script>
    var table;
    var editor;
    var op = "Menu.menuList";
    $(document).ready(function() {
        table = $("#page_list").DataTable({
            processing: true,
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            serverSide: true,
            paging: true,
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
            },

            ajax: {
                url: "web/router.php",
                type: "POST",
                data: function(d, l) {
                    d.op = op;
                    d.li = Math.random();
                    //          d.start_date = $("#start_date").val();
                    //          d.end_date = $("#end_date").val();
                }
            }
        });
    });

    function do_filter() {
        table.draw();
    }

    function closeModal() {
        $("#defaultModal").modal("hide");
    }

    function deleteMenu(id) {
        let cnf = confirm("Are you sure you want to delete menu?");
        if (cnf == true) {
            $.blockUI();
            $.ajax({
                url: "web/router.php",
                data: {
                    op: "Menu.deleteMenu",
                    menu_id: id
                },
                type: "post",
                dataType: "json",
                success: function(re) {
                    $.unblockUI();
                    // alert(re.response_message);
                    toastr.success(re.response_message, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                    getpage('modules/menu/menu_list.php', "page");
                },
                error: function(re) {
                    $.unblockUI();
                    // alert("Request could not be processed at the moment!");
                    toastr.error("Request could not be processed at the moment!", 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                }
            });
        }

    }

    function getModal(url, div) {
        //        alert('dfd');
        $('#' + div).html("<h2>Loading....</h2>");
        //        $('#'+div).block({ message: null });
        $.post(url, {}, function(re) {
            $('#' + div).html(re);
        })
    }
</script>