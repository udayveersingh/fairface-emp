@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Employee TimeSheet</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employee TimeSheet</li>
            </ul>
        </div>
        {{-- <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_timesheet"><i
                    class="fa fa-plus"></i>Add Employee TimeSheet</a>
        </div> --}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>Timesheet Id</th>
                            <th>Employee Name</th>
                            <th>Supervisor</th>
                            <th>Project</th>
                            {{-- <th>Project Phase</th> --}}
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_timesheets->count()))
                        @foreach ($employee_timesheets as $index => $timesheet)
                                    @php
                                        $firstname = !empty($timesheet->employee->firstname) ? $timesheet->employee->firstname : '';
                                        $lastname = !empty($timesheet->employee->lastname) ? $timesheet->employee->lastname : '';
                                        $supervisor = App\Models\Employee::find($timesheet->supervisor_id);
                                        if (!empty($supervisor)) {
                                            $supervisor_name = $supervisor->firstname . ' ' . $supervisor->lastname;
                                        }
                                        $start_date = explode(',',$timesheet->start_date);
                                        $end_date = explode(',',$timesheet->end_date);
                                    @endphp
                        @if($start_date[0] != null && $end_date[0] != null)
                                <tr>
                                    <td>{{ $timesheet->timesheet_id }}</td>
                                    <td>{{ $firstname . ' ' . $lastname }}</td>
                                    <td>{{ $supervisor_name }}</td>
                                    <td>{{ !empty($timesheet->project->name) ? $timesheet->project->name : '' }}</td>
                                    {{-- <td>{{ !empty($timesheet->projectphase->name) ? str_replace('_', ' ', ucfirst($timesheet->projectphase->name)) : '' }} --}}
                                    {{-- </td> --}}
                                    <td>{{ date('d-m-Y', strtotime($start_date[0]))}}</td>
                                    <td>{{ date('d-m-Y',strtotime($end_date[0])) }}</td>
                                    <td>{{ !empty($timesheet->timesheet_status->status) ? ucfirst($timesheet->timesheet_status->status) : '' }}
                                    </td>
                                    {{-- {{!empty($timesheet->timesheet_status->status) && $timesheet->timesheet_status->status == "approved" ? 'checked' : ''}} --}}
                                    {{-- <td class="text-center">
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                                <i
                                                    class="fa fa-dot-circle-o text-success"></i>{{ !empty($timesheet->timesheet_status->status) ? ucfirst($timesheet->timesheet_status->status) : '' }}
                                            </a>
                                            <a class="btn text-danger statusChecked" data-id="{{ $timesheet->id }}"
                                                data-status="approved" href="#" data-toggle="modal"
                                                id="statusChecked">Change Status</a>
                                        </div>
                                    </td> --}}
                                    <td class="d-flex" style="align-items: center;">
                                    <p style="white-space:nowrap;" class="m-0" data-toggle="tooltip" data-html="true"
                                        title="{{ $timesheet->status_reason }}">
                                        {{ substr($timesheet->status_reason, 0, 10) . ' ...' }}</p>
                                    
                                   </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            @if($start_date[0] != null && $end_date[0] != null) 
                                            <a class="btn-sm btn-primary" href="{{route('employee-timesheet-detail',['id' => $timesheet->employee_id ,'start_date'=> $start_date[0] ,'end_date' => $end_date[0]])}}"><i class="fa fa-eye" aria-hidden="true"></i>View</a>    
                                            @endif
                                            {{-- <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right"> --}}
                                                {{-- <a class="dropdown-item statusChecked" data-id="{{ $timesheet->id }}"
                                                    data-status="approved" href="#" data-toggle="modal"
                                                    id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Change Status</a>
                                                <a data-id="{{ $timesheet->id }}"
                                                    data-timesheet_id="{{ $timesheet->timesheet_id }}"
                                                    data-employee_id="{{ $timesheet->employee_id }}"
                                                    data-supervisor_id="{{ $timesheet->supervisor_id }}"
                                                    data-project_id="{{ $timesheet->project_id }}"
                                                    data-project_phase_id="{{ $timesheet->project_phase_id }}"
                                                    data-calendar_day="{{ $timesheet->calender_day }}"
                                                    data-calendar_date="{{ $timesheet->calender_date }}"
                                                    data-from_time="{{ $timesheet->from_time }}"
                                                    data-to_time="{{ $timesheet->to_time }}"
                                                    data-total_hours_worked="{{ $timesheet->total_hours_worked }}"
                                                    data-notes="{{ $timesheet->notes }}"
                                                    data-timesheet_status_id="{{ $timesheet->timesheet_status_id }}"
                                                    data-status_reason="{{ $timesheet->status_reason }}"
                                                    data-edit_approved_date_time="{{ $timesheet->approved_date_time }}"
                                                    class="dropdown-item editbtn" href="javascript:void(0);"
                                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a data-id="{{ $timesheet->id }}" class="dropdown-item deletebtn"
                                                    href="javascript:void(0);" data-target="#deletebtn"
                                                    data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a> --}}
                                                    {{-- @if($start_date[0] != null && $end_date[0] != null) 
                                                    <a class="dropdown-item" href="{{route('employee-timesheet-detail',['id' => $timesheet->employee_id ,'start_date'=> $start_date[0] ,'end_date' => $end_date[0]])}}"><i class="fa fa-pencil m-r-5"></i>View</a>    
                                                    @endif --}}
                                            {{-- </div> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            <x-modals.delete :route="'employee-timesheet.destroy'" :title="'Employee Timesheet'" />
                            <!-- Edit Employee Timesheet Status Modal -->
                            <div id="edit_employee_timesheet" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit TimeSheet Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('employee-timesheet') }}" method="POST">
                                                @csrf
                                                <input type="hidden" id="edit_id" name="id">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Timesheet ID <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="timesheet_id"
                                                                id="edit_timesheet_id" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Employee<span class="text-danger">*</span></label>
                                                            <select name="employee_id" id="edit_employee_id"
                                                                class="select form-control">
                                                                <option value="">Select Employee</option>
                                                                @foreach ($employees as $employee)
                                                                    <option value="{{ $employee->id }}">
                                                                        {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Supervisor<span class="text-danger">*</span></label>
                                                            <select name="supervisor_id" id="edit_supervisor_id"
                                                                class="select form-control">
                                                                <option value="">Select Supervisor</option>
                                                                @foreach ($employees as $employee)
                                                                    <option value="{{ $employee->id }}">
                                                                        {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Project<span class="text-danger">*</span></label>
                                                            <select name="project_id" id="edit_project_id"
                                                                class="select form-control">
                                                                <option value="">Select Project</option>
                                                                @foreach ($projects as $project)
                                                                    <option value="{{ $project->id }}">
                                                                        {{ $project->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Project Phase<span class="text-danger">*</span></label>
                                                            <select name="project_phase_id" id="edit_project_phase_id"
                                                                class="select form-control">
                                                                <option value="">Select Project Phase</option>
                                                                @foreach ($project_phases as $project_phase)
                                                                    <option value="{{ $project_phase->id }}">
                                                                        {{ str_replace('_', ' ', ucfirst($project_phase->name)) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Calendar Day<span class="text-danger">*</span></label>
                                                            <select name="calendar_day" id="edit_calendar_day"
                                                                class="select form-control">
                                                                @php
                                                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                                @endphp
                                                                <option value="">Select Calendar Day</option>
                                                                @foreach ($days as $day)
                                                                    <option value="{{ $day }}">
                                                                        {{ $day }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Calendar Date<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="calender_date"
                                                                id="edit_calendar_date" type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">From Time<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="from_time"
                                                                id="edit_from_time" type="time">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">To Time<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="to_time" id="edit_to_time"
                                                                type="time">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Total Hours Worked<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" id="edit_total_hours_works"
                                                                name="total_hours_works" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Notes<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="edit_notes" name="notes" rows="4" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>TimeSheet Status<span
                                                                    class="text-danger">*</span></label>
                                                            <select name="timesheet_status" id="edit_timesheet_status"
                                                                class="select form-control">
                                                                <option value="">Select TimeSheet Status</option>
                                                                @foreach ($timesheet_statuses as $time_status)
                                                                    <option value="{{ $time_status->id }}">
                                                                        {{ str_replace('_', ' ', ucfirst($time_status->status)) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Status Reason<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="edit_status_reason" name="status_reason" rows="4" cols="50"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Approved Date/Time<span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" name="approved_date_time"
                                                                id="edit_approved_datetime" type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="submit-section">
                                                    <button type="submit"
                                                        class="btn btn-primary submit-btn">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Edit Employee Timesheet Status Modal -->
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Employee Timesheet Modal -->
    <div id="add_employee_timesheet" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee Timesheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employee-timesheet') }}" method="POST">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Timesheet ID <span class="text-danger">*</span></label>
                                    <input class="form-control" name="timesheet_id" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Employee<span class="text-danger">*</span></label>
                                    <select name="employee_id" id="employee" class="select form-control">
                                        <option value="">Select Employee</option>
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
                                    <label>Supervisor<span class="text-danger">*</span></label>
                                    <select name="supervisor_id" id="supervisor" class="select form-control">
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
                                    <label>Project<span class="text-danger">*</span></label>
                                    <select name="project_id" id="project" class="select form-control">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Project Phase<span class="text-danger">*</span></label>
                                    <select name="project_phase_id" id="project_phase" class="select form-control">
                                        <option value="">Select Project</option>
                                        @foreach ($project_phases as $project_phase)
                                            <option value="{{ $project_phase->id }}">{{ $project_phase->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Calendar Day<span class="text-danger">*</span></label>
                                    <select name="calendar_day" id="calendar_day" class="select form-control">
                                        @php
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        @endphp
                                        <option value="">Select Calendar Day</option>
                                        @foreach ($days as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Calendar Date<span class="text-danger">*</span></label>
                                    <input class="form-control" name="calender_date" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">From Time<span class="text-danger">*</span></label>
                                    <input class="form-control" name="from_time" type="time">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">To Time<span class="text-danger">*</span></label>
                                    <input class="form-control" name="to_time" type="time">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Total Hours Worked<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="total_hours_works" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Notes<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="notes" name="notes" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Status Reason<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="status_reason" name="status_reason" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Approved Date/Time<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="approved_date_time" type="date">
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
    <!-- Add Employee Timesheet Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', function() {
                $('#edit_employee_timesheet').modal('show');
                var id = $(this).data('id');
                var timesheet_id = $(this).data('timesheet_id');
                var employee_id = $(this).data('employee_id');
                var supervisor_id = $(this).data('supervisor_id');
                var project_id = $(this).data('project_id');
                var project_phase_id = $(this).data('project_phase_id');
                var calendar_day = $(this).data('calendar_day');
                var calendar_date = $(this).data('calendar_date');
                var from_time = $(this).data('from_time');
                var to_time = $(this).data('to_time');
                var total_hours_worked = $(this).data('total_hours_worked');
                var notes = $(this).data('notes');
                var timesheet_status_id = $(this).data('timesheet_status_id');
                var status_reason = $(this).data('status_reason');
                var timesheet_approved_date_time = $(this).data('edit_approved_date_time');
                console.log(timesheet_approved_date_time);
                $('#edit_id').val(id);
                $('#edit_status').val(edit_status);
                $('#edit_timesheet_id').val(timesheet_id);
                $("#edit_employee_id").val(employee_id).trigger("change");
                $("#edit_supervisor_id").val(supervisor_id).trigger("change");
                $("#edit_project_id").val(project_id).trigger("change");
                $("#edit_project_phase_id").val(project_phase_id).trigger("change");
                $("#edit_calendar_day").val(calendar_day).trigger("change");
                $('#edit_calendar_date').val(calendar_date);
                $('#edit_from_time').val(from_time);
                $('#edit_to_time').val(to_time);
                $('#edit_total_hours_works').val(total_hours_worked);
                $('#edit_notes').val(notes);
                $("#edit_timesheet_status").val(timesheet_status_id).trigger("change");
                $('#edit_status_reason').val(status_reason);
                $('#edit_approved_datetime').val(timesheet_approved_date_time);
            });
        });
    </script>
    <script>
        $('.statusChecked').on('click', function() {
            $('#update_timesheet_status').modal('show');
            var id = $(this).data('id');
            var status = $(this).data('status');
            $('#timesheet_id').val(id);
        });

        // $(document).ready(function() {
        //     $('#timesheet_status_form').on('status_update_button', function(e) {
        //         e.preventDefault();
        //         alert("test hello");
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //             }
        //         });
        //         $.ajax({
        //             url: "{{ route('timesheet-status-update') }}",
        //             method: "POST",
        //             data: new FormData(this),
        //             dataType: 'JSON',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success: function(dataResult) {
        //                 location.reload();
        //             }
        //         });
        //     });
        // });
    </script>
@endsection
