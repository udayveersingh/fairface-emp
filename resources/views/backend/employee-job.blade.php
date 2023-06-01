@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Job</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_job"><i class="fa fa-plus"></i> Add Employee Job</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div>
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
                        $supervisor_name = $supervisor->firstname ."". $supervisor->lastname;
                        }else{
                        $supervisor_name='';
                        }
                        if(!empty($job->timesheet_approval_incharge)){
                        $timesheet_approval_incharge = App\Models\Employee::find($job->timesheet_approval_incharge);
                        $incharge_name = $timesheet_approval_incharge->firstname ."". $timesheet_approval_incharge->lastname;
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
                                    <a data-id="{{$job->id}}" data-supervisor="{{$job->supervisor }}" data-timesheet_approval_inch="{{$job->timesheet_approval_incharge}}" data-job_title="{{$job->job_title}}" data-department="{{$job->department_id}}" data-work_email="{{$job->work_email}}" data-work_phone_number="{{$job->work_phone_number}}" data-start_date="{{$job->start_date}}" data-job_type="{{$job->job_type}}" data-cont_weekly_hours="{{$job->contracted_weekly_hours}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$job->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-job.destroy'" :title="'Employee Job'" />
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
                                    <form method="POST" action="{{route('employee-job.update')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="row">
                                            <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Job Title<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="job_title" id="edit_job_title" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Work Email<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="work_email" id="edit_work_email" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Work Phone Number</label>
                                                    <input class="form-control" name="work_phone_number" id="edit_phone_number" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Supervisor<span class="text-danger">*</span></label>
                                                    <select name="supervisor" id="supervisor" class="select">
                                                        <option value="">Select Supervisor</option>
                                                        @foreach($employees as $employee)
                                                        <option value="{{$employee->id}}"> {{$employee->firstname ."".$employee->lastname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>TimeSheet Approval Incharge<span class="text-danger">*</span></label>
                                                    <select name="timesheet_approval_inch" id="timesheet_approval_inch" class="select">
                                                        <option value="">Select Approval Incharge</option>
                                                        @foreach($employees as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->firstname ." ".$employee->lastname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Department<span class="text-danger">*</span></label>
                                                    <select name="department" id="department" class="select">
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Job Type<span class="text-danger">*</span></label>
                                                    <select name="job_type" id="job_type" class="select">
                                                        <option value="">Select Job Type</option>
                                                        <option value="full_time">Full Time</option>
                                                        <option value="part_time">Part Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="form-control" name="start_date" id="edit_start_date" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Contracted Weekly Hours</label>
                                                    <input class="form-control" name="contract_weekly_hours" id="contracted_weekly_hours" type="time">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Edit Employee Job Modal -->
                    @endif
                </tbody>
            </table>
        </div>
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
                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Job Title<span class="text-danger">*</span></label>
                                <input class="form-control" name="job_title" id="edit_job_title" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Work Email<span class="text-danger">*</span></label>
                                <input class="form-control" name="work_email" id="edit_work_email" type="text">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Work Phone Number</label>
                                <input class="form-control" name="work_phone_number" id="edit_phone_number" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Supervisor<span class="text-danger">*</span></label>
                                <select name="supervisor" id="supervisor" class="select form-control">
                                    <option value="">Select Supervisor</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->firstname ."".$employee->lastname }}</option>
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
                                    <option value="{{$employee->id}}">{{$employee->firstname ."".$employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Department<span class="text-danger">*</span></label>
                                <select name="department" id="department" class="select form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Job Type<span class="text-danger">*</span></label>
                                <select name="job_type" id="job_type" class="select form-control">
                                    <option value="">Select Job Type</option>
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" name="start_date" id="edit_start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contracted Weekly Hours</label>
                                <input class="form-control" name="contract_weekly_hours" id="contracted_weekly_hours" type="time">
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
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.table').on('click', '.editbtn', function() {
            $('#edit_employee_job').modal('show');
            var id = $(this).data('id');
            var edit_supervisor = $(this).data('supervisor');
            var edit_job_title = $(this).data('job_title');
            var edit_timesheet_approval_inch = $(this).data('timesheet_approval_inch');
            var edit_department = $(this).data('department');
            var edit_work_email = $(this).data('work_email');
            var edit_work_phone_number = $(this).data('work_phone_number');
            var edit_start_date = $(this).data('start_date');
            var edit_job_type = $(this).data('job_type');
            var edit_cont_weekly_hours = $(this).data('cont_weekly_hours');
            $('#edit_id').val(id);
            $('#edit_job_title').val(edit_job_title);
            $('#supervisor').val(edit_supervisor);
            $('#timesheet_approval_inch').val(edit_timesheet_approval_inch);
            $('#department').val(edit_department);
            $('#edit_work_email').val(edit_work_email);
            $('#edit_phone_number').val(edit_work_phone_number);
            $('#edit_start_date').val(edit_start_date);
            $('#job_type').val(edit_job_type);
            $('#contracted_weekly_hours').val(edit_cont_weekly_hours);
        });
    });
</script>
@endsection