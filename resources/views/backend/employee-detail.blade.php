@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection
@section('content')

    @php
        $firstname = !empty($employee->firstname) ? $employee->firstname : '';
        $lastname = !empty($employee->lastname) ? $employee->lastname : '';
        $fullname = $firstname . ' ' . $lastname;
    @endphp
    @if (!empty($employee))
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">
                <h3>You are viewing record of {{ ucfirst($fullname) }}</h3>
            </li>
        </ul>
    @endif
    <?php
    $tabs = [
        'document' => 'Document',
        'job' => 'Job',
        'visa' => 'Visa',
        'project' => 'Project',
        'contact' => 'Contact',
        'address' => 'Address',
        'bank' =>'Bank',
        'payslip' =>'Payslip',
        'rlmt' => 'RLMT',
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

        @if (!empty($employee))
            <li class="nav-item ml-auto">
                <a href="{{ route('print-employee-detail', $employee->id) }}" class="text-white btn add-btn rounded-pill"
                    target="_blank"><i class="fa fa-download"></i>Print PDF</a>
            </li>
        @endif

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
                                    <td>{{ !empty($employee->date_of_birth) ? date('d-m-Y', strtotime($employee->date_of_birth)) : '' }}
                                    </td>
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
                                    <td>{{ !empty($employee->passport_issue_date) ? date('d-m-Y', strtotime($employee->passport_issue_date)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Passport Expire Date</th>
                                    <td>{{ !empty($employee->passport_expiry_date) ? date('d-m-Y', strtotime($employee->passport_expiry_date)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Marital Status</th>
                                    <td>{{ $employee->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th>Record Status </th>
                                    <td>{{ $employee->record_status }}</td>
                                </tr>
                                <tr>
                                    <th>Join Of Date</th>
                                    <td>{{ !empty($employee->date_of_join) ? date('d-m-Y', strtotime($employee->date_of_join)) :'' }}</td>
                                </tr>

                                @if ($employee->record_status == 'archieve')
                                    <tr>
                                        <th>Status Change Date</th>
                                        <td>{{ !empty($employee->status_change_date) ? date('d-m-Y', strtotime($employee->status_change_date)) : '' }}
                                        </td>
                                    </tr>
                              
                                @endif
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
                                    data-join_of_date="{{$employee->date_of_join}}"
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
                                <a data-id="" data-employee_id="" data-target="#profile_info"
                                    class="btn btn-primary mt-2" href="javascript:void(0);" data-toggle="modal"><i
                                        class="fa fa-pencil m-r-5"></i>
                                    Edit Profile Pic</a>
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
                                                            name="employee_id" required type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Main Work Location<span class="text-danger">*</span></label>
                                                        <select name="branch_id" required class="form-control">
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
                                                                class="text-danger"></span></label>
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
                                                            required value="{{ $employee->firstname }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Last Name <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control edit_lastname" name="lastname" required
                                                            value="{{ $employee->lastname }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Phone Number Main <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control edit_phone"
                                                            name="phone" required value="{{ $employee->phone }}"
                                                            type="number">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Phone Number Alternate</label>
                                                        <input class="form-control edit_al_phone_number"
                                                            name="al_phone_number"
                                                            value="{{ $employee->alternate_phone_number }}"
                                                            type="number">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Work Email <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control edit_email"
                                                            value="{{ $employee->email }}" name="email" required
                                                            type="email">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Date of Birth</label>
                                                        <input class="form-control edit_date_of_birth"
                                                            name="date_of_birth" value="{{ $employee->date_of_birth }}"
                                                            type="date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Role<span class="text-danger">*</span></label>
                                                        <select name="role_id" required class="form-control">
                                                            <option value="">Select to</option>
                                                            @foreach (getEmployeeRole() as $role)
                                                                @php
                                                                    $role_id = '';
                                                                    if (!empty($employee->user->role_id)) {
                                                                        $role_id = $employee->user->role_id;
                                                                    } else {
                                                                        $role_id = old('role_id');
                                                                    }
                                                                @endphp
                                                                <option value="{{ $role->id }}"
                                                                    {{ $role_id == $role->id ? 'selected' : '' }}>
                                                                    {{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
                                                        <select name="nationality" required id="nationality"
                                                            class="form-control">
                                                            <option value="">~Select Nationality~</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    {{ !empty($employee->country_id) && $employee->country_id == "$country->id" ? 'selected' : '' }}>
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
                                                        <label class="col-form-label">Date Of Join</label>
                                                        <input class="form-control datetimepicker edit_date_of_join" name="date_of_join"
                                                            value="{{ $employee->date_of_join }}" type="text">
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
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Passport Expire Date</label>
                                                        <input class="form-control edit_pass_expire_date"
                                                            name="pass_expire_date"
                                                            value="{{ $employee->passport_expiry_date }}" type="date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Marital Status <span class="text-danger">*</span></label>
                                                        <select name="marital_status" required id="marital_status"
                                                            class="form-control">
                                                            <option value="">Select Marital Status</option>
                                                            <option value="married"
                                                                {{ $employee->marital_status == 'married' ? 'selected' : '' }}>
                                                                Married</option>
                                                            <option value="single"
                                                                {{ $employee->marital_status == 'single' ? 'selected' : '' }}>
                                                                Single</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Record Status <span class="text-danger">*</span></label>
                                                        <select name="record_status" required id="record_status"
                                                            class="form-control">
                                                            <option value="">Select Record Status</option>
                                                            <option value="active"
                                                                {{ $employee->record_status == 'active' ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="archieve"
                                                                {{ $employee->record_status == 'archieve' ? 'selected' : '' }}>
                                                                Archieve</option>
                                                            @if (Auth::user()->role->name == App\models\Role::SUPERADMIN)
                                                                <option value="delete"
                                                                    {{ $employee->record_status == 'delete' ? 'selected' : '' }}>
                                                                    Delete</option>
                                                            @endif
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
                    <input type="hidden" name="record_status" value="active">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                            <input class="form-control" name="employee_id" value="{{ old('employee_id') }}"
                                type="text">
                            @if ($errors->has('employee_id'))
                                <span class="text-danger">
                                    {{ $errors->first('employee_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Main Work Location<span class="text-danger">*</span></label>
                            <select name="branch_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->branch_code }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('branch_id'))
                                <span class="text-danger">
                                    The main work location field is required.
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label">Employee Picture</label>
                            <input class="form-control floating" name="avatar" type="file">
                            {{-- <div class="text-center"> --}}
                            <span class="text-danger">Please upload a valid image file. Size of image should not be more
                                than 2MB.</span>
                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="firstname" value="{{ old('firstname') }}" type="text">
                            @if ($errors->has('firstname'))
                                <span class="text-danger">
                                    {{ $errors->first('firstname') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                            <input class="form-control" name="lastname" value="{{ old('lastname') }}" type="text">
                            @if ($errors->has('lastname'))
                                <span class="text-danger">
                                    {{ $errors->first('lastname') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Phone Number Main <span class="text-danger">*</span> </label>
                            <input class="form-control" value="{{ old('phone') }}" name="phone"
                                type="number">
                            @if ($errors->has('phone'))
                                <span class="text-danger">
                                    {{ $errors->first('phone') }}
                                </span>
                            @endif
                            <div class="validation-message" style="color: red; display: none;">Please enter only numbers.</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Alternate Phone Number</label>
                            <input class="form-control" name="al_phone_number"
                                value="{{ old('al_phone_number') }}" type="number">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Work Email <span class="text-danger">*</span></label>
                            <input class="form-control" name="email" value="{{ old('email') }}" type="email">
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Role<span class="text-danger">*</span></label>
                            <select name="role_id" class="form-control">
                                <option value="">Select to</option>
                                @php
                                    $role_id = '';
                                    if (!empty($employee->user->role_id)) {
                                        $role_id = $employee->user->role_id;
                                    } else {
                                        $role_id = old('role_id');
                                    }
                                @endphp
                                @foreach (getEmployeeRole() as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $role_id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                <span class="text-danger">
                                    {{ $errors->first('role_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Date of Birth<span class="text-danger">*</span></label>
                            <input class="form-control edit_date_of_birth" value="{{ old('date_of_birth') }}"
                                name="date_of_birth" type="date">
                            @if ($errors->has('date_of_birth'))
                                <span class="text-danger">
                                    {{ $errors->first('date_of_birth') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">National Insurance Number</label>
                            <input class="form-control edit_insurance_number" value="{{ old('nat_insurance_number') }}"
                                name="nat_insurance_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nationality <span class="text-danger">*</span></label>
                            <select name="nationality" class="form-control">
                                <option value="">Select</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('nationality'))
                                <span class="text-danger">
                                    {{ $errors->first('nationality') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Passport Number</label>
                            <input class="form-control edit_passport_number" value="{{ old('passport_number') }}"
                                name="passport_number" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Date Of Join</label>
                            <input class="form-control datetimepicker edit_date_of_join" name="date_of_join"
                                value="{{ old('date_of_join') }}" type="text">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Passport Issue Date</label>
                            <input class="form-control datetimepicker edit_pass_issue_date" name="pass_issue_date"
                                value="{{ old('pass_issue_date') }}" type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Passport Expire Date</label>
                            <input class="form-control datetimepicker edit_pass_expire_date" name="pass_expire_date"
                                value="{{ old('pass_expire_date') }}" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marital Status <span class="text-danger">*</span></label>
                            <select name="marital_status" class="form-control">
                                <option value="">Select</option>
                                <option value="married">Married
                                </option>
                                <option value="single">Single</option>
                            </select>
                            @if ($errors->has('marital_status'))
                                <span class="text-danger">
                                    {{ $errors->first('marital_status') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input class="form-control edit_password" name="password" type="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input class="form-control edit_password" name="password_confirmation" type="password">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
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
    <!-- Profile picture change Models -->
    <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Pic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('employee-profile') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <input type="hidden" name="employee_id"
                                        value="{{ !empty($employee->user_id) ? $employee->user_id : '' }}">
                                    <img class="inline-block"
                                        src="{{ !empty($employee->avatar) ? asset('storage/employees/' . $employee->avatar) : asset('assets/img/user.jpg') }}"
                                        alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input name="avatar" class="upload" type="file">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="text-danger">Please upload a valid image file. Size of image should not be
                                        more than 2MB.</span>
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
    <!-- Profile picture change Models -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/employee.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
@endsection
