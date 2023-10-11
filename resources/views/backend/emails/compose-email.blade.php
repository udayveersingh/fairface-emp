@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            {{-- <h3 class="page-title">Email</h3> --}}
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Email</li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card w-100">
                <div class="col-md-12 mt-2">
                    <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" id="edit_id" name="id"> --}}
                        <input class="form-control" value="{{ date('Y-m-d') }}" type="hidden" name="email_date"
                            id="">
                        <input class="form-control" value="{{ date('H:i:s') }}" type="hidden" name="email_time"
                            id="">
                        @php
                            $to_email_ids = App\Models\EmployeeJOb::with('employee')->whereHas('employee', function ($q) {
                            $q->where('record_status', '=', 'active');
                        })->get();
                        @endphp
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::EMPLOYEE)
                            <div class="form-group">
                                <label>From<span class="text-danger">*</span></label>
                                <select name="from_id" id="from_id" class="form-control">
                                    {{-- <option value="">Select from</option> --}}
                                    @php
                                        $from_email = App\Models\EmployeeJOb::with('employee')
                                            ->where('employee_id', '=', $employee->id)
                                            ->first();
                                        $firstname = !empty($from_email->employee->firstname) ? $from_email->employee->firstname : '';
                                        $lastname = !empty($from_email->employee->lastname) ? $from_email->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $from_email->id }}">
                                        {{ ucfirst($emp_name) . ' < ' . $from_email->work_email . ' > ' }}
                                    </option>
                                </select>
                            </div>
                        @elseif(Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN || Auth::user()->role->name == App\Models\Role::ADMIN)
                            <div class="form-group">
                                <label>From<span class="text-danger">*</span></label>
                                <select name="from_id" id="from_id" class="form-control">
                                    <option value="">Select to</option>
                                    @foreach ($to_email_ids as $from_email)
                                        @php
                                            $firstname = !empty($from_email->employee->firstname) ? $from_email->employee->firstname : '';
                                            $lastname = !empty($from_email->employee->lastname) ? $from_email->employee->lastname : '';
                                            $emp_name = $firstname . '  ' . $lastname;
                                        @endphp
                                        <option value="{{ $from_email->id }}">
                                            {{ $emp_name . ' < ' . $from_email->work_email . ' > ' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>To<span class="text-danger">*</span></label>
                            <select name="to_id[]" class="form-control select" multiple
                            data-mdb-placeholder="Example placeholder" multiple>
                                <option value="">Select to</option>
                                @foreach ($to_email_ids as $to_email)
                                    @php
                                        $firstname = !empty($to_email->employee->firstname) ? $to_email->employee->firstname : '';
                                        $lastname = !empty($to_email->employee->lastname) ? $to_email->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $to_email->id }}">
                                        {{ $emp_name . ' < ' . $to_email->work_email . ' > ' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label select-label">CC </label>
                            <select name="cc[]" class="form-control select" multiple
                                data-mdb-placeholder="Example placeholder" multiple>
                                @foreach ($employee_jobs as $employee_job)
                                    @php
                                        $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                        $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $employee_job->id }}">
                                        {{ $emp_name . ' < ' . $employee_job->work_email . ' > ' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input class="form-control" type="text" name="email_date" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Time </label>
                                    <input class="form-control " type="time" name="email_time" id="">
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" name="email_subject" id="">
                        </div>
                        <div class="form-group">
                            <label>Body<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="" name="email_body" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment</label>
                            <input class="form-control" type="file" name="email_attachment" id="">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn mb-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
