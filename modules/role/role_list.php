<?php
include_once("../../libs/dbfunctions.php");
//var_dump($_SESSION);
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Role</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Role</li>
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
                    <div class="col-md-12">
                        <h4 class="card-title"><br>
                            <a class="btn btn-ahf btn-sm"
                                onclick="myLoadModal('modules/role/role_setup.php','modal_div')"
                                href="javascript:void(0)">Create Role</a>
                        </h4>
                    </div>

                </div>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>Created</th>
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

<div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_div">

        </div>
    </div>
</div>

<script>
var table;
var editor;
var route = "/roleList";
$(document).ready(function() {
 showLoader();
    table = $("#page_list").DataTable({
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
            },
            dataSrc: function(response) {
                hideLoader();
                // Check response and format data
                if (response.draw) {
                    // Map response data and add a Delete button as the last column
                    return response.data.map(row => {
                        const flattenedRow = row.flat(); // Flatten nested arrays
                        flattenedRow.push(
                            `<button class="btn btn-danger btn-sm delete-btn" data-id="${flattenedRow[1]}">Delete</button>`
                        ); // Add delete button with ID from the first column
                        return flattenedRow;
                    });
                } else {
                    console.error("Invalid response:", response);
                    return [];
                }
            }
        },
        columns: [{
                title: "S/N",
                data: 0
            },
            {
                title: "Role ID",
                data: 1
            },
            {
                title: "Role Name",
                data: 2
            },
            {
                title: "Created",
                data: 3
            },
            {
                title: "Action",
                data: 4
            } // The new "Action" column for buttons
        ]
    });

    // Handle delete button click
    $("#page_list").on("click", ".delete-btn", function() {
        const id = $(this).data("id");
        if (confirm("Are you sure you want to delete this role?")) {
            $.ajax({
                url: "controllers/gateway.php",
                type: "POST",
                data: {
                    id: id,
                    'route': '/deleteRole'
                },
                dataType: "json",
                success: function(data) {
                    if (data.response_code === 200) {
                        toastr.success(data.response_message, 'Success', {
                            timeOut: 3000
                        });
                        table.ajax.reload(); // Reload the table data
                        getpage('modules/role/role_list.php', "page");
                    } else {
                        toastr.error(data.response_message, 'Error', {
                            timeOut: 3000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting role:", error);
                    alert("Failed to delete role.");
                }
            });
        }
    });
});

function do_filter() {
    table.draw();
}

function closeModal() {
    $("#defaultModal").modal("hide");
}

function getModal(url, div) {
    //        alert('dfd');
    $('#' + div).html("<h2>Loading....</h2>");
    //        $('#'+div).block({ message: null });
    $.post(url, {}, function(re) {
        $('#' + div).html(re);
    })
}

function deleteRole(id) {
    let cnf = confirm("Are you sure you want to delete Role?");
    if (cnf == true) {
        $.blockUI();
        $.ajax({
            url: "web/router.php",
            data: {
                op: "Role.deleteRole",
                id: id
            },
            type: "post",
            dataType: "json",
            success: function(re) {
                $.unblockUI();
                toastr.success(re.response_message, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
                getpage('modules/role/role_list.php', "page");
            },
            error: function(re) {
                $.unblockUI();
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
</script>