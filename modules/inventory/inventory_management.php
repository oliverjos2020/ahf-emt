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
    /* Make input fields, selects, and textareas have thick borders */
    .form-control,
    .form-select,
    textarea {
        border: 0.5px solid #000 !important;
        /* Dark and visible borders */
    }

    #regimenTable {
        border: 0.5px solid #000;
        /* Dark border for the entire table */
    }

    #regimenTable th,
    #regimenTable td {
        border: 0.5px solid #000 !important;
        /* Dark and thick border for cells */
        text-align: center;
    }

    /* Optional: Add some padding and margin for better visual appearance */
    .form-control,
    .form-select,
    textarea {
        padding: 8px;
        margin-bottom: 5px;
    }

    table.table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #eee;
        /* Ensure the border color matches your design */
    }

    table.table th,
    table.table td {
        border: 1px solid #eee;
        /* Add border to all cells */
        padding: 8px;
        /* Adjust padding for better readability */
    }

    table.table thead th {
        background-color: #f9f9f9;
        /* Optional: Add background color to the header */
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Inventory Management</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Inventory Management</li>
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
                            Inventory Management
                        </h3>
                        <p>Table showing the list of all available drugs.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p class=""><br><a class="btn btn-ahf" data-bs-toggle="modal" data-bs-target="#addNewDrug" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Inventory</a>
                        </p>
                    </div>
                </div>
                <hr>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>

                        <tr role="row">
                            <th>S/N</th>
                            <th>Drug Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Stock</th>
                            <th>Batches</th>
                            <th>Captured Date</th>
                            <th>Expiry Date</th>
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

<!-- Add New Drug Modal -->
<div class="modal fade" id="addNewDrug" tabindex="-1" aria-labelledby="addNewDrugLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addNewDrugLabel">Add Inventory</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="inventory-form">
                    <div class="row mb-3">
                        <label for="drugname" class="col-sm-2 col-form-label">Drug Name</label>
                        <div class="col-sm-4">
                            <select name="drug_id" id="drug_id" class="form-select">

                            </select>
                        </div>

                        <label for="drugbrand" class="col-sm-2 col-form-label">Drug Brand</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="drug_brand" name="drug_brand" placeholder="Input Drug Brand">
                        </div>
                    </div>

                    <div class="row mb-3">
                    <label for="storage_condition" class="col-sm-2 col-form-label">Storage Condition</label>
                        <div class="col-sm-4">
                            <select name="storage_condition" id="storage_condition" class="form-select">

                            </select>
                           
                        </div>

                        <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="expiryDate" class="col-sm-2 col-form-label">Expiry Date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                        </div>

                        <label for="dateAdded" class="col-sm-2 col-form-label">Date Added</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="record_date" name="record_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="batchNumber" class="col-sm-2 col-form-label">Batch Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="batch_number" name="batch_number" placeholder="Enter Batch Number">
                        </div>

                        <label for="supplierName" class="col-sm-2 col-form-label">Supplier Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Enter Supplier Name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="manufacturer" class="col-sm-2 col-form-label">Recieved From</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="recieved_from" name="recieved_from" placeholder="Enter Manufacturer">
                        </div>

                        <label for="reorderLevel" class="col-sm-2 col-form-label">Reorder Level</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="minimum_stock_level" name="minimum_stock_level" placeholder="Enter your threshold quantity here">
                        </div>
                    </div>
                    <div class="row mb-3">

                        <label for="associated_illness" class="col-sm-2 col-form-label">Associated Illness</label>
                        <div class="col-sm-4">
                            <select name="associated_illness" id="associated_illness" class="form-select">

                            </select>
                           
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Input Text Details Here"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-outline-dark waves-effect waves-light btn-lg" data-bs-dismiss="modal">
                    <i class="bx bx-x-circle font-size-16 align-middle me-2"></i>Close</button> -->
                <button type="button" class="btn btn-ahf waves-effect waves-light btn-lg" id="add-inventory-btn" onclick="addDrugInventory()">
                    <i class="bx bxs-check-circle font-size-16 align-middle me-2"></i>Add Inventory</button>
            </div>
        </div>
    </div>
</div>


<script>

function getDrugList() {
    var route = "/drug_name_list";
        var data = {
            route
        };
    $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array
            if(re.status == 200){
            const $select = $('#drug_id');
            $select.empty(); // Clear existing options
            $select.append($('<option>', {
                value: '',
                text: 'Select Drug'
            })); // Default option

            // Populate the dropdown
            $.each(re.data, function(index, drug) {
                $select.append($('<option>', {
                    value: drug.id,
                    text: drug.drug_name 
                }));
            });
        }else{
            toastr.error(re.message || "Unable to load drugs. Please try again.", "Error", {
                    closeButton: true,
                    progressBar: true,
                });
        }
        }, 'json')


}


getDrugList();

function getStorageCondition() {
    var route = "/get_storage_conditions";
        var data = {
            route
        };
    $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array
            if(re.status == 200){
            const $select = $('#storage_condition');
            $select.empty(); // Clear existing options
            $select.append($('<option>', {
                value: '',
                text: 'Select Storage Condition'
            })); // Default option

            // Populate the dropdown
            $.each(re.data, function(index, drug) {
                $select.append($('<option>', {
                    value: drug.id,
                    text: drug.storage_condition 
                }));
            });
        }else{
            toastr.error(re.message || "Unable to load drugs. Please try again.", "Error", {
                    closeButton: true,
                    progressBar: true,
                });
        }
        }, 'json')


}


getStorageCondition();

function getIllnessOptions() {
    var route = "/get_illness_option";
        var data = {
            route
        };
    $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array
            if(re.status == 200){
            const $select = $('#associated_illness');
            $select.empty(); // Clear existing options
            $select.append($('<option>', {
                value: '',
                text: 'Select Storage Condition'
            })); // Default option

            // Populate the dropdown
            $.each(re.data, function(index, drug) {
                $select.append($('<option>', {
                    value: drug.id,
                    text: drug.illness 
                }));
            });
        }else{
            toastr.error(re.message || "Unable to load drugs. Please try again.", "Error", {
                    closeButton: true,
                    progressBar: true,
                });
        }
        }, 'json')


}


getIllnessOptions();

function addDrugInventory(){
    // Serialize the form data
    var formData = $("#inventory-form").serializeArray();
    var processedData = {};

    // Group multi-select field values as an array
    $.each(formData, function(_, field) {  
            // Process normal fields
            processedData[field.name] = field.value;
    });

    processedData['route'] = "/drug_inventory_setup";
    processedData['action'] = "new";
    console.log("Processed Data:", processedData);

    // Replace button text with loader
    $('#add-inventory-btn').html('<div class="table-loader-btn"></div> Processing...');
    $('#add-inventory-btn').prop('disabled', true); // Disable button

     // Send data to the back-end
     $.post("controllers/gateway.php", processedData, function(re) {
        console.log(re);

        if (re.response_code == 200) {
            // Success handling
            $("#add-inventory-btn").html('Add Inventory').prop('disabled', false); // Reset button
            toastr.success(re.response_message, 'Success', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                extendedTimeOut: 3000,
                escapeHtml: true,
                tapToDismiss: false,
            });
     
            $("#addNewDrug").modal("hide");
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');

            // Reset all input fields except select fields
            $('#inventory-form').find('input').not('select').each(function() {
                if ($(this).attr('type') === 'date') {
                    $(this).val(''); // Reset date fields
                } else {
                    $(this).val(''); // Reset other input fields
                }
            });
            table.draw();
        } else {
            // Error handling
            $("#add-inventory-btn").html('Add Inventory').prop('disabled', false); // Reset button
            toastr.error(re.response_message, 'Error', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                extendedTimeOut: 3000,
                escapeHtml: true,
                tapToDismiss: false,
            });
        }
    }, 'json');
}

// var table;
// var editor;
// var route = "/get_drug_inventory_data";
// $(document).ready(function() {
    
//     table = $("#page_list").DataTable({
//         processing: true,
//         serverSide: true,
//         paging: true,
//         columnDefs: [{
//             orderable: false,
//             targets: -1 // Disable ordering on the "Action" column
//         }],
//         oLanguage: {
//             sEmptyTable: "No record was found, please try another query"
//         },
//         ajax: {
//             url: "controllers/gateway.php",
//             type: "POST",
//             data: function(d) {
//                 d.route = route;
//                 d.li = Math.random();
//                 d.list = "yes";
//             },
//         },
//         columns: [{
//                 title: "S/N",
//                 data: 0
//             },
//             {
//                 title: "First Name",
//                 data: 1
//             },
//             {
//                 title: "Last Name",
//                 data: 2
//             },
//             {
//                 title: "Email",
//                 data: 3
//             },
//             {
//                 title: "Phone",
//                 data: 4
//             },
//             {
//                 title: "Role",
//                 data: 5
//             },
//             {
//                 title: "Login Status",
//                 data: 7
//             },
//             {
//                 title: "Created",
//                 data: 10
//             }, {
//                 // Render function
// title: "Edit",
// data: 3,
// render: function(data, type, row) {
//     const params = {
//         op: 'edit',
//         username: data,
//         firstname: row[1],
//         lastname: row[2],
//         phone: row[4],
//         role: row[5],
//         facility_code: row[11],
//         facility_name: row[12],
//         day_1: row[13],
//         day_2: row[14],
//         day_3: row[15],
//         day_4: row[16],
//         day_5: row[17],
//         day_6: row[18],
//         day_7: row[19],
//         user_lock: row[20]
//     };

//     const queryString = buildQueryString(params); // Construct the query string
//     return `
//         <button class="btn btn-success btn-sm deactivate" 
//                 style="background-color: #FFF2F0; border-color: #FFF2F0; color: #BC9408;" 
//                 title="Edit User" 
//                 data-userdeactivate-id="${data}" 
//                 onclick="myLoadModal('modules/user/user.php?${queryString}', 'modal_div')">
//             <i class="fas fa-pencil-alt"></i>
//         </button>
//     `;
// }
//             },
//             {
//                 title: "Disable",
//                 data: 3,
//                 render: function(data, type, row) {
//                     // Assuming row[7] is the Login Status column (enabled/disabled)
//                     if (row[7] == "Enabled") {
//                         // Show Disable User button
//                         return '<button class="btn btn-danger btn-sm deactivate" title="Disable User" style="background-color: #FFF2F0; border-color: #FFF2F0; color: #EF7370;" onclick="disableUser(\'' +
//                             data + '\')" data-userdeactivate-id="' + data +
//                             '"><i class="fas fa-ban"></i></button>';
//                     } else {
//                         // Show Enable User button
//                         return '<button class="btn btn-success btn-sm activate" title="Enable User" style="background-color: #FFF2F0; border-color: #FFF2F0; color: green;" onclick="enableUser(\'' +
//                             data + '\')" data-useractivate-id="' + data +
//                             '"><i class="fas fa-check"></i></button>';
//                     }
//                 }
//             }

//         ],
//         initComplete: function() {
//             $("#page_list").addClass("table-bordered"); // Add the bordered class dynamically
//         }
//     });
// });


   
</script>