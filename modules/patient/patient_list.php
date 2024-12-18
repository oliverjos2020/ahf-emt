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

#page_list_x {
    border-collapse: collapse;
    /* Ensure proper cell collapse */
    border-spacing: 0;
}

#page_list_x th,
#page_list_x td {
    border: 1px solid #dee2e6 !important;
    /* Visible border for all cells */
}

    #page_list_x thead th {
        background-color: #f8f9fa; /* Light header background */
    }

    /* div.dataTables_filter {
    display: none;
} */
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h3 class="page-title mb-0">PATIENT MANAGEMENT PAGE</h3>

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
                    <a class="btn  text-white" style="background:#991002 !important;"
                            onclick="getpage('modules/patient/add_patient.php','page')"
                            href="javascript:void(0)"> <i class="fa fa-plus"></i> Add New Patient</a>
                       
                    </div>
                </div>
                <hr>

                <div class="container">
    <div class="row mb-3">
        <!-- Start Date -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="s_date" class="form-label">Start Date:</label>
            <input type="date" class="form-control" name="s_date" id="s_date">
        </div>
        <!-- End Date -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="e_date" class="form-label">End Date:</label>
            <input type="date" class="form-control" name="e_date" id="e_date">
        </div>
        <!-- Missed Appointment -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="missed_appointment" class="form-label">Missed Appointment:</label>
            <select name="missed_appointment" class="form-select" id="missed_appointment">
                <option value="" selected disabled>Select</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Entry Point Type -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="entry_date" class="form-label">Entry Point Type:</label>
            <select name="entry_date" class="form-select" id="entry_date">
                <option value="" selected disabled>Select</option>
                <option value="intra_transfer">Transferred Intra</option>
                <option value="inter_transfer">Transferred Inter</option>
            </select>
        </div>
        <!-- Gender -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="gender" class="form-label">Gender:</label>
            <select name="gender" class="form-select" id="gender">
                <option value="" selected disabled>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <!-- Age Range -->
        <div class="col-md-6 col-lg-4 mb-3">
            <label for="age" class="form-label">Age Range:</label>
            <select name="age" class="form-select" id="age">
                <option value="" selected disabled>Select Age Range</option>
                <option value="above_35">Above 35 Years</option>
                <option value="below_35">Below 35 Years</option>
            </select>
        </div>
    </div>
</div>



                <hr>
                <div class="row justify-content-end">
                    <!-- <div class="input-group" style="width: 300px;">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input
                                type="text"
                                id="customSearchInput"
                                class="form-control"
                                placeholder="Search by ID or Name"
                                aria-label="Search">
                        </div> -->

                    <table id="page_list_x" class="table table-bordered table-hover dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ARTID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Viral Load</th>
                                <th>Appointment Date</th>
                                <th>Enrollment Date</th>
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
    var route = "/patientsData";
    $(document).ready(function() {
       
        table = $("#page_list_x").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            columnDefs: [{
                orderable: false,
                targets: -1 // Disable ordering on the "Action" column
            }],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
                // sProcessing: "<div class='table-loader'></div>"
            },
            ajax: {
                url: "controllers/gateway.php",
                type: "POST",
                data: function(d) {
                    d.route = route;
                    d.li = Math.random();
                    d.list = "yes";
                    d.op = "Patients.fetchPatients"
                },
            

            },
            columns: [{
                    title: "ART ID",
                    data: 1
                },
                {
                    title: "First Name",
                    data: 2
                },
                {
                    title: "Last Name",
                    data: 4
                },
                {
                    title: "Viral Load",
                    data: 47
                },
                {
                    title: "Appointment Date",
                    // data: 6
                    data: 48
                },
                {
                    title: "Date",
                    data: 6
                },
                {
                    title: "Action",
                    data: 1,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm" title="View" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #991002;" onclick="getpage('modules/patient/view_patient.php?id=${row[1]}','page')">
                                <i class="bx bx-show"></i> View
                            </button>
                            <button class="btn btn-sm" title="Create Visit" style="background-color: #CDFFE7; border-color: #FFF2F0; color: #02A055;" 
                                onclick="">
                                <i class="bx bx-plus"></i> Create Visit
                            </button>`;
                    }
                },

            ]
        });
    });

    function disableUser(data) {
        alert("The data is: " + data);
    }

    function do_filter() {
        table.draw();
    }

    function trigUser(user, status) {
        var r_status = (status == 1) ? "Unlock this user" : "Lock this user";
        var cnf = confirm("Are you sure you want to " + r_status + " this user ?");
        if (cnf) {
            $.blockUI();
            $.post('web/router.php', {
                op: 'Users.changeUserStatus',
                current_status: status,
                username: user
            }, function(resp) {
                $.unblockUI();
                if (resp.response_code == 0) {
                    //                           alert(resp.response_message);
                    getpage('modules/user/user_list.php', 'page');
                }

            }, 'json')
        }
    }

    function sackUser(username_1, status_1) {
        let tt = confirm("Are you sure you want to perform this action");
        if (tt) {
            $.post("web/router.php", {
                op: "Users.sackUser",
                username: username_1,
                status: status_1
            }, function(rr) {
                alert(rr.response_message);
                getpage('modules/user/user_list.php', 'page');
            }, 'json');
        }
    }

    function getModal(url, div) {
        $('#' + div).html("<h2>Loading....</h2>");
        //        $('#'+div).block({ message: null });
        $.post(url, {}, function(re) {
            $('#' + div).html(re);
        })
    }

    function disableUser(user) {
        // let tt = confirm("Are you sure you want to perform this action");
        Swal.fire({
            title: 'Disable User?',
            text: "Are you sure you want to disable this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Action when confirmed
                Swal.fire(
                    'Confirmed!',
                    'Your action has been confirmed.',
                    'success'
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Action when cancelled
                Swal.fire(
                    'Cancelled',
                    'Your action has been cancelled.',
                    'error'
                );
            }
        });

    }

    $('#customSearchInput').on('keyup', function () {
        table.search(this.value).draw(); // Use the value of the custom input for searching
    });
</script>