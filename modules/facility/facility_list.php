<?php
require_once('../../controllers/cookieManager.php');
$cookieManager = new cookieManager();
$details = $cookieManager->pickCookie();
// print_r($details);exit;
if (!isset($details['username'])) {
    header('location: ../../web/logout.php');
}
?>
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
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="fw-bold">
                            Facility Management
                        </h3>
                        <p>Table showing the list of all available facilities.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a class="btn btn-ahf" onclick="myLoadModal('modules/facility/facility_setup','modal_div')" href="javascript:void(0)"><i class="fa fa-plus"></i> Create Facility</a>
                        <!-- <button href="" class="btn btn-ahf-secondary" onclick="myLoadModal('modules/user/user.php','modal_div')"><i class="fa fa-plus"></i> Create New User</button> -->
                    </div>

                </div>
                <hr>
                <table id="page_list_x" class="table table-bordered table-hover dt-responsive nowrap"
       style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
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
                // sProcessing: "<div class='table-loader'></div>"
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
                // beforeSend: function() {
                //     // Show the loader before the request starts
                //     showLoader();
                // },
                // complete: function() {
                //     // Hide the loader after the request completes
                //     hideLoader();
                // },

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
                                onclick="myLoadModal('modules/facility/facility_setup.php?op=edit&username=${data}&facility_name=${row[2]}&facility_code=${row[1]}&phone=${row[19]}&address=${row[4]}&officer=${row[3]}&state=${row[14]}&lga=${row[15]}', 'modal_div')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="btn btn-sm" title="Delete" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #EF7370;" onclick="deleteFacility('${encodeURIComponent(row[1])}', '${row[2]}')">
                                <i class="bx bx-trash"></i>
                            </button>
                            <button class="btn btn-sm" title="View" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #991002;" onclick="viewFacility(${row})">
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

    function deleteFacility(id, facility) {
        
        Swal.fire({
            title: "Delete Facility?",
            text: "Are you sure you want to delete " + facility,
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete!"
        }).then(function(t) {
            if (t.value) {

                showLoader();
                // Replace these values with dynamic ones as needed
                const route = "/deleteFacility" // Replace with actual user_locked value
                var data = {
                    route: route,
                    id: id

                };
                $.post("controllers/gateway.php", data, function(response) {
                    hideLoader();
                    // Handle the response
                    if (response.response_code === 200) {
                        toastr.success(response.response_message, "Success", {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 5000, // 5 seconds (time in milliseconds)
                            extendedTimeOut: 0,
                            onHidden: function() {
                                // Notification hidden, no need to wait for this to execute getpage
                            }
                        });

                        // Call getpage immediately after success
                        getpage('modules/facility/facility_list.php', 'page');
                    } else {
                        toastr.error(response.response_message || "An error occurred", "Error", {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 5000
                        });
                    }
                }, 'json').fail(function() {
                    hideLoader();
                    Swal.fire("Error", "Failed to communicate with the server.", "error");
                });
            }
        })

    }

    function do_filter() {
        table.draw();
    }

  function viewFacility(data){
    console.log(data);
  }
</script>