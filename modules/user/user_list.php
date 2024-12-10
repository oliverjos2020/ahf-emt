
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">User</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4 class="fs-2" style="font-weight: bold;">User List</h4>
                        <p>The report contains users that have been setup in the system.</p>
                    </div>
                    <div class="col-md-6">
                    <a class="btn btn-ahf btn-block" style="float:right;" onclick="myLoadModal('modules/user/user.php','modal_div')" href="javascript:void(0)"><i
                                    class="fa fa-plus"></i> Create User</a>
                    </div>
                </div>
       

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                        <tr role="row">
                            <th>S/N</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <!-- <th>Username</th> -->
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Login Status</th>
                            <th>Action</th>
                            <th>Action</th>
                            <th>Created</th>
                        </tr>
                    </thead>

                    <tbody>


                    </tbody>
                </table>
                <!-- <input type="hidden" id="route" value="modules/user/user.php"> -->
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
var route = "/usersList";
$(document).ready(function() {
    // $.blockUI({
    //     message: '<img src="loading.gif" alt=""/>&nbsp;&nbsp;loading please wait . . .',
    // });
    table = $("#page_list").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        columnDefs: [{
            orderable: false,
            targets: -1 // Disable ordering on the "Action" column
        }],
        oLanguage: {
            sEmptyTable: "No record was found, please try another query",
            sProcessing: "<div class='table-loader'></div>"
        },
        ajax: {
            url: "controllers/gateway.php",
            type: "POST",
            data: function(d) {
                d.route = route;
                d.li = Math.random();
                d.list = "yes";
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
                title: "S/N",
                data: 0
            },
            {
                title: "First Name",
                data: 1
            },
            {
                title: "Last Name",
                data: 2
            },
            {
                title: "Email",
                data: 3
            },
            {
                title: "Phone",
                data: 4
            },
            {
                title: "Role",
                data: 5
            },
            {
                title: "Login Status",
                data: 7
            },
            {
                title: "Created",
                data: 10
            }, {
                title: "Edit",
                data: 3,
                render: function(data, type, row) {
                    return '<button class="btn btn-success btn-sm deactivate" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #BC9408;" title="Edit User" data-userdeactivate-id="' +
                        data +
                        '" onclick="myLoadModal(\'modules/user/user.php?op=edit&username=' +
                        data +
                        '&firstname=' + row[1] +
                        '&lastname=' + row[2] +
                        '&phone=' + row[4] +
                        '\', \'modal_div\')"><i class="fas fa-pencil-alt"></i></button>';
                }
            },
            {
                title: "Disable",
                data: 3,
                render: function(data, type, row) {
                    // Assuming row[7] is the Login Status column (enabled/disabled)
                    if (row[7] == "Enabled") {
                        // Show Disable User button
                        return '<button class="btn btn-danger btn-sm deactivate" title="Disable User" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #EF7370;" onclick="disableUser(\'' +
                            data + '\')" data-userdeactivate-id="' + data +
                            '"><i class="fas fa-ban"></i></button>';
                    } else {
                        // Show Enable User button
                        return '<button class="btn btn-success btn-sm activate" title="Enable User" style="background-color: #FFF2F0; border-color: #FFF2F0; color: green;" onclick="enableUser(\'' +
                            data + '\')" data-useractivate-id="' + data +
                            '"><i class="fas fa-check"></i></button>';
                    }
                }
            }

        ],
        initComplete: function() {
            $("#page_list").addClass("table-bordered"); // Add the bordered class dynamically
        }
    });
});

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

function disableUser(user) {
    // let tt = confirm("Are you sure you want to perform this action");
    Swal.fire({
        title: "Disable User?",
        text: "Note that user will not be able to log into the system",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, disable!"
    }).then(function(t) {
        if (t.value) {

            showLoader();
            // Replace these values with dynamic ones as needed
            const username = user; // Replace with actual username variable
            const user_locked = 1;
            const route = "/lockAccess" // Replace with actual user_locked value
            var data = {
                route: route,
                username: username,
                user_locked: user_locked,
                operation: "edit"

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
                    getpage('modules/user/user_list.php', 'page');
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

function enableUser(user) {
    // let tt = confirm("Are you sure you want to perform this action");
    Swal.fire({
        title: "Enable User?",
        text: "Are you sure you want to enable this user",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, Enable!"
    }).then(function(t) {
        if (t.value) {

            showLoader();
            // Replace these values with dynamic ones as needed
            const username = user; // Replace with actual username variable
            const user_locked = 0;
            const route = "/lockAccess" // Replace with actual user_locked value
            var data = {
                route: route,
                username: username,
                user_locked: user_locked,
                operation: "edit"

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
                    getpage('modules/user/user_list.php', 'page');

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
</script>