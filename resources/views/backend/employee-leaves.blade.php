@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Leaves</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) href="{{ route('dashboard') }}" @else href="{{ route('employee-dashboard') }}" @endif>Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Leaves</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i
                    class="fa fa-plus"></i> Add Leave</a>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>No of Days</th>
                            <th>Reason</th>
                            <th class="text-center">Status</th>
                            @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                                <th>Employee</th>
                            @endif
                            <th>Approved Date/Time</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $index => $leave)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $leave->leaveType->type }}</td>
                                <td>{{ date_format(date_create($leave->from), 'd M, Y') }}</td>
                                <td>{{ date_format(date_create($leave->to), 'd M, Y') }}</td>
                                <td>
                                    @php
                                        $start = new DateTime($leave->to);
                                        $end_date = new DateTime($leave->from);
                                    @endphp
                                    {{ $start->diff($end_date, '%d')->days . ' ' . Str::plural('Days', $start->diff($end_date, '%d')->days) }}
                                </td>
                                <td><p class="" data-toggle="tooltip" data-html="true" title="{{$leave->reason}}">
                                    {{ substr($leave->reason, 0, 10) . ' ........' }}</p></td>
                                <td class="text-center">
                                    <div class="action-label">
                                        <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                            <i
                                                class="fa fa-dot-circle-o text-success"></i>{{ !empty($leave->time_sheet_status->status) ? ucfirst($leave->time_sheet_status->status) : '' }}
                                        </a>
                                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                                            <a class="btn text-danger statusChecked" data-id="{{ $leave->id }}"
                                                data-status="approved" href="#" data-toggle="modal"
                                                id="statusChecked">Change Status</a>
                                        @endif
                                    </div>
                                    {{-- <div class="action-label">
                                        <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                            {{-- @if ($leave->status == 'Approved') --}}
                                    {{-- <i class="fa fa-dot-circle-o text-success"></i>{{ !empty($leave->time_sheet_status->status) ? ucfirst($leave->time_sheet_status->status) : '' }}
                                        </a> --}}
                                    {{-- @else --}}
                                    {{-- <i class="fa fa-dot-circle-o text-danger"></i> Declined
									@endif --}}
                                    {{-- <a class="btn text-danger statusChecked" data-id="{{ $leave->id }}"
                                            data-status="approved" href="#" data-toggle="modal"
                                            id="statusChecked">Change Status</a> --}}
                                    {{-- </div> --}}
                                </td>
                                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0)" class="avatar avatar-xs">
                                                <img alt="avatar"
                                                    src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </a>
                                            <a href="#">{{ !empty($leave->employee->firstname) ? $leave->employee->firstname : '' }}
                                                {{ !empty($leave->employee->lastname) ? $leave->employee->lastname : '' }}
                                            </a>
                                        </h2>
                                    </td>
                                @endif
                                <td>{{ $leave->approved_date_time }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-id="{{ $leave->id }}" data-leave_type="{{ $leave->leave_type_id }}"
                                                data-employee="{{ $leave->employee_id }}"
                                                data-supervisor="{{ $leave->supervisor_id }}"
                                                data-project="{{ $leave->project_id }}"
                                                data-project_phase="{{ $leave->project_phase_id }}"
                                                data-from="{{ $leave->from }}" data-to="{{ $leave->to }}"
                                                data-leave_reason="{{ $leave->reason }}"
                                                data-status_reason="{{ $leave->status_reason }}"
                                                data-approved_date_time="{{ $leave->approved_date_time }}"
                                                data-timesheet_status_id="{{ $leave->timesheet_status_id }}"
                                                class="dropdown-item editbtn" href="javascript:void(0)"
                                                data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-id="{{ $leave->id }}" class="dropdown-item deletebtn"
                                                href="javascript:void(0)" data-toggle="modal"><i
                                                    class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- delete Leave Modal -->
                        <x-modals.delete :route="'leave.destroy'" :title="'Leave'" />
                        <!-- /delete Leave Modal -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Leave Modal -->
    <div id="add_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('employee-leave') }}">
                        @csrf
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select name="leave_type" class="select">
                                @foreach ($leave_types as $leave_type)
                                    <option value="{{ $leave_type->id }}">{{ $leave_type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="form-group">
                                <label>Employee</label>
                                <select name="employee" class="select">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->firstname }}
                                            {{ $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select name="supervisor" class="select">
                                @foreach (getSupervisor() as $sup)
                                    @php
                                        $supervisor = App\Models\Employee::where('user_id', '=', $sup->id)->first();
                                        $firstname = !empty($supervisor->firstname) ? $supervisor->firstname : '';
                                        $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
                                        $fullname = $firstname . ' ' . $lastname;
                                    @endphp
                                    @if (!empty($supervisor))
                                        <option value="{{ !empty($supervisor->id) ? $supervisor->id : '' }}">
                                            {{ $fullname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Projects</label>
                            <select name="project" class="select">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Project Phase</label>
                            <select name="project_phase_id" id="project_phase" class="select form-control">
                                <option value="">Select Project</option>
                                @foreach ($project_phases as $project_phase)
                                    <option value="{{ $project_phase->id }}">
                                        {{ str_replace('_', ' ', ucfirst($project_phase->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input name="from" class="form-control datetimepicker" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input name="to" class="form-control datetimepicker" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" rows="4" class="form-control"></textarea>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="form-group">
                                <label>TimeSheet Status<span class="text-danger">*</span></label>
                                <select name="timesheet_status" class="select form-control">
                                    <option value="">Select TimeSheet Status</option>
                                    @foreach ($timesheet_statuses as $time_status)
                                        <option value="{{ $time_status->id }}">
                                            {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status Reason <span class="text-danger">*</span></label>
                                <textarea name="status_reason" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Approved Date/Time<span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker" name="approved_date_time" type="text">
                            </div>
                        @endif
                        <!-- <div class="form-group">
                                                  <label>Status </label>
                                                  <select name="status" class="select">
                                                  <option value="null" disabled selected>Select Status</option>
                                                  <option>Approved</option>
                                                  <option>Pending</option>
                                                  <option>Declined</option>
                                                  </select>
                                                  </div> -->
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->

    <!-- Edit Leave Modal -->
    <div id="edit_leave_list" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employee-leave') }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="leave_edit_id">
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select name="leave_type" class="select2" id="edit_leave_type">
                                @foreach ($leave_types as $leave_type)
                                    <option value="{{ $leave_type->id }}">{{ $leave_type->type }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="form-group">
                                <label>Employee<span class="text-danger">*</span></label>
                                <select name="employee" class="select2" id="edit_employee">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->firstname . ' ' . $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select name="supervisor" id="edit_supervisor_id" class="select">
                                @foreach (getSupervisor() as $sup)
                                    @php
                                        $supervisor = App\Models\Employee::where('user_id', '=', $sup->id)->first();
                                        $firstname = !empty($supervisor->firstname) ? $supervisor->firstname : '';
                                        $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
                                        $fullname = $firstname . ' ' . $lastname;
                                    @endphp
                                    @if ($supervisor)
                                        <option value="{{ $supervisor->id }}">
                                            {{ $fullname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Projects</label>
                            <select name="project" id="edit_project_id" class="select">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Project Phase</label>
                            <select name="project_phase_id" id="edit_project_phase_id" class="select form-control">
                                <option value="">Select Project</option>
                                @foreach ($project_phases as $project_phase)
                                    <option value="{{ $project_phase->id }}">
                                        {{ str_replace('_', ' ', ucfirst($project_phase->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input name="from" class="form-control datetimepicker" type="text" id="edit_from">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input name="to" class="form-control datetimepicker" type="text" id="edit_to">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" rows="4" class="form-control" id="edit_reason"></textarea>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="form-group">
                                <label>TimeSheet Status<span class="text-danger">*</span></label>
                                <select name="timesheet_status" id="edit_status" class="select form-control">
                                    <option value="">Select TimeSheet Status</option>
                                    @foreach ($timesheet_statuses as $time_status)
                                        <option value="{{ $time_status->id }}">
                                            {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status Reason <span class="text-danger">*</span></label>
                                <textarea name="status_reason" id="edit_status_reason" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Approved Date/Time<span class="text-danger">*</span></label>
                                <input class="form-control datetimepicker" name="approved_date_time"
                                    id="edit_approved_date_time" type="text">
                            </div>
                        @endif

                        <!-- <div class="form-group">
                                                      <label>Status </label>
                                                      <select name="status" class="select2 form-control" id="edit_status">
                                                      <option value="null">Select Status</option>
                                                      <option>Approved</option>
                                                      <option>Pending</option>
                                                      <option>Declined</option>
                                                      </select>
                                                      </div> -->
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Leave Modal -->

    <!-- update Employee Leave status Model-->
    <div class="modal custom-modal fade" id="update_leave_status" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Update {{ ucfirst($title) }} data</h3>
                        <p>Are you sure want to update status?</p>
                    </div>
                    <form action="{{ route('leave-status-update') }}" method="post">
                        @csrf
                        <input type="hidden" id="timesheet_id" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>TimeSheet Status<span class="text-danger">*</span></label>
                                    <select name="timesheet_status" id="" class="select form-control">
                                        <option value="">Select TimeSheet Status</option>
                                        @foreach ($timesheet_statuses as $time_status)
                                            <option value="{{ $time_status->id }}">
                                                {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status Reason <span class="text-danger">*</span></label>
                                    <textarea name="status_reason" id="edit_status_reason" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary continue-btn btn-block" type="submit">Update</button>
                                </div>
                                <div class="col-6">
                                    <button data-dismiss="modal"
                                        class="btn btn-primary cancel-btn btn-block">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- update Employee Timsheet status Model-->
@endsection

@section('scripts')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $('.editbtn').click(function() {
            var leave_id = $(this).data('id');
            console.log(leave_id, 'testid');
            var leave_type = $(this).data('leave_type');
            var employee = $(this).data('employee');
            var supervisor = $(this).data('supervisor');
            var project = $(this).data('project');
            var project_phase = $(this).data('project_phase')
            var from = $(this).data('from');
            var to = $(this).data('to');
            var leave_reason = $(this).data('leave_reason');
            // var status = $(this).data('status');
            var status_reason = $(this).data('status_reason');
            var timesheet_status_id = $(this).data('timesheet_status_id');
            var approved_date_time = $(this).data('approved_date_time');
            $('#edit_leave_list').modal('show');
            $('#leave_edit_id').val(leave_id);
            $('#edit_employee').val(employee).trigger('change');
            $('#edit_supervisor_id').val(supervisor).trigger('change');
            $('#edit_project_id').val(project).trigger('change');
            $('#edit_project_phase_id').val(project_phase).trigger('change');
            $('#edit_leave_type').val(leave_type).trigger('change');
            $('#edit_status').val(timesheet_status_id).trigger('change');
            $('#edit_from').val(from);
            $('#edit_to').val(to)
            $('#edit_reason').append(leave_reason);
            $('#edit_status_reason').append(status_reason);
            $('#edit_approved_date_time').append(approved_date_time);

            // check employee select
            // $("#edit_employee option").each(function() {
            // 	if ($(this).val() == employee) {
            // 		$(this).attr('selected', 'selected');
            // 	}
            // });
            // // check leave type select
            // $("#edit_type option").each(function() {
            // 	if ($(this).val() == leave_type) {
            // 		$(this).attr('selected', 'selected');
            // 	}
            // });
            // // check status select
            // $("#edit_status option").each(function() {
            // 	if ($(this).val() == status) {
            // 		$(this).attr('selected', 'selected');
            // 	}
            // });
        });
    </script>
    <script>
        $('.statusChecked').on('click', function() {
            $('#update_leave_status').modal('show');
            var id = $(this).data('id');
            var status = $(this).data('status');
            $('#timesheet_id').val(id);
        });
    </script>
@endsection
