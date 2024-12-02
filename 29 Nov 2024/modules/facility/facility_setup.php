<?php
if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation = 'edit';
    $menu_id = $_REQUEST['menu_id'];
} else {
    $operation = 'new';
}
?>

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Facility Setup</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <!-- <input type="hidden" name="op" value="Menu.saveMenu"> -->
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Facility Name</label>
                    <input type="text" autocomplete="off" name="facility_name"
                        value="<?php echo ($operation == 'edit') ? $facility_name : ""; ?>" class="form-control"
                        autocomplete="off" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Facility Code</label>
                    <input type="text" autocomplete="off" name="facility_code"
                        value="<?php echo ($operation == 'edit') ? $facility_code : ""; ?>" class="form-control"
                        autocomplete="off" />
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <label class="form-label">State</label>
                    <select name="state" id="state" class="form-control" onchange="getLGA(this.value)">
                        <option value="">Select State</option>
                        <?php
                            foreach($states as $state):
                                echo "<option value='$state[state]'?>$state[state]</option>";
                            endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <label class="form-label">L.G.A</label>
                    <select name="lga" id="lga" class="form-control">
                        <option value="">Select LGA</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Facility Phone Number</label>
                <input type="number" name="contactNumber" id="contactNumber" class="form-control">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">GPS Coordinates/Map</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Satelite Site Connected</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Address</label>
                <textarea name="faclilityAddress" id="faclilityAddress" class="form-control"></textarea>
            </div>
        </div>


        <div class="modal-footer">
            <div id="err"></div>
            <button id="save_facility" onclick="saveRecord()" class="btn btn-ahf">Submit</button>
        </div>
    </form>
    <script>
        function getLGA(state)
        {
            $.ajax({
                url: "web/router.php",
                data: {
                    op: "Facility.getLGA",
                    state
                },
                type: "post",
                // dataType: "json",
                success: function(re) {
                  
                },
                error: function(re) {
                    // $.unblockUI();
                    // // alert("Request could not be processed at the moment!");
                    // toastr.error("Request could not be processed at the moment!", 'Error', {
                    //     closeButton: true,
                    //     progressBar: true,
                    //     positionClass: 'toast-top-right',
                    //     timeOut: 3000, // Time in milliseconds
                    //     extendedTimeOut: 3000, // Additional time for the progress bar to complete
                    //     escapeHtml: true,
                    //     tapToDismiss: false, // Prevent dismissing on click
                    // });
                }
            });
        }
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
                    getpage('modules/facility/facility_setup.php', 'page');
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