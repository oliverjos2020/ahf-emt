
<style>
    label {
        font-weight: bold;
        white-space: nowrap;
        /* Ensures labels remain on one line */
    }

    input[type="date"],
    .form-select {
        min-width: 200px;
        /* Ensures a consistent width for inputs */
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Patients List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Menu</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col d-flex justify-content-start">
                        <h4 class="fs-2" style="font-weight: bold;">Patients List</h4>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                id="customSearchInput"
                                class="form-control"
                                placeholder="Search by ART, ID, or Name"
                                aria-label="Search">
                        </div>
                    </div>
                </div>
                <hr>

                <div class="container">
    <div class="row align-items-center mb-3">
        <!-- Start Date -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="s_date" class="me-2">Start Date:</label>
                <input type="date" class="form-control flex-grow-1" name="s_date" id="s_date">
            </div>
        </div>
        <!-- End Date -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="e_date" class="me-2">End Date:</label>
                <input type="date" class="form-control flex-grow-1" name="e_date" id="e_date">
            </div>
        </div>
        <!-- Missed Appointment -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="missed_appointment" class="me-2">Missed Appointment:</label>
                <select name="missed_appointment" class="form-select flex-grow-1" id="missed_appointment">
                    <option value="" selected disabled>Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row align-items-center">
        <!-- Entry Point Type -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="entry_date" class="me-2">Entry Point Type:</label>
                <select name="entry_date" class="form-select flex-grow-1" id="entry_date">
                    <option value="" selected disabled>Select</option>
                    <option value="intra_transfer">Transferred Intra</option>
                    <option value="inter_transfer">Transferred Inter</option>
                </select>
            </div>
        </div>
        <!-- Gender -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="gender" class="me-2">Gender:</label>
                <select name="gender" class="form-select flex-grow-1" id="gender">
                    <option value="" selected disabled>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>
        <!-- Age Range -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="d-flex align-items-center">
                <label for="age" class="me-2">Age Range:</label>
                <select name="age" class="form-select flex-grow-1" id="age">
                    <option value="" selected disabled>Select Age Range</option>
                    <option value="above_35">Above 35 Years</option>
                    <option value="below_35">Below 35 Years</option>
                </select>
            </div>
        </div>
    </div>
</div>


                <hr>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <a class="btn  text-white" style="background:#991002 !important;"
                            onclick="getpage('modules/patient/add_patient.php','page')"
                            href="javascript:void(0)"> <i class="bi bi-plus"></i> Add New Patient</a>
                    </div>

                    <table id="page_list_x" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ARTID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Viral Load</th>
                                <th>Appointment Date</th>
                                <th>Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- end col -->
    </div>

    <div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal_div">

            </div>
        </div>
    </div>


    <script>
        var table;
        var editor;
        var op = "Patients.patientList";
        $(document).ready(function() {
            table = $("#page_list").DataTable({
                processing: true,
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],
                dom: 'lrtip',
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

        // Custom search input functionality
        $('#page_list').on('keyup', function() {
            table.search(this.value).draw();
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