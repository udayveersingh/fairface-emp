@extends('layouts.backend')

@section('styles')
@endsection

@section('page-header')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Profile</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="avatar"
                                        src="{{ !empty(auth()->user()->avatar) ? asset('storage/employees/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ ucfirst(auth()->user()->name) }}</h3>
                                        @if (Auth::check() && Auth::user()->role->name != App\Models\Role::SUPERADMIN)
                                            <h5 class="user-name m-t-0 mb-0">Employee ID: {{ $employee->employee_id }}</h5>
                                            <div class="text">Date of Join
                                                :
                                                {{ !empty($employee->created_at) ? date_format(date_create($employee->created_at), 'd-m-Y') : '' }}
                                            </div>
                                            <div class="text">Job Title
                                                : {{ ucfirst($job_title) }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Username:</div>
                                            <div class="text">{{ ucfirst(auth()->user()->username) }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Email:</div>
                                            <div class="text">{{ auth()->user()->email }}</div>
                                        </li>
                                        @if (Auth::check() && Auth::user()->role->name != App\Models\Role::SUPERADMIN)
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text">
                                                    {{ !empty($employee->date_of_birth) ? date('d-m-Y', strtotime($employee->date_of_birth)) : '' }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text">{{ $employee->phone }}</div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon"
                                    href="#"><i class="fa fa-pencil"></i></a></div>
                        @else
                            <div class="pro-edit"><a data-target="#change_profile_pic" data-toggle="modal" class="edit-icon"
                                    href="#"><i class="fa fa-pencil"></i></a></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::check() && Auth::user()->role->name != App\Models\Role::SUPERADMIN)
        @php
            $tabs = [
                'address' => 'Address',
                'document' => 'Document',
                'job' => 'Job',
                'visa' => 'Visa',
                'project' => 'Project',
                'payslip' => 'Payslip',
            ];
        @endphp
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="true">Profile</a>
            </li>
            @foreach ($tabs as $index => $tab)
                <li class="nav-item">
                    <a class="nav-link" id="{{ $index }}-tab" data-toggle="tab" href="#{{ $index }}"
                        role="tab" aria-controls="{{ $index }}" aria-selected="true">{{ $tab }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card card-block shadow shadow-sm p-3 h-80">
                    <h3 class="card-title">Personal Informations</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Main Branch Location:</div>
                                    <div class="text">
                                        {{ !empty($employee->branch->branch_code) ? $employee->branch->branch_code : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Alternate Phone Number:</div>
                                    <div class="text">
                                        {{ !empty($employee->alternate_phone_number) ? $employee->alternate_phone_number : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Nationality:</div>
                                    <div class="text">
                                        {{ !empty($employee->country->name) ? $employee->country->name : '' }}</div>
                                </li>
                                <li>
                                    <div class="title">National Insurance Number:</div>
                                    <div class="text">
                                        {{ !empty($employee->national_insurance_number) ? $employee->national_insurance_number : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Passport Number:</div>
                                    <div class="text">
                                        {{ !empty($employee->passport_number) ? $employee->passport_number : '' }}</div>
                                </li>
                                <li>
                                    <div class="title">Passport Issue Date:</div>
                                    <div class="text">
                                        {{ !empty($employee->passport_issue_date) ? date('d-m-Y', strtotime($employee->passport_issue_date)) : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Passport Expire Date:</div>
                                    <div class="text">
                                        {{ !empty($employee->passport_expiry_date) ? date('d-m-Y', strtotime($employee->passport_expiry_date)) : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Record Status:</div>
                                    <div class="text">
                                        {{ !empty($employee->record_status) ? $employee->record_status : '' }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- @if (!empty($emergency_contact))
                        <div class="col-md-6">
                            <div class="card card-block shadow shadow-sm p-3 h-80">
                                <h3 class="card-title">Emergency Contact</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Local Contact Name</th>
                                        <td>{{ !empty($emergency_contact->full_name) ? $emergency_contact->full_name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ !empty($emergency_contact->address) ? $emergency_contact->address : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number 1</th>
                                        <td>{{ !empty($emergency_contact->phone_number_1) ? $emergency_contact->phone_number_1 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number 2</th>
                                        <td>{{ !empty($emergency_contact->phone_number_2) ? $emergency_contact->phone_number_2 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Relationship</th>
                                        <td>{{ !empty($emergency_contact->relationship) ? $emergency_contact->relationship : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Overseas & Local Contact Name</th>
                                        <td>{{ !empty($emergency_contact->overseas_full_name) ? $emergency_contact->overseas_full_name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Overseas Address</th>
                                        <td>{{ !empty($emergency_contact->overseas_address) ? $emergency_contact->overseas_address : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Overseas Phone Number 1</th>
                                        <td>{{ !empty($emergency_contact->overseas_phone_number_1) ? $emergency_contact->overseas_phone_number_1 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Overseas Phone Number 2</th>
                                        <td>{{ !empty($emergency_contact->overseas_phone_number_2) ? $emergency_contact->overseas_phone_number_2 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Overseas Relationship</th>
                                        <td>{{ !empty($emergency_contact->overseas_relationship) ? $emergency_contact->overseas_relationship : '' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif --}}
                <div class="row">
                    @if (!empty($employee_bank))
                        <div class="col-md-6">
                            <div class="card card-block shadow shadow-sm p-3 h-80">
                                <h3 class="card-title">Bank Information</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Bank Account Name</th>
                                        <td>{{ !empty($employee_bank->account_name) ? $employee_bank->account_name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td>{{ !empty($employee_bank->bank_name) ? $employee_bank->bank_name : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bank Account Number</th>
                                        <td>{{ !empty($employee_bank->bank_account_number) ? $employee_bank->bank_account_number : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bank Sort Code</th>
                                        <td>{{ !empty($employee_bank->bank_sort_code) ? $employee_bank->bank_sort_code : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ifsc Code</th>
                                        <td>{{ !empty($employee_bank->ifsc_code) ? $employee_bank->ifsc_code : '' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                    @if (!empty($employee_addresses))
                        @foreach ($employee_addresses as $index => $employee_address)
                            @if ($index == 1)
                            @break;
                        @endif
                        <div class="col-md-6">
                            <div class="card card-block shadow shadow-sm p-3 h-80">
                                <h3 class="card-title">Address Information</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Address Line 1</th>
                                        <td>{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address Line 2</th>
                                        <td>{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Post Code</th>
                                        <td>{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>From Date</th>
                                        <td>{{ !empty($employee_address->from_date) ? date('d-m-Y', strtotime($employee_address->from_date)) : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>To Date</th>
                                        <td>{{ !empty($employee_address->to_date) ? date('d-m-Y', strtotime($employee_address->to_date)) : '' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                @if (!empty($employee_jobs))
                    @foreach ($employee_jobs as $index => $job)
                        @if ($index == 1)
                        @break;
                    @endif
                    @php
                        if (!empty($job->supervisor)) {
                            $supervisor = App\Models\Employee::find($job->supervisor);
                            $supervisor_name = $supervisor->firstname . ' ' . $supervisor->lastname;
                        } else {
                            $supervisor_name = '';
                        }
                        if (!empty($job->timesheet_approval_incharge)) {
                            $timesheet_approval_incharge = App\Models\Employee::find($job->timesheet_approval_incharge);
                            $incharge_name = $timesheet_approval_incharge->firstname . ' ' . $timesheet_approval_incharge->lastname;
                        } else {
                            $incharge_name = '';
                        }
                    @endphp
                    <div class="col-md-6">
                        <div class="card card-block shadow shadow-sm p-3 h-80 ">
                            <h3 class="card-title">Job Information</h3>
                            <table class="table table-striped">
                                <tr>
                                    <th>Job Title</th>
                                    <td>{{ $job->job_title }}</td>
                                </tr>
                                <tr>
                                    <th>supervisor </th>
                                    <td>{{ $supervisor_name }}</td>
                                </tr>
                                <tr>
                                    <th>Timesheet Approval Incharge </th>
                                    <td>{{ $incharge_name }}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>{{ !empty($job->department->name) ? $job->department->name : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Work Email</th>
                                    <td>{{ !empty($job->work_email) ? $job->work_email : '' }}</td>
                                </tr>
                                <tr>
                                    <th>Work Phone Number</th>
                                    <td>{{ $job->work_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ !empty($job->start_date) ? date('d-m-Y', strtotime($job->start_date)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ !empty($job->end_date) ? date('d-m-Y', strtotime($job->end_date)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Job Type</th>
                                    <td>{{ str_replace('_', ' ', $job->job_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Contracted Weekly Hours</th>
                                    <td>{{ $job->contracted_weekly_hours }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endif
            @if (!empty($employee_visas))
                @foreach ($employee_visas as $index => $visa)
                    @if ($index == 1)
                    @break;
                @endif
                <div class="col-md-6">
                    <div class="card card-block shadow shadow-sm p-3 h-80">
                        <h3 class="card-title">Visa Information</h3>
                        <table class="table table-striped">
                            <tr>
                                <th>Visa Type</th>
                                <td>{{ !empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Cos Number</th>
                                <td>{{ $visa->cos_number }}</td>
                            </tr>
                            <tr>
                                <th>Cos Issue Date</th>
                                <td>{{ !empty($visa->cos_issue_date) ? date('d-m-Y', strtotime($visa->cos_issue_date)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Cos Expire Date</th>
                                <td>{{ !empty($visa->cos_expiry_date) ? date('d-m-Y', strtotime($visa->cos_expiry_date)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Visa Issue Date</th>
                                <td>{{ !empty($visa->visa_issue_date) ? date('d-m-Y', strtotime($visa->visa_issue_date)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Visa Expiry Date</th>
                                <td>{{ !empty($visa->visa_expiry_date) ? date('d-m-Y', strtotime($visa->visa_expiry_date)) : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
    </div>
@endif
</div>

<!-- Employee Address-->
<div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
@if (!empty($employee_addresses))
<div class="card profile-box flex-fill">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <thead>
                            <tr>
                                <th style="width: 30px;">Sr No.</th>
                                <th>Address Line 1</th>
                                <th>Address Line 2</th>
                                <th>Post Code</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                {{-- <th class="text-right">Action</th> --}}
                            </tr>
                        </thead>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee_addresses as $index => $address)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $address->home_address_line_1 }}</td>
                            <td>{{ $address->home_address_line_2 }}</td>
                            <td>{{ $address->post_code }}</td>
                            <td>{{ !empty($address->from_date) ? date('d-m-Y', strtotime($address->from_date)) : '' }}
                            </td>
                            <td>{{ !empty($address->to_date) ? date('d-m-Y', strtotime($address->to_date)) : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_address"><i
                class="fa fa-plus"></i>
            Add New Address</a>
    </div>
</div>
@endif
</div>
<!-- Employee address -->

<!-- Employee Document -->
<div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
<div class="row mt-3">
<div class="col-md-12">
    <form id="documentform" method="POST" action="{{ route('employee-document-update') }}"
        enctype="multipart/form-data">
        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
        <input type="hidden" id="edit_id" value="{{ !empty($document->id) ? $document->id : '' }}"
            name="id">
        <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label">Document Name<span class="text-danger">*</span></label>
                    <input class="form-control edit_name" required name="name" type="text">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label">Attachment</label>
                    <input class="form-control" name="attachment" type="file">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="submit-section">
                    <button type="submit" id="submit" class="btn w-100 btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
@if (!empty($employee_documents))
<div class="card profile-box flex-fill">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <thead>
                            <tr>
                                <th style="width: 30px;">Sr No.</th>
                                <th>Document Name</th>
                                <th>Created</th>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee_documents as $index => $document)
                    @if($index > 5)
                    @break;
                    @endif
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $document->name }}</td>
                            <td>{{ !empty($document->created_at) ? date('d-m-Y', strtotime($document->created_at)) : '' }}
                            </td>
                            @php
                                $extension = pathinfo(storage_path('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment), PATHINFO_EXTENSION);
                            @endphp
                            <td>
                                @if (!empty($extension) && $extension == 'pdf')
                                    <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                        target="_blank"><img
                                            src="{{ asset('assets/img/profiles/photopdf.png') }}"
                                            width="100px"></a>
                                @else
                                    @if (!empty($document->attachment))
                                    <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                        target="_blank">
                                        <img src="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                            width="100px"></a>
                                    @else
                                    No Document
                                    {{-- <a href=""><img src={{asset('assets/img/document_image.png')}} width="100px"></a> --}}
                                            @endif 
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                    target="_blank" download>Download</a>
                            </td>
                            {{-- <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a data-id="{{$document->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-target="#deletebtn" data-resource_data="Employee Document" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td> --}}
                        </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-document.destroy'" :title="'Employee document'" />
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
</div>
<!-- Employee Document -->

<!-- Employee Job -->
<div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="job-tab">
<div class="row">
    @if (!empty($employee_jobs->count()) && $employee_jobs->count() > 0 )
    <div class="row">
        @foreach ($employee_jobs as $job)
            @php
                if (!empty($job->supervisor)) {
                    $supervisor = App\Models\Employee::find($job->supervisor);
                    $supervisor_name = $supervisor->firstname . ' ' . $supervisor->lastname;
                } else {
                    $supervisor_name = '';
                }
                if (!empty($job->timesheet_approval_incharge)) {
                    $timesheet_approval_incharge = App\Models\Employee::find($job->timesheet_approval_incharge);
                    $incharge_name = $timesheet_approval_incharge->firstname . ' ' . $timesheet_approval_incharge->lastname;
                } else {
                    $incharge_name = '';
                }
            @endphp
            <div class="col-md-12 mb-4">
                <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                    <table class="table table-striped">
                        <tr>
                            <th>Job Title</th>
                            <td>{{ $job->job_title }}</td>
                        </tr>
                        <tr>
                            <th>supervisor </th>
                            <td>{{ $supervisor_name }}</td>
                        </tr>
                        <tr>
                            <th>Timesheet Approval Incharge </th>
                            <td>{{ $incharge_name }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ !empty($job->department->name) ? $job->department->name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Work Email</th>
                            <td>{{ !empty($job->work_email) ? $job->work_email : '' }}</td>
                        </tr>
                        <tr>
                            <th>Work Phone Number</th>
                            <td>{{ $job->work_phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ !empty($job->start_date) ? date('d-m-Y',strtotime($job->start_date)):''}}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{!empty($job->end_date) ? date('d-m-Y',strtotime($job->end_date)):'' }}</td>
                        </tr>
                        <tr>
                            <th>Job Type</th>
                            <td>{{ str_replace('_', ' ', $job->job_type) }}</td>
                        </tr>
                        <tr>
                            <th>Contracted Weekly Hours</th>
                            <td>{{ $job->contracted_weekly_hours }}</td>
                        </tr>
                    </table>
                    {{-- <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                        <a data-id="{{ $job->id }}" data-employee_id="{{ $job->employee_id }}"
                            data-supervisor="{{ $job->supervisor }}"
                            data-timesheet_approval_inch="{{ $job->timesheet_approval_incharge }}"
                            data-job_title="{{ $job->job_title }}" data-department="{{ $job->department_id }}"
                            data-work_email="{{ $job->work_email }}"
                            data-work_phone_number="{{ $job->work_phone_number }}"
                            data-start_date="{{ $job->start_date }}" data-end_date="{{ $job->end_date }}"
                            data-job_type="{{ $job->job_type }}"
                            data-cont_weekly_hours="{{ $job->contracted_weekly_hours }}" class="btn btn-primary"
                            id="edit_btn" href="javascript:void(0);"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a data-id="{{ $job->id }}" data-resource_data="Employee Job"
                            class="btn btn-danger detail_delete" href="javascript:void(0);" data-target="delete_modal"
                            data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div> --}}
                </div>
            </div>
        @endforeach
    </div>
@endif
</div>
</div>
<!-- Employee Job -->
<!-- Emplolyee Visa -->
<div class="tab-pane fade" id="visa" role="tabpanel" aria-labelledby="visa-tab">
<div class="row">
@if (!empty($employee_visas))
    @foreach ($employee_visas as $visa)
        <div class="col-md-12 mb-4">
            <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                <table class="table table-striped">
                    <tr>
                        <th>Visa Type</th>
                        <td>{{ !empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Cos Number</th>
                        <td>{{ $visa->cos_number }}</td>
                    </tr>
                    <tr>
                        <th>Cos Issue Date</th>
                        <td>{{ !empty($visa->cos_issue_date) ? date('d-m-Y', strtotime($visa->cos_issue_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Cos Expire Date</th>
                        <td>{{ !empty($visa->cos_expiry_date) ? date('d-m-Y', strtotime($visa->cos_expiry_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Visa Issue Date</th>
                        <td>{{ !empty($visa->visa_issue_date) ? date('d-m-Y', strtotime($visa->visa_issue_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Visa Expiry Date</th>
                        <td>{{ !empty($visa->visa_expiry_date) ? date('d-m-Y', strtotime($visa->visa_expiry_date)) : '' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach
@endif
</div>
</div>
<!-- Employee Visa -->
<!-- Employee Project  -->
<div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
@if (!empty($employee_projects))
<div class="row">
    @foreach ($employee_projects as $project)
        <div class="col-md-12 mb-4">
            <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                <table class="table table-striped">
                    <tr>
                        <th>Project</th>
                        <td>{{ !empty($project->projects->name) ? $project->projects->name : '' }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ !empty($project->start_date) ? date('d-m-Y', strtotime($project->start_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ !empty($project->end_date) ? date('d-m-Y', strtotime($project->end_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>status</th>
                        @php
                            $status = '';
                            if (!empty($project->projects->status) && $project->projects->status == 1) {
                                $status = 'Active';
                            } else {
                                $status = 'Inactive';
                            }
                        @endphp
                        <td>{{ $status }}</td>
                    </tr>
                </table>
                {{-- <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                                    <a data-id="{{ $project->id }}" data-employee_id="{{ $project->employee_id }}"
                                        data-project="{{ $project->project_id }}" data-start_date="{{ $project->start_date }}"
                                        data-end_date="{{ $project->end_date }}" class="btn btn-primary edit_btn"
                                        data-target="edit_employee_project" href="javascript:void(0);" data-toggle="modal"><i
                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{ $project->id }}" class="btn btn-danger detail_delete"
                                        data-resource_data="Employee Project" href="javascript:void(0);" data-toggle="modal"><i
                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div> --}}
            </div>
        </div>
    @endforeach
</div>
@endif
</div>
<!-- Employee Project -->
<!-- Employee Payslip -->
<div class="tab-pane fade" id="payslip" role="tabpanel" aria-labelledby="payslip-tab">
<div class="card profile-box flex-fill">
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0">
            <thead>
                <tr>
                    <th style="width: 30px;">Sr No.</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Created</th>
                    <th>Attachment</th>
                    <th>Action</th>
                    {{-- <th class="text-right">Action</th> --}}
                </tr>
            </thead>
            <tbody id="bodyData">
                @if (!empty($employee_payslips))
                    @foreach ($employee_payslips as $index => $employee_payslip)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ !empty($employee_payslip->month) ? $employee_payslip->month : '' }}</td>
                            <td>{{ !empty($employee_payslip->year) ? $employee_payslip->year : '' }}</td>
                            <td>{{ !empty(date('Y-m-d', strtotime($employee_payslip->created_at))) ? date('Y-m-d', strtotime($employee_payslip->created_at)) : '' }}
                            </td>
                            @php
                                $extension = pathinfo(storage_path('storage/payslips/' . $employee_payslip->attachment), PATHINFO_EXTENSION);
                            @endphp
                            <td>
                                @if ($extension == 'pdf')
                                    <a href="{{ asset('storage/payslips/' . $employee_payslip->attachment) }}"
                                        target="_blank"><img
                                            src="{{ asset('assets/img/profiles/photopdf.png') }}"
                                            width="100px"></a>
                                @else
                                    <a href="{{ asset('storage/payslips/' . $employee_payslip->attachment) }}"
                                        target="_blank"><img
                                            src="{{ asset('storage/payslips/' . $employee_payslip->attachment) }}"
                                            width="120px" height="100px"></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ asset('storage/payslips/' . $employee_payslip->attachment) }}"
                                    target="_blank" download>Download
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<!-- Employee Payslip -->
</div>
@endif
<!-- admin Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Profile Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" action="{{ route('profile') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-img-wrap edit-img">
                        <img class="inline-block"
                            src="{{ !empty(auth()->user()->avatar) ? asset('storage/users/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"
                            alt="user">
                        <div class="fileupload btn">
                            <span class="btn-text">edit</span>
                            <input name="avatar" class="upload" type="file">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ auth()->user()->name }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Username</label>
                                <input type="text" class="form-control" name="username"
                                    value="{{ auth()->user()->username }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button class="btn btn-primary submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
<!-- admin profile modal -->

<!-- Employee Profile Modal -->
@include('backend.profile-models.emp-profile-pic')
<!-- Employee Profile Modal -->

@if (Auth::check() && Auth::user()->role->name != App\Models\Role::SUPERADMIN)
<!-- /Profile Modal -->
@include('backend.profile-models.employee-address')
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/js/employee.js') }}"></script>
@endsection
