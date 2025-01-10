<?php
require_once('../../controllers/cookieManager.php');
$cookieManager = new cookieManager();
$details = $cookieManager->pickCookie();
// print_r($details);exit;
if (!isset($details['username'])) {
    header('location: ../../web/logout.php');
}

// echo $_REQUEST['day_7'];

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $username  = $_REQUEST['username'];
    $firstname  = $_REQUEST['firstname'];
    $lastname  = $_REQUEST['lastname'];
    $phone  = $_REQUEST['phone'];
    $facility_code  = isset($_REQUEST['facility_code']) ? $_REQUEST['facility_code'] : null;
    $facility_name  = isset($_REQUEST['facility_name']) ? $_REQUEST['facility_name'] : null;
    $day_1 = isset($_REQUEST['day_1']) ? $_REQUEST['day_1'] : null;
    $day_2 = isset($_REQUEST['day_2']) ? $_REQUEST['day_2'] : null;
    $day_3 = isset($_REQUEST['day_3']) ? $_REQUEST['day_3'] : null;
    $day_4 = isset($_REQUEST['day_4']) ? $_REQUEST['day_4'] : null;
    $day_5 = isset($_REQUEST['day_5']) ? $_REQUEST['day_5'] : null;
    $day_6 = isset($_REQUEST['day_6']) ? $_REQUEST['day_6'] : null;
    $day_7 = isset($_REQUEST['day_7']) ? $_REQUEST['day_7'] : null;
    $user_lock = $_REQUEST['user_lock'];
    $role  = $_REQUEST['role'];

    // Remove the trailing comma (if any)
    $role = rtrim($role, ',');

    // Convert the string into an array
    $roleArray = explode(', ', $role);
    $operation = 'edit';
} else {
    $operation = 'new';
}

$roleArray = isset($roleArray) ? $roleArray : [];
?>

<style>
    #login_days>label {
        margin-right: 10px;
    }

    .asterik {
        color: red;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation == "edit") ? "Edit " : ""; ?>User Setup <div>
            <small style="font-size:12px">All asterik fields are compulsory</small>
        </div>
    </h4>
    <button type="button" class="close btn btn-dark" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="gateway.registerUser">
        <input type="hidden" name="reg_status" value="1">
        <input type="hidden" name="reg_type" value="0">
        <input type="hidden" name="route" value="<?php echo $operation === 'new' ? '/registerUser' : '/userEdit'; ?>">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">

        <div class="row" style="<?php echo ($operation == "edit") ? "display:none" : ""; ?>">
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Email<span class="asterik">*</span></label><small
                        style="float:right;color:red">This will be used to login</small>
                    <input type="text" name="email" <?php echo ($operation == "edit") ? "disabled" : ""; ?>
                        class="form-control" value="<?php echo ($operation == "edit") ? $username : ""; ?>"
                        placeholder="" autocomplete="off">

                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group ">
                    <label class="form-label" style="display:block !important">Password<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <input type="password" <?php echo ($operation == "edit") ? "disabled" : ""; ?> autocomplete="off"
                            name="password"
                            value=""
                            id="password" class="form-control" autocomplete="off" />
                        <div class="input-group-append"
                            style="cursor:pointer; <?php echo ($operation == "edit") ? "display:none" : ""; ?>">
                            <span class="input-group-text" id="show">Show</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        if ($operation == "edit") {
        ?>
            <input type="hidden" name="username" class="form-control" value="<?php echo $username; ?>" placeholder=""
                autocomplete="off">
        <?php
        }
        ?>
        <div class="row">
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">First Name<span class="asterik">*</span></label>
                    <input type="text" name="firstname"
                        value="<?php echo ($operation == "edit") ? $firstname : "" ?>" class="form-control"
                        autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Last Name<span class="asterik">*</span></label>
                    <input type="text" name="lastname"
                        value="<?php echo ($operation == "edit") ? $lastname : "" ?>" class="form-control"
                        autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Phone Number<span class="asterik">*</span></label>
                    <input type="number" name="mobile_phone"
                        value="<?php echo ($operation == "edit") ? $phone : "" ?>"
                        class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Gender<span class="asterik">*</span></label>
                    <select class="form-select" name="sex" id="sex">
                        <option value="male">
                            Male</option>
                        <option value="female">
                            Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Role(s)<span class="asterik">*</span></label>
                    <select name="role_id[]" id="role_id" multiple class="form-select">

                    </select>
                    <input type="hidden" class="form-control" placeholder="web look up" value="none" name="web_look_up"
                        autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Facility<span class="asterik">*</span></label>
                    <select class="form-select" name="facility_code" id="facility_code">
                        <?php echo ($operation == "edit") ? "<option selected value='" . $facility_code . "'>" . $facility_name . "</option>" : "<option value=''>Select Facility</option>" ?>

                    </select>
                    <input type="hidden" class="form-control" placeholder="web look up" value="none" name="web_look_up" autocomplete="off">
                </div>
            </div>
        </div>
        <div id="displayCompany">


        </div>


        <div class="row">
            <div class="col-sm-12 mt-2">
                <label for=""><b>Login Days</b></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            <div class="form-group" id="login_days">
    <label class="form-label" id="day1">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_1) && $day_1 == 1 ? "checked" : "") : "checked"; ?>
               name="day_1"> Sunday
    </label>
    <label class="form-label" id="day2">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_2) && $day_2 == 1 ? "checked" : "") : "checked"; ?>
               name="day_2"> Monday
    </label>
    <label class="form-label" id="day3">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_3) && $day_3 == 1 ? "checked" : "") : "checked"; ?>
               name="day_3"> Tuesday
    </label>
    <label class="form-label" id="day4">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_4) && $day_4 == 1 ? "checked" : "") : "checked"; ?>
               name="day_4"> Wednesday
    </label>
    <label class="form-label" id="day5">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_5) && $day_5 == 1 ? "checked" : "") : "checked"; ?>
               name="day_5"> Thursday
    </label>
    <label class="form-label" id="day6">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_6) && $day_6 == 1 ? "checked" : "") : "checked"; ?>
               name="day_6"> Friday
    </label>
    <label class="form-label" id="day7">
        <input type="checkbox"
               value="1"
               <?php echo (isset($operation) && $operation === 'edit') ? (isset($day_7) && $day_7 == 1 ? "checked" : "") : "checked"; ?>
               name="day_7"> Saturday
    </label>
</div>


            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <label for=""><b>Security Settings</b></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="form-group">
                <label class="form-label" id="user_locked">
        <input type="checkbox" value="<?php echo ($operation == 'edit') ? $user_lock : '0'; ?>" name="user_locked" id="user_locked" 
        <?php 
            if ($operation == 'edit') {
                // If the operation is 'edit', check if $user_lock is 1 (checked) or 0 (unchecked)
                echo ($user_lock == 1) ? 'checked' : '';
            } else {
                // If not 'edit', leave it unchecked by default
                echo '';
            }
        ?>>
        Lock User
    </label>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div id="server_mssg"></div>
            </div>
        </div>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-ahf waves-effect waves-light btn-lg">Add User</button>
    </form>
</div>
<script>
    var operation = "<?php echo $operation; ?>";

    function getRoles() {
        var route = "/roleList_simple";
        var data = {
            route
        };

        // Initialize Choices before making the API call
        const roleSelect = new Choices('#role_id', {
            removeItemButton: true,
            placeholder: true // Optional: To display a placeholder
        });

        $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            if (re.response_code == 200) {
                const $select = $('#role_id');
                $select.empty(); // Clear existing options

                // Populate the dropdown
                $.each(re.data, function(index, role) {
                    $select.append($('<option>', {
                        value: role.role_id,
                        text: role.role_name
                    }));
                });


                const selectedRoles = <?php echo json_encode($roleArray); ?>;

                // Refresh Choices.js to reflect new options
                roleSelect.setChoices(
                    re.data.map(role => ({
                        value: role.role_id,
                        label: role.role_name,
                        selected: operation === "edit" && selectedRoles.includes(role.role_name), // Check if role is in selectedRoles
                        disabled: false // Ensure options are enabled
                    })),
                    'value', // Value field
                    'label', // Label field
                    true // Allow duplication of items
                );



            } else {
                console.error('Failed to load roles:', re.message || 'Unknown error');
            }
        }, 'json');
    }

    getRoles();
    function saveRecord() {
    // Check required fields
    let isValid = true;
    const requiredFields = [
        { selector: "input[name='firstname']", message: "First Name is required." },
        { selector: "input[name='lastname']", message: "Last Name is required." },
        { selector: "input[name='mobile_phone']", message: "Phone Number is required." },
        { selector: "select[name='sex']", message: "Gender is required." },
        { selector: "select[name='role_id[]']", message: "At least one Role is required." },
        { selector: "select[name='facility_code']", message: "Facility is required." }
    ];

    // Loop through fields and validate
    for (const field of requiredFields) {
    const element = $(field.selector);
    const value = element.val(); // Get the field value
    if (element.length && (!value || (typeof value === "string" && value.trim() === ""))) {
        toastr.error(field.message, 'Validation Error', {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            extendedTimeOut: 3000,
            escapeHtml: true,
            tapToDismiss: false,
        });
        element.focus(); // Focus on the first invalid field
        isValid = false;
        break; // Stop further validation if a field is invalid
    }
}


    if (!isValid) return; // Prevent submission if validation fails

    // Serialize the form data
    var formData = $("#form1").serializeArray();
    var processedData = {};

    // Group multi-select field values as an array
    $.each(formData, function(_, field) {
        if (field.name.endsWith('[]')) {
            // Remove '[]' from the field name
            var key = field.name.replace('[]', '');
            if (!processedData[key]) {
                processedData[key] = [];
            }
            processedData[key].push(field.value);
        } else {
            // Process normal fields
            processedData[field.name] = field.value;
        }
    });

    console.log("Processed Data:", processedData);

    // Replace button text with loader
    $('#save_facility').html('<div class="table-loader-btn"></div> Processing...');
    $('#save_facility').prop('disabled', true); // Disable button

    // Send data to the back-end
    $.post("controllers/gateway.php", processedData, function(re) {
        console.log(re);

        if (re.response_code == 200) {
            // Success handling
            $("#save_facility").html('Add User').prop('disabled', false); // Reset button
            toastr.success(re.response_message, 'Success', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                extendedTimeOut: 3000,
                escapeHtml: true,
                tapToDismiss: false,
            });
            // getpage('modules/user/user_list.php', 'page');
            $("#defaultModal").modal("hide");
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
            table.draw();
        } else {
            // Error handling
            $("#save_facility").html('Add User').prop('disabled', false); // Reset button
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

    // function saveRecord() {
    //     // Serialize the form data
    //     var formData = $("#form1").serializeArray();
    //     var processedData = {};

    //     // Group multi-select field values as an array
    //     $.each(formData, function(_, field) {
    //         if (field.name.endsWith('[]')) {
    //             // Remove '[]' from the field name
    //             var key = field.name.replace('[]', '');
    //             if (!processedData[key]) {
    //                 processedData[key] = [];
    //             }
    //             processedData[key].push(field.value);
    //         } else {
    //             // Process normal fields
    //             processedData[field.name] = field.value;
    //         }
    //     });

    //     console.log("Processed Data:", processedData);
    //     // Replace button text with loader
    //     $('#save_facility').html('<div class="table-loader-btn"></div> Processing...');
    //     $('#save_facility').prop('disabled', true); // Disable button
    //     // Send data to the back-end
    //     $.post("controllers/gateway.php", processedData, function(re) {
    //         console.log(re);



    //         if (re.response_code == 200) {
    //             // Success handling
    //             $("#save_facility").html('Add User').prop('disabled', false); // Reset button
    //             toastr.success(re.response_message, 'Success', {
    //                 closeButton: true,
    //                 progressBar: true,
    //                 positionClass: 'toast-top-right',
    //                 timeOut: 3000,
    //                 extendedTimeOut: 3000,
    //                 escapeHtml: true,
    //                 tapToDismiss: false,
    //             });
    //             getpage('modules/user/user_list.php', 'page');
    //             $("#defaultModal").modal("hide");
    //             $('.modal-backdrop').remove();
    //             $('body').css('overflow', 'auto');
    //         } else {
    //             // Error handling
    //             $("#save_facility").html('Add User').prop('disabled', false); // Reset button
    //             toastr.error(re.response_message, 'Error', {
    //                 closeButton: true,
    //                 progressBar: true,
    //                 positionClass: 'toast-top-right',
    //                 timeOut: 3000,
    //                 extendedTimeOut: 3000,
    //                 escapeHtml: true,
    //                 tapToDismiss: false,
    //             });
    //         }
    //     }, 'json');
    // }

    function getFacility() {

        var route = "/fetchCodes";
        var data = {
            route
        };

        $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array

            const $select = $('#facility_code');
            $select.empty(); // Clear existing options
            $select.append($('<option>', {
                value: '',
                text: 'Select Facility'
            })); // Default option

            // Populate the dropdown
            $.each(re, function(index, role) {
                $select.append($('<option>', {
                    value: role.facility_code, // Set role_id as the value
                    text: role.hospital_name // Set role_name as the display text
                }));
            });

        }, 'json')
    }

   

    if (operation !== 'edit') {
        getFacility();
    }
   

    $("#show").click(function() {
        var password = $("#password").attr('type');
        if (password == "password") {
            $("#password").attr('type', 'text');
            $("#show").text("Hide");
        } else {
            $("#password").attr('type', 'password');
            $("#show").text("Show");
        }
    });

    function checkRole(value) {
        if (value == '0011') {
            //  $("#displayCompany").show();
            // $("#displayCompany").removeClass('d-none');
            $("#displayCompany").html(`
            <div class="form-group">
                <label for="">Company Name</label>
                <input type="text" class="form-control" placeholder="Company Name" name="company_name" autocomplete="off">
            </div>
        `);
            // alert('Company');

        } else {
            $("#displayCompany").html('');
        }
        // alert(value);
    }
</script>