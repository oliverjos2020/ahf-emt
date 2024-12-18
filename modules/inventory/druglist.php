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
            <h2 class="page-title mb-0">DRUG</h2>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Drug</li>
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
                            Drug
                        </h3>
                        <p>Table showing the list of all available drugs.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p class=""><br><a class="btn btn-ahf" data-bs-toggle="modal" data-bs-target="#addNewDrug" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Drug</a>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addNewDrugLabel">Add Drug</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="form1">
                    <!-- Drug Name Row -->
                    <div class="row mb-3">
                        <label for="drugname" class="col-sm-2 col-form-label">Drug Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="drug_name" name="drug_name" placeholder="Enter Drug Name">
                            <input type="hidden" class="form-control" id="route" name="route" value="/drug_name_setup">
                            <input type="hidden" class="form-control" id="action" name="action" value="new">
                        </div>
                    </div>

                    <!-- Drug Category Row -->
                    <div class="row mb-3">
                        <label for="drugcategory" class="col-sm-2 col-form-label">Drug Category</label>
                        <div class="col-sm-10">
                            <select class="form-select border border-grey" id="category_id" name="category_id">
                                <option value="" selected>Select Drug Category</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description Row -->
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="drug_description" name="drug_description" rows="4" placeholder="Input Text Details Here"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <!-- Close Button - Grey -->
                <button type="button" class="btn btn-secondary waves-effect waves-light btn-lg" data-bs-dismiss="modal">
                    Close
                </button>

                <!-- Save Button - Red -->
                <button type="button" class="btn btn-ahf waves-effect waves-light btn-lg" id="add_drug" onclick="saveDrug()">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Restock Drug Modal -->
<div class="modal fade" id="restockDrug" tabindex="-1" aria-labelledby="restockDrugLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restockDrugLabel">Restock Drug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form>
                    <div class="row mb-3">
                        <label for="restockdrugname" class="col-sm-2 col-form-label">Drug Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockdrugname" placeholder="Enter Drug Name">
                        </div>

                        <label for="restockdrugbrand" class="col-sm-2 col-form-label">Drug Brand</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockdrugbrand" placeholder="Input Drug Brand">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockdrugcategory" class="col-sm-2 col-form-label">Drug Category</label>
                        <div class="col-sm-4">
                            <select class="form-select border border-grey" id="restockdrugcategory">
                                <option value="" selected>Select Drug Category</option>
                                <option value="ahx">AHX</option>
                            </select>
                        </div>

                        <label for="restockquantity" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockquantity" placeholder="Enter Quantity">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockexpiryDate" class="col-sm-2 col-form-label">Expiry Date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="restockexpiryDate">
                        </div>

                        <label for="restockdateAdded" class="col-sm-2 col-form-label">Date Added</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="restockdateAdded">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockbatchNumber" class="col-sm-2 col-form-label">Batch Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockbatchNumber" placeholder="Enter Batch Number">
                        </div>

                        <label for="restocksupplierName" class="col-sm-2 col-form-label">Supplier Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restocksupplierName" placeholder="Enter Supplier Name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockmanufacturer" class="col-sm-2 col-form-label">Manufacturer</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockmanufacturer" placeholder="Enter Manufacturer">
                        </div>

                        <label for="restockreorderLevel" class="col-sm-2 col-form-label">Reorder Level</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockreorderLevel" placeholder="Enter your threshold quantity here">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockstorageCondition" class="col-sm-2 col-form-label">Storage Condition</label>
                        <div class="col-sm-4">
                            <select name="restockstorageCondition" class="form-select" id="restockstorageCondition">
                                <option value="">Select Condition</option>
                            </select>
                        </div>

                        <label for="restockaddedBy" class="col-sm-2 col-form-label">Added By</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="restockaddedBy" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="row mb-3" id="restockregimenSetupSection" style="display: none;">
                        <label class="col-sm-2 col-form-label">Regimen Setup</label>
                        <div class="col-sm-10 d-flex justify-content-end" style="margin-top:10px;">
                            <span class="text-primary" style="cursor: pointer;" id="restockaddRegimenRow">+ Add more</span>
                        </div>
                    </div>

                    <div class="row mb-3" id="restockregimenTableSection" style="display: none;">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="restockregimenTable">
                                <thead>
                                    <tr>
                                        <th>Age Group</th>
                                        <th>Sub-line</th>
                                        <th>Section</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-select">
                                                <option value="">Select Age Group</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select">
                                                <option value="">Select Sub-line</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select">
                                                <option value="">Select Section</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm restockdeleteRow" style="margin-top: 5px;">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="restockdescription" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="restockdescription" rows="4" placeholder="Input Text Details Here"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark waves-effect waves-light btn-lg" data-bs-dismiss="modal">
                    <i class="bx bx-x-circle font-size-16 align-middle me-2"></i>Close</button>
                <button type="button" class="btn btn-success waves-effect waves-light btn-lg">
                    <i class="bx bxs-check-circle font-size-16 align-middle me-2"></i>Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#drugcategory').change(function() {
            if ($(this).val().toLowerCase() === 'ahx') {
                $('#regimenSetupSection, #regimenTableSection').show();
            } else {
                $('#regimenSetupSection, #regimenTableSection').hide();
            }
        });

        $('#addRegimenRow').click(function() {
            var rowHtml = `
            <tr>
                <td>
                    <select class="form-select">
                        <option value="">Select Age Group</option>
                        <!-- Add more options as needed -->
                    </select>
                </td>
                <td>
                    <select class="form-select">
                        <option value="">Select Sub-line</option>
                        <!-- Add more options as needed -->
                    </select>
                </td>
                <td>
                    <select class="form-select">
                        <option value="">Select Section</option>
                        <!-- Add more options as needed -->
                    </select>
                </td>
                <td>
                   <button type="button" class="btn btn-danger btn-sm deleteRow" style="margin-top: 5px;">
                        <i class="far fa-trash-alt"></i>
                   </button>
                </td>
            </tr>`;
            $('#regimenTable tbody').append(rowHtml);
        });

        $(document).on('click', '.deleteRow', function() {
            $(this).closest('tr').remove();
        });
    });

    function getCategory() {

        var route = "/drugCategories";
        var data = {
            route
        };

        $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array

            const $select = $('#category_id');
            $select.empty(); // Clear existing options
            $select.append($('<option>', {
                value: '',
                text: 'Select Category'
            })); // Default option

            // Populate the dropdown
            $.each(re, function(index, cat) {
                $select.append($('<option>', {
                    value: cat.id, // Set role_id as the value
                    text: cat.category_name // Set role_name as the display text
                }));
            });

        }, 'json')
    }


    function saveDrug() {
    // Validate form fields
    const drugName = $("#drug_name").val().trim();
    const categoryId = $("#category_id").val().trim();
    const description = $("#drug_description").val().trim();

    if (!drugName) {
        toastr.error('Drug Name is required', 'Error', {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            extendedTimeOut: 3000,
            escapeHtml: true,
            tapToDismiss: false,
        });
        return;
    }

    if (!categoryId) {
        toastr.error('Drug Category is required', 'Error', {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            extendedTimeOut: 3000,
            escapeHtml: true,
            tapToDismiss: false,
        });
        return;
    }

    if (!description) {
        toastr.error('Description is required', 'Error', {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            extendedTimeOut: 3000,
            escapeHtml: true,
            tapToDismiss: false,
        });
        return;
    }

     // Replace button text with loader
     $('#add_drug').html('<div class="table-loader-btn"></div> Processing...');

    // Optionally, you can disable the button to prevent multiple submissions
    $('#add_drug').prop('disabled', true);

    // Proceed with API call if validation passes
    var dd = $("#form1").serialize();
    $.post("controllers/gateway.php", dd, function(re) {
        console.log(re);

        if (re.status == 200) {

            $("#add_drug").html('Save'); // Reset button text
            $("#add_drug").prop('disabled', false); // Re-enable button

            toastr.success(re.message, 'Success', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                extendedTimeOut: 3000,
                escapeHtml: true,
                tapToDismiss: false,
            });

            getpage('modules/inventory/druglist.php', 'page');
            $("#defaultModal").modal("hide");
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        } else {
            $("#add_drug").html('Save'); // Reset button text
            $("#add_drug").prop('disabled', false); // Re-enable button

            toastr.error(re.message, 'Error', {
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

    getCategory();
</script>