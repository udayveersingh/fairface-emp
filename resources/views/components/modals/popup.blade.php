@if (route_is(['projects','project-list']))
<!-- Create Project Modal -->
<div id="create_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('projects')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Project Name</label>
                                <input class="form-control" type="text" name="project_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Project Type<span class="text-danger">*</span></label>
                            <select name="project_type" class="form-control">
                                <option value="">Select Project Type</option>
                                <option value="internal">Internal</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contract_id</label>
                                <input class="form-control" type="text" name="contract_id">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client Name</label>
                                <input class="form-control" type="text" name="client_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Client Address<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_client_address" name="client_address" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Work Location</label>
                                <input class="form-control" type="text" name="work_location">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Start Date<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>End Date<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="end_date" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                            <label>Upload Files</label>
                            <input class="form-control" name="project_files[]" multiple type="file">
                        </div> -->
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Create Project Modal -->

<!-- Edit Project Modal -->
<div id="edit_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('projects')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Project Name</label>
                                <input class="form-control" id="edit_name" type="text" name="project_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Project Type<span class="text-danger">*</span></label>
                            <select name="project_type" selected="selected" id="edit_project_type" class="form-control">
                                <option value="">Select Project Type</option>
                                <option value="internal">Internal</option>
                                <option value="external">External</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contract id</label>
                                <input class="form-control" type="text" id="contract_id" name="contract_id">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client Name</label>
                                <input class="form-control" type="text" id="client_name" name="client_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Client Address<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="client_address" name="client_address" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Work Location</label>
                                <input class="form-control" type="text" name="work_location" id="work_location">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Start Date<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="edit_startdate" name="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>End Date<span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="end_date" id="edit_enddate" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                            <label>Upload Files</label>
                            <input class="form-control" name="project_files[]" multiple type="file">
                        </div> -->
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Project Modal -->
@endif

@if (route_is(['employees.attendance']))
<!-- Add Attendance Modal -->
<div class="modal custom-modal fade" id="add_attendance" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employees.attendance')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Employee</label>
                        <select name="employee" class="select2">
                            <option value="null">Select Employee</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Checkin Time <span class="text-danger">*</span></label>
                        <input type="time" name="checkin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Checkout Time <span class="text-danger">*</span></label>
                        <input name="checkout" class="form-control" type="time">
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Attendance Modal -->

<!-- Edit Attendance Modal -->
<div class="modal custom-modal fade" id="edit_attendance" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employees.attendance')}}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Employee</label>
                        <select name="employee" id="edit_employee" class="select2">
                            <option value="null">Select Employee</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Checkin Time <span class="text-danger">*</span></label>
                        <input type="time" name="checkin" id="edit_checkin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Checkout Time <span class="text-danger">*</span></label>
                        <input name="checkout" id="edit_checkout" class="form-control" type="time">
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Attendance Modal -->
@endif