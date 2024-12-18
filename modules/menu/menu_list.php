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
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4 class="fs-2" style="font-weight: bold;">Menu List</h4>
                        <p>The report contains Menus that have been setup in the system.</p>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-ahf btn-sm mx-2" href="javascript:void(0)" style="float:right"
                            onclick="openModal('createMenuModal')">Create Menu</a>&nbsp;&nbsp;
                        <a class="btn btn-ahf btn-sm" href="javascript:void(0)" style="float:right"
                            onclick="openModal('editMenuGroup')">Create Menu Group</a>
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
                        <label for="menuName" class="fw-bold">Menu Name</label>
                        <input type="text" class="form-control" name="menu_name" id="menuName"
                            placeholder="Enter menu name">
                    </div>
                    <div class="form-group mt-4 fw-bold">
                        <label for="menuURL" class="fw-bold">Menu URL</label>
                        <input type="text" class="form-control" name="menu_url" id="menuURL"
                            placeholder="Enter menu URL">
                    </div>
                    <div class="form-group mt-4 fw-bold">
                        <label for="icon" class="fw-bold">Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon">
                    </div>
                    <div class="form-group mt-4 fw-bold">
                        <label for="menuParent" class="fw-bold">Parent Menu</label>
                        <div id="menuContainer"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf" id="saveMenuButton">Save Menu</button>
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
                <form id="editMenuForm">
                    <div class="form-group">
                        <label for="modalMenuName" class="fw-bold">Menu Name</label>
                        <input type="hidden" name="id" id="modalMenuID">
                        <input type="hidden" name="operation" value="edit" id="operation">
                        <input type="hidden" name="route" value="/saveMenu">
                        <input type="text" class="form-control" name="menu_name" id="modalMenuName"
                            placeholder="Enter menu name">
                    </div>
                    <div class="form-group mt-4">
                        <label for="modalMenuURL" class="fw-bold">Menu URL</label>
                        <input type="text" class="form-control" name="menu_url" id="modalMenuURL"
                            placeholder="Enter menu URL">
                    </div>
                    <div class="form-group mt-4 fw-bold">
                        <label for="icon" class="fw-bold">Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon">
                    </div>
                    <div class="form-group mt-4">
                        <label for="menuParent" class="fw-bold">Parent Menu</label>
                        <div id="menuContainer2"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf" id="saveEditMenuButton">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade bs-example-modal-lg" id="editMenuGroup" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Menu Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMenuForm">
                    <div class="form-group">
                        <div id="roleList"></div>
                        <div id="loading" class="p-3"></div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-6">
                            <label for="visible-menu">Visible Menu</label>
                            <form id="form1" style="width:100%">
                                <div id="div1" class="form-group" ondrop="drop(event)" ondragover="allowDrop(event)">
                                    <!-- Visible menus will be dynamically populated here -->
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <label for="invisible-menu">Hidden Menu</label>
                            <form style="width:100%">
                                <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
                                    <!-- Invisible menus will be dynamically populated here -->
                                </div>
                            </form>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf" onclick="saveVisibleMenus()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->

<script>
getParentMenu();
getParentMenu2();
getRoles();
// getInvisibleMenus();
function loadMenus(el) {
    $("#loading").html("Loading...");
    // Use AJAX to fetch menus based on role_id
    $.post('controllers/gateway.php', {
        route: '/loadmenus',
        role_id: el
    }, function(res) {
        if (res.response_code === 200) {
            // Populate visible and invisible menus
            const visibleMenus = res.data.visible;
            const invisibleMenus = res.data.invisible;

            // Generate HTML for visible menus
            const visibleHtml = visibleMenus.map(menu =>
                `<div id="${menu.menu_id}" class="menu-item" draggable="true" ondragstart="drag(event)">
                    ${menu.menu_name}
                </div>`
            ).join('');

            // Generate HTML for invisible menus
            const invisibleHtml = invisibleMenus.map(menu =>
                `<div id="${menu.menu_id}" class="menu-item" draggable="true" ondragstart="drag(event)">
                    ${menu.menu_name}
                </div>`
            ).join('');

            // Populate div1 and div2 with respective menus
            $('#div1').html(visibleHtml || '<p>No visible menus available</p>');
            $('#div2').html(invisibleHtml || '<p>No invisible menus available</p>');
            $("#loading").html("");
        } else {
            alert(res.response_message || 'Unable to load menus');
        }
    }, 'json');
}


function getParentMenu() {
    var data = {
        'route': '/parentMenulist'
    };
    $.ajax({
        type: "post",
        url: "controllers/gateway.php",
        data: data,
        dataType: "json",
        success: function(response) {
            let selectHtml = `<select id="menuSelect" name="parent_id" class="form-control">`;

            // Add a placeholder option
            selectHtml += `<option value="#">This is a parent menu</option>`;

            // Loop through the 'data' array and create <option> elements
            response.data.forEach(menu => {
                selectHtml += `<option value="${menu.menu_id}">${menu.menu_name}</option>`;
            });

            selectHtml += `</select>`;

            // Inject the HTML into your target container
            $('#menuContainer').html(selectHtml);
        },
        error: function() {
            // toastr.error('Unable to process request at the moment!', 'Error', {
            //     timeOut: 2000
            // });
        }
    });
}


function getParentMenu2() {
    var data = {
        'route': '/parentMenulist'
    };
    $.ajax({
        type: "post",
        url: "controllers/gateway.php",
        data: data,
        dataType: "json",
        success: function(response) {
            let selectHtml = `<select id="menuSelect" name="parent_id" class="form-control">`;

            // Add a placeholder option
            selectHtml += `<option value="#">This is a parent menu</option>`;

            // Loop through the 'data' array and create <option> elements
            response.data.forEach(menu => {
                selectHtml += `<option value="${menu.menu_id}">${menu.menu_name}</option>`;
            });

            selectHtml += `</select>`;

            // Inject the HTML into your target container
            $('#menuContainer2').html(selectHtml);
        },
        error: function() {
            // toastr.error('Unable to process request at the moment!', 'Error', {
            //     timeOut: 2000
            // });
        }
    });
}

function getRoles() {
    var data = {
        'route': '/roleList_simple'
    };
    $.ajax({
        type: "post",
        url: "controllers/gateway.php",
        data: data,
        dataType: "json",
        success: function(response) {
            // let selectHtml = `<select onchange="loadMenus(this.value)" id="menuSelect" name="parent_id" class="form-control">`;
            let selectHtml =
                `<select onchange="loadMenus(this.value)" id="roleSelect" name="parent_id" class="form-control">`;

            // Add a placeholder option
            selectHtml += `<option value="#">Select Role</option>`;

            // Loop through the 'data' array and create <option> elements
            response.data.forEach(role => {
                selectHtml += `<option value="${role.role_id}">${role.role_name}</option>`;
            });

            selectHtml += `</select>`;

            // Inject the HTML into your target container
            $('#roleList').html(selectHtml);
        },
        error: function() {
            // toastr.error('Unable to process request at the moment!', 'Error', {
            //     timeOut: 2000
            // });
        }
    });
}
var table;
var route = "/getMenuList";

$(document).ready(function() {
    // Display loading indicator
    // showLoader();

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

            return response.data;
        },
        columns: [{
                title: "S/N",
                data: row => row[0][0]
            },
            {
                title: "Menu",
                data: row => row[2][0]
            }, // Nested structure for URL
            {
                title: "URL",
                data: row => row[3][0]
            }, // Nested structure for Parent
            {
                title: "Parent",
                data: row => row[4][0]
            }, // Nested structure for Icon
            
            {
                title: "Icon",
                data: row => row[5][0], // Use data[1] for unique identifier
                render: function(data) {
                    return ` 
                    <i class="${data}"></i> ${data}`
                }
            },
            {
                title: "Actions",
                data: null,
                render: function(data, type, row) {
                    const rowData = JSON.stringify({
                        id: row[1][0],
                        menu: row[2][0],
                        url: row[3][0],
                        parent: row[4][0]
                    }).replace(/"/g, "&quot;"); // Escape double quotes for HTML

                    return `
                        <button class="btn btn-success btn-sm edit-button" data-row="${rowData}">
                            <i class="mdi mdi-account-lock"></i> Edit
                        </button>`;
                }
            },
            {
                title: "Actions",
                data: row => row[1][0], // Use data[1] for unique identifier
                render: function(data) {
                    return `
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${data}">
                            <i class="fa fa-trash"></i> Delete
                        </button>`;
                }
            },
            {
                title: "Created",
                data: row => row[10][0]
            } // Nested structure for Created
        ]
    });

    // Unblock UI after data is fetched
    table.on('xhr', function() {
        // hideLoader();
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
        // $("#modalMenuIcon").text(rowData.icon);
        $("#modalMenuID").val(rowData.id);

        // Show the modal
        $("#editModal").modal("show");
    });

    $("#saveMenuButton").click(function() {
        $('#saveMenuButton').text('processing...');
        var data = $("#createMenuForm").serialize();
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('#saveMenuButton').text('Save Menu');
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
                $('#saveMenuButton').text('Save Menu');
                toastr.error('Unable to process request at the moment!', 'Error', {
                    timeOut: 2000
                });
            }
        });
    });

    $("#saveEditMenuButton").click(function() {
        var data = $("#editMenuForm").serialize();
        $('#saveEditMenuButton').text('processing...');
        $.ajax({
            type: "post",
            url: "controllers/gateway.php",
            data: data,
            dataType: "json",
            success: function(data) {
                $('#saveEditMenuButton').text('Save Menu');
                if (data.response_code === 200) {
                    toastr.success(data.response_message, 'Success', {
                        timeOut: 1000
                    });
                    $("#editModal").modal("hide");
                    getpage('modules/menu/menu_list.php', "page");
                } else {
                    toastr.error(data.response_message, 'Error', {
                        timeOut: 2000
                    });
                }
            },
            error: function() {
                $('#saveEditMenuButton').text('Save Menu');
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

function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}

function drop(event) {
    event.preventDefault();
    const menuId = event.dataTransfer.getData("text");
    const draggedElement = document.getElementById(menuId);

    // Append the dragged element to the target container
    event.target.appendChild(draggedElement);
}

function saveVisibleMenus() {
    const visibleMenus = [];
    // Iterate through all elements inside #div1 and collect their IDs
    $('#div1 .menu-item').each(function() {
        visibleMenus.push($(this).attr('id'));
    });
    var role_id = $('#roleSelect').val();
    // Structure the data for saving
    const payload = {
        menus: visibleMenus
    };
    // Make an AJAX POST request to save the data
    $.ajax({
        url: 'controllers/gateway.php', // Your API endpoint
        type: 'POST',
        data: {
            route: '/saveMenuGroup',
            menus: visibleMenus,
            role_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.response_code === 200) {
                alert('Menus saved successfully!');
                $("#editMenuGroup").modal("hide");
            } else {
                alert('Failed to save menus: ' + response.response_message);
            }
        },
        error: function() {
            alert('An error occurred while saving the menus.');
        }
    });
}
</script>