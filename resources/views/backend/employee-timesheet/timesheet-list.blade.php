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
        <div class="col-auto float-right ml-auto">
            <a href="{{ route('employee-timesheet-view') }}" class="btn add-btn"><i class="fa fa-plus"></i>Add Employee TimeSheet</a>
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
                            {{-- <th>Employee Name</th> --}}
                            {{-- <th>Project</th>
                            <th>Project Phase</th> --}}
                            <th>Calender Date</th>
                            <th>From Time</th>
                            <th>To Time</th>
                            <th style="text-align:center">Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_timesheets->count()))
                            @foreach ($employee_timesheets as $index => $timesheet)
                                <tr>
                                    {{-- @php
                                        $firstname = !empty($timesheet->employee->firstname) ? $timesheet->employee->firstname : '';
                                        $lastname = !empty($timesheet->employee->lastname) ? $timesheet->employee->lastname : '';
                                        $supervisor = App\Models\Employee::find($timesheet->supervisor_id);
                                        if (!empty($supervisor)) {
                                            $supervisor_name = $supervisor->firstname . ' ' . $supervisor->lastname;
                                        }
                                    @endphp --}}
                                    {{-- <td>{{ $firstname . ' ' . $lastname }}</td> --}}
                                        {{-- <td>{{ !empty($timesheet->project->name) ? $timesheet->project->name : '' }}</td>
                                        <td>{{ !empty($timesheet->projectphase->name) ? str_replace('_', ' ', ucfirst($timesheet->projectphase->name)) : '' }}
                                        </td> --}}
                                    <td>{{$timesheet->calender_date}}</td>    
                                    <td>{{ date('H:i', strtotime($timesheet->from_time)) }}</td>
                                    <td>{{ date('H:i', strtotime($timesheet->to_time)) }}</td>
                                    {{-- {{!empty($timesheet->timesheet_status->status) && $timesheet->timesheet_status->status == "approved" ? 'checked' : ''}} --}}
                                    <td class="text-center">
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                                <i
                                                    class="fa fa-dot-circle-o text-success"></i>{{ !empty($timesheet->timesheet_status->status) ? ucfirst($timesheet->timesheet_status->status) : '' }}
                                            </a>
                                            <a class="btn text-danger statusChecked" data-id="{{ $timesheet->id }}"
                                                data-status="approved" href="#" data-toggle="modal"
                                                id="statusChecked">Change Status</a>
                                        </div>
                                    </td>
                                    <!-- <td>{{ !empty($timesheet->timesheet_status->status) ? str_replace('_', ' ', ucfirst($timesheet->timesheet_status->status)) : '' }}</td> -->
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
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
                                                    data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <x-modals.delete :route="'employee-timesheet.destroy'" :title="'Employee Timesheet'" />
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- update Employee Timsheet status Model-->
    <div class="modal custom-modal fade" id="update_timesheet_status" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Update {{ ucfirst($title) }} data</h3>
                        <p>Are you sure want to update status?</p>
                    </div>
                    <form action="{{ route('timesheet-status-update') }}" method="post">
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
