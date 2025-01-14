@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    {{-- @endsection --}}
    {{-- <style>
        table,th,td {
            border: 1px solid;
        }
    </style> --}}
@section('content')
    @php
        //Monthly ending date
        $date = new DateTime('now');
        $date->modify('last day of this month');

        //display week starting date
        $week_starting = new DateTime('now');
        $week_starting->modify('first day of this month');
        $first_name = App\Models\Employee::where('id', '=', $id)->value('firstname');
        $last_name = App\Models\Employee::where('id', '=', $id)->value('lastname');
        $employee_name = ucfirst($first_name) . ' ' . $last_name;
    @endphp
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Employee Timesheet Details</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Employee Name:-</strong><span>
                    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN || Auth::user()->role->name == App\Models\Role::ADMIN)
                        {{ ucfirst($employee_name) }} 
                        @else
                        {{ ucfirst(Auth::user()->name) }}
                    @endif
                </span></div>
            <div class="col-md-6 mt-2">
                <a href="{{ route('print-timesheet-detail', ['id' => $id, 'start_date' => $start_date, 'end_date' => $end_date]) }}"
                    class="btn add-btn" target="_blank"><i class="fa fa-download"></i>Print PDF File</a>
                <a href="@if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN || Auth::check() && Auth::user()->role->name == App\Models\Role::ADMIN ) {{ route('employee-timesheet') }} @else  {{ route('employee-timesheet-list') }} @endif" class="btn add-btn mr-2">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="mx-0"><strong>Date
                        Starting:-</strong>{{ !empty($start_date) ? date('d-m-Y', strtotime($start_date)) : '' }}</p>
                <p class="mx-0"></p>
            </div>
            <div class="col-md-6">
                <p class="mx-0"><strong>Date
                        Ending:-</strong><span>{{ !empty($end_date) ? date('d-m-Y', strtotime($end_date)) : '' }}</span></p>
                <p class="mx-0"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Project</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th>1/2 or 1 Day</th>
                        <th>Comments</th>
                    </tr>
                    @php
                        $count = 0;
                        $total_days_worked = 0;
                    @endphp
                    @foreach ($employee_timesheets as $index => $timesheet)
                        <tbody id="bodyData">
                            @php
                                // if ($timesheet->calender_day == 'Sunday') {
                                //     $count++;
                                //     continue;
                                // }
                                // $total_count = $index + 1;
                                $timesheet_hours = '';
                                if (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '8 hours') {
                                    $timesheet_hours = 'Full day';
                                    $count = 1;
                                } elseif (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '4 hours') {
                                    $timesheet_hours = 'Half day';
                                    $count =.5;
                                } else {
                                    $timesheet_hours = '______';
                                }
                                $from_time = date('H:i', strtotime($timesheet->from_time));
                                $to_time = date('H:i', strtotime($timesheet->to_time));
                                $total_days_worked +=$count; 
                            @endphp
                            <td>{{ !empty($timesheet->calender_date) ? date('d-m-Y', strtotime($timesheet->calender_date)) : '' }}
                            </td>
                            <td>{{ $timesheet->calender_day }}</td>
                            <td>{{ !empty($timesheet->project->name) ? ucfirst($timesheet->project->name) : '______' }}
                            </td>
                            <td>{{ !empty($from_time) ? $from_time : '' }}</td>
                            <td>{{ !empty($to_time) ? $to_time : '' }}</td>
                            <td>{{ $timesheet_hours }}</td>
                            <td class="d-flex" style="
                                align-items: center;">
                                {{ $timesheet->notes }}
                                {{-- <p style="white-space:nowrap;" class="m-0" data-toggle="tooltip" data-html="true"
                                    title="{{ $timesheet->notes }}">
                                    {{ substr($timesheet->notes, 0, 10) . ' ...' }}</p> --}}

                            </td>
                        </tbody>
                    @endforeach
                    {{-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">total: {{ $total_count - $count }}</td>
                        </tr> --}}
                </table>
            <div>
                <h4>Total days Worked:{{" ".$total_days_worked ."days"}}</h4>
            </div>
                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                    @php
                        $timesheet_status = App\Models\TimesheetStatus::where('id', '=', $timesheet->timesheet_status_id)->value('status');
                    @endphp
                    <div class="row">

                        <div class="col-lg-6">
                            <a class="dropdown-item btn btn-primary continue-btn btn-block"
                                data-emp_id="{{ $id }}" data-start_date="{{ $start_date }}"
                                data-end_date="{{ $end_date }}" data-status="approved" href="#"
                                data-toggle="modal" id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Change
                                Timesheet Status</a>
                        </div>
                        {{-- @if (!empty($timesheet_status) && $timesheet_status != 'approved') --}}
                            <div class="col-lg-6">
                                <a class="dropdown-item btn btn-primary continue-btn btn-block"
                                    data-emp_id="{{ $id }}" data-start_date="{{ $start_date }}"
                                    data-end_date="{{ $end_date }}" data-status="approved"
                                    href="{{ route('employee-timesheet-edit', ['id' => $timesheet->employee_id, 'start_date' => $start_date, 'end_date' => $end_date]) }}"
                                    id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Edit
                                    Timesheet</a>
                            </div>
                        {{-- @endif --}}
                    </div>
                @elseif(Auth::check() && Auth::user()->role->name == App\Models\Role::ADMIN && Auth::user()->id != $loginUserId )
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="dropdown-item btn btn-primary continue-btn btn-block"
                                data-emp_id="{{ $id }}" data-start_date="{{ $start_date }}"
                                data-end_date="{{ $end_date }}" data-status="approved" href="#"
                                data-toggle="modal" id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Change
                                Timesheet Status</a>
                        </div>
                @endif
            </div>
        </div>
    </div>

    <!-- update Employee Timsheet status Model-->
    <div class="modal custom-modal fade" id="update_timesheet_status" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Update {{ ucfirst($title) }} data</h3>
                        <p>Are you sure want to update status?</p>
                    </div>
                    <form action="{{ route('timesheet-status-update') }}" method="post" id="timesheet_status_form">
                        @csrf
                        <input type="hidden" id="emp_id" name="emp_id">
                        <input type="hidden" id="start_date" name="start_date">
                        <input type="hidden" id="end_date" name="end_date">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>TimeSheet Status<span class="text-danger">*</span></label>
                                    <select name="timesheet_status" id="timesheet_status_field" class="select form-control">
                                        <option value="">Select TimeSheet Status</option>
                                        @foreach ($timesheet_statuses as $time_status)
                                            <option value="{{ $time_status->id }}">
                                                {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="status_val_error">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>To Reason</label>
                                    <textarea name="status_reason" id="edit_status_reason" rows="4" class="form-control"></textarea>
                                    @if ($errors->has('status_reason'))
                                        <span class="text-danger">{{ $errors->first('status_reason') }}</span>
                                    @endif
                                </div>
                                <div class="validation_error">
                                </div>
                            </div>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary continue-btn btn-block" id="update_status"
                                        type="submit">Update</button>
                                </div>
                                <div class="col-6">
                                    <button data-dismiss="modal" class="btn btn-primary cancel-btn btn-block"
                                        id="">Cancel</button>
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
    <script>
        $("#update_status").on("click", function(event) {
            event.preventDefault()
            var timesheet_status_reason = "";
            var status_field_value = $("#timesheet_status_field").find(":selected").text().trim();
            console.log(status_field_value, "status_field_value");
            var timesheet_status_reason = $("#edit_status_reason").val();
            if ((status_field_value == "Approved")) {
                $("#timesheet_status_form").submit();
            } else if ((status_field_value == "Select TimeSheet Status")) {
                $(".status_val_error").html("");
                $(".status_val_error").html(
                    `<span class="text-danger">The timesheet status field is required.</span>`);
            } else if (timesheet_status_reason && status_field_value == "Rejected") {
                $("#timesheet_status_form").submit();
            } else if (status_field_value == "Rejected") {
                $(".status_val_error").html("");
                $(".validation_error").html("");
                $(".validation_error").html(`<span class="text-danger">The reason field is required.</span>`);
            }
        });


        $('#statusChecked').on('click', function() {
            $('#update_timesheet_status').modal('show');
            var emp_id = $(this).data('emp_id');
            var status = $(this).data('status');
            var start_date = $(this).data('start_date');
            var end_date = $(this).data('end_date');
            $('#emp_id').val(emp_id);
            $('#start_date').val(start_date);
            $('#end_date').val(end_date);
        });
    </script>
@endsection
