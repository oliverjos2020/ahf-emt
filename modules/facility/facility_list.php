<?php
include_once("../../libs/dbfunctions.php");
$dbobject = new dbobject();

?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Facility</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Facility</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- <h4 class="card-title">Default Datatable</h4>
                <p class="card-title-desc">DataTables has most features enabled by default, so all
                    you need to do to use it with your own tables is to call the construction
                    function: <code>$().DataTable();</code>.
                </p> -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title"><br><a class="btn btn-ahf btn-sm"
                                onclick="myLoadModal('modules/facility/facility_setup','modal_div')"
                                href="javascript:void(0)">Create Facility</a>
                        </h4>
                        <p>The report contains Menus that have been setup in the system.</p>
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

<div class="modal fade bs-example-modal-lg" id="defaultModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_div">

        </div>
    </div>
</div>

<!--<script src="../js/sweet_alerts.js"></script>-->
<!--<script src="../js/jquery.blockUI.js"></script>-->
<script>
    var table;
    var editor;
    var op = "Menu.menuList";
    $(document).ready(function() {
        table = $("#page_list").DataTable({
            processing: true,
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            serverSide: true,
            paging: true,
            oLanguage: {
                sEmptyTable: "No record was found, please try another query"
            },

            ajax: {
                url: "web/router.php",
                type: "POST",
                data: function(d, l) {
                    d.op = op;
                    d.li = Math.random();
                    //          d.start_date = $("#start_date").val();
                    //          d.end_date = $("#end_date").val();
                }
            }
        });
    });

    function do_filter() {
        table.draw();
    }

    function closeModal() {
        $("#defaultModal").modal("hide");
    }

    function deleteMenu(id) {
        let cnf = confirm("Are you sure you want to delete menu?");
        if (cnf == true) {
            $.blockUI();
            $.ajax({
                url: "web/router.php",
                data: {
                    op: "Menu.deleteMenu",
                    menu_id: id
                },
                type: "post",
                dataType: "json",
                success: function(re) {
                    $.unblockUI();
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
                    getpage('modules/menu/menu_list.php', "page");
                },
                error: function(re) {
                    $.unblockUI();
                    // alert("Request could not be processed at the moment!");
                    toastr.error("Request could not be processed at the moment!", 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                }
            });
        }

    }

    function getModal(url, div) {
        //        alert('dfd');
        $('#' + div).html("<h2>Loading....</h2>");
        //        $('#'+div).block({ message: null });
        $.post(url, {}, function(re) {
            $('#' + div).html(re);
        })
    }
</script>