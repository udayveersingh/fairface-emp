<div class="row align-items-center mb-2">
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_job"><i class="fa fa-plus"></i> Add Employee Job</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>supervisor </th>
                    <th>Timesheet Approval Incharge </th>
                    <th>Job Title</th>
                    <th>Job Type</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($employee_jobs->count()))
                @foreach ($employee_jobs as $job)
                <tr>
                    @php
                    if(!empty($job->supervisor)){
                    $supervisor = App\Models\Employee::find($job->supervisor);
                    $supervisor_name = $supervisor->firstname ." ". $supervisor->lastname;
                    }else{
                    $supervisor_name='';
                    }
                    if(!empty($job->timesheet_approval_incharge)){
                    $timesheet_approval_incharge = App\Models\Employee::find($job->timesheet_approval_incharge);
                    $incharge_name = $timesheet_approval_incharge->firstname ." ". $timesheet_approval_incharge->lastname;
                    }else{
                    $incharge_name = "";
                    }
                    @endphp
                    <td>{{$job->id}}</td>
                    <td>{{$supervisor_name}}</td>
                    <td>{{$incharge_name}}</td>
                    <td>{{$job->job_title}}</td>
                    <td>{{str_replace("_"," ",$job->job_type)}}</td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$job->id}}" data-resource_data="Employee Job" class="dropdown-item deletebtn" href="javascript:void(0);" data-target="data_delete_modal" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                <a data-id="{{$job->id}}" data-employee_id="{{$job->employee_id}}" data-supervisor="{{$job->supervisor }}" data-timesheet_approval_inch="{{$job->timesheet_approval_incharge}}" data-job_title="{{$job->job_title}}" data-department="{{$job->department_id}}" data-work_email="{{$job->work_email}}" data-work_phone_number="{{$job->work_phone_number}}" data-start_date="{{$job->start_date}}" data-job_type="{{$job->job_type}}" data-cont_weekly_hours="{{$job->contracted_weekly_hours}}" class="dropdown-item edit_btn" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<!-- Add Employee Job Modal -->
<div id="add_employee_job" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-job.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee Id<span class="text-danger">*</span></label>
                                <input class="form-control" value="{{$employee->employee_id}}" name="employee_id" id="" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Title<span class="text-danger">*</span></label>
                                <input class="form-control" name="job_title" id="job_title" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Supervisor<span class="text-danger">*</span></label>
                                <select name="supervisor" id="supervisor" class="form-control">
                                    <option value="">Select Supervisor</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->firstname ." ".$employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                                <select name="timesheet_approval_inch" id="" class="form-control">
                                    <option value="">Select Approval Incharge</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->firstname ." ".$employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Department<span class="text-danger">*</span></label>
                                <select name="department" id="department" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Work Email<span class="text-danger">*</span></label>
                                <input class="form-control" name="work_email" id="work_email" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Work Phone Number</label>
                                <input class="form-control mask_phone_number" name="work_phone_number" id="phone_number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" name="start_date" id="start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Type<span class="text-danger">*</span></label>
                                <select name="job_type" id="job_type" class="form-control">
                                    <option value="">Select Job Type</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Contracted Weekly Hours</label>
                                <input class="form-control" name="contract_weekly_hours" id="" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  Add Employee Job Modal -->
<!-- Edit Employee Job Modal -->
<div id="edit_employee_job" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-job.update')}}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <input type="hidden" id="edit_job_id" name="edit_id">
                        <input type="hidden" id="employee_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee Id<span class="text-danger">*</span></label>
                                <input class="form-control" value="{{$employee->employee_id}}" name="employee_id" id="" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Title<span class="text-danger">*</span></label>
                                <input class="form-control" name="job_title" value="" id="edit_job_title" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Supervisor<span class="text-danger">*</span></label>
                                <select name="supervisor" id="edit_supervisor" class="form-control">
                                    <option value="">Select Supervisor</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->firstname ."".$employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                                <select name="timesheet_approval_inch" id="timesheet_approval_inch" class="form-control">
                                    <option value="">Select Approval Incharge</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->firstname ." ".$employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Department<span class="text-danger">*</span></label>
                                <select name="department" id="edit_department" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Work Email<span class="text-danger">*</span></label>
                                <input class="form-control" name="work_email" id="edit_work_email" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Work Phone Number</label>
                                <input class="form-control mask_phone_number" name="work_phone_number" id="edit_phone_number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" name="start_date" id="edit_start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Type<span class="text-danger">*</span></label>
                                <select name="job_type" id="edit_job_type" class="form-control">
                                    <option value="">Select Job Type</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Contracted Weekly Hours</label>
                                <input class="form-control" name="contract_weekly_hours" id="contracted_weekly_hours" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Edit Employee Job Modal -->