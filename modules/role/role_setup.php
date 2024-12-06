<?php

$id = "";
if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation = 'edit';
} else {
    $operation = 'new';
}
?>

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Role Setup</h4>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="form1" onsubmit="return false" autocomplete="off">
    <div class="modal-body">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="hidden" name="route" value="/saveRole">
                    <input type="hidden" name="operation" value="<?php echo $operation; ?>">
                    <?php
                    if($operation == 'edit'){ ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php } ?>
                    <label class="form-label">Role Name</label>
                    <input type="text" autocomplete="off" name="role_name" id="role_name" value="" class="form-control"
                        autocomplete="off" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Enable Role</label>
                    <select name="role_enabled" id="role_enabled" class="form-control">

                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="err"></div>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-ahf mb-1">Submit</button>
    </div>
</form>
<script>
    function saveRecord() {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("controllers/gateway.php", dd, function(re) {
            $("#save_facility").text("Save");
            console.log(re);
            if (re.response_code == 200) {

                // $("#err").css('color', 'green')
                // $("#err").html(re.response_message)
                toastr.success(re.response_message, 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000, // Time in milliseconds
                    extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    escapeHtml: true,
                    tapToDismiss: false, // Prevent dismissing on click
                });
                getpage('modules/role/role_list.php', 'page');
                $("#defaultModal").modal("hide");
                $('.modal-backdrop').remove();
                $('body').css('overflow', 'auto');

            } else {
                // regenerateCORS();
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

        }, 'json')
    }
</script>