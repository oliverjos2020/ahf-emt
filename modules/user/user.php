<?php
include_once("../../libs/dbfunctions.php");
$dbobject = new dbobject();
// $user_role = $_SESSION['role_id_sess'];
$user_role = "001";
// $where = "";
// if ($user_role == '029') {
//     $where = "  AND role_id IN ('0011','012')";
// }

$sql_role = "SELECT * FROM role WHERE role_id ";
$role = $dbobject->db_query($sql_role);


$get_role_name = $dbobject->getitemlabel('role', 'role_id', $user_role, 'role_name');

$roles = $dbobject->db_query($sql_role);

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $username  = $_REQUEST['username'];
    $get_merchant = $dbobject->db_query("SELECT * FROM userdata WHERE username='$username'");

    $user      = $dbobject->db_query("SELECT * FROM userdata WHERE username='$username'");
    $operation = 'edit';
    $sql = "SELECT role_id FROM user_role WHERE user_id = '$username'";
    $query = $dbobject->db_query($sql, true);

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
        <input type="hidden" name="op" value="Users.saveUser">
        <input type="hidden" name="reg_status" value="1">
        <input type="hidden" name="reg_type" value="0">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <div class="row" style="<?php echo ($operation == "edit") ? "display:none" : ""; ?>">
            <div class="col-sm-6">
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
                        value="<?php echo ($operation == "edit") ? $user[0]['firstname'] : "" ?>" class="form-control"
                        autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Last Name<span class="asterik">*</span></label>
                    <input type="text" name="lastname"
                        value="<?php echo ($operation == "edit") ? $user[0]['lastname'] : "" ?>" class="form-control"
                        autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Phone Number<span class="asterik">*</span></label>
                    <input type="number" name="mobile_phone"
                        value="<?php echo ($operation == "edit") ? $user[0]['mobile_phone'] : "" ?>"
                        class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                <div class="form-group">
                    <label class="form-label">Gender<span class="asterik">*</span></label>
                    <select class="form-control" name="sex" id="sex">
                        <option value="male"
                            <?php echo ($operation == "edit") ? (($user[0]['sex'] == "male") ? "selected" : "") : ""; ?>>
                            Male</option>
                        <option value="female"
                            <?php echo ($operation == "edit") ? (($user[0]['sex'] == "female") ? "selected" : "") : ""; ?>>
                            Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="form-group">
                    <label class="form-label">Role<span class="asterik">*</span></label>
                    <select class="form-control" multiple onchange="checkRole(this.value)" name="role_id[]">
                        <!-- <option value="">Select Role</option> -->
                        <?php
                        // print_r($role);
                           if (is_array($role)) {
                            // Extract role_id values from $query
                            $queryRoleIds = [];
                            if (is_array($query)) {
                            $queryRoleIds = array_column($query, 'role_id');
                            }
                            foreach ($role as $rows) {
                                $selected = in_array($rows['role_id'], $queryRoleIds) ? 'selected' : '';
                                echo "<option $selected value='" . $rows['role_id'] . "'>" . $rows['role_name'] . "</option>";
                            }
                        }
                        
                        ?>
                    </select>
                    <input type="hidden" class="form-control" placeholder="web look up" value="none" name="web_look_up"
                        autocomplete="off">
                </div>
            </div>
            <!-- <div class="col-sm-12 mt-3 mb-3">
                
            </div> -->
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
                    <label class="form-label" id="day1"><input type="checkbox"
                            value="<?php echo isset($user[0]['user_locked']) ? $user[0]['user_locked'] : '0'; ?>"
                            <?php echo (isset($user[0]['user_locked'])) ? ($user[0]['user_locked'] == 0) ? "" : "checked" : ""; ?>
                            name="user_locked" id="day1"> Lock User</label>
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
        $.post("web/router.php", dd, function(re) {
            console.log(re);
            $("#save_facility").text("Save");
            if (re.response_code == 0) {
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
    if ($("#sh_display").is(':checked')) {

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