@extends('layouts.backend-detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('employee-job.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id" value="{{!empty($employee_job->id) ? $employee_job->id:'' }}"name="id">
            <input type="hidden" id="emp_id"  value="{{$employee->id}}" name="emp_id">
            <div class="row">
                <div class="col-md-6">
                    job Title<span class="text-danger">*</span></label>
                    <input class="form-control" name="job_title" value="{{!empty($employee_job->job_title) ? $employee_job->job_title:'' }}" id="edit_job_title" type="text">
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Work Email<span class="text-danger">*</span></label>
                        <input class="form-control" name="work_email" id="edit_work_email" value="{{!empty($employee_job->work_email) ? $employee_job->work_email:'' }}" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Work Phone Number</label>
                        <input class="form-control" name="work_phone_number" id="edit_phone_number" value="{{$employee_job->work_phone_number}}" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Supervisor<span class="text-danger">*</span></label>
                        <select name="supervisor" id="supervisor" class="select form-control">
                            <option value="">Select Supervisor</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}"{{$employee_job->supervisor == $employee->id  ? 'selected' : '' }}>{{$employee->firstname ."".$employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                        <select name="timesheet_approval_inch" id="timesheet_approval_inch" class="select form-control">
                            <option value="">Select Approval Incharge</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}"{{$employee_job->timesheet_approval_incharge  == $employee->id  ? 'selected' : ''}}>{{$employee->firstname ."".$employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Department<span class="text-danger">*</span></label>
                        <select name="department" id="department" class="select form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}" {{$employee_job->department_id  == $department->id  ? 'selected' : ''}}>{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Job Type<span class="text-danger">*</span></label>
                        <select name="job_type" id="job_type" class="select form-control">
                            <option value="">Select Job Type</option>
                            <option value="full_time"{{$employee_job->job_type  == "full_time"  ? 'selected' : ''}}>Full Time</option>
                            <option value="part_time"{{$employee_job->job_type  == "part_time"  ? 'selected' : ''}}>Part Time</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input class="form-control" value="{{$employee_job->start_date}}" name="start_date" id="edit_start_date" type="date">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Contracted Weekly Hours</label>
                        <input class="form-control"  value="{{$employee_job->contracted_weekly_hours}}" name="contract_weekly_hours" id="contracted_weekly_hours" type="time">
                    </div>
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection