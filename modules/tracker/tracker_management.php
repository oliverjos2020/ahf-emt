<?php
require_once('../../controllers/cookieManager.php');
$cookieManager = new cookieManager();
$details = $cookieManager->pickCookie();
// print_r($details);exit;
if (!isset($details['username'])) {
    header('location: ../../web/logout.php');
}
?>
<style>
    /* Ensure borders are always visible on select elements */
.select2-selection, .form-control, .form-select {
  border: 1px solid #ced4da; /* Light gray border */
  border-radius: .25rem; /* Rounded corners */
  padding: .375rem .75rem; /* Padding for better visual appearance */
}

.form-select:focus, .form-control:focus {
  border-color: #80bdff; /* Highlighted border color on focus */
  outline: 0; /* Remove default outline */
  box-shadow: 0 0 0 .2rem rgba(38, 143, 255, 0.25); /* Focus shadow effect */
}
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Tracker Management</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tracker Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Statistical Analysis</h4>

                <canvas id="bar" height="300"></canvas>

                <!-- <div class="row text-center">
                    <div class="col-4">
                        <h5 class="mb-0">2541</h5>
                        <p class="text-muted text-truncate">Activated</p>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0">84845</h5>
                        <p class="text-muted text-truncate">Pending</p>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0">12001</h5>
                        <p class="text-muted text-truncate">Deactivated</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Progress Report</h4>

                <canvas id="doughnut" height="260"></canvas>

                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="mb-0">9595</h5>
                        <p class="text-muted text-truncate">Activated</p>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0">36524</h5>
                        <p class="text-muted text-truncate">Pending</p>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0">62541</h5>
                        <p class="text-muted text-truncate">Deactivated</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title">Trackers List</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-ahf btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal" href="javascript:void(0)">
                            <i class="fas fa-plus"></i> Create Tracker
                        </a>
                    </div>
                </div>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
            
                        <tr role="row">
                            <th>S/N</th>
                            <th>Tracker Name</th>
                            <th>Gender</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Assigned</th>
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

<!-- Modal -->
<!-- <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create Tracker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <label for="trackerName" class="col-sm-3 col-form-label">Tracker Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="trackerName" placeholder="Enter Tracker Name">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="trackerPhone" class="col-sm-3 col-form-label">Tracker Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="trackerPhone" placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="trackerEmail" class="col-sm-3 col-form-label">Tracker Email Address</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="trackerEmail" placeholder="Enter Email Address">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="trackerStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="state" class="col-sm-3 col-form-label">State & LGA</label>
                        <div class="col-sm-5">
                            <select class="form-select" id="state">
                                <option value="">Select State</option>
                                
                                <option value="state1">State 1</option>
                                <option value="state2">State 2</option>
                            </select>
                        </div>
                    <label for="lga" class="col-sm-3 col-form-label">LGA</label>
                        <div class="col-sm-4">
                            <select class="form-select" id="lga">
                                <option value="">Select LGA</option>
                               
                                <option value="lga1">LGA 1</option>
                                <option value="lga2">LGA 2</option>
                            </select>
                        </div>
                    </div>
                </form>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ahf btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf btn-sm">Save Status</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Assign Patient to Trackers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <label for="trackerName" class="col-sm-3 col-form-label">Select Patient:</label>
                        <div class="col-sm-9">
                           <select name="trackerName" id="" class="form-select">
                            <option value="">Select Patient</option>
                           </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ahf btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf btn-lg">Assign Tracker</button>
            </div>
        </div>
    </div>
</div>

<script>
    !(function(d) {
        "use strict";

        function ChartManager() {}

        ChartManager.prototype.respChart = function(chartElement, chartType, chartData, chartOptions) {
            // Default font and grid line colors
            Chart.defaults.global.defaultFontColor = "#8791af";
            Chart.defaults.scale.gridLines.color = "rgba(166, 176, 207, 0.1)";

            var ctx = chartElement.get(0).getContext("2d");

            function createChart() {
                chartElement.attr("width", chartElement.parent().width());
                new Chart(ctx, {
                    type: chartType,
                    data: chartData,
                    options: chartOptions
                });
            }

            d(window).resize(createChart);
            createChart();
        };

        ChartManager.prototype.init = function() {
            // Bar Chart
            this.respChart(
                d("#bar"),
                "bar", {
                    labels: ["Activated", "Pending", "Deactivated"],
                    datasets: [{
                        label: "Status",
                        data: [2541, 84845, 12001],
                        backgroundColor: [
                            "rgba(59, 93, 231, 0.8)",
                            "rgba(235, 87, 87, 0.8)",
                            "rgba(69, 203, 133, 0.8)"
                        ],
                        borderColor: [
                            "rgba(59, 93, 231, 1)",
                            "rgba(235, 87, 87, 1)",
                            "rgba(69, 203, 133, 1)"
                        ],
                        borderWidth: 1
                    }]
                }, {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.4
                        }]
                    },
                    legend: {
                        display: true,
                        position: "bottom" // Place legend below the chart
                    }
                }
            );

            // Doughnut Chart
            this.respChart(
                d("#doughnut"),
                "doughnut", {
                    labels: ["Activated", "Pending", "Deactivated"],
                    datasets: [{
                        data: [9595, 36524, 62541],
                        backgroundColor: ["#45cb85", "#3b5de7", "#ebeff2"],
                        hoverBackgroundColor: ["#45cb85", "#3b5de7", "#ebeff2"],
                        hoverBorderColor: "#fff"
                    }]
                }, {
                    legend: {
                        display: true,
                        position: "bottom" // Place legend below the chart
                    }
                }
            );
        };

        d.ChartManager = new ChartManager();
        d.ChartManager.init();
    })(window.jQuery);

    var table;
    var editor;
    var route = "/trackerList";
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

</script>