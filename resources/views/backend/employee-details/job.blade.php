@if (!empty($employee_jobs->count()))
    <div class="row align-items-center mb-2">
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_job"><i
                    class="fa fa-plus"></i>
                Add Job</a>
        </div>
    </div>
@else
    <div class="row align-items-center mb-2">
        <div class="">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_job"><i
                    class="fa fa-plus"></i>
                Add Job</a>
        </div>
    </div>
@endif
@if (!empty($employee_jobs->count()))
    <div class="row">
        @foreach ($employee_jobs as $job)
            @php
                if (!empty($job->supervisor)) {
                    $supervisor = App\Models\Employee::find($job->supervisor);
                    $supervisor_name = $supervisor->firstname . ' ' . $supervisor->lastname;
                } else {
                    $supervisor_name = '';
                }
                if (!empty($job->timesheet_approval_incharge)) {
                    $timesheet_approval_incharge = App\Models\Employee::find($job->timesheet_approval_incharge);
                    $incharge_name = $timesheet_approval_incharge->firstname . ' ' . $timesheet_approval_incharge->lastname;
                } else {
                    $incharge_name = '';
                }
            @endphp
            <div class="col-md-12 mb-4">
                <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                    <table class="table table-striped">
                        <tr>
                            <th>Job Title</th>
                            <td>{{ $job->job_title }}</td>
                        </tr>
                        <tr>
                            <th>supervisor </th>
                            <td>{{ $supervisor_name }}</td>
                        </tr>
                        <tr>
                            <th>Timesheet Approval Incharge </th>
                            <td>{{ $incharge_name }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ !empty($job->department->name) ? $job->department->name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Work Email</th>
                            <td>{{ !empty($job->work_email) ? $job->work_email : '' }}</td>
                        </tr>
                        <tr>
                            <th>Work Phone Number</th>
                            <td>{{ $job->work_phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $job->start_date }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $job->end_date }}</td>
                        </tr>
                        <tr>
                            <th>Job Type</th>
                            <td>{{ str_replace('_', ' ', $job->job_type) }}</td>
                        </tr>
                        <tr>
                            <th>Contracted Weekly Hours</th>
                            <td>{{ $job->contracted_weekly_hours }}</td>
                        </tr>
                    </table>
                    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                        <a data-id="{{ $job->id }}" data-employee_id="{{ $job->employee_id }}"
                            data-supervisor="{{ $job->supervisor }}"
                            data-timesheet_approval_inch="{{ $job->timesheet_approval_incharge }}"
                            data-job_title="{{ $job->job_title }}" data-department="{{ $job->department_id }}"
                            data-work_email="{{ $job->work_email }}"
                            data-work_phone_number="{{ $job->work_phone_number }}"
                            data-start_date="{{ $job->start_date }}" data-end_date="{{ $job->end_date }}"
                            data-job_type="{{ $job->job_type }}"
                            data-cont_weekly_hours="{{ $job->contracted_weekly_hours }}" class="btn btn-primary"
                            id="edit_btn" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a data-id="{{ $job->id }}" data-resource_data="Employee Job"
                            class="btn btn-danger detail_delete" href="javascript:void(0);" data-target="delete_modal"
                            data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
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
                <form action="{{ route('employee-job.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee Id<span class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $employee->employee_id }}" name="employee_id"
                                    id="" type="text" readonly>
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
                                <select name="supervisor" id="supervisor" class="form-control select">
                                    <option value="">Select Supervisor</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->firstname . ' ' . $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                                <select name="timesheet_approval_inch" id="" class="form-control select">
                                    <option value="">Select Approval Incharge</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->firstname . ' ' . $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Department<span class="text-danger">*</span></label>
                                <select name="department" id="department" class="form-control select">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
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
                                <input class="form-control mask_phone_number" name="work_phone_number"
                                    id="phone_number" type="text">
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
                                <label>End Date</label>
                                <input class="form-control" name="end_date" id="end_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Type<span class="text-danger">*</span></label>
                                <select name="job_type" id="job_type" class="form-control select">
                                    <option value="">Select Job Type</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Contracted Weekly Hours</label>
                                <input class="form-control" name="contract_weekly_hours" id=""
                                    type="text">
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
<div id="employee_job" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee-job.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" id="edit_job_id" name="edit_id">
                        <input type="hidden" id="employee_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Title<span class="text-danger">*</span></label>
                                <input class="form-control" name="job_title" value="" id="edit_job_title"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Supervisor<span class="text-danger">*</span></label>
                                <select name="supervisor" id="edit_supervisor" class="form-control select">
                                    <option value="">Select Supervisor</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->firstname . '' . $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                                <select name="timesheet_approval_inch" id="timesheet_approval_inch"
                                    class="form-control select">
                                    <option value="">Select Approval Incharge</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->firstname . ' ' . $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Department<span class="text-danger">*</span></label>
                                <select name="department" id="edit_department" class="form-control select">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
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
                                <input class="form-control mask_phone_number" name="work_phone_number"
                                    id="edit_phone_number" type="text">
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
                                <label>End Date</label>
                                <input class="form-control" name="end_date" id="edit_end_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Job Type<span class="text-danger">*</span></label>
                                <select name="job_type" id="edit_job_type" class="form-control select">
                                    <option value="">Select Job Type</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Contracted Weekly Hours</label>
                                <input class="form-control" name="contract_weekly_hours" id="contracted_weekly_hours"
                                    type="text">
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