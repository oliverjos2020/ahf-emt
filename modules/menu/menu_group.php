<?php
include_once("../../libs/dbfunctions.php");
$dbobject = new dbobject();

$sql_role = "SELECT * FROM role order by role_name";
//$sql_role = "SELECT * FROM role";

$roles = $dbobject->db_query($sql_role);


if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation  = 'edit';
    $id  = $_REQUEST['id'];
} else {
    $operation = 'new';
}
?>

<input type="hidden" name="op" value="Church.saveChurchType">
<input type="hidden" name="operation" value="<?php echo $operation; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<div class="row">
    <div class="col-sm-12">
        <!--               System Administrator-->
    </div>
</div>

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">User Roles</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
<div class="modal-body m-3 ">
    <div class="form-group">
        <select name="roles" id="role_id" onchange="loadMenus(this.value)" class="form-control">
            <option value="">:: SELECT ROLE ::</option>
            <?php
            foreach ($roles as $row) {
                echo "<option value='" . $row['role_id'] . "'>" . $row['role_name'] . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <label for="visible-menu">Visible Menu</label>
            <form action="" id="form1" style="width:100%">
                <div id="div1" class="form-group" ondrop="drop(event)" ondragover="allowDrop(event)">

                </div>
            </form>
        </div>

        <div class="col-md-6">
            <label for="invisible-menu">Invisible Menu</label>
            <form action="" style="width:100%">
                <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button id="save_facility" onclick="saveRecord()" class="btn btn-primary">Save</button>
</div>





<style>
    #div1 {
        width: 100%;
        height: 300px;
        margin: 10px;
        padding: 10px;
        overflow-y: scroll;
        border: 1px solid #333;
        /* border-radius:15px; */
        box-shadow: 2px 2px 2px solid #333;
    }

    #div2 {
        width: 100%;
        height: 300px;
        margin: 10px;
        overflow-y: scroll;
        padding: 10px;
        border: 1px solid #333;
    }

    #div1 .form-group {
        background: #306450;
        color: #fff;
        padding: 10px
    }

    #div2 .form-group {
        background: #f44455;
        color: #fff;
        padding: 10px
    }
</style>
<script>
    function saveRecord() {
        var role = $("#role_id").val();
        if (role != "") {
            $("#save_facility").text("Loading......");
            var dd = $("#form1").serialize();
            console.log(dd);

            // $.post("utilities.php?op=Menu.saveMenuGroup&role_id=" + $("#role_id").val(), dd, function(re) {
            $.post("web/router.php?op=Menu.saveMenuGroup&role_id=" + $("#role_id").val(), dd, function(re) {
                $("#save_facility").text("Save");
                console.log(re);
                if (re.response_code == 0)
                    // alert(re.response_message)
                    toastr.success(re.response_message, 'Success', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
                else
                    toastr.error(re.response_message, 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000, // Time in milliseconds
                        extendedTimeOut: 3000, // Additional time for the progress bar to complete
                        escapeHtml: true,
                        tapToDismiss: false, // Prevent dismissing on click
                    });
            }, 'json')
        } else {
            alert("Please select a menu");
        }

    }

    function loadMenus(el) {
        //        $.blockUI();
        $.post('web/router.php', {
            op: 'Menu.loadmenus',
            role_id: el
        }, function(res) {
            //            $.unblockUI();
            $('#div1').html(res.data.visible);
            $('#div2').html(res.data.invisible);
        }, 'json');
    }
</script>
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
    }
</script>