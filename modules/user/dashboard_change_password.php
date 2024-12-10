<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Menu</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Menu</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center">Change Password</h4>
                <!-- Login Form -->
                <!-- <form> -->
                <label for="username" class="form-label">New Password</label>
                <input type="password" class="form-control" placeholder="New Password" name="password" id="password"
                    required>

                <label for="username" class="form-label mt-2">Confirm Password</label>
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password"
                    id="confirm_password" required>
                <button type="submit" id="resetBtn" onclick="resetPassword()" class="btn btn-ahf w-100 mt-3">Change
                    Password</button>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>