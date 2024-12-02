<style>
    .filter-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 15px;
    }

    .filter-label {
      margin-right: 10px;
    }

    /* Make input fields, selects, and textareas have thick borders */
    .form-control,
    .form-select,
    textarea {
        border: 0.5px solid #000 !important;
        /* Dark and visible borders */
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Missed Appointments</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Missed Appointments</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="title">Missed Appointments List</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="filter-container">
                            <label for="" class="me-3">Tracked Status: </label>
                            <select name="" id="" class="form-select w-50 border border-dark">
                            <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                </div>

                <table id="page_list" class="table table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>Patient Name</th>
                            <th>Missed Date</th>
                            <th>Assigned Tracker</th>
                            <th>Assign Date</th>
                            <th>Phone No</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Action</th>
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
<a class="btn btn-ahf btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal" href="javascript:void(0)">
                            <i class="fas fa-plus"></i> Assign Tracker
</a>
<!-- Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Trackers to Patients</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <label for="trackerName" class="col-sm-3 col-form-label">Select Tracker:</label>
                        <div class="col-sm-9">
                           <select name="trackerName" id="" class="form-select">
                            <option value="">Select Tracker</option>
                           </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ahf btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf btn-lg">Assign Tracker</button>
            </div>
        </div>
    </div>
</div>