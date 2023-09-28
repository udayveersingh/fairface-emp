@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('content')
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) href="{{ route('dashboard') }}" @else href="{{ route('employee-dashboard') }}" @endif>Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Leave Details</li>
            </ul>
            <h3 class="page-title">Leave details</h3>
        </div>
    </div>
@endsection
@php
    $first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname : '';
    $last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname : '';
    $full_name = $first_name . ' ' . $last_name;
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card card-block shadow shadow-sm p-3 h-100 w-100">
            <table class="table table-striped">
                <tr>
                    <th>Employee</th>
                    <td>{{ ucfirst($full_name) }}</td>
                </tr>
                <tr>
                    <th>Leave Type</th>
                    <td>{{ !empty($leave->leaveType->type) ? ucfirst($leave->leaveType->type) : '' }}</td>
                </tr>
                <tr>
                    <th>From Date</th>
                    <td>{{ date_format(date_create($leave->from), 'd M, Y') }}</td>
                </tr>
                <tr>
                    <th>To Date</th>
                    <td>{{ date_format(date_create($leave->to), 'd M, Y') }}</td>
                </tr>
                <tr>
                    <th>No. of Days</th>
                    <td>
                        @php
                            $start = new DateTime($leave->to);
                            $end_date = new DateTime($leave->from);
                        @endphp
                        @if ($start == $end_date)
                            {{ '1 Days' }}
                        @else
                            {{ $start->diff($end_date, '%d')->days . ' ' . Str::plural('Days', $start->diff($end_date, '%d')->days) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Reason</th>
                    <td>{{ $leave->reason }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ !empty($leave->time_sheet_status->status) ? ucfirst($leave->time_sheet_status->status) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Status Reason</th>
                    <td>{{ $leave->status_reason }}</td>
                </tr>
                <tr>
                    <th>Approved Date/Time</th>
                    <td>{{ !empty($leave->approved_date_time) ? date('d-m-Y', strtotime($leave->approved_date_time)) : '' }}
                    </td>
                </tr>
            </table>
            <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                {{-- <a data-id="{{ $job->id }}" data-employee_id="{{ $job->employee_id }}"
                        data-supervisor="{{ $job->supervisor }}"
                        data-timesheet_approval_inch="{{ $job->timesheet_approval_incharge }}"
                        data-job_title="{{ $job->job_title }}" data-department="{{ $job->department_id }}"
                        data-work_email="{{ $job->work_email }}" data-work_phone_number="{{ $job->work_phone_number }}"
                        data-start_date="{{ $job->start_date }}" data-end_date="{{ $job->end_date }}"
                        data-job_type="{{ $job->job_type }}" data-cont_weekly_hours="{{ $job->contracted_weekly_hours }}"
                        class="btn btn-primary" id="edit_btn" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i>
                        Edit</a>
                    <a data-id="{{ $job->id }}" data-resource_data="Employee Job" class="btn btn-danger detail_delete"
                        href="javascript:void(0);" data-target="delete_modal" data-toggle="modal"><i
                            class="fa fa-trash-o m-r-5"></i> Delete</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection
