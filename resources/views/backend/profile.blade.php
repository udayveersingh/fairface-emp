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
                                        src="{{ !empty(auth()->user()->avatar) ? asset('storage/users/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ auth()->user()->name }}</h3>
                                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::EMPLOYEE)
                                            <h5 class="user-name m-t-0 mb-0">Employee ID:{{ $employee->employee_id }}</h5>
                                            <div class="text">Date of Join
                                                :{{ date_format(date_create($employee->created_at), 'd M,Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Username:</div>
                                            <div class="text">{{ auth()->user()->username }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Email:</div>
                                            <div class="text">{{ auth()->user()->email }}</div>
                                        </li>
                                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::EMPLOYEE)
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text">{{ $employee->date_of_birth }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text">{{ $employee->phone }}</div>
                                            </li>
                                            <li>
                                                <div class="title">Marital Status:</div>
                                                <div class="text">{{ $employee->marital_status }}</div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon"
                                    href="#"><i class="fa fa-pencil"></i></a></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
                role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">test</div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">test2</div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">test3</div>
    </div> --}}
    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::EMPLOYEE)
        @php
            $tabs = [
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
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Personal Informations
                                    {{-- <a href="#" class="edit-icon"
                                    data-bs-toggle="modal" data-bs-target="#personal_info_modal">
                                    <i class="fa fa-pencil"></i>
                                </a> --}}
                                </h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Main Branch Location</div>
                                        <div class="text">
                                            {{ !empty($employee->branch->branch_code) ? $employee->branch->branch_code : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Alternate Phone Number</div>
                                        <div class="text">{{ $employee->alternate_phone_number }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Nationality</div>
                                        <div class="text">
                                            {{ !empty($employee->country->name) ? $employee->country->name : '' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">National Insurance Number</div>
                                        <div class="text">{{ $employee->national_insurance_number }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Passport Number</div>
                                        <div class="text">{{ $employee->passport_number }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Passport Issue Date</div>
                                        <div class="text">{{ $employee->passport_issue_date }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Passport Expire Date</div>
                                        <div class="text">{{ $employee->passport_expiry_date }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Record Status</div>
                                        <div class="text">{{ $employee->record_status }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Emergency Contact
                                    {{-- <a href="#" class="edit-icon"
                                    data-bs-toggle="modal" data-bs-target="#emergency_contact_modal"><i
                                        class="fa fa-pencil"></i></a> --}}
                                </h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Local Contact Name</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->full_name) ? $emergency_contact->full_name : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Address</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->address) ? $emergency_contact->address : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Phone Number 1</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->phone_number_1) ? $emergency_contact->phone_number_1 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Phone Number 2</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->phone_number_2) ? $emergency_contact->phone_number_2 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Relationship</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->relationship) ? $emergency_contact->relationship : '' }}
                                        </div>
                                    </li>
                                </ul>
                                <hr style="margin-top:3rem;">
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Overseas & Local Contact Name</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->overseas_full_name) ? $emergency_contact->overseas_full_name : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Overseas Address</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->overseas_address) ? $emergency_contact->overseas_address : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Overseas Phone Number 1 </div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->overseas_phone_number_1) ? $emergency_contact->overseas_phone_number_1 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Overseas Phone Number 2</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->overseas_phone_number_2) ? $emergency_contact->overseas_phone_number_2 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Overseas Relationship</div>
                                        <div class="text">
                                            {{ !empty($emergency_contact->overseas_relationship) ? $emergency_contact->overseas_relationship : '' }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Bank Information</h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank Account Name</div>
                                        <div class="text">
                                            {{ !empty($employee_bank->account_name) ? $employee_bank->account_name : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Bank name</div>
                                        <div class="text">
                                            {{ !empty($employee_bank->bank_name) ? $employee_bank->bank_name : '' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Bank account No.</div>
                                        <div class="text">
                                            {{ !empty($employee_bank->bank_account_number) ? $employee_bank->bank_account_number : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">IFSC Code</div>
                                        <div class="text">
                                            {{ !empty($employee_bank->ifsc_code) ? $employee_bank->ifsc_code : '' }}</div>
                                    </li>
                                    <li>
                                        <div class="title">Bank Sort Code</div>
                                        <div class="text">
                                            {{ !empty($employee_bank->bank_sort_code) ? $employee_bank->bank_sort_code : '' }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Employee Address</h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Address Line 1</div>
                                        <div class="text">
                                            {{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Address Line 2</div>
                                        <div class="text">
                                            {{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Post Code</div>
                                        <div class="text">
                                            {{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">From Date</div>
                                        <div class="text">
                                            {{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">To Date</div>
                                        <div class="text">
                                            {{ !empty($employee_address->to_date) ? $employee_address->to_date : '' }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
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
                    <div class="col-md-6 mb-4">
                        <div class="card card-block shadow shadow-sm p-3 h-80 ">
                            {{-- <h3 class="card-title">Employee Job</h3> --}}
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
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card card-block shadow shadow-sm p-3 h-80 ">
                            <table class="table table-striped">
                                <tr>
                                    <th>Work Phone Number</th>
                                    <td>{{ $job->work_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $job->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $job->end_date }}</td>
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
            </div>
            @if (!empty($employee_visas->count()))
                <div class="row">
                    @foreach ($employee_visas as $index => $visa)
                        @if ($index == 1)
                        @break;
                    @endif
                    <div class="col-md-6 mb-4">
                        <div class="card card-block shadow shadow-sm p-3 h-80">
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
                                    <td>{{ $visa->cos_issue_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card card-block shadow shadow-sm p-3 h-80">
                            <table class="table table-striped">
                                <tr>
                                    <th>Cos Expire Date</th>
                                    <td>{{ $visa->cos_expiry_date }}</td>
                                </tr>
                                <tr>
                                    <th>Visa Issue Date</th>
                                    <td>{{ $visa->visa_issue_date }}</td>
                                </tr>
                                <tr>
                                    <th>Visa Expiry Date</th>
                                    <td>{{ $visa->visa_expiry_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Employee Document -->
    <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
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
                                        {{-- <th class="text-right">Action</th> --}}
                                    </tr>
                                </thead>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee_documents as $index => $document)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ !empty(date('Y-m-d', strtotime($document->created_at))) ? date('Y-m-d', strtotime($document->created_at)) : '' }}
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
                                            <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                                target="_blank"><img
                                                    src="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                                    width="100px"></a>
                                        @endif
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
    </div>
    <!-- Employee Document -->

    <!-- Employee Job -->
    <div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="job-tab">
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
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Employee Job</h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Job Title</div>
                                    <div class="text">{{ $job->job_title }}</div>
                                </li>
                                <li>
                                    <div class="title">supervisor</div>
                                    <div class="text">{{ $supervisor_name }}</div>
                                </li>
                                <li>
                                    <div class="title">Timesheet Approval Incharge</div>
                                    <div class="text">
                                        {{ $incharge_name }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Department</div>
                                    <div class="text">
                                        {{ !empty($job->department->name) ? $job->department->name : '' }}</div>
                                </li>
                                <li>
                                    <div class="title">Work Email</div>
                                    <div class="text">{{ !empty($job->work_email) ? $job->work_email : '' }}
                                    </div>
                                </li>
                                <li>
                                    <div class="title">Work Phone Number</div>
                                    <div class="text">{{ $job->work_phone_number }}</div>
                                </li>
                                <li>
                                    <div class="title">Start Date</div>
                                    <div class="text">{{ $job->start_date }}</div>
                                </li>
                                <li>
                                    <div class="title">End Date</div>
                                    <div class="text">{{ $job->end_date }}</div>
                                </li>
                                <li>
                                    <div class="title">Job Type</div>
                                    <div class="text">{{ str_replace('_', ' ', $job->job_type) }}</div>
                                </li>
                                <li>
                                    <div class="title">Contracted Weekly Hours</div>
                                    <div class="text">{{ $job->contracted_weekly_hours }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Employee Job -->
    <!-- Emplolyee Visa -->
    <div class="tab-pane fade" id="visa" role="tabpanel" aria-labelledby="visa-tab">
        {{-- <div class="row">
                    @foreach ($employee_visas as $visa)
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Employee Visa</h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Visa Type</div>
                                            <div class="text">
                                                {{ !empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type : '' }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Cos Number</div>
                                            <div class="text">{{ $visa->cos_number }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Cos Issue Date</div>
                                            <div class="text">
                                                {{ $visa->cos_issue_date }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Cos Expire Date</div>
                                            <div class="text">
                                                {{ $visa->cos_expiry_date }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Visa Issue Date</div>
                                            <div class="text">{{ $visa->visa_issue_date }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Visa Expiry Date</div>
                                            <div class="text">{{ $visa->visa_expiry_date }}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
        <div class="row">
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
                                <td>{{ $visa->cos_issue_date }}</td>
                            </tr>
                            <tr>
                                <th>Cos Expire Date</th>
                                <td>{{ $visa->cos_expiry_date }}</td>
                            </tr>
                            <tr>
                                <th>Visa Issue Date</th>
                                <td>{{ $visa->visa_issue_date }}</td>
                            </tr>
                            <tr>
                                <th>Visa Expiry Date</th>
                                <td>{{ $visa->visa_expiry_date }}</td>
                            </tr>
                        </table>
                        {{-- <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                                    <a data-id="{{ $visa->id }}" data-employee_id="{{ $visa->employee_id }}"
                                        data-visa_type="{{ $visa->visa_type }}" data-cos_number="{{ $visa->cos_number }}"
                                        data-cos_issue_date="{{ $visa->cos_issue_date }}"
                                        data-cos_expiry_date="{{ $visa->cos_expiry_date }}"
                                        data-visa_issue_date="{{ $visa->visa_issue_date }}"
                                        data-visa_expiry_date="{{ $visa->visa_expiry_date }}" data-target="edit_employee_visa"
                                        class="btn btn-primary" id="edit_btn_visa" href="javascript:void(0);" data-toggle="modal"><i
                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{ $visa->id }}" class="btn btn-danger detail_delete"
                                        data-resource_data="Employee Visa" href="javascript:void(0);" data-toggle="modal"><i
                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Employee Visa -->
    <!-- Employee Project  -->
    <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
        @if (!empty($employee_projects->count()))
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
                                    <td>{{ $project->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $project->end_date }}</td>
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
                                {{-- <th class="text-right">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody id="bodyData">
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
                                                    width="100px"></a>
                                        @endif
                                    </td>
                                    {{-- <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a data-id="{{$employee_payslip->id}}" class="dropdown-item detail_delete" href="javascript:void(0);" data-resource_data="Employee Payslip" data-target="data_delete_modal" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Employee Payslip -->
</div>
@endif
<!-- Profile Modal -->
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
<!-- /Profile Modal -->
@endsection

@section('scripts')
@endsection
