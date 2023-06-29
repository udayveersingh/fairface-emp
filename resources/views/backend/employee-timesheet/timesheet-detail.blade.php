@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    {{-- @endsection --}}
@section('content')
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Employee Timesheet Details</h1>
                {{-- <h3 class="text-left">Employee Time Sheet</h3> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{-- <p class="mx-0">Week starting:- <strong>{{ $week_starting->format('d-m-Y') }}</strong></p> --}}
                <p class="mx-0"></p>
                <table class="table">
                    <tr>
                        <td>Sr no.</td>
                        <td>Project Name</td>
                        <td>Project Phase</td>
                        <td>Calender Date</td>
                        <td>Days</td>
                        <td>Start Time</td>
                        <td>Finish Time</td>
                        <td>1/2 or 1 Day</td>
                    </tr>
                    <tbody id="bodyData">
                        @foreach ($employee_timesheets as $index => $timesheet)
                         @php
                             $timesheet_hours = "____";
                             if(!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == "8 hours")
                             {
                                $timesheet_hours = "Full day";
                             }elseif (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == "4 hours" ) {
                                $timesheet_hours = "Half day";
                             }
                            $from_time = date('H:i', strtotime($timesheet->from_time));
                            $to_time = date('H:i', strtotime($timesheet->to_time));
                         @endphp
                        <tr>
                                <td>{{$index+1}}</td>
                                <td>{{!empty(ucfirst($timesheet->project->name)) ? $timesheet->project->name:''}}</td>
                                <td>{{!empty(ucfirst($timesheet->projectphase->name))? $timesheet->projectphase->name:''}}</td>
                                <td>{{$timesheet->calender_date}}</td>
                                <td>{{$timesheet->calender_day}}</td>
                                <td>{{!empty($from_time)? $from_time:'____'}}</td>
                                <td>{{!empty($to_time) ? $to_time:'____'}}</td>
                                <td>{{$timesheet_hours}}</td>
                            </tr>
                            @endforeach
                    </tbody>
            </div>
        </div>
    </div>
    @endsection
