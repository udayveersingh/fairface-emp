@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        #sidebar {
            display: none !important;
        }

        #sidebar+.page-wrapper {
            margin-left: 0 !important;
        }

        .no-border td {
            border: none;
        }

        .table-box a {
            color: #333;
        }

        .mx-100vh {
            max-height: 40vh;
            overflow-y: auto;
        }

        .emails_list thead {
            position: sticky;
            top: 0;
            background: #fff;
            border-top: 1px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }

        .unread {
            font-weight: bold;
        }

        .single-email-wrapper {
            min-height: 90vh;
        }

        .single-email-inner {
            border-top: 1px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
            overflow-y: auto;
        }

        .single-email-inner .card {
            height: 100%;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .announcement_slider .carousel-indicators li {
            background-color: #004085;
        }
    </style>
@endsection
@section('page-header')
    <div class="top_email_header d-flex align-items-center">
        <div class="col-auto">
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fa fa-home"></i></a>
        </div>
        <div class="col">

            <div id="carouselExampleFade" class="carousel announcement_slider alert-primary p-3 rounded slide carousel-fade"
                data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <strong>Announcement One!</strong> You should check in on some of those fields below.
                    </div>
                    <div class="carousel-item">
                        <strong>Announcement Two!</strong> You should check in on some of those fields below.
                    </div>
                    <div class="carousel-item">
                        <strong>Announcement Three!</strong> You should check in on some of those fields below.
                    </div>
                </div>
                <ol class="carousel-indicators" style="right:20px; left:auto; margin-right:0;">
                    <li data-target="#carouselExampleFade" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="1"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="2"></li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- New Layout Starts-->
    <div class="table-box bg-white row">
        <div class="table-detail col-md-3">
            <div class="p-4">
                <a href="{{ route('compose-email') }}"
                    class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a>

                <div class="list-group mail-list mt-3">
                    <a href="#" class="list-group-item border-0 text-success"><i
                            class="fas fa-download font-13 mr-2"></i>Inbox <b>(8)</b></a>
                    {{-- <a href="#" class="list-group-item border-0"><i class="far fa-star font-13 mr-2"></i>Unread</a> --}}
                    {{-- <a href="#" class="list-group-item border-0"><i class="far fa-file-alt font-13 mr-2"></i>Archive --}}
                        {{-- <b>(20)</b></a> --}}
                    <a href="#" class="list-group-item border-0"><i
                            class="far fa-paper-plane font-13 mr-2"></i>Sent</a>
                </div>

            </div>
        </div>

        <div class="table-detail mail-right col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-toolbar mt-4" role="toolbar">
                        {{-- <div class="btn-group mr-2">
                            <button type="button" class="btn btn-primary waves-effect waves-light" fdprocessedid="ri6ks"><i
                                    class="fa fa-inbox"></i></button>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                fdprocessedid="omqa9tb"><i class="fa fa-exclamation-circle"></i></button>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                fdprocessedid="oqzsnm"><i class="far fa-trash-alt"></i></button>
                        </div> --}}
                        {{-- <div class="btn-group mr-2">

                            <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="iqg1vn">
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
                        </div> --}}
                        {{-- <div class="btn-group mr-2">
                            <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="xuli2m">
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
                        </div> --}}

                        {{-- <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                fdprocessedid="x3mkj9">
                                More <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                            </ul>
                        </div> --}}

                        <form class="form-inline my-2 my-lg-0 ml-auto">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                        </form>

                    </div>
                </div>
            </div>
            <!-- End row -->

            <div class="table-responsive mt-3 mx-100vh">
                <table class="table table-hover mails m-0 no-border emails_list" style="border:none;">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th class="text-right">Date & Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($company_emails->count()) > 0)
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
                                    <td class="mail-select">
                                        <div class="checkbox checkbox-primary">
                                            <input id="checkbox1" type="checkbox">
                                            <label for="checkbox1"></label>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="#single-email-wrapper" class="email-name mail-detail"
                                            data-from_id="{{ $company_email->from_id }}">{{ ucfirst($fullname) }}</a>
                                    </td>

                                    <td>
                                        <a href="#single-email-wrapper" class="email-name mail-detail"
                                            data-from_id="{{ $company_email->from_id }}">{{ ucfirst($to_last_name) }}</a>
                                    </td>

                                    <td class="d-none d-lg-inline-block">
                                        <a href="#single-email-wrapper" class="email-msg mail-detail"
                                            data-from_id="{{ $company_email->from_id }}">{{ $company_email->subject }}</a>
                                    </td>
                                    <td style="width: 20px;" class=" d-none d-lg-display-inline">
                                        <i class="fa fa-paperclip"></i>
                                    </td>
                                    <td class="text-right mail-time">
                                        @php
                                            $date = \Carbon\Carbon::parse($company_email->date);
                                        @endphp
                                        <a href="#single-email-wrapper" class="email-date mail-detail"
                                            data-from_id="{{ $company_email->from_id }}">{{ $date->diffForHumans() }}</a>
                                        {{-- <br>
                                        {{!empty($company_email->date) ? date('d-m-Y', strtotime($company_email->date)) : ''}} --}}
                                    </td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            <div class="p-1 text-secondary cursor-pointer" data-toggle="modal"
                                                data-target="#email_edit"><i class="fa fa-edit edit"
                                                    data-id="{{ $company_email->id }}"
                                                    data-email_from="{{ $company_email->from_id }}"
                                                    data-email_to="{{ $company_email->to_id }}"
                                                    data-email_cc="{{ $company_email->company_cc }}"
                                                    data-email_date="{{ $company_email->date }}"
                                                    data-email_time="{{ $company_email->time }}"
                                                    data-email_subject="{{ $company_email->subject }}"
                                                    data-email_body="{{ $company_email->body }}"
                                                    data-email_attachment="{{ $company_email->attachment }}"></i></div>
                                        </div>
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
                <div class="col-5 mt-3">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-sm btn-outline-secondary waves-effect"
                            fdprocessedid="1gxuds"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary waves-effect"
                            fdprocessedid="6i5q7q"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>


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
                    $from_name = $from_first_name . ' ' . $from_last_name;
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
                <div id="single-email-wrapper" class="row single-email-wrapper py-3">
                    <div class="col-lg-12 px-0 single-email-inner">
                        <div class="card m-0">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h3 class="subject">{{ $company_email->subject }}</h3>
                                    <div class="btn-group ml-auto">
                                        <div class="p-1 text-secondary cursor-pointer" data-toggle="modal"
                                            data-target="#email_edit"><i class="fa fa-edit edit"
                                                data-id="{{ $company_email->id }}"
                                                data-email_from="{{ $company_email->from_id }}"
                                                data-email_to="{{ $company_email->to_id }}"
                                                data-email_cc="{{ $company_email->company_cc }}"
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                data-email_attachment="{{ $company_email->attachment }}"></i></div>
                                        <div class="p-1 text-secondary cursor-pointer"
                                            onclick="printDiv('single-email-wrapper')"><i class="fa fa-print"></i></div>
                                    </div>
                                </div>
                                <div class="email_header d-flex align-items-center">
                                    <img class="avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                    <div class="from email_from_name">
                                        <span>{{ $from_name }}</span>
                                        <span class="work_email">
                                            < {{ $from->work_email }}>
                                        </span>
                                    </div>
                                    @php
                                        $date = \Carbon\Carbon::parse($company_email->date);
                                    @endphp
                                    <div class="date ml-auto">{{ $date->diffForHumans() }}</b></div>
                                </div>
                            </div>

                            <div class="card-body">
                                <p class="body">
                                    {{ $company_email->body }}
                                </p>
                            </div>

                            <div class="card-footer d-flex align-items-center">
                                <div>
                                    <div class="from email_from_name">
                                        <span>{{ ucfirst($from_name) }}</span>
                                        < {{ $from->work_email }}>
                                    </div>
                                    <div class="date ml-auto">{{ $date->diffForHumans() }}</div>
                                </div>
                                <div class="btn-group ml-auto">
                                    <div class="p-1 text-secondary cursor-pointer"><a href=""
                                            class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light"
                                            id="reply" data-toggle="modal"
                                            data-target="#reply_model">Reply</a></div>
                                    {{-- <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-reply-all"></i></div> --}}
                                    {{-- <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-forward"></i></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- edit email modal starts -->
        <div id="email_edit" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="" id="edit_id" name="id">
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
                            <select name="to_id[]" id="to_id" class="form-control select" multiple
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
                            <select name="cc[]" id="cc" class="form-control select" multiple
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
                            <label>Subject</label>
                            <input class="form-control" type="text" name="email_subject" id="edit_subject">
                        </div>
                        <div class="form-group">
                            <label>Body<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_body" name="email_body" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment</label>
                            <input class="form-control" type="file" name="email_attachment" id="edit_attachment">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn mb-2">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit email modal ends  -->
        <!-- New layout ends-->



        <!--- reply Models --->
        <div id="reply_model" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('reply-mail') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="" id="edit_id" name="id">
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
                             <input type="hidden" name=""> 
                            </div>
                        @endif
                        <div class="form-group">
                            <label>To<span class="text-danger">*</span></label>
                            <select name="to_id[]" class="form-control select" id="to_id" multiple
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
                        <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" name="email_subject" id="edit_subject">
                        </div>
                        <div class="form-group">
                            <label>Body<span class="text-danger">*</span></label>
                            <textarea class="form-control ckeditor" id="edit_body" name="email_body" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment</label>
                            <input class="form-control" type="file" name="email_attachment" id="edit_attachment">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn mb-2">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!---reply models --->


    @endsection

    @section('scripts')
        <!-- Datatable JS -->
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.mail-detail').on('click', function() {
                    var from_id = $(this).data('from_id');
                    $.ajax({
                        type: 'GET',
                        url: '/mail-detail/' + from_id,
                        data: {
                            _token: $("#csrf").val(),
                            from_id: from_id,
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            // console.log(data.email_data, "data");
                            $.each(data.email_data, function(index, row) {
                                // console.log( row.employeejob.work_email)
                                var work_email = `<` + row.employeejob.work_email + `>`;
                                $(".subject").html(row.subject);
                                $(".body").html(row.body);
                                $(".email_from_name").html(`<span>` + row.employeejob
                                    .employee.firstname + " " + row.employeejob.employee
                                    .lastname + `</span>` + work_email);
                                $(".work_email").html(row.employeejob.work_email);
                            });
                            // $.each(data.email_data, function(index, row) {
                            //     $(".subject").html(row.subject);
                            // });

                            // $("#msg").html(data.msg);
                        },
                    });
                });
            });

            $('.edit').on('click', function() {
                var id = $(this).data('id');
                var edit_from = $(this).data('email_from');
                var edit_work_email = $(this).data('work_email');
                var edit_email_to = $(this).data('email_to'); 
                var edit_cc = $(this).data('email_cc');
                var edit_date = $(this).data('email_date');
                var edit_time = $(this).data('email_time');
                var edit_subject = $(this).data('email_subject');
                var body = $(this).data('email_body');
                // console.log(edit_email_to,"email_to");
                $('#edit_id').val(id);
                $('#from_id').val(edit_from)
                $('#edit_subject').val(edit_subject);
                // $('#to_id option[value=' + edit_email_to + ']').attr('selected', true);
                $('#to_id').val(edit_email_to);
                $('#cc').val(edit_cc);
                $('#edit_body').val(body);
            });

            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endsection
