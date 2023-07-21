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
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Employee Timesheet Details</h1>
            </div>
        </div>
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
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Employee Name:-</strong><span>
                    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                        {{ $employee_name }} @else{{ Auth::user()->name }}
                    @endif
                </span></div>
            <div class="col-md-6"><strong>Month Ending:-</strong> <span>{{ $end_date }}</span></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="mx-0"><strong>Month starting:-</strong>{{ $start_date }}</p>
                <p class="mx-0"></p>
                <table class="table table-bordered">
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th>1/2 or 1 Day</th>
                    </tr>
                    {{-- @php
                        $count = 0;
                    @endphp --}}
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
                                } elseif (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '4 hours') {
                                    $timesheet_hours = 'Half day';
                                } else {
                                    $timesheet_hours = '______';
                                }
                                $from_time = date('H:i', strtotime($timesheet->from_time));
                                $to_time = date('H:i', strtotime($timesheet->to_time));
                            @endphp
                            <td>{{ $timesheet->calender_day }}</td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ !empty($from_time) ? $from_time : '' }}</td>
                            <td>{{ !empty($to_time) ? $to_time : '' }}</td>
                            <td>{{ $timesheet_hours }}</td>
                        </tbody>
                    @endforeach
                    {{-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2">total: {{ $total_count - $count }}</td>
                        </tr> --}}
                </table>
                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                    <a class="dropdown-item btn btn-primary continue-btn btn-block" data-emp_id="{{ $id }}"
                        data-start_date="{{ $start_date }}" data-end_date="{{ $end_date }}" data-status="approved"
                        href="#" data-toggle="modal" id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Timesheet
                        Status</a>
                @endif
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
                        <input type="hidden" id="emp_id" name="emp_id">
                        <input type="hidden" id="start_date" name="start_date">
                        <input type="hidden" id="end_date" name="end_date">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Timesheet status Reason</label>
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
    <script>
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
