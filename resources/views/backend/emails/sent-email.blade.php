@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .gap-2 {
            gap: 10px;
        }

        .email_tabs {
            border: none;
        }

        .email_tabs .nav-link {
            border: none;
        }

        .email_tabs .nav-link.active {
            color: #667eea;
        }

        .fsizi {
            display: block;
            font-size: 16px;
        }

        .fsizii {
            display: block;
            font-size: 14px;
        }

        .fsiziii {
            display: block;
            font-size: 10px;
        }

        .email-content-wrap {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            max-width: 400px;
        }

        .email-msg.fsizii {
            max-width: 400px;
        }

        .fs-12 {
            font-size: 12px;
            color: #c4bfbf !important;
        }

        .fs-18 {
            font-size: 18px;
        }

        .shadow-0 {
            box-shadow: none !important;
        }

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
            max-height: 60vh;
            overflow-y: auto;
        }

        .emails_list thead {
            position: sticky;
            top: 0;
            background: #fff;
            border-top: 1px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }

        .emails_list tr td {
            border-bottom: 1px solid #dee2e6;
        }

        /* .emails_list tr.active:nth-child(1) td {
                            background: #dfe4fa;
                        } */

        .unread {
            font-weight: bold;
        }

        .single-email-wrapper {
            min-height: calc(100vh - 157px);
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

        .email_header .avatar {
            border-radius: 4px;
        }
    </style>
@endsection
@section('page-header')
    <div class="top_email_header d-flex align-items-center">
        <div class="col-auto">
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fa fa-home"></i></a>
        </div>
        {{-- <div class="col">
            @if (count($annoucement_list) > 0)
                <div id="carouselExampleFade"
                    class="carousel announcement_slider alert-primary p-3 rounded slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($annoucement_list as $key => $annoucement)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <strong>{{ $annoucement->description }}</strong>
                            </div>
                        @endforeach --}}
        {{-- <div class="carousel-item">
                        <strong>Announcement Two!</strong> You should check in on some of those fields below.
                    </div>
                    <div class="carousel-item">
                        <strong>Announcement Three!</strong> You should check in on some of those fields below.
                    </div> --}}
        {{-- </div>
                    <ol class="carousel-indicators" style="right:20px; left:auto; margin-right:0;">
                        @foreach ($annoucement_list as $key => $annoucement)
                            <li data-target="#carouselExampleFade" data-slide-to="{{ $key }}" class=""></li>
                        @endforeach --}}
        {{-- <li data-target="#carouselExampleFade" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="1"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="2"></li> --}}
        {{-- </ol> --}}
        {{-- </div>
            @endif
        </div> --}}
    </div>
@endsection

@section('content')
    <!-- New Layout Starts-->
    <div class="table-box bg-white row">
        <div class="table-detail col-md-2">
            <div class="p-4">
                <a href="{{ route('compose-email') }}"
                    class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light w-100">Compose</a>

                <div class="list-group mail-list mt-3">
                    @if (Auth::check() && Auth::user()->role->name != App\Models\Role::EMPLOYEE)
                        <a href="{{ route('company-email') }}" class="list-group-item border-0 py-2 px-3"><i
                                class="fas fa-download font-13 mr-2"></i>Inbox <b>({{ $count_emails }})</b></a>
                    @else
                        <a href="{{ route('user-email-inbox') }}" class="list-group-item border-0 py-2 px-3"><i
                                class="fas fa-download font-13 mr-2"></i>Inbox <b>({{ $count_emails }})</b></a>
                        <a href="{{ route('user-email-inbox') }}" class="list-group-item border-0 py-2 px-3"><i
                                    class="fas fa-download font-13 mr-2"></i>Inbox <b>({{ $count_emails }})</b></a>    
                    @endif
                    {{-- <a href="" class="list-group-item border-0 py-2 px-3"><i
                            class="far fa-star font-13 mr-2"></i>Unread<b>({{ $count_unread_emails }})</b></a> --}}
                    <a href="{{ route('sent-email') }}" class="list-group-item border-0 py-2 px-3"><i
                            class="far fa-paper-plane font-13 mr-2"></i>Sent<b>({{ $sent_email_count }})</b></a>
                </div>
            </div>
        </div>

        <div class="table-detail mail-right col-md-10">
            <div class="row">
                <div class="col-md-6 pr-2 pr-md-0">
                    <form class="input-group mt-3 pr-3" method="post" action="">
                        <input type="text" class="form-control border-0 bg-light" placeholder="Search"
                            aria-label="Search">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group-append">
                            <button class="btn btn-light border-0" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form><!-- search bar ends here -->

                    <ul class="nav nav-tabs mt-2 email_tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active bg-white" id="all-tab" data-toggle="tab" data-target="#all"
                                type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-white" id="unread-tab" data-toggle="tab" data-target="#unread"
                                type="button" role="tab" aria-controls="unread" aria-selected="false">Unread</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <div class="table-responsive mx-100vh">
                                <table class="table table-hover mails m-0 no-border emails_list" style="border:none;">
                                    <tbody>
                                        @if (!empty($company_emails->count()) > 0)
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($company_emails as $index => $company_email)
                                                @php
                                                    $from = App\Models\EmployeeJob::with('employee')
                                                        ->where('id', '=', $company_email->from_id)
                                                        ->first();
                                                    $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                                    $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                                    $fullname = $from_first_name . ' ' . $from_last_name;
                                                    // $to = App\Models\EmployeeJob::with('employee')
                                                    //     ->where('id', '=', $company_email->to_id)
                                                    //     ->first();

                                                    // $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname : '';
                                                    // $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname : '';
                                                    // $to_fullname = $to_first_name . ' ' . $to_last_name;

                                                    if (!empty($company_email->to_id)) {
                                                        $to_ids = explode(',', $company_email->to_id);
                                                    }
                                                    $to_emails = [];
                                                    foreach ($to_ids as $to_id) {
                                                        $to_mail_user = App\Models\EmployeeJob::with('employee')
                                                            ->where('id', '=', $to_id)
                                                            ->first();
                                                        $to_first_name = !empty($to_mail_user->employee->firstname) ? $to_mail_user->employee->firstname : '';
                                                        $to_last_name = !empty($to_mail_user->employee->lastname) ? $to_mail_user->employee->lastname : '';
                                                        $to_fullname = $to_first_name . ' ' . $to_last_name;
                                                        $to_emails[] = $to_fullname;
                                                    }

                                                    $to_mail_users = implode(',', $to_emails);
                                                    $multiple_cc = explode(',', $company_email->company_cc);
                                                    $cc_emails = [];
                                                    foreach ($multiple_cc as $value) {
                                                        $cc = App\Models\EmployeeJob::where('id', '=', $value)->value('work_email');
                                                        $cc_emails[] = $cc;
                                                    }
                                                    $cc = implode(',', $cc_emails);

                                                    if (!empty($company_email->read_at) && $company_email->read_at != null) {
                                                        $unread = 'unread';
                                                    } else {
                                                        $unread = '';
                                                    }

                                                @endphp
                                                <tr class="{{ $unread }}">
                                                    <td>
                                                        <div class="d-block fsizi">
                                                            <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">
                                                                {{ ucfirst($fullname) }}
                                                            </a>
                                                            <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">{{ $to_mail_users }}</a>
                                                        </div>

                                                        <a href="#single-email-wrapper"
                                                            class="email-msg mail-detail get_email_data fsizii"
                                                            data-com_email_id="{{ $company_email->id }}"
                                                            data-from_id="{{ $company_email->from_id }}"
                                                            data-email_to="{{ $company_email->to_id }}"
                                                            data-subject="{{ $company_email->subject }}"
                                                            data-email_cc="{{ $company_email->company_cc }}"
                                                            data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                            data-email_attachment="{{ $company_email->attachment }}"
                                                            data-token="{{ Session::token() }}"
                                                            data-count="{{ $count }}">{{ $company_email->subject }}</a>

                                                        <div class="d-block fsiziii email-content-wrap">
                                                            {!! mb_strimwidth("$company_email->body", 0, 200, '...') !!}
                                                        </div>
                                                    </td>


                                                    <td align="end" class="align-middle">


                                                        <div class="text-right mail-time">
                                                            <a href="#single-email-wrapper"
                                                                class="email-date mail-detail get_email_data fs-12"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">{{ date('d-m-Y H:i', strtotime($company_email->created_at)) }}</a>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                                            <div class="p-1 text-secondary cursor-pointer"
                                                                data-toggle="modal" data-target="#email_edit"><i
                                                                    class="fa fa-edit edit"
                                                                    data-id="{{ $company_email->id }}"
                                                                    data-email_from="{{ $company_email->from_id }}"
                                                                    data-email_to="{{ $company_email->to_id }}"
                                                                    data-email_cc="{{ $company_email->company_cc }}"
                                                                    data-email_date="{{ $company_email->date }}"
                                                                    data-email_time="{{ $company_email->time }}"
                                                                    data-email_subject="{{ $company_email->subject }}"
                                                                    data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                    data-email_attachment="{{ $company_email->attachment }}"
                                                                    title="Edit"></i></div>
                                                            @if (!empty($company_email->attachment))
                                                                <a href="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}"
                                                                    target="_blank"> <i
                                                                        class="fa fa-paperclip text-secondary cursor-pointer"></i></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div><!-- table list ends here -->
                        </div><!-- all mails tab ends here -->
                        <div class="tab-pane fade" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                            <div class="table-responsive mx-100vh">
                                <table class="table table-hover mails m-0 no-border emails_list" style="border:none;">
                                    <tbody>
                                        @if (!empty($company_unread_emails->count()) > 0)
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($company_unread_emails as $index => $company_email)
                                                @php
                                                    $from = App\Models\EmployeeJob::with('employee')
                                                        ->where('id', '=', $company_email->from_id)
                                                        ->first();
                                                    $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                                    $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                                    $fullname = $from_first_name . ' ' . $from_last_name;
                                                    // $to = App\Models\EmployeeJob::with('employee')
                                                    //     ->where('id', '=', $company_email->to_id)
                                                    //     ->first();

                                                    // $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname : '';
                                                    // $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname : '';
                                                    // $to_fullname = $to_first_name . ' ' . $to_last_name;

                                                    if (!empty($company_email->to_id)) {
                                                        $to_ids = explode(',', $company_email->to_id);
                                                    }
                                                    $to_emails = [];
                                                    foreach ($to_ids as $to_id) {
                                                        $to_mail_user = App\Models\EmployeeJob::with('employee')
                                                            ->where('id', '=', $to_id)
                                                            ->first();
                                                        $to_first_name = !empty($to_mail_user->employee->firstname) ? $to_mail_user->employee->firstname : '';
                                                        $to_last_name = !empty($to_mail_user->employee->lastname) ? $to_mail_user->employee->lastname : '';
                                                        $to_fullname = $to_first_name . ' ' . $to_last_name;
                                                        $to_emails[] = $to_fullname;
                                                    }

                                                    $to_mail_users = implode(',', $to_emails);
                                                    $multiple_cc = explode(',', $company_email->company_cc);
                                                    $cc_emails = [];
                                                    foreach ($multiple_cc as $value) {
                                                        $cc = App\Models\EmployeeJob::where('id', '=', $value)->value('work_email');
                                                        $cc_emails[] = $cc;
                                                    }
                                                    $cc = implode(',', $cc_emails);

                                                    if (!empty($company_email->read_at) && $company_email->read_at != null) {
                                                        $unread = 'unread';
                                                    } else {
                                                        $unread = '';
                                                    }

                                                @endphp
                                                <tr class="{{ $unread }}">
                                                    <td>
                                                        <div class="d-block fsizi">
                                                            <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">
                                                                {{ ucfirst($fullname) }}
                                                            </a>
                                                            <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">{{ $to_mail_users }}</a>
                                                        </div>

                                                        <a href="#single-email-wrapper"
                                                            class="email-msg mail-detail get_email_data fsizii"
                                                            data-com_email_id="{{ $company_email->id }}"
                                                            data-from_id="{{ $company_email->from_id }}"
                                                            data-email_to="{{ $company_email->to_id }}"
                                                            data-subject="{{ $company_email->subject }}"
                                                            data-email_cc="{{ $company_email->company_cc }}"
                                                            data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                            data-email_attachment="{{ $company_email->attachment }}"
                                                            data-token="{{ Session::token() }}"
                                                            data-count="{{ $count }}">{{ $company_email->subject }}</a>

                                                        <div class="d-block fsiziii email-content-wrap">
                                                            {!! mb_strimwidth("$company_email->body", 0, 200, '...') !!}
                                                        </div>
                                                    </td>


                                                    <td align="end" class="align-middle">


                                                        <div class="text-right mail-time">
                                                            <a href="#single-email-wrapper"
                                                                class="email-date mail-detail get_email_data fs-12"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-from_id="{{ $company_email->from_id }}"
                                                                data-email_to="{{ $company_email->to_id }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"></i>
                                                                data-token="{{ Session::token() }}"
                                                                data-count="{{ $count }}">{{ date('d-m-Y H:i', strtotime($company_email->created_at)) }}</a>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                                            <div class="p-1 text-secondary cursor-pointer"
                                                                data-toggle="modal" data-target="#email_edit"><i
                                                                    class="fa fa-edit edit"
                                                                    data-id="{{ $company_email->id }}"
                                                                    data-email_from="{{ $company_email->from_id }}"
                                                                    data-email_to="{{ $company_email->to_id }}"
                                                                    data-email_cc="{{ $company_email->company_cc }}"
                                                                    data-email_date="{{ $company_email->date }}"
                                                                    data-email_time="{{ $company_email->time }}"
                                                                    data-email_subject="{{ $company_email->subject }}"
                                                                    data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                    data-email_attachment="{{ $company_email->attachment }}"
                                                                    title="Edit"></i></div>
                                                            @if (!empty($company_email->attachment))
                                                                <a href="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}"
                                                                    target="_blank"> <i
                                                                        class="fa fa-paperclip text-secondary cursor-pointer"></i></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <div class="text-left ml-5">There is no new email.</div>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div><!-- unread mails tab ends here -->
                    </div>


                </div> <!-- col-6 ends here -->
                <div class="col-md-6 pl-2 pl-md-0">
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
                        <div id="single-email-wrapper" class="single-email-wrapper h-100 py-3">
                            <div class="single-email-inner h-100">
                                    <div class="loader text-secondary"
                                        style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-spinner fa fa-spin"></i>
                                    </div>
                                <div class="card m-0 shadow-0">
                                    <div class="card-header">
                                        <div class="d-flex gap-2 text-secondary">
                                            <span class="p-1 cursor-pointer text-secondary cursor-pointer"
                                                data-toggle="modal" data-target="#email_edit"><i title="Edit"
                                                    class="fa fa-edit editbtn" data-id="{{ $company_email->id }}"
                                                    data-email_from="{{ $company_email->from_id }}"
                                                    data-email_to="{{ $company_email->to_id }}"
                                                    data-email_cc="{{ $company_email->company_cc }}"
                                                    data-email_date="{{ $company_email->date }}"
                                                    data-email_time="{{ $company_email->time }}"
                                                    data-email_subject="{{ $company_email->subject }}"
                                                    data-email_body="{!! $company_email->body !!}"
                                                    data-email_attachment="{{ $company_email->attachment }}"></i>
                                                Edit</span>
                                            <div class="p-1 text-secondary cursor-pointer"><a href=""
                                                    class=" text-secondary" id="reply" data-toggle="modal"
                                                    data-target="#reply_model"><i class="fa fa-mail-reply"></i> Reply</a>
                                            </div>
                                            <div class="p-1 text-secondary cursor-pointer"
                                                onclick="printDiv('single-email-wrapper')"><i class="fa fa-print"></i>
                                            </div>
                                            {{-- <span class="cursor-pointer"><i class="fa fa-mail-forward"
                                                    class="Forward"></i> Forward</span> --}}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <h3 class="subject fs-18 mt-2">{{ $company_email->subject }}</h3>
                                            {{-- <div class="btn-group ml-auto">

                                                <div class="p-1 text-secondary cursor-pointer"
                                                    onclick="printDiv('single-email-wrapper')"><i class="fa fa-print"></i>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="email_header d-flex align-items-center">
                                            <img class="avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                            <div class="from email_from_name">
                                                <span>{{ $from_name }}</span>
                                                <span class="work_email d-block fs-12">
                                                    < {{ !empty($from->work_email) ? $from->work_email : '' }}>
                                                </span>
                                            </div>
                                            @php
                                                $date = \Carbon\Carbon::parse($company_email->created_at);
                                            @endphp
                                            <div class="date ml-auto">{{ $date->diffForHumans() }}</b></div>
                                        </div>
                                        <div class="mt-2 fs-14">To: <span class="email-name mail-detail get_email_data"
                                                data-com_email_id="{{ $company_email->id }}"
                                                data-from_id="{{ $company_email->from_id }}"
                                                data-email_to="{{ $company_email->to_id }}"
                                                data-subject="{{ $company_email->subject }}"
                                                data-token="{{ Session::token() }}">{{ $to_mail_users }}</span></div>
                                    </div>

                                    <div class="card-body">
                                        <p class="body">
                                            {!! $company_email->body !!}
                                        </p>
                                    </div>

                                    <div class="view_attachment">
                                    <img class="img-fluid" src="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}" width="150px">

                                    </div>

                                    <div class="card-footer d-flex align-items-center">
                                        <div class="btn-group ml-auto gap-2">
                                            <div class="p-1 text-secondary cursor-pointer"><a href=""
                                                    class=" text-secondary" id="reply" data-toggle="modal"
                                                    data-target="#reply_model"><i class="fa fa-mail-reply"></i> Reply</a>
                                            </div>
                                            {{-- <div class="p-1 text-secondary cursor-pointer"><i class="fa fa-mail-forward"
                                                    title="Forward"></i> Forward</div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> <!-- End row -->




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
                                $to_email_ids = App\Models\EmployeeJOb::with('employee')
                                    ->whereHas('employee', function ($q) {
                                        $q->where('record_status', '=', 'active');
                                    })
                                    ->get();
                            @endphp
                            <div class="row">
                                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::EMPLOYEE)
                                    <div class="col-lg-6">
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
                                    </div>
                                @elseif(
                                    (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
                                        Auth::user()->role->name == App\Models\Role::ADMIN)
                                    <div class="col-lg-6">
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
                                    </div>
                                @endif
                                <div class="col-lg-6">
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
                                </div>
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
                            {{-- <div class="attachment">

                            </div> --}}
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn mb-2">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit email modal ends  -->
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
                            @foreach ($company_emails as $index => $company_email)
                                @php
                                    if ($index > 0) {
                                        break;
                                    }
                                @endphp
                                <input type="hidden" value="{{ !empty($company_email->id) ? $company_email->id : '' }}"
                                    id="edit_id" name="id">
                                <input type="hidden"
                                    value="{{ !empty($company_email->from_id) ? $company_email->from_id : '' }}"
                                    id="reply_from_id" name="from_id">
                                <input type="hidden"
                                    value="{{ !empty($company_email->to_id) ? $company_email->to_id : '' }}"
                                    id="reply_to_ids" name="to_id[]">
                                <input type="hidden"
                                    value="{{ !empty($company_email->subject) ? $company_email->subject : '' }}"
                                    id="reply_subject" name="subject">
                                <input class="form-control" value="{{ date('Y-m-d') }}" type="hidden"
                                    name="email_date" id="">
                                <input class="form-control" value="{{ date('H:i:s') }}" type="hidden"
                                    name="email_time" id="">
                            @endforeach
                            @php
                                $to_email_ids = App\Models\EmployeeJOb::with('employee')
                                    ->whereHas('employee', function ($q) {
                                        $q->where('record_status', '=', 'active');
                                    })
                                    ->get();
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
                            @elseif(
                                (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
                                    Auth::user()->role->name == App\Models\Role::ADMIN)
                                <div class="form-group">
                                    <input type="hidden" name="">
                                </div>
                            @endif
                            {{-- <div class="form-group">
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
                            </div> --}}
                            {{-- <div class="form-group">
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
                            </div> --}}
                            {{-- <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" name="email_subject" id="edit_subject">
                        </div> --}}
                            <div class="form-group">
                                <label>Message<span class="text-danger">*</span></label>
                                <textarea class="form-control ckeditor" id="edit_body" name="email_body" rows="4" cols="50"></textarea>
                            </div>
                            {{-- <div class="form-group">
                            <label>Attachment</label>
                            <input class="form-control" type="file" name="email_attachment" id="edit_attachment">
                        </div> --}}
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn mb-2">Send</button>
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
                setTimeout(function() {
                    $(".loader").hide();
                }, 500);
                $('.mail-detail').on('click', function() {
                    var id = $(this).data('com_email_id');
                    var from_id = $(this).data('from_id');
                    var token = $(this).data('token');
                    console.log(token);
                    $.ajax({
                        type: 'POST',
                        url: '/mail-detail/' + from_id,
                        data: {
                            _token: token,
                            from_id: from_id,
                            id: id,
                        },
                        beforeSend: function() {
                            $(".loader").show();
                        },

                        complete: function() {
                            $(".loader").hide();
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            $.each(data.email_data, function(index, row) {
                                var date = new Date(row.created_at);
                                dateStringWithTime = moment(date).format('DD-MM-YYYY');
                                var work_email = `<` + row.employeejob.work_email + `>`;
                                $(".subject").html(row.subject);
                                $(".card-body").html(row.body);
                                $(".email_from_name").html(`<span>` + row.employeejob
                                    .employee.firstname + " " + row.employeejob.employee
                                    .lastname + `</span>` + work_email);
                                $(".work_email").html(row.employeejob.work_email);
                                $(".date").html(dateStringWithTime);
                                if (row.attachment != null) {
                                    $(".view_attachment").html(
                                        `<img src='{{ asset('storage/company_email/attachment/${row.attachment}') }}' width='150px'>`
                                    );
                                } else {
                                    $(".view_attachment").html('');
                                }
                            });
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
                var attachment = $(this).data('email_attachment');

                console.log(body);
                // console.log(edit_email_to,"email_to");
                $('#edit_id').val(id);
                $('#from_id').val(edit_from)
                $('#edit_subject').val(edit_subject);
                // $('#to_id option[value=' + edit_email_to + ']').attr('selected', true);
                $('#to_id').val(edit_email_to);
                $('#cc').val(edit_cc);
                $('#edit_body').val(body);
                $(".attachment").html(
                    `<img src='{{ asset('storage/company_email/attachment/${attachment}') }}' width='150px'>`);
            });

            $('.editbtn').on('click',function(){
                $('#email_edit').modal('show');
            })

            //reply mail
            $('.get_email_data').on('click', function() {
                id = $(this).data('com_email_id');
                from = $(this).data('from_id');
                to_ids = $(this).data('email_to');
                reply_subject = $(this).data('subject')
                edit_cc = $(this).data('email_cc');
                body = $(this).data('email_body');
                attachment = $(this).data('email_attachment');

                console.log(attachment , "attachment");

                // console.log(body , "email_body");
                $('#reply_from_id').val(from);
                $('#reply_to_ids').val(to_ids);
                $('#reply_subject').val(reply_subject);
                $('#edit_id').val(id);
                $('#from_id').val(from)
                // $('#to_id').val(to_ids);
                $("#to_id").val(to_ids).trigger("change");
                $('#edit_subject').val(reply_subject);
                $('#cc').val(edit_cc);
                $('#edit_body').val(body);
                $(".attachment").html(
                    `<img src='{{ asset('storage/company_email/attachment/${attachment}') }}' width='150px'>`);
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
