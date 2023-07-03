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
        @endphp
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Employee Name:-</strong><span>{{ Auth::user()->name }}</span></div>
            <div class="col-md-6"><strong>Month Ending:-</strong> <span>{{ $date->format('d-m-Y') }}</span></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p class="mx-0"><strong>Month starting:-</strong>{{ $start_date }}</p>
                <p class="mx-0"></p>
                {{-- <table class="table">
                    <tr>
                        <td>Sr no.</td>
                        <td>Project Name</td>
                        <td>Supervisor</td>
                        <td>Calender Date</td>
                        <td>Days</td>
                        <td>Start Time</td>
                        <td>Finish Time</td>
                        <td>1/2 or 1 Day</td>
                    </tr>
                    <tbody id="bodyData">
                        @foreach ($employee_timesheets as $index => $timesheet)
                            @php
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
                                $supervisor = App\Models\User::where('id', '=', $timesheet->supervisor_id)->value('name');
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ !empty($timesheet->project->name) ? $timesheet->project->name : '______' }}</td>
                                <td>{{ !empty($supervisor) ? $supervisor : '______' }}</td>
                                <td>{{ $timesheet->calender_date }}</td>
                                <td>{{ $timesheet->calender_day }}</td>
                                <td>{{ !empty($from_time) ? $from_time : '' }}</td>
                                <td>{{ !empty($to_time) ? $to_time : '' }}</td>
                                <td>{{ $timesheet_hours }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
                <table border="1px">
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Start Time</td>
                        <td>Finish Time</td>
                        <td>1/2 or 1 Day</td>
                    </tr>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($employee_timesheets as $index => $timesheet)
                        <tbody id="bodyData">
                            @php
                                if ($timesheet->calender_day == 'Sunday') {
                                    $count++;
                                    continue;
                                }
                                $total_count = $index + 1;
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">total: {{ $total_count - $count }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
