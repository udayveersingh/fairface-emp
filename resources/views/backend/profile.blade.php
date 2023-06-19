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
    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::Employee)
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
            </div>

            <!-- Employee Document -->
            <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                <div class="card profile-box flex-fill">
                    <div class="row">
                        @foreach ($employee_documents as $document)
                            @php
                                $extension = pathinfo(storage_path('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment), PATHINFO_EXTENSION);
                            @endphp
                            <div class="col-md-6">
                                <div class="card-body">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Document Name</div>
                                            <div class="text">{{ $document->name }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="title">Created Date</div>
                                            <div class="text">
                                                {{ !empty(date('Y-m-d', strtotime($document->created_at))) ? date('Y-m-d', strtotime($document->created_at)) : '' }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="text"><a
                                                    href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                                    class="btn btn-primary" target="_blank" download> download</a></div>
                                        </li>
                                    </ul>
                                    <br>
                                    @if (!empty($extension) && $extension == 'pdf')
                                        <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                            target="_blank"><img src="{{ asset('assets/img/profiles/photopdf.png') }}"
                                                width="300px" height="185px"></a>
                                    @else
                                        <a href="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                            target="_blank"><img
                                                src="{{ asset('storage/documents/employee/' . $document->employee_id . '/' . $document->attachment) }}"
                                                width="300px"></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
                <div class="row">
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
                </div>
            </div>
            <!-- Employee Visa -->
            <!-- Employee Project  -->
            <div class="tab-pane fade" id="project" role="tabpanel" aria-labelledby="project-tab">
                @if (!empty($employee_projects->count()))
                    <div class="row">
                        @foreach ($employee_projects as $project)
                            <div class="col-md-6 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <h3 class="card-title">Projects</h3>
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Project Name</div>
                                                <div class="text">
                                                    {{ !empty($project->projects->name) ? $project->projects->name : '' }}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Start Date</div>
                                                <div class="text">{{ $project->start_date }}</div>
                                            </li>
                                            <li>
                                                <div class="title">End Date</div>
                                                <div class="text">
                                                    {{ $project->end_date }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- Employee Projetct -->
            <!-- Employee Payslip -->
            <div class="tab-pane fade" id="payslip" role="tabpanel" aria-labelledby="payslip-tab">
                <div class="card profile-box flex-fill">
                    <div class="row">
                        @foreach ($employee_payslips as $payslip)
                            @php
                                $extension = pathinfo(storage_path('storage/payslips/' . $payslip->attachment), PATHINFO_EXTENSION);
                            @endphp
                            <div class="col-md-6">
                                <div class="card-body">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Month</div>
                                            <div class="text">{{ $payslip->month }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Year</div>
                                            <div class="text">{{ $payslip->year }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Created Date</div>
                                            <div class="text">
                                                {{ !empty(date('Y-m-d', strtotime($payslip->created_at))) ? date('Y-m-d', strtotime($payslip->created_at)) : '' }}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="text"><a
                                                    href="{{ asset('storage/payslips/' . $payslip->attachment) }}"
                                                    class="btn btn-primary" target="_blank" download> download</a></div>
                                        </li>
                                    </ul>
                                    <br>
                                    @if (!empty($extension) && $extension == 'pdf')
                                        <a href="{{ asset('storage/payslips/' . $payslip->attachment) }}"
                                            target="_blank"><img src="{{ asset('assets/img/profiles/photopdf.png') }}"
                                                width="300px" height="185px"></a>
                                    @else
                                        <a href="{{ asset('storage/payslips/' . $payslip->attachment) }}"
                                            target="_blank"><img
                                                src="{{ asset('storage/payslips/' . $payslip->attachment) }}"
                                                width="300px"></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
