{{-- @extends('layouts.backend')

@section('styles') --}}
    <!-- Select2 CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}"> --}}

    <!-- Datatable CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

 @section('content')
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) href="{{ route('dashboard') }}" @else href="{{ route('employee-dashboard') }}" @endif>Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Expenses Details</li>
            </ul>
            <h3 class="page-title">Expenses details</h3>
        </div>
    </div>
@endsection
@php
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card card-block shadow shadow-sm p-3 h-100 w-100">
            <table class="table table-striped">
                @php
                $firstName = !empty($expenses->employee->firstname) ? $expenses->employee->firstname : '';
                $lastName = !empty($expenses->employee->lastname) ? $expenses->employee->lastname : '';
                $emp_full_name = $firstName . ' ' . $lastName;

                $supervisor_id = $expenses->supervisor_id;
                $get_suepervisor = app\models\Employee::find($expenses->supervisor_id);
                $sup_firstname = !empty($get_suepervisor->firstname) ? $get_suepervisor->firstname : '';
                $sup_lastname = !empty($get_suepervisor->lastname) ? $get_suepervisor->lastname : '';
                $sup_fullname = $sup_firstname . ' ' . $sup_lastname;
                @endphp
                <tr>
                    <th>Expense Id</th>
                    <td>{{$expenses->expense_id}}</td>
                </tr>
                <tr>
                    <th>Expense Type</th>
                    <td>{{ !empty($expenses->expensetype->type) ? $expenses->expensetype->type : '' }}</td>
                </tr>
                <tr>
                    <th>Employee</th>
                    <td>{{ ucfirst($emp_full_name) }}</td>
                </tr>
                <tr>
                    <th>Supervisor</th>
                    <td>{{ ucfirst($sup_fullname) }}</td>
                </tr>
                <tr>
                    <th>Project</th>
                    <td>{{ !empty($expenses->project->name) ? $expenses->project->name : '' }}</td>
                </tr>
                <tr>
                    <th>Occurred Date</th>
                    <td>{{ !empty($expenses->expense_occurred_date) ? date('d-m-Y', strtotime($expenses->expense_occurred_date)) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Cost</th>
                    <td>{{ app(App\Settings\ThemeSettings::class)->currency_symbol.' '.$expenses->cost }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {{ !empty($expenses->time_sheet_status->status) ? ucfirst($expenses->time_sheet_status->status) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Status Reason</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Approved Date/Time</th>
                    <td>
                    </td>
                </tr>
            </table>
            <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    @endsection
    <style>
        table,th,td {
            border: 1px solid;
        }
    </style>
 @section('content')
    @php
        //Monthly ending date
        $date = new DateTime('now');
        $date->modify('last day of this month');

        //display week starting date
        $week_starting = new DateTime('now');
        $week_starting->modify('first day of this month');
    @endphp
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Employee Expenses Details</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Employee Name:-</strong><span>
                </span></div>
            <div class="col-md-6 mt-2">
                {{-- <a href="" class="btn add-btn" target="_blank"><i class="fa fa-download"></i>Print PDF File</a> --}}
                <a href="" class="btn add-btn mr-2">Back</a>
            </div>
        </div>
    </div>
        {{-- <div class="row">
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
        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Expense Id</th>
                        <th>Expense Type</th>
                        <th>Employee</th>
                        <th>Supervisor</th>
                        <th>Project</th>
                        <th>Occurred Date</th>
                        <th>Status</th>
                        <th>Cost</th>
                    </tr>
                    @php
                        $count = 0;
                        $total_days_worked = 0;
                    @endphp
                    
                </table>
        </div>
    </div> 
</div>
@endsection
