<?php
require_once('../../controllers/cookieManager.php');
$cookieManager = new cookieManager();
$details = $cookieManager->pickCookie();
// print_r($details);exit;
if (!isset($details['username'])) {
    header('location: ../../web/logout.php');
}

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $username  = $_REQUEST['username'];
    $firstname  = $_REQUEST['firstname'];
    $lastname  = $_REQUEST['lastname'];
    $phone  = $_REQUEST['phone'];
    $operation = 'edit';
} else {
    $operation = 'new';
}
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
        <!-- <input type="hidden" name="route" value="registerUser"> -->
        <!-- <input type="hidden" name="token" value="WWtOVURsQWl0QlcwNzlYeEZoeVk4a2JPcUphVXdPVDVObUV6ckNYZ3FuZEJoYXM3dU95RjJSUG56WGFKYmtOU0Q1N2ZSZnRIME9FUjhSWERvV3VqaFUxYnFkVm5DVDlub0NReE5aa0d2NzVqNkYvQUxENi9RdTgwRTR3VGxvSll4ZGJGZmFpOVJjMzY4S0pnZWVzTm5meU5tL2VmQUNKVXNVUUtLczhpSDU0PTo6xLYp7JuA"> -->
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
                            value="<?php echo ($operation == "edit") ? $church[0]['date_of_inception'] : ""; ?>"
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
                    <select class="form-control" name="sex" id="sex">
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
                    <label class="form-label">Role<span class="asterik">*</span></label>
                    <select class="form-control" name="role_id" id="role_id">
                        <option value="">Select Role</option>
                    </select>
                    <input type="hidden" class="form-control" placeholder="web look up" value="none" name="web_look_up"
                        autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Facility<span class="asterik">*</span></label>
                    <select class="form-control" name="facility_code" id="facility_code">
                        <option value="">Select Facility</option>
                    </select>
                    <input type="hidden" class="form-control" placeholder="web look up" value="none" name="web_look_up"
                        autocomplete="off">
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
                    <label class="form-label" id="day1"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_1']) ? $user[0]['day_1'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_1'])) ? ($user[0]['day_1'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_1"> Sunday</label>
                    <label class="form-label" id="day2"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_2']) ? $user[0]['day_2'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_2'])) ? ($user[0]['day_2'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_2"> Monday</label>
                    <label class="form-label" id="day3"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_3']) ? $user[0]['day_3'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_3'])) ? ($user[0]['day_3'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_3"> Tuesday</label>
                    <label class="form-label" id="day4"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_4']) ? $user[0]['day_4'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_4'])) ? ($user[0]['day_4'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_4"> Wednesday</label>
                    <label class="form-label" id="day5"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_5']) ? $user[0]['day_5'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_5'])) ? ($user[0]['day_5'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_5"> Thursday</label>
                    <label class="form-label" id="day6"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_6']) ? $user[0]['day_6'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_6'])) ? ($user[0]['day_6'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_6"> Friday</label>
                    <label class="form-label" id="day7"><input type="checkbox"
                            value="<?php echo isset($user[0]['day_7']) ? $user[0]['day_7'] : '1'; ?>"
                            <?php echo (isset($user[0]['day_7'])) ? ($user[0]['day_7'] == 0) ? "" : "checked" : "checked"; ?>
                            name="day_7"> Saturday</label>
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
                    <label class="form-label" id="day1">
                        <input type="checkbox" value="" name="user_locked" id="day1"> Lock User</label>
                    <!-- <label class="form-label" id="day1"><input type="checkbox" value="<?php echo isset($user[0]['passchg_logon']) ? $user[0]['passchg_logon'] : '1'; ?><?php echo isset($user[0]['passchg_logon']) ? $user[0]['passchg_logon'] : '1'; ?>" name="passchg_logon" <?php echo (isset($user[0]['passchg_logon'])) ? ($user[0]['passchg_logon'] == 0) ? "" : "checked" : "checked"; ?> id="passchg_logon"> Change password on first login</label> -->
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div id="server_mssg"></div>
            </div>
        </div>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    function saveRecord() {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("controllers/gateway.php", dd, function(re) {
            console.log(re);
            $("#save_facility").text("Save");
            if (re.response_code == 200) {
                toastr.success(re.response_message, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
                getpage('modules/user/user_list.php', 'page');
                $("#defaultModal").modal("hide");
                $('.modal-backdrop').remove();
                $('body').css('overflow', 'auto');

            } else {
                regenerateCORS();
                // $("#server_mssg").text(re.response_message);
                toastr.error(re.response_message, 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
            }

        }, 'json');
    }

    function getRoles() {

        var route = "/roleList_simple";
        var data = {
            route
        };

        $.post("controllers/gateway.php", data, function(re) {
            console.log(re); // Debug: Log the API response

            // Ensure re is an array
            if (re.response_code == 200) {
                const $select = $('#role_id');
                $select.empty(); // Clear existing options
                $select.append($('<option>', {
                    value: '',
                    text: 'Select Role'
                })); // Default option

                // Populate the dropdown
                $.each(re.data, function(index, role) {
                    $select.append($('<option>', {
                        value: role.role_id, // Set role_id as the value
                        text: role.role_name // Set role_name as the display text
                    }));
                });
            } else {

            }

        }, 'json')
    }

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
    
    getRoles();
    getFacility();

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