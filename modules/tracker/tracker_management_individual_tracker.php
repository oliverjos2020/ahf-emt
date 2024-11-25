<style>
    .inner-card {
        border: 1px solid pink;
        border-radius: 2px;
        /* squared edges */
        padding: 15px;
        text-align: center;
        height: 100%;
    }

    .header {
        margin-bottom: 10px;
        text-align: left;
    }

    .amount-icon {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1em;
        margin-top: 10px;
        color: #555;
    }

    .icon {
        font-size: 20px;
        color: #991002;
    }

    .filter-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin-bottom: 15px;
    }

    .filter-label {
      margin-right: 10px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Tracker Management</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tracker Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<a class="btn btn-ahf btn-sm" data-bs-toggle="modal" data-bs-target="#followUpModal" href="javascript:void(0)">
                            <i class="fas fa-plus"></i> Follow Up
</a>
<div class="row">
    <div class="card p-4">
        <div class="filter-container">
            <label for="date-filter" class="filter-label">Filter By:</label>
            <input type="date" id="date-filter" class="form-control w-auto">
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-3">
            <div class="col">
                <div class="inner-card">
                    <div class="header">Total Assigned Patients</div>
                    <div class="amount-icon">
                        <div class="amount">100</div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner-card">
                    <div class="header">Total Pending Patients</div>
                    <div class="amount-icon">
                        <div class="amount">200</div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner-card">
                    <div class="header">Total Patients in Progress</div>
                    <div class="amount-icon">
                        <div class="amount">300</div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="inner-card">
                    <div class="header">Total Patients Treated</div>
                    <div class="amount-icon">
                        <div class="amount">400</div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
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
                        <h4 class="title">Patients List</h4>
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
                            <th>S/N</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Patient ID</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
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

<!--Follow Up Modal -->
<div class="modal fade" id="followUpModal" tabindex="-1" aria-labelledby="followUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followUpModalLabel">Follow-Up Status Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <label for="trackerName" class="col-sm-3 col-form-label">Date Of Follow-Up Contact</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="followUpDate">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="followUpContactMethod" class="col-sm-3 col-form-label">Follow-Up Contact Method</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="followUpContactMethod" placeholder="Input method used for follow-up">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="outcome" class="col-sm-3 col-form-label">Outcome of Follow-Up</label>
                        <div class="col-sm-9">
                            <select class="form-select border border-grey" id="outcome">
                                <option value="" selected>Select follow-up outcome</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nextSteps" class="col-sm-3 col-form-label">Next Steps</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nextSteps" placeholder="Write next steps to be carried out if necessary">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ahf btn-lg" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-ahf btn-lg">Save Status</button>
            </div>
        </div>
    </div>
</div>