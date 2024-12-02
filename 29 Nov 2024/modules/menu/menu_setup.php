

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Menu Setup</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="Menu.saveMenu">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="id" value="<?php echo ($operation == 'edit') ? $menu_id : ""; ?>">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Menu Name</label>
                    <input type="text" autocomplete="off" name="menu_name" onkeyup="validateCode(this.value)"
                        value="<?php echo ($operation == 'edit') ? $menu[0]['menu_name'] : ""; ?>" class="form-control"
                        autocomplete="off" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Menu URL</label>
                    <input type="text" name="menu_url" class="form-control"
                        value="<?php echo ($operation == 'edit') ? $menu[0]['menu_url'] : ""; ?>" placeholder=""
                        autocomplete="off">
                </div>
            </div>
        </div>


        <?php
        if ($operation == 'edit' || $operation == 'new') {
            $rr = new menu();
            $p = $rr->loadParentMenu("");
        } else {
        }
        ?>


        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="form-group">
                    <label class="form-label">Set Parent Menu</label>
                    <select name="parent_id" class="form-control">
                        <option hidden value="">Select menu</option>
                        <option value="#"
                            <?php echo (isset($menu[0]['parent_id']) && $menu[0]['parent_id'] == "#") ? "selected" : ""; ?>>
                            :: This menu is a parent menu::</option>
                        <?php

                        if ($p['response_code'] == "0") {
                            foreach ($p['data'] as $key) {
                                $selected = ($key[0] == $menu[0]['parent_id']) ? "selected" : "";
                        ?>
                                <option <?php echo $selected; ?> value="<?php echo $key[0]; ?>"><?php echo $key[1]; ?></option>
                        <?php
                            }
                        }
                        ?>

                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div id="err"></div>
            <button id="save_facility" onclick="saveRecord()" class="btn btn-primary mb-1">Submit</button>
        </div>
    </form>
    <script>
        function saveRecord() {
            $("#save_facility").text("Loading......");
            var dd = $("#form1").serialize();
            $.post("web/router.php", dd, function(re) {
                $("#save_facility").text("Save");
                console.log(re);
                if (re.response_code == 0) {

                    // $("#err").css('color', 'green')
                    // $("#err").html(re.response_message)
                    // alert(re.response_message);
                    toastr.success(re.response_message, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                    getpage('modules/menu/menu_list.php', 'page');
                    $("#defaultModal").modal("hide");
                    $('.modal-backdrop').remove();
                    $('body').css('overflow', 'auto');

                } else {
                    regenerateCORS();
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