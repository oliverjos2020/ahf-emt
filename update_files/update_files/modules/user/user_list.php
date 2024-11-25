<?php
include_once("../../libs/dbfunctions.php");
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">User</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">User</li>
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
                    <div class="col-md-12">
                        <h4 class="card-title"><br><a class="btn btn-ahf btn-sm"
                                onclick="myLoadModal('modules/user/user.php','modal_div')"
                                href="javascript:void(0)">Create User</a>
                        </h4>
                    </div>

                </div>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                        <tr role="row">
                                <th>S/N</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <!-- <th>Username</th> -->
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Login Status</th>
                                <th>Action</th>
                                <th>Action</th>
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
var op = "gateway.userlist";
$(document).ready(function() {
    table = $("#page_list").DataTable({
        processing: true,
        columnDefs: [{
                orderable: false,
                targets: 0
            },
            {
                width: "3100",
                targets: "3"
            }
        ],
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

            }
        }
    });
});

function do_filter() {
    table.draw();
}

function trigUser(user, status) {
    var r_status = (status == 1) ? "Unlock this user" : "Lock this user";
    var cnf = confirm("Are you sure you want to " + r_status + " this user ?");
    if (cnf) {
        $.blockUI();
        $.post('web/router.php', {
            op: 'Users.changeUserStatus',
            current_status: status,
            username: user
        }, function(resp) {
            $.unblockUI();
            if (resp.response_code == 0) {
                //                           alert(resp.response_message);
                getpage('modules/user/user_list.php', 'page');
            }

        }, 'json')
    }
}

function sackUser(username_1, status_1) {
    let tt = confirm("Are you sure you want to perform this action");
    if (tt) {
        $.post("web/router.php", {
            op: "Users.sackUser",
            username: username_1,
            status: status_1
        }, function(rr) {
            alert(rr.response_message);
            getpage('modules/user/user_list.php', 'page');
        }, 'json');
    }
}

function getModal(url, div) {
    $('#' + div).html("<h2>Loading....</h2>");
    //        $('#'+div).block({ message: null });
    $.post(url, {}, function(re) {
        $('#' + div).html(re);
    })
}
</script>