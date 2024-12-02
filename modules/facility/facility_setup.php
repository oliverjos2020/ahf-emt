<?php
if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation = 'edit';
    $menu_id = $_REQUEST['menu_id'];
} else {
    $operation = 'new';
}
?>
<style>

</style>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Facility Setup</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <!-- <input type="hidden" name="op" value="Menu.saveMenu"> -->
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="route" value="/setupFacility">
        <input type="hidden" name="source" value="web">
        <input type="hidden" name="country" value="Nigeria">
        <input type="hidden" name="webAccess" value="0">
        <input type="hidden" name="country_code" value="234">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Facility Name</label>
                    <input type="text" autocomplete="off" name="facilityName"
                        value="<?php echo ($operation == 'edit') ? $facility_name : ""; ?>" class="form-control"
                        autocomplete="off" />
                </div>
            </div>
            <div class="col-md-12 mt-2">
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
                    <select name="state" id="state" class="form-control">
                        <option value="">Select State</option>
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
                <label class="form-label">Contact Officer</label>
                <input type="text" name="contactOfficer" id="contactOfficer" class="form-control">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">Facility Phone Number</label>
                <input type="number" name="contactNumber" id="contactNumber" class="form-control">
            </div>
            <div class="col-md-12 mt-2">
                <label class="form-label">GPS Coordinates/Map</label>
                <div class="input-group">
        <input type="text" id="gps-coordinates" class="form-control" placeholder="Enter or select coordinates">
        <button class="btn btn-ahf" type="button" id="map-picker-btn" onclick="openMapPicker()">
            <i class="bx bx-map"></i>
        </button>
    </div>
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
        function getStates() {
            $.ajax({
                url: "controllers/gateway.php",
                data: {
                    route: "/statesData"
                },
                type: "post",
                success: function(response) {
                    try {
                        // Parse the response if it's not already a JSON object
                        const data = typeof response === 'string' ? JSON.parse(response) : response;

                        // Populate the #states dropdown
                        let stateOptions = '<option value="">Select State</option>';
                        data.forEach(state => {
                            stateOptions += `<option value="${state.state_name}">${state.state_name}</option>`;
                        });
                        $('#state').html(stateOptions);

                        // Add change event listener to populate LGAs
                        $('#state').on('change', function() {
                            const selectedStateName = $(this).val();

                            if (selectedStateName) {
                                // Find the selected state object
                                const selectedState = data.find(state => state.state_name === selectedStateName);

                                if (selectedState && selectedState.lgas) {
                                    // Populate the #lgas dropdown
                                    let lgaOptions = '<option value="">Select LGA</option>';
                                    selectedState.lgas.forEach(lga => {
                                        lgaOptions += `<option value="${lga.lga_name}">${lga.lga_name}</option>`;
                                    });
                                    $('#lga').html(lgaOptions);
                                } else {
                                    $('#lga').html('<option value="">No LGAs Found</option>');
                                }
                            } else {
                                // Reset LGAs if no state is selected
                                $('#lga').html('<option value="">Select LGA</option>');
                            }
                        });
                    } catch (err) {
                        console.error("Error processing response:", err);
                        toastr.error("Unable to load states. Please try again.", "Error", {
                            closeButton: true,
                            progressBar: true,
                        });
                    }
                },
                error: function() {
                    toastr.error("Request could not be processed at the moment!", "Error", {
                        closeButton: true,
                        progressBar: true,
                        positionClass: "toast-top-right",
                        timeOut: 3000,
                        extendedTimeOut: 3000,
                        escapeHtml: true,
                        tapToDismiss: false,
                    });
                },
            });
        }

        getStates();


        function saveRecord() {
            $("#save_facility").text("Loading......");
            var dd = $("#form1").serialize();
            $.post("controllers/gateway.php", dd, function(re) {
                $("#save_facility").text("Save");
                console.log(re);
                if (re.response_code == 200) {

                    // $("#err").css('color', 'green')
                    // $("#err").html(re.response_message)
                    // alert(re.response_message);
                    toastr.success(re.response_message, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 5000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                    getpage('modules/facility/facility_list.php', 'page');
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