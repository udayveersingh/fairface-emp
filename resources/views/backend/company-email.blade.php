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
            <h3 class="page-title">Company Email</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Company Email</li>
            </ul>
        </div>
        {{-- <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_company_email"><i
                    class="fa fa-plus"></i> Add Company Email</a>
        </div> --}}
    </div>
@endsection

@section('content')
    <!-- New Layout Starts-->
    <!---->
    <div id="email_read" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card-box">
                        {{-- <h5 class="mt-0"><b>Hi Bro, How are you?</b></h5>

                        <hr> --}}

                        <div class="media mb-4">
                            <a href="#" class="float-left mr-2">
                                <img alt="" src="assets/images/users/avatar-2.jpg"
                                    class="media-object avatar-sm rounded-circle">
                            </a>
                            <div class="media-body">
                                {{-- <span class="media-meta float-right" id="time">07:23 AM</span> --}}
                                <span class="media-meta float-right" id="time"></span>
                                <h5 class="text-primary font-16 m-0" id="from_id"></h5>
                                {{-- <h5 class="text-primary font-16 m-0" >Jonathan Smith</h5> --}}
                                <small class="text-muted" id="from_work_email">From: jonathan@domain.com</small>
                                <br>
                                <small class="text-muted" id="to_work_email">TO: jonathan@domain.com</small>
                            </div>
                        </div>
                        <!-- media -->

                        <p id="email-subject"><b>Hi Bro...</b></p>
                        <p id="edit_body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
                            eget dolor.
                            Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                            mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
                        {{-- <p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget,
                            arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu
                            pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
                        <p>Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac,
                            enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla
                            ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue.
                            Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget
                            condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam
                            nunc, blandit vel, luctus pulvinar,</p> --}}

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!---->

    <div class="table-box bg-white row">
        {{-- <div class="table-detail col-md-3"> --}}
        {{-- <div class="p-4">
                <a href="{{route('compose-email')}}"
                    class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a> --}}

        {{-- <div class="list-group mail-list mt-3">
                    <a href="#" class="list-group-item border-0 text-success"><i --}}
        {{-- class="fas fa-eye font-13 mr-2"></i>View </a> --}}
        {{-- <a href="#" class="list-group-item border-0"><i class="far fa-star font-13 mr-2"></i>Starred</a> --}}
        {{-- </div> --}}

        {{-- <h5 class="mt-4 text-uppercase hidden-xxs">Labels</h5>

            <div class="list-group border-0 mail-list hidden-xxs">
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-info mr-2"></span>Web App</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-warning mr-2"></span>Project 1</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-purple mr-2"></span>Project 2</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-pink mr-2"></span>Friends</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-success mr-2"></span>Family</a>
            </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}

        <div class="table-detail mail-right col-md-6">
            {{-- <div class="row">
            <div class="col-lg-12">
                <div class="btn-toolbar mt-4" role="toolbar">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-primary waves-effect waves-light" fdprocessedid="ri6ks"><i class="fa fa-inbox"></i></button>
                        <button type="button" class="btn btn-primary waves-effect waves-light" fdprocessedid="omqa9tb"><i class="fa fa-exclamation-circle"></i></button>
                        <button type="button" class="btn btn-primary waves-effect waves-light" fdprocessedid="oqzsnm"><i class="far fa-trash-alt"></i></button>
                    </div>
                    <div class="btn-group mr-2">

                        <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="iqg1vn">
                            <i class="fa fa-folder"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="dropdown-item">Action</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Another action</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Something else here</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="btn-group mr-2">
                        <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="xuli2m">
                            <i class="fa fa-tag"></i>
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="dropdown-item">Action</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Another action</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Something else here</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Separated link</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="x3mkj9">
                            More <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                            <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
            <!-- End row -->

            <div class="table-responsive mt-3">
                <table class="table table-hover mails m-0 no-border" style="border:none;">
                    <tbody>
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Subject</th>
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
                                <tr class="unread">

                                    <td data-id="{{ $company_email->id }}" data-email_from="{{ $fullname }}"
                                        data-work_email="{{ $from->work_email }}" data-email_to="{{ $to->work_email }}"
                                        data-email_date="{{ $company_email->date }}"
                                        data-email_time="{{ $company_email->time }}"
                                        data-email_subject="{{ $company_email->subject }}"
                                        data-email_body="{{ $company_email->body }}" href="" id="email-info">
                                        {{ ucfirst($fullname) }}
                                    </td>
                                    <td class="d-none d-lg-inline-block">
                                        <a data-toggle="modal" data-target="#email_read" data-id="{{ $company_email->id }}"
                                            data-email_from="{{ $fullname }}"
                                            data-work_email="{{ $from->work_email }}"
                                            data-email_to="{{ $to->work_email }}"
                                            data-email_date="{{ $company_email->date }}"
                                            data-email_time="{{ $company_email->time }}"
                                            data-email_subject="{{ $company_email->subject }}"
                                            data-email_body="{{ $company_email->body }}"
                                            href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }})}}"
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
                                        {{ !empty($company_email->date) ? date('d-m-Y', strtotime($company_email->date)) : '' }}
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
        <div class="col-md-6">

            {{-- <div class="table-responsive mt-3">
                <table class="table table-hover mails m-0 no-border" style="border:none;">
                    <tbody>
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <td id="subject"></td>
                            </tr>
                            <tr>
                                <th>From</th>
                                <td id="from_email"></td>
                            </tr>
                            <tr>
                                <th>To</th>
                                <td></td>
                            </tr>
                            <th>Body</th>
                            <td></td>
                            </tr>
                        </thead>
                    </tbody>
                </table>
            </div> --}}
            @if (!empty($company_emails->count()))
                @foreach ($company_emails as $index => $company_email)
                    @php
                        if ($index > 0) {
                            break;
                        }
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
                    <div class="card">
                        <div class="card-box">
                            <h5 class="mt-1 ml-2" id="subject"><b>{{ $company_email->subject }}</b></h5>
                            <div class="media mb-4">
                                <a href="#" class="float-left mr-2">
                                    <img alt="" src="assets/images/users/avatar-2.jpg"
                                        class="media-object avatar-sm rounded-circle">
                                </a>
                                <div class="media-body">
                                    {{-- <span class="media-meta float-right" id="time">07:23 AM</span> --}}
                                    {{-- <h5 class="text-primary font-16 m-0" >Jonathan Smith</h5> --}}
                                    <small class="text-primary font-16 m-0" id="from_email">From:{{ $from->work_email }}
                                    </small>
                                    <br>
                                    <small class="text-muted" id="to_email">TO:{{ $to->work_email }} </small>
                                </div>
                            </div>
                            <!-- media -->

                            {{-- <p id="email-subject"><b>Hi Bro...</b></p> --}}
                            <p id="email_body" class="ml-2">{{ $company_email->body }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
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
    <div id="add_company_email" class="modal custom-modal fade" role="dialog">
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
                // $('#edit_company_email').modal('show');
                // var id = $(this).data('id');
                // var edit_from_id = $(this).data('email_from');
                // var edit_email_to = $(this).data('email_to');
                // var edit_cc_id = $(this).data('email_cc');
                // var cc_id = edit_cc_id.split(",");
                // //  console.log(cc_id.length);
                // var edit_date = $(this).data('email_date');
                // var edit_time = $(this).data('email_time');
                // var edit_subject = $(this).data('email_subject');
                // var edit_body = $(this).data('email_body');
                // var edit_attachment = $(this).data('email_attachment');
                // $('#edit_id').val(id);
                // $('#from_id').val(edit_from_id);
                // $('#to_id').val(edit_email_to);
                // $('#cc').val(cc_id);
                // $('#edit_date').val(edit_date);
                // $('#edit_time').val(edit_time);
                // $('#edit_subject').val(edit_subject);
                // $('#edit_body').val(edit_body);
                // $('#edit_attachment').val(edit_attachment);
            });

            $('.table').on('click', '#email-info', function() {
                // $('#edit_company_email').modal('show');
                var id = $(this).data('id');
                var edit_from = $(this).data('email_from');
                var edit_work_email = $(this).data('work_email');
                var edit_email_to = $(this).data('email_to');
                // var edit_cc_id = $(this).data('email_cc');
                // var cc_id = edit_cc_id.split(",");
                //  console.log(cc_id.length);
                var edit_date = $(this).data('email_date');
                var edit_time = $(this).data('email_time');
                var edit_subject = $(this).data('email_subject');
                var edit_body = $(this).data('email_body');
                // var edit_attachment = $(this).data('email_attachment');
                $('#edit_id').val(id);
                $('#from_id').html(edit_from);
                $('#from_work_email').html("From:" + edit_work_email);
                $('#to_work_email').html("To:" + edit_email_to)
                $('#to_id').val(edit_email_to);
                // $('#cc').val(cc_id);
                $('#time').html(edit_date);
                $('#email-subject').html("<b>Subject:</b>" + edit_subject);
                // $('#time').append(edit_time);
                $('#edit_subject').val(edit_subject);
                $('#edit_body').html("<b>Body:</b>" + edit_body);
                // $('#edit_attachment').val(edit_attachment);

            });

            $('.table').on('click', '#email-info', function() {
                // var employeeId = $('#employee_id').find('option:selected').text();
                // var token =  $('input[name="csrfToken"]').attr('value');
                var id = $(this).data('id');
                var edit_from = $(this).data('email_from');
                var edit_work_email = $(this).data('work_email');
                var edit_email_to = $(this).data('email_to');
                var edit_subject = $(this).data('email_subject');
                var edit_body = $(this).data('email_body');
                console.log(edit_subject, "edit_subject");
                $.ajax({
                    type: 'POST',
                    url: '/email-read',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        emailFromUser: edit_from,
                        workEmail: edit_work_email,
                        emailTo: edit_email_to,
                        emailSubject: edit_subject,
                        emailBody: edit_body,
                    },
                    dataType: 'JSON',
                    success: function(dataResult) {
                        console.log(dataResult);
                        $.each(dataResult, function(index, row) {
                            $("#subject").html(row.emailSubject);
                            $("#from_email").html("From:" + row.workEmail);
                            $("#to_email").html("To:" + row.emailTo);
                            $("#email_body").html(row.emailBody)
                        });
                        // console.log(myArray);
                    },
                });
            });
        });
    </script>
@endsection
