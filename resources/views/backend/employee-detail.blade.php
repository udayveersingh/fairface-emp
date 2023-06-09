@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection
@section('content')
    <?php
    $tabs = [
        'document' => 'Document',
        'job' => 'Job',
        'visa' => 'Visa',
        'project' => 'Project',
        'contact' => 'Contact',
        'address' => 'Address',
        'bank' => 'Bank',
        'payslip' => 'Payslip',
    ];
    ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="basic_info-tab" data-toggle="tab" href="#basic_info" role="tab"
                aria-controls="basic_info" aria-selected="true">Basic Info</a>
        </li>
        @foreach ($tabs as $index => $tab)
            <li class="nav-item">
                <a class="nav-link" id="{{ $index }}-tab" data-toggle="tab" href="#{{ $index }}"
                    role="tab" aria-controls="{{ $index }}" aria-selected="true">{{ $tab }}</a>
            </li>
        @endforeach
    </ul>

    @if (!empty($employee))
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="basic_info" role="tabpanel" aria-labelledby="basic_info-tab">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-block shadow shadow-sm p-3 h-100">
                            <table class="table table-striped">
                                <tr>
                                    <th>Employee Id</th>
                                    <td>{{ $employee->employee_id }}</td>
                                </tr>
                                <tr>
                                    <th>Main Branch Location</th>
                                    <td>{{ !empty($employee->branch->branch_code) ? $employee->branch->branch_code : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $employee->firstname . ' ' . $employee->lastname }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $employee->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Alternate Phone Number</th>
                                    <td>{{ $employee->alternate_phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $employee->date_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th>Nationality</th>
                                    <td>{{ !empty($employee->country->name) ? $employee->country->name : '' }}</td>
                                </tr>
                                <tr>
                                    <th>National Insurance Number</th>
                                    <td>{{ $employee->national_insurance_number }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Number</th>
                                    <td>{{ $employee->passport_number }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Issue Date</th>
                                    <td>{{ $employee->passport_issue_date }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Expire Date</th>
                                    <td>{{ $employee->passport_expiry_date }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Expire Date</th>
                                    <td>{{ $employee->passport_expiry_date }}</td>
                                </tr>
                                <tr>
                                    <th>Marital Status</th>
                                    <td>{{ $employee->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th>Record Status </th>
                                    <td>{{ $employee->record_status }}</td>
                                </tr>
                            </table>
                            <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                                <a class="btn btn-primary w-100 " id="employee_edit_btn" href="javascript:void(0)"
                                    data-id="{{ !empty($employee->id) ? $employee->id : '' }}"
                                    data-employee_id="{{ $employee->employee_id }}"
                                    data-firstname="{{ $employee->firstname }}" data-lastname="{{ $employee->lastname }}"
                                    data-email="{{ $employee->email }}" data-phone="{{ $employee->phone }}"
                                    data-avatar="{{ $employee->avatar }}" data-company="{{ $employee->company }}"
                                    data-main_work_loc="{{ !empty($employee->branch->id) ? $employee->branch->id : '' }}"
                                    data-phone_number="{{ $employee->alternate_phone_number }}"
                                    data-national_insurance_number="{{ $employee->national_insurance_number }}"
                                    data-nationality="{{ $employee->country_id }}"
                                    data-passport_number="{{ $employee->passport_number }}"
                                    data-marital_status="{{ $employee->marital_status }}"
                                    data-record_status="{{ $employee->record_status }}"
                                    data-date_of_birth="{{ $employee->date_of_birth }}"
                                    data-passport_issue_date="{{ $employee->passport_issue_date }}"
                                    data-passport_expiry_date="{{ $employee->passport_expiry_date }}"
                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    @if (!empty($employee->avatar))
                        <div class="col-md-4">
                            <div class="card card-block shadow shadow-sm p-3">
                                <img alt="avatar" height="300px"
                                    src="@if (!empty($employee->avatar)) {{ asset('storage/employees/' . $employee->avatar) }}  @else assets/img/profiles/default.jpg @endif">
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Edit Employee Modal -->
                <div id="edit_employee_detail" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Employee</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="POST" action="{{ route('employee.update') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <input type="hidden" name="id"
                                                    value="{{ !empty($employee->id) ? $employee->id : '' }}"
                                                    id="edit_id">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Employee ID <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control"
                                                            value="{{ !empty($employee->employee_id) ? $employee->employee_id : '' }}"
                                                            name="employee_id" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Main Work Location<span class="text-danger">*</span></label>
                                                        <select name="branch_id" class="form-control">
                                                            <option value="">Select Main Work Location</option>
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}"
                                                                    {{ !empty($employee->branch_id) && $employee->branch_id == $branch->id ? 'selected' : '' }}>
                                                                    {{ $branch->branch_code }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Employee Picture<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control floating edit_avatar" name="avatar"
                                                            type="file">
                                                    </div>
                                                    <img alt="avatar"
                                                        src="@if (!empty($employee->avatar)) {{ asset('storage/employees/' . $employee->avatar) }} @else assets/img/profiles/default.jpg @endif"
                                                        width="100px"><br>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">First Name <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control edit_firstname" name="firstname"
                                                            value="{{ $employee->firstname }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Last Name</label>
                                                        <input class="form-control edit_lastname" name="lastname"
                                                            value="{{ $employee->lastname }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Phone Number Main </label>
                                                        <input class="form-control edit_phone mask_phone_number"
                                                            name="phone" value="{{ $employee->phone }}"
                                                            type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Phone Number Alternate</label>
                                                        <input class="form-control edit_al_phone_number mask_phone_number"
                                                            name="al_phone_number"
                                                            value="{{ $employee->alternate_phone_number }}"
                                                            type="text">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Email <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control edit_email"
                                                            value="{{ $employee->email }}" name="email"
                                                            type="email">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Date of Birth</label>
                                                        <input class="form-control edit_date_of_birth"
                                                            name="date_of_birth" value="{{ $employee->date_of_birth }}"
                                                            type="date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">National Insurance Number</label>
                                                        <input class="form-control edit_insurance_number"
                                                            name="nat_insurance_number"
                                                            value="{{ $employee->national_insurance_number }}"
                                                            type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nationality <span class="text-danger">*</span></label>
                                                        <select name="nationality" id="nationality" class="form-control">
                                                            <option value="">Select Nationality</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ $employee->country_id == "$country->id" ? 'selected' : '' }}>
                                                                    {{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Passport Number</label>
                                                        <input class="form-control edit_passport_number"
                                                            name="passport_number"
                                                            value="{{ $employee->passport_number }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Passport Issue Date</label>
                                                        <input class="form-control edit_pass_issue_date"
                                                            name="pass_issue_date"
                                                            value="{{ $employee->passport_issue_date }}" type="date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Passport Expire Date</label>
                                                        <input class="form-control edit_pass_expire_date"
                                                            name="pass_expire_date"
                                                            value="{{ $employee->passport_expiry_date }}" type="date">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Marital Status <span class="text-danger">*</span></label>
                                                        <select name="marital_status" id="marital_status"
                                                            class="form-control">
                                                            <option value="">Select Marital Status</option>
                                                            <option value="married"
                                                                {{ $employee->marital_status == 'married' ? 'selected' : '' }}>
                                                                Married</option>
                                                            <option value="unmarried"
                                                                {{ $employee->marital_status == 'unmarried' ? 'selected' : '' }}>
                                                                Unmarried</option>
                                                            <option value="divorced"
                                                                {{ $employee->marital_status == 'divorced' ? 'selected' : '' }}>
                                                                Divorced</option>
                                                            <option value="widowed"
                                                                {{ $employee->marital_status == 'widowed' ? 'selected' : '' }}>
                                                                Widowed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Record Status <span class="text-danger">*</span></label>
                                                        <select name="record_status" id="record_status"
                                                            class="form-control">
                                                            <option>Select Record Status</option>
                                                            <option value="active"
                                                                {{ $employee->record_status == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="archieve"
                                                                {{ $employee->record_status == 'archieve' ? 'selected' : '' }}>
                                                                Archieve</option>
                                                            <option value="delete"
                                                                {{ $employee->record_status == 'delete' ? 'selected' : '' }}>
                                                                Delete</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Employee Modal -->
            @foreach ($tabs as $index => $tab)
                <div class="tab-pane fade" id="{{ $index }}" role="tabpanel"
                    aria-labelledby="{{ $index }}-tab">
                    @include("backend.employee-details.{$index}")
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-4">
            <form method="POST" action="{{ route('employee.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                            <input class="form-control" name="employee_id" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Main Work Location<span class="text-danger">*</span></label>
                            <select name="branch_id" class="form-control select">
                                <option value="">Select Main Work Location</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label">Employee Picture<span class="text-danger">*</span></label>
                            <input class="form-control floating" name="avatar" type="file">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="firstname" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Last Name</label>
                            <input class="form-control" name="lastname" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Phone Number Main </label>
                            <input class="form-control mask_phone_number" name="phone" type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Alternate Phone Number</label>
                            <input class="form-control mask_phone_number" name="al_phone_number" type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="email" type="email">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Date of Birth</label>
                            <input class="form-control edit_date_of_birth" name="date_of_birth" type="date">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">National Insurance Number</label>
                            <input class="form-control edit_insurance_number" name="nat_insurance_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nationality <span class="text-danger">*</span></label>
                            <select name="nationality" class="form-control select">
                                <option value="">Select Nationality</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Passport Number</label>
                            <input class="form-control edit_passport_number" name="passport_number" type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Passport Issue Date</label>
                            <input class="form-control edit_pass_issue_date" name="pass_issue_date" type="date">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Passport Expire Date</label>
                            <input class="form-control edit_pass_expire_date" name="pass_expire_date" type="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marital Status <span class="text-danger">*</span></label>
                            <select name="marital_status" class="form-control select">
                                <option value="">Select Marital Status</option>
                                <option value="married">Married</option>
                                <option value="unmarried">Unmarried</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Record Status <span class="text-danger">*</span></label>
                            <select name="record_status" class="form-control select">
                                <option value="">Select Record Status</option>
                                <option value="active">Active</option>
                                <option value="archieve">Archieve</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    @endif
    <!-- Delete Modal -->
    <div class="modal custom-modal fade" id="delete_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete {{ ucfirst($title) }} data</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <form action="{{ route('employee.detail.delete') }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="delete_data" name="id">
                        <input type="hidden" id="resource_data" name="data_model">
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary continue-btn btn-block" type="submit">Delete</button>
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
    <!-- /Delete  Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/employee.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
@endsection