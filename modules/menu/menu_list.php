<?php
include_once("../../libs/dbfunctions.php");
$dbobject = new dbobject();

?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Menu</h4>

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

                <!-- <h4 class="card-title">Default Datatable</h4>
                <p class="card-title-desc">DataTables has most features enabled by default, so all
                    you need to do to use it with your own tables is to call the construction
                    function: <code>$().DataTable();</code>.
                </p> -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title">
                            <br>
                            <a class="btn btn-ahf btn-sm" href="javascript:void(0)"
                                onclick="openModal('createMenuModal')">Create Menu</a>

                            <a class="btn btn-ahf text-right btn-sm"
                                onclick="myLoadModal('modules/menu/menu_group','modal_div')"
                                href="javascript:void(0)">Create Group</a>
                        </h4>
                        <p>The report contains Menus that have been setup in the system.</p>
                    </div>

                </div>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Menu</th>
                            <th>URL</th>
                            <th>Parent</th>
                            <th>Icon</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Created</th>
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

<div class="modal fade modal-lg" id="createMenuModal" tabindex="-1" role="dialog"
    aria-labelledby="createMenuModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMenuModalLabel">Create New Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createMenuForm">
                    <input type="hidden" name="operation" value="new">
                    <input type="hidden" name="route" value="/saveMenu">
                    <div class="form-group">
                        <label for="menuName">Menu Name</label>
                        <input type="text" class="form-control" name="menu_name" id="menuName"
                            placeholder="Enter menu name">
                    </div>
                    <div class="form-group mt-2">
                        <label for="menuURL">Menu URL</label>
                        <input type="text" class="form-control" name="menu_url" id="menuURL"
                            placeholder="Enter menu URL">
                    </div>
                    <div class="form-group mt-2">
                        <label for="menuParent">Parent Menu</label>
                        <select name="parent_id" class="form-control">
                            <option value="#">This is a Parent Menu</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveMenuButton">Save Menu</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade bs-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="modalMenuName">Menu Name</label>
                        <input type="text" class="form-control" id="modalMenuName" placeholder="Enter menu name">
                    </div>
                    <div class="form-group mt-2">
                        <label for="modalMenuURL">Menu URL</label>
                        <input type="text" class="form-control" id="modalMenuURL" placeholder="Enter menu URL">
                    </div>
                    <div class="form-group mt-2">
                        <label for="modalMenuParent">Parent Menu</label>
                        <input type="text" class="form-control" id="modalMenuParent" placeholder="Enter parent menu">
                    </div>
                    <div class="form-group mt-2">
                        <label for="modalMenuIcon">Icon</label>
                        <input type="text" class="form-control" id="modalMenuIcon" placeholder="Enter icon">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->

<script>
var table;
var route = "/getMenuList";

$(document).ready(function() {
    // Display loading indicator
    $.blockUI({
        message: '<img src="loading.gif" alt=""/>&nbsp;&nbsp;Loading, please wait...',
    });

    // Initialize DataTable
    table = $("#page_list").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        columnDefs: [{
            orderable: false,
            targets: -1 // Disable ordering on the "Actions" column
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
        },
        dataSrc: function(response) {
            $.unblockUI();
            return response.data;
        },
        columns: [{
                title: "S/N",
                data: row => row[0][0]
            }, // Nested structure for S/N
            {
                title: "Menu",
                data: row => row[1][0]
            }, // Nested structure for Menu
            {
                title: "URL",
                data: row => row[2][0]
            }, // Nested structure for URL
            {
                title: "Parent",
                data: row => row[3][0]
            }, // Nested structure for Parent
            {
                title: "Icon",
                data: row => row[4][0]
            }, // Nested structure for Icon
            {
                title: "Actions",
                data: null,
                render: function(data, type, row) {
                    const rowData = JSON.stringify({
                        id: row[0][0],
                        menu: row[1][0],
                        url: row[2][0],
                        parent: row[3][0],
                        icon: row[4][0],
                        created: row[7][0]
                    }).replace(/"/g, "&quot;"); // Escape double quotes for HTML

                    return `
                        <button class="btn btn-success btn-sm edit-button" data-row="${rowData}">
                            <i class="mdi mdi-account-lock"></i> Edit
                        </button>`;
                }
            },
            {
                title: "Actions",
                data: row => row[0][0], // Use data[1] for unique identifier
                render: function(data) {
                    return `
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${data}">
                            <i class="fa fa-trash"></i> Delete
                        </button>`;
                }
            },
            {
                title: "Created",
                data: row => row[7][0]
            } // Nested structure for Created
        ]
    });

    // Unblock UI after data is fetched
    table.on('xhr', function() {
        $.unblockUI();
    });

    $("#page_list").on("click", ".delete-btn", function() {
        const id = $(this).data("id");
        if (confirm("Are you sure you want to delete this Menu?")) {
            $.ajax({
                url: "controllers/gateway.php",
                type: "POST",
                data: {
                    menu_id: id,
                    'route': '/deleteMenu'
                },
                dataType: "json",
                success: function(data) {
                    if (data.response_code === 200) {
                        toastr.success(data.response_message, 'Success', {
                            timeOut: 3000
                        });
                        table.ajax.reload(); // Reload the table data
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

    // Handle "Edit" button click
    $(document).on("click", ".edit-button", function() {
        // Get row data from the data-row attribute
        const rowData = JSON.parse($(this).attr("data-row"));

        // Populate the modal fields with row data
        $("#modalMenuName").val(rowData.menu);
        $("#modalMenuURL").val(rowData.url);
        $("#modalMenuParent").val(rowData.parent);
        $("#modalMenuIcon").text(rowData.icon);

        // Show the modal
        $("#editModal").modal("show");
    });
    $("#saveMenuButton").click(function() {
        var data = $("#createMenuForm").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 1000
                    });
                    $("#createMenuModal").modal("hide");
                    getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 2000
                    });
                }
            },
            error: function() {
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 2000
                });
            }
        });
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
</script>