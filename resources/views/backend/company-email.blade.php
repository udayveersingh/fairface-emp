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
    </style>
@endsection
@section('page-header')
    <div class="top_email_header d-flex align-items-center">
        <div class="col-auto">
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fa fa-home"></i></a>
        </div>
        <div class="col">
            <div class="alert alert-primary m-0" style="display:block;">
                <strong>Announcement!</strong> You should check in on some of those fields below.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- New Layout Starts-->
    <div class="table-box bg-white row">
        <div class="table-detail col-md-3">
            <div class="p-4">
                <a href="email-compose.html"
                    class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a>

                <div class="list-group mail-list mt-3">
                    <a href="#" class="list-group-item border-0 text-success"><i
                            class="fas fa-download font-13 mr-2"></i>Inbox <b>(8)</b></a>
                    <a href="#" class="list-group-item border-0"><i class="far fa-star font-13 mr-2"></i>Unread</a>
                    <a href="#" class="list-group-item border-0"><i class="far fa-file-alt font-13 mr-2"></i>Archive
                        <b>(20)</b></a>
                    <a href="#" class="list-group-item border-0"><i
                            class="far fa-paper-plane font-13 mr-2"></i>Sent</a>
                </div>

            </div>
        </div>

        <div class="table-detail mail-right col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="btn-toolbar mt-4" role="toolbar">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-primary waves-effect waves-light" fdprocessedid="ri6ks"><i
                                    class="fa fa-inbox"></i></button>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                fdprocessedid="omqa9tb"><i class="fa fa-exclamation-circle"></i></button>
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                fdprocessedid="oqzsnm"><i class="far fa-trash-alt"></i></button>
                        </div>
                        <div class="btn-group mr-2">

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
                        </div>
                        <div class="btn-group mr-2">
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
                        </div>

                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="x3mkj9">
                                More <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                                <li><a href="javascript:void(0);" class="dropdown-item">Dropdown link</a></li>
                            </ul>
                        </div>

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
                                        <a href="#single-email-wrapper" class="email-name">{{ucfirst($fullname)}}</a>
                                    </td>

                                    <td>
                                        <a href="#single-email-wrapper" class="email-name">{{ ucfirst($to_last_name) }}</a>
                                    </td>

                                    <td class="d-none d-lg-inline-block">
                                        <a href="#single-email-wrapper" class="email-msg">Lorem ipsum dolor sit amet,
                                            consectetuer adipiscing elit</a>
                                    </td>
                                    <td style="width: 20px;" class=" d-none d-lg-display-inline">
                                        <i class="fa fa-paperclip"></i>
                                    </td>
                                    <td class="text-right mail-time">
                                        07:23 AM
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



            <div id="single-email-wrapper" class="row single-email-wrapper py-3">
                <div class="col-lg-12 px-0 single-email-inner">
                    <div class="card m-0">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3>We received your inquiry for moving!</h3>
                                <div class="btn-group ml-auto">
                                    <div class="p-1 text-secondary cursor-pointer" data-toggle="modal"
                                        data-target="#email_edit"><i class="fa fa-edit"></i></div>
                                    <div class="p-1 text-secondary cursor-pointer"
                                        onclick="printDiv('single-email-wrapper')"><i class="fa fa-print"></i></div>
                                </div>
                            </div>
                            <div class="email_header d-flex align-items-center">
                                <img class="avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                <div class="from">
                                    <span>Lukasz Holeczek</span>
                                    < lukasz@bootstrapmaster.com>
                                </div>
                                <div class="date ml-auto">Today, <b>3:47 PM</b></div>
                            </div>
                        </div>

                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                                sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                                laborum.
                            </p>
                            <blockquote>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                                sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                                laborum.
                            </blockquote>
                        </div>


                        <div class="card-footer d-flex align-items-center">
                            <div>
                                <div class="from">
                                    <span>Lukasz Holeczek</span>
                                    < lukasz@bootstrapmaster.com>
                                </div>
                                <div class="date ml-auto">Today, <b>3:47 PM</b></div>
                            </div>
                            <div class="btn-group ml-auto">
                                <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-reply"></i></div>
                                <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-reply-all"></i></div>
                                <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-forward"></i></div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
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

                        <div class="card-box">

                            <div class="form-group">
                                <label for="">Subject</label>
                                <input type="text" class="form-control" value="We received your inquiry for moving!">
                            </div>

                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea class="form-control" rows="6">  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- edit email modal ends  -->
        <!-- New layout ends-->


    @endsection

    @section('scripts')
        <!-- Datatable JS -->
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
        <script>
            $(document).ready(function() {

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
