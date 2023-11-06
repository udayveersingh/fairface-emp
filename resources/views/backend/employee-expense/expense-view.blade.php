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
                <li class="breadcrumb-item active">Expenses Details</li>
            </ul>
            <h3 class="page-title">Expenses details</h3>
            {{-- @if (!empty($expenses))
                <div class="col-auto float-right ml-auto mt-2">
                    <a href="{{ route('print-employee-leave', $leave->id) }}" class="btn add-btn" target="_blank"><i
                            class="fa fa-download"></i>Print PDF</a>
                </div>
                <div class="col-auto float-right ml-auto mt-2">
                    <a class="btn add-btn" id="edit_btn" href="{{route('employee-leave')}}"><i class=""></i>
                        Back</a>
                </div>
            @endif --}}
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
                {{-- <a class="btn btn-primary" id="edit_btn" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i>
                        Back</a> --}}
                {{-- <a data-id="{{ $job->id }}" data-resource_data="Employee Job" class="btn btn-danger detail_delete"
                        href="javascript:void(0);" data-target="delete_modal" data-toggle="modal"><i
                            class="fa fa-trash-o m-r-5"></i> Delete</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection
