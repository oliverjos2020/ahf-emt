<style>
    #page_list_x {
        border-collapse: collapse; /* Ensure proper cell collapse */
        border-spacing: 0;
    }

    #page_list_x th,
    #page_list_x td {
        border: 1px solid #dee2e6 !important; /* Visible border for all cells */
    }

    #page_list_x thead th {
        background-color: #f8f9fa; /* Light header background */
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Facility</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Facility</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- <h4 class="card-title">Default Datatable</h4>
                <p class="card-title-desc">DataTables has most features enabled by default, so all
                    you need to do to use it with your own tables is to call the construction
                    function: <code>$().DataTable();</code>.
                </p> -->
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="fw-bold">
                            Facility Management
                        </h3>
                        <p>Table showing the list of all available facilities.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a class="btn btn-ahf" onclick="myLoadModal('modules/facility/facility_setup','modal_div')" href="javascript:void(0)"><i class="fa fa-plus"></i> Create Facility</a>
                        <button href="" class="btn btn-ahf-secondary" onclick="myLoadModal('modules/user/user.php','modal_div')"><i class="fa fa-plus"></i> Create New User</button>
                    </div>

                </div>

                <table id="page_list_x" class="table table-bordered table-hover dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%; border: 1px solid #000;">
    <thead class="thead-light">
        <tr>
            <th>Facility Name</th>
            <th>State</th>
            <th>L.G.A.</th>
            <th>Phone Number</th>
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

<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->
<script>
    var table;
    var editor;
    var route = "/fetchCodesDataTable";
    $(document).ready(function() {
        // $.blockUI({
        //     message: '<img src="loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .',
        // });
        table = $("#page_list_x").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            columnDefs: [{
                orderable: false,
                targets: -1 // Disable ordering on the "Action" column
            }],
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
            },
            ajax: {
                url: "controllers/gateway.php",
                type: "POST",
                data: function(d) {
                    d.route = route;
                    d.li = Math.random();
                    d.list = "yes";
                    // d.op = "Patients.fetchPatients"
                },
                beforeSend: function() {
                    // Show the loader before the request starts
                    showLoader();
                },
                complete: function() {
                    // Hide the loader after the request completes
                    hideLoader();
                },

            },
            columns: [{
                    title: "Facility Name",
                    data: 2
                },
                {
                    title: "State",
                    data: 14
                },
                {
                    title: "LGA",
                    data: 15
                },
                {
                    title: "Phone Number",
                    data: 19
                },
                {
                    title: "Action",
                    data: 1,
                    render: function(data, type, row) {
                        return `
                              <button class="btn btn-sm" title="Edit" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #BC9408;" 
                                onclick="myLoadModal('modules/facility/facility_setup.php?op=edit&username=${data}&facility_name=${row[1]}&facility_code=${row[2]}&phone=${row[4]}&address=${row[2]}', 'modal_div')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="btn btn-sm" title="Delete" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #EF7370;" onclick="deleteFacility(${data})">
                                <i class="bx bx-trash"></i>
                            </button>
                            <button class="btn btn-sm" title="View" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #991002;" onclick="viewFacility(${data})">
                                <i class="bx bx-show"></i>
                            </button>`;
                    }
                },


            ],
            initComplete: function () {
            $("#page_list_x").addClass("table-bordered"); // Add the bordered class dynamically
        }
        });
    });

    function disableUser(data) {
        alert("The data is: " + data);
    }

    function do_filter() {
        table.draw();
    }

    function getModal(url, div) {
        $('#' + div).html("<h2>Loading....</h2>");
        //        $('#'+div).block({ message: null });
        $.post(url, {}, function(re) {
            $('#' + div).html(re);
        })
    }
</script>