@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .no-border td {
            border: none;
        }

        .table-box a {
            color: #333;
        }
    </style>
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            {{-- <h3 class="page-title">Email</h3> --}}
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employee-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Email</li>
            </ul>
        </div>
        {{-- @if (!empty($employee_jobs))
            <div class="col-auto float-right ml-auto">
                <a href="{{ route('compose-email') }}" class="btn add-btn"><i class="fa fa-plus"></i> Compose Email</a>
            </div>
        @endif --}}
    </div>
    @if (isset($errorMessageDuration))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $errorMessageDuration }}
        </div>
    @endif
@endsection

@section('content')
    @if (!empty($employee_jobs))
        <!---->
        <div id="email_read" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!---->

        <div class="table-box bg-white row">
            <div class="table-detail col-md-3">
                <div class="p-4">
                    <a href="{{ route('compose-email') }}"
                        class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a>

                    <div class="list-group mail-list mt-3">
                        @if ((Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) || Auth::user()->role->name == App\Models\Role::ADMIN)
                            <a href="#" class="list-group-item border-0 text-success"><i
                                    class="fa-solid fa-inbox font-13 mr-2"></i>inbox <span>{{ $count_emails }}</span> </a>
                        @else
                        <a href="{{route('sent-email')}}" class="list-group-item border-0 text-success"><i
                            class="fa fa-envelope font-13 mr-2"></i>Sent({{$company_emails_count}})</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-detail mail-right col-md-9">
                <div class="table-responsive mt-3">
                    <table class="table table-hover mails m-0 no-border" style="border:none;">
                        <tbody>
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th width="500px">Subject</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            @if (!empty($company_emails->count()))
                                @foreach ($company_emails as $index => $company_email)
                                    @php
                                        $from = App\Models\EmployeeJob::with('employee')
                                            ->where('id', '=', $company_email->from_id)
                                            ->first();
                                        $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                        $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                        $fullname = $from_first_name . ' ' . $from_last_name;

                                        $to_ids = explode(',', $company_email->to_id);
                                        $to_emails = [];
                                        foreach ($to_ids as $value) {
                                            $to = App\Models\EmployeeJob::with('employee')
                                                ->where('id', '=', $value)
                                                ->first();
                                            $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname : '';
                                            $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname : '';
                                            $to_fullname = $to_first_name . ' ' . $to_last_name;
                                            $to_emails[] = $to_fullname;
                                        }
                                        $to_emails = implode(',', $to_emails);

                                        $multiple_cc = explode(',', $company_email->company_cc);
                                        $cc_emails = [];
                                        foreach ($multiple_cc as $value) {
                                            $cc = App\Models\EmployeeJob::where('id', '=', $value)->value('work_email');
                                            $cc_emails[] = $cc;
                                        }
                                        $cc = implode(',', $cc_emails);
                                    @endphp
                                    <tr class="unread">
                                        <td>
                                            <a data-id="{{ $company_email->id }}" data-email_from="{{ $fullname }}"
                                                data-work_email="{{ $from->work_email }}"
                                                data-email_to=""
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }})}}"
                                                id="">{{ $fullname }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }})}}"
                                                id="">{{ $to_emails }}</a>
                                        </td>
                                        <td class="d-none d-lg-inline-block" width="500px">
                                            <a data-target="#email_read" data-id="{{ $company_email->id }}"
                                                data-email_from="{{ $fullname }}"
                                                data-work_email="{{ $from->work_email }}"
                                                data-email_to=""
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id)])}}"
                                                id="email-info">{{ $company_email->subject }}</a>
                                        </td>

                                        {{-- <td class="d-none d-lg-inline-block">
                                    <a data-toggle="modal" data-target="#email_read" href="email-read.html"
                                        class="email-msg"> {{$company_email->subject}}</a>
                                </td> --}}
                                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                                            <i class="fa fa-paperclip"></i>
                                        </td>
                                        <td class="mail-time">
                                            <a data-target="#email_read" data-id="{{ $company_email->id }}"
                                                data-email_from="{{ $fullname }}"
                                                data-work_email="{{ $from->work_email }}"
                                                data-email_to=""
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }})}}"
                                                id="email-info">{{ !empty($company_email->date) ? date('d-m-Y', strtotime($company_email->date)) : '' }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3 mb-3">
                    <div class="col-7 mt-3">
                        Showing 1 - 20 of 289
                    </div>
                </div>
            </div>
        </div>
        <!-- New layout ends-->
        {{-- <div class="row">
    <div class="col-md-12">
        <div>
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>From</th>
                        <th>To</th>
                        <th>CC</th>
                        <th>Date</th>
                        <th>Subject</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($company_emails->count()))
                        @foreach ($company_emails as $index => $company_email)
                            @php
                                $from = App\Models\EmployeeJob::with('employee')
                                    ->where('id', '=', $company_email->from_id)
                                    ->first();
                                $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                $fullname = $from_first_name . ' ' . $from_last_name;
                                $to = App\Models\EmployeeJob::with('employee')
                                    ->where('id', '=', $company_email->to_id)
                                    ->first();
                                $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname : '';
                                $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname : '';
                                $to_fullname = $to_first_name . ' ' . $to_last_name;
                                $multiple_cc = explode(',', $company_email->company_cc);
                                $cc_emails = [];
                                foreach ($multiple_cc as $value) {
                                    $cc = App\Models\EmployeeJob::where('id', '=', $value)->value('work_email');
                                    $cc_emails[] = $cc;
                                }
                                $cc = implode(',', $cc_emails);
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ '<' . $fullname . '>' }}<a
                                        href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }}">{{ $from->work_email }}</a>
                                </td>
                                <td>{{ '<' . $to_last_name . '>' . $to->work_email }}</td>
                                <td>{{ $cc }}</td>
                                <td>{{ !empty($company_email->date) ? date('d-m-Y', strtotime($company_email->date)) : '' }}
                                </td>
                                <td>{{ $company_email->subject }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-id="{{ $company_email->id }}"
                                                data-email_from="{{ $company_email->from_id }}"
                                                data-email_to="{{ $company_email->to_id }}"
                                                data-email_cc="{{ $company_email->company_cc }}"
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                data-email_attachment="{{ $company_email->attachment }}"
                                                class="dropdown-item editbtn" href="javascript:void(0);"
                                                data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a data-id="{{ $company_email->id }}" class="dropdown-item deletebtn"
                                                href="javascript:void(0);" data-target="#deletebtn"
                                                data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <x-modals.delete :route="'company-email.destroy'" :title="'Company Email'" />
                        <!-- Edit Company Email Modal -->
                        <div id="edit_company_email" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Company Email</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('company-email') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="edit_id" name="id">
                                            <div class="form-group">
                                                <label>From<span class="text-danger">*</span></label>
                                                <select name="from_id" id="from_id" class="form-control">
                                                    <option value="">Select from</option>
                                                    @foreach ($employee_jobs as $employee_job)
                                                        @php
                                                            $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                                            $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                                            $emp_name = $firstname . '  ' . $lastname;
                                                        @endphp
                                                        <option value="{{ $employee_job->id }}">
                                                            {{ 'From' . ' ' . $emp_name . ' < ' . $employee_job->work_email . ' > ' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>To<span class="text-danger">*</span></label>
                                                <select name="to_id" id="to_id" class="form-control">
                                                    <option value="">Select to</option>
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
                                            <div class="form-group">
                                                <label>CC</label>
                                                <select name="cc[]" id="cc" class="form-control select"
                                                    multiple data-mdb-placeholder="Example placeholder" multiple>
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
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input class="form-control" type="date" name="email_date"
                                                    id="edit_date">
                                            </div>
                                            <div class="form-group">
                                                <label>Time </label>
                                                <input class="form-control" type="time" name="email_time"
                                                    id="edit_time">
                                            </div>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" type="text" name="email_subject"
                                                    id="edit_subject">
                                            </div>
                                            <div class="form-group">
                                                <label>Body<span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="edit_body" name="email_body" rows="4" cols="50"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Attachment</label>
                                                <input class="form-control" type="file" name="email_attachment"
                                                    id="edit_attachment">
                                            </div>
                                            <div class="submit-section">
                                                <button type="submit"
                                                    class="btn btn-primary submit-btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Edit Company Email Modal -->
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div> --}}
        <!-- Add Company Email Modal -->
        {{-- <div id="add_company_email" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Company Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="edit_id" name="id">
                            <div class="form-group">
                                <label>From<span class="text-danger">*</span></label>
                                <select name="from_id" id="from_id" class="form-control">
                                    <option value="">Select from</option>
                                    @foreach ($employee_jobs as $employee_job)
                                        @php
                                            $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                            $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                            $emp_name = $firstname . '  ' . $lastname;
                                        @endphp --}}
        {{-- <option value="{{ $employee_job->id }}">
                                            {{ 'From' . ' ' . $emp_name . ' < ' . $employee_job->work_email . ' > ' }}
                                        </option> --}}
        {{-- @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>To<span class="text-danger">*</span></label>
                                <select name="to_id" id="to_id" class="form-control">
                                    <option value="">Select to</option>
                                    @foreach ($employee_jobs as $employee_job)
                                        @php
                                            $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                            $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                            $emp_name = $firstname . '  ' . $lastname;
                                        @endphp
                                        <option value="{{ $employee_job->id }}">
                                            {{ $emp_name . ' < ' . $employee_job->work_email . ' > ' }}</option>
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
                            <div class="form-group">
                                <label>Date</label>
                                <input class="form-control" type="date" name="email_date" id="">
                            </div>
                            <div class="form-group">
                                <label>Time </label>
                                <input class="form-control" type="time" name="email_time" id="">
                            </div>
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
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Add Company Email Modal -->
        {{-- <div class="row">
        <div class="col-md-12">
            <div>
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>From</th>
                            <th>To</th>
                            <th>CC</th>
                            <th>Date</th>
                            <th>Subject</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($company_emails->count()))
                            @foreach ($company_emails as $index => $company_email)
                                @php
                                    $from = App\Models\EmployeeJob::where('id', '=', $company_email->from_id)->value('work_email');
                                    $to = App\Models\EmployeeJob::where('id', '=', $company_email->to_id)->value('work_email');
                                    $multiple_cc = explode(',', $company_email->company_cc);
                                    $cc_emails = [];
                                    foreach ($multiple_cc as $value) {
                                        $cc = App\Models\EmployeeJob::where('id', '=', $value)->value('work_email');
                                        $cc_emails[] = $cc;
                                    }
                                    $cc = implode(',', $cc_emails);
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="{{route('mail-detail',['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id])}}">{{ $from }}</a></td>
                                    <td>{{ $to }}</td>
                                    <td>{{ $cc }}</td>
                                    <td>{{ $company_email->date }}</td>
                                    <td>{{ $company_email->subject }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right"> --}}
        {{-- <a data-id="{{ $company_email->id }}"
                                                    data-email_from="{{ $company_email->from_id }}"
                                                    data-email_to="{{ $company_email->to_id }}"
                                                    data-email_cc="{{ $company_email->company_cc }}"
                                                    data-email_date="{{ $company_email->date }}"
                                                    data-email_time="{{ $company_email->time }}"
                                                    data-email_subject="{{ $company_email->subject }}"
                                                    data-email_body="{{ $company_email->body }}"
                                                    data-email_attachment="{{ $company_email->attachment }}"
                                                    class="dropdown-item editbtn" href="javascript:void(0);"
                                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
        {{-- <a class="dropdown-item viewbtn" href="{{route('mail-detail',['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id])}}"><i class="fa fa-pencil m-r-5"></i> View</a>
                                                <a data-id="{{ $company_email->id }}" class="dropdown-item deletebtn"
                                                    href="javascript:void(0);" data-target="#deletebtn"
                                                    data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach --}}
        {{-- <x-modals.delete :route="'company-email.destroy'" :title="'Company Email'" /> --}}
        <!-- Edit Company Email Modal -->
        {{-- <div id="edit_company_email" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Company Email</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('company-email') }}" method="POST">
                                                @csrf
                                                <input type="hidden" id="edit_id" name="id">
                                                <div class="form-group">
                                                    <label>From<span class="text-danger">*</span></label>
                                                    <select name="from_id" id="from_id" class="form-control">
                                                        <option value="">Select from</option>
                                                        @foreach ($employee_jobs as $employee_job)
                                                            @php

                                                                $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                                                $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                                                $emp_name = $firstname . '  ' . $lastname;
                                                            @endphp
                                                            <option value="{{ !empty($employee_job->id) ? $employee_job->id:'' }}">
                                                                {{ 'From' . ' ' . !empty($emp_name) ? $emp_name:''  . ' < ' . $employee_job->work_email . ' > ' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>To<span class="text-danger">*</span></label>
                                                    <select name="to_id" id="to_id" class="form-control">
                                                        <option value="">Select to</option>
                                                        @foreach ($employee_jobs as $employee_job)
                                                            @php
                                                                $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                                                $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                                                $emp_name = $firstname . '  ' . $lastname;
                                                            @endphp
                                                            <option value="{{ !empty($employee_job->id) ? $employee_job->id:''  }}">
                                                                {{ !empty($emp_name) ? $emp_name:'' . ' < ' . $employee_job->work_email . ' > ' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>CC</label>
                                                    <select name="cc[]" id="cc" class="form-control select"
                                                        multiple data-mdb-placeholder="Example placeholder" multiple>
                                                        @foreach ($employee_jobs as $employee_job)
                                                            @php
                                                                $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                                                $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                                                $emp_name = $firstname . '  ' . $lastname;
                                                            @endphp
                                                            <option value="{{ !empty($employee_job->id) ? $employee_job->id:'' }}">
                                                                {{ !empty($emp_name) ? $emp_name:'' . ' < ' . $employee_job->work_email . ' > ' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input class="form-control" type="date" name="email_date"
                                                        id="edit_date">
                                                </div>
                                                <div class="form-group">
                                                    <label>Time </label>
                                                    <input class="form-control" type="time" name="email_time"
                                                        id="edit_time">
                                                </div>
                                                <div class="form-group">
                                                    <label>Subject</label>
                                                    <input class="form-control" type="text" name="email_subject"
                                                        id="edit_subject">
                                                </div>
                                                <div class="form-group">
                                                    <label>Body<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_body" name="email_body" rows="4" cols="50"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Attachment</label>
                                                    <input class="form-control" type="file" name="email_attachment"
                                                        id="edit_attachment">
                                                </div>  
                                                <div class="submit-section">
                                                    <button type="submit"
                                                        class="btn btn-primary submit-btn">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Edit Company Email Modal -->
                        @endif --}}
        {{-- </tbody>
                </table> --}}
        </div>
        </div>
        </div>
    @endif
    <!-- Add Company Email Modal -->
    {{-- <div id="add_company_email" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Company Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> --}}
    {{-- <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label>From<span class="text-danger">*</span></label>
                            <select name="from_id" id="from_id" class="form-control">
                                <option value="">Select from</option>
                                @foreach ($employee_jobs as $employee_job)
                                    @php
                                        $from_email = App\Models\EmployeeJOb::with('employee')->where('employee_id','=',$employee->id)->first(); 
                                        $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                        $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $employee_job->id }}">
                                        {{ 'From' . ' ' . $emp_name . ' < ' . $from_email->work_email . ' > ' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>To<span class="text-danger">*</span></label>
                            <select name="to_id" id="to_id" class="form-control">
                                <option value="">Select to</option>
                                @foreach ($employee_jobs as $employee_job)
                                    @php
                                        $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                        $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $employee_job->id }}">
                                        {{ $emp_name . ' < ' . $employee_job->work_email . ' > ' }}</option>
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
                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control" type="date" name="email_date" id="">
                        </div>
                        <div class="form-group">
                            <label>Time </label>
                            <input class="form-control" type="time" name="email_time" id="">
                        </div>
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
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form> --}}
    </div>
    </div>
    </div>
    </div>
    <!-- /Add Company Email Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', function() {
                $('#edit_company_email').modal('show');
                var id = $(this).data('id');
                var edit_from_id = $(this).data('email_from');
                var edit_email_to = $(this).data('email_to');
                var edit_cc_id = $(this).data('email_cc');
                var cc_id = edit_cc_id.split(",");
                //  console.log(cc_id.length);
                var edit_date = $(this).data('email_date');
                var edit_time = $(this).data('email_time');
                var edit_subject = $(this).data('email_subject');
                var edit_body = $(this).data('email_body');
                var edit_attachment = $(this).data('email_attachment');
                $('#edit_id').val(id);
                $('#from_id').val(edit_from_id);
                $('#to_id').val(edit_email_to);
                $('#cc').val(cc_id);
                $('#edit_date').val(edit_date);
                $('#edit_time').val(edit_time);
                $('#edit_subject').val(edit_subject);
                $('#edit_body').val(edit_body);
                $('#edit_attachment').val(edit_attachment);
            });
        });
    </script>
@endsection
