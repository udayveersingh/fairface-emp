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
        <div class="col">
            @if (count($annoucement_list) > 0)
                <div id="carouselExampleFade"
                    class="carousel announcement_slider alert-primary p-3 rounded slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($annoucement_list as $key => $annoucement)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <strong>{{ $annoucement->description }}</strong>
                            </div>
                        @endforeach
                        {{-- <div class="carousel-item">
                        <strong>Announcement Two!</strong> You should check in on some of those fields below.
                    </div>
                    <div class="carousel-item">
                        <strong>Announcement Three!</strong> You should check in on some of those fields below.
                    </div> --}}
                    </div>
                    <ol class="carousel-indicators" style="right:20px; left:auto; margin-right:0;">
                        @foreach ($annoucement_list as $key => $annoucement)
                            <li data-target="#carouselExampleFade" data-slide-to="{{ $key }}" class=""></li>
                        @endforeach
                        {{-- <li data-target="#carouselExampleFade" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="1"></li>
                    <li data-target="#carouselExampleFade" data-slide-to="2"></li> --}}
                    </ol>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <!-- New Layout Starts-->
    <div class="table-box bg-white row">
        <div class="table-detail col-md-2">
            <div class="p-4">
                <a href="{{ route('compose-email') }}"
                    class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a>

                <div class="list-group mail-list mt-3">
                    <a href="{{ route('user-email-inbox') }}" class="list-group-item border-0 {{ $keyword=='inbox'?'active':'' }} py-2 px-3"><i
                        class="fas fa-download font-13 mr-2"></i>Inbox <b>({{ $total_mail_count }})</b></a>
                    <a href="{{ route('user-email-inbox', ['keyword' => 'archive']) }}"
                    class="list-group-item border-0 py-2 px-3 {{ $keyword=='archive'?'active':'' }}"><i
                        class="far fa-star font-13 mr-2"></i>Archive<b>({{$archive_count}})</b></a>
                    <a href="{{ route('user-email-inbox', ['keyword' => 'sent']) }}" class="list-group-item border-0 {{ $keyword=='sent'?'active':'' }} py-2 px-3"><i
                        class="far fa-paper-plane font-13 mr-2"></i>Sent<b>({{ $sent_email_count }})</b></a>
                        
                </div>

            </div>
        </div>

        <div class="table-detail mail-right col-md-10">
            <div class="row">
                <div class="col-md-6 pr-2 pr-md-0">
                    <form class="input-group mt-3 pr-3" method="post" action="" id="searchform">
                        @csrf
                        <input type="text" class="form-control border-0 bg-light" name="search" id="searchvalue"
                            placeholder="Search" aria-label="Search">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="input-group-append">
                            <button class="btn btn-light border-0" value="submit" id="searchbtn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form><!-- search bar ends here -->

                    @if($keyword=='inbox')
                    <ul class="nav nav-tabs mt-2 email_tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('user-email-inbox', ['keyword' => 'inbox']) }}"><button class="nav-link {{ $keyword=='inbox'?'active':'' }} bg-white">All({{ $total_mail_count }})</button>
                                </a>    
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('user-email-inbox', ['keyword' => 'unread']) }}"><button class="nav-link {{ $keyword=='unread'?'active':'' }} bg-white">Unread({{ $company_unread_emails }})</button>
                                </a>
                                
                        </li>
                    </ul>
                    @endif
                    <div class="tab-content pt-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <div class="table-responsive mx-100vh">
                                <table class="table table-hover mails m-0 no-border emails_list" style="border:none;">
                                    <tbody>
                                        @if (!empty($company_emails)) 
                                            @foreach ($company_emails as $index => $company_email)
                                                @php
                                                    if($keyword=='sent'){
                                                        $from = App\Models\EmployeeJob::with('employee')
                                                        ->where('id', '=', $company_email->to_id)
                                                        ->first();
                                                    
                                                    }else{
                                                        $from = App\Models\EmployeeJob::with('employee')
                                                        ->where('id', '=', $company_email->from_id)
                                                        ->first();
                                                    }
                                                    $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                                    $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                                    $fullname = $from_first_name . ' ' . $from_last_name;
                                                    $to_emails = [];
                                                    $to_ids = explode(',', $company_email->to_id);
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
                                                    if (!empty($company_email->read_at) && $company_email->read_at != null) {
                                                        $unread = 'unread';
                                                    } else {
                                                        $unread = '';
                                                    }

                                                @endphp

                                                {{-- @dd($company_email) --}}
                                                <tr class={{ $unread }}>
                                                    <td>
                                                        <div class="d-block fsizi">
                                                            <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-email_to="{{ $company_email->from_id }}"
                                                                data-from_id="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}">{{ ($keyword=='sent')?'To: ':'' }}{{  $fullname }}</a>

                                                            <!-- <a href="#single-email-wrapper"
                                                                class="email-name mail-detail get_email_data"
                                                                data-com_email_id="{{ $company_email->id }}"
                                                                data-email_to="{{ $company_email->from_id }}"
                                                                data-from_id="{{ $company_email->to_id }}"
                                                                data-subject="{{ $company_email->subject }}"
                                                                data-email_cc="{{ $company_email->company_cc }}"
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}">{{ ucfirst($to_emails) }}</a> -->
                                                        </div>

                                                        <a href="#single-email-wrapper"
                                                            class="email-msg mail-detail get_email_data"
                                                            data-com_email_id="{{ $company_email->id }}"
                                                            data-email_to="{{ $company_email->from_id }}"
                                                            data-from_id="{{ $company_email->to_id }}"
                                                            data-subject="{{ $company_email->subject }}"
                                                            data-email_cc="{{ $company_email->company_cc }}"
                                                            data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                            data-email_attachment="{{ $company_email->attachment }}"
                                                            data-token="{{ Session::token() }}">{{ $company_email->subject }}</a>

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
                                                                data-email_body="{{ strip_tags(html_entity_decode($company_email->body)) }}"
                                                                data-email_date="{{ !empty($company_email->date) ? date('d-m-Y', strtotime($company_email->date)) : '' }}"
                                                                data-email_time="{{ $company_email->time }}"
                                                                data-email_attachment="{{ $company_email->attachment }}"
                                                                data-token="{{ Session::token() }}">{{ date('d-m-Y H:i', strtotime($company_email->date . $company_email->time)) }}</a>
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
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div><!-- table list ends here -->
                        </div><!-- all mails tab ends here -->
                       
                    </div>


                </div> <!-- col-6 ends here -->
                <div class="col-md-6 pl-2 pl-md-0">
                    @foreach ($company_emails as $index => $company_email)
                        @php
                            if ($index > 0) {
                                break;
                            }
                            if($keyword=='sent'){
                                $from = App\Models\EmployeeJob::with('employee')
                                ->where('id', '=', $company_email->to_id)
                                ->first();
                            }else{
                                $from = App\Models\EmployeeJob::with('employee')
                                ->where('id', '=', $company_email->from_id)
                                ->first();
                            }
                            
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
                                <div class="loader  text-secondary"
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
                                                    data-email_body="{{ $company_email->body }}"
                                                    data-email_attachment="{{ $company_email->attachment }}"></i>
                                                Edit</span> 
                                            <div class="p-1 text-secondary cursor-pointer"><a href=""
                                                    class=" text-secondary" id="reply" data-toggle="modal"
                                                    data-target="#reply_model"><i class="fa fa-mail-reply"></i> Reply</a>
                                            </div>
                                            <!-- <div class="p-1 text-secondary cursor-pointer"><a href=""
                                                class=" text-secondary" id="replyAll" data-toggle="modal"
                                                data-target="#reply_model"><i class="fa fa-mail-reply"></i> Reply All</a>
                                            </div> -->
                                            @if (!empty($company_email->archive) && $company_email->archive == 1)
                                                <div class="restore">
                                                    <div class="p-1 text-secondary cursor-pointer"><a
                                                            href="{{ route('restore', $company_email->id) }}"
                                                            class="text-secondary company_email_id" id="restore"><i
                                                                class="fas fa-download"></i>
                                                            Restore To Inbox</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="archive">
                                                    <div class="p-1 text-secondary cursor-pointer"><a
                                                            href="{{ route('archive', $company_email->id) }}"
                                                            class="text-secondary company_email_id"
                                                            id="company_email_id"><i class="far fa-star"></i>Archive
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="p-1 text-secondary cursor-pointer view_attachment">
                                                <a href="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}"
                                                    target="_blank" download> <i
                                                        class="fa fa-paperclip text-secondary cursor-pointer"></i></a>
                                            </div>
                                            <div class="p-1 text-secondary cursor-pointer"
                                                onclick="printDiv('single-email-wrapper')"><i class="fa fa-print"></i>
                                            </div>
                                            {{-- <span class="cursor-pointer"><i class="fa fa-mail-forward"
                                                    class="Forward"></i> Forward</span> --}}
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <h3 class="subject fs-18 mt-2">{{ $company_email->subject }}</h3>
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
                                        <div class="mt-2 fs-14"> <span class="email-name mail-detail get_email_data"
                                                data-com_email_id="{{ $company_email->id }}"
                                                data-from_id="{{ $company_email->from_id }}"
                                                data-email_to="{{ $company_email->to_id }}"
                                                data-subject="{{ $company_email->subject }}"
                                                data-email_attachment="{{ $company_email->attachment }}"
                                                data-token="{{ Session::token() }}">{{ !empty($to_mail_users) ? $to_mail_users : '' }}</span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <p class="body">
                                            {!! $company_email->body !!}
                                        </p>
                                    </div>
                                    {{-- <div class="view_attachment">
                                    <img class="img-fluid" src="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}" width="150px">

                                    </div> --}}

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
                        <form action="{{ route('reply-mail') }}" method="POST" enctype="multipart/form-data">
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
                                <select name="cc[]" id="cc" class="form-control select" data-mdb-placeholder="Example placeholder" multiple>
                                    @foreach ($to_email_ids as $employee_job)
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
                                <input class="form-control reply_subject" type="text" name="email_subject" id="edit_subject">
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
                        <form action="{{ route('reply-mail') }}" id="reply_mail" method="POST" enctype="multipart/form-data">
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
                                    id="reply_to_ids" name="to_id[]">
                                <input type="hidden"
                                    value="{{ !empty($company_email->to_id) ? $company_email->to_id : '' }}"
                                    id="reply_from_id" name="from_id">
                                <input  type="hidden"
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
                             //   dd($to_email_ids);
                            @endphp
                            <!--
                           <div class="form-group">
                                <label>To<span class="text-danger">*</span></label>
                                <select name="to_id[]" class="form-control select" id="reply_to_id" >
                                    <option value="">Select to</option>
                                    @foreach ($to_email_ids as $to_email)
                                        @php
                                            $firstname = !empty($to_email->employee->firstname) ? $to_email->employee->firstname : '';
                                            $lastname = !empty($to_email->employee->lastname) ? $to_email->employee->lastname : '';
                                            $emp_name = $firstname . '  ' . $lastname;
                                        @endphp
                                        <option value="{{ $to_email->id }}">
                                            {{ $emp_name . ' < ' . $to_email->work_email . ' > ' }}</option>
                                        @php
                                        if($company_email->from_id==$to_email->id)
                                            $from_name_email = $emp_name . ' < ' . $to_email->work_email . ' > ';
                                        @endphp
                                    @endforeach
                                </select>
                            </div> -->
                            <div class="form-group" id="reply_mail_cc">
                                <label class="form-label select-label">CC : {{ $company_email->company_cc }}</label>
                                <select name="cc[]" id="reply_to" class="form-control select"  data-mdb-placeholder="Example placeholder" multiple>
                                    @foreach ($to_email_ids as $to_email)
                                        @php
                                            $firstname = !empty($to_email->employee->firstname) ? $to_email->employee->firstname : '';
                                            $lastname = !empty($to_email->employee->lastname) ? $to_email->employee->lastname : '';
                                            $emp_name = $firstname . '  ' . $lastname;
                                        @endphp
                                        <option value="{{ $to_email->id }}">{{ $emp_name . ' < ' . $to_email->work_email . ' > ' }}</option>
                                        
                                    @endforeach
                                </select>
                            </div> 
                            <div class="form-group">
                                <label>Subject</label>
                                <input class="form-control reply_subject" type="text" name="email_subject" value="Re: {{ $company_email->subject }}" id="edit_subject">
                            </div> 
                            <div class="form-group">
                                <label>Message On: <span class="message_on">{{ date('d-M-Y h:i',strtotime($company_email->created_at)) }}</span></label>
                                <textarea class="form-control reply_body" id="edit_body" name="email_body" rows="4" cols="50" readonly>{{ str_replace(['<p>', '</p>'], '', $company_email->body); }}</textarea></div>
                            <div class="form-group">
                                <label>Reply Message<span class="text-danger">*</span></label>
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
                            console.log(data.email_data, "data");
                            $.each(data.email_data, function(index, row) {
                                var date = new Date(row.created_at);
                                dateStringWithTime = moment(date).format('DD-MM-YYYY');
                                var work_email = `<` + row.employeejob.work_email + `>`;
                                // make reply modal filled with dynamic data
                                // make selected to
                                $("#reply_to_id option").each(function() {
                                    var optionValue = $(this).val();
                                    console.log("Option Value: " + optionValue);
                                    
                                    // Perform actions based on option values
                                    if (optionValue == row.from_id) {
                                        console.log("Selected: " + optionValue);
                                        $(this).prop("selected", true);
                                    }
                                });
                                $(".subject").html(row.subject);
                                $(".reply_subject").val('Re: '+row.subject);
                                let reply_body = row.body;
                                $(".reply_body").val(reply_body.replace(/(<([^>]+)>)/ig,""));
                                $(".message_on").html(dateStringWithTime);
                                
                                $(".email_from_name").html(`<span>` + row.employeejob
                                    .employee.firstname + " " + row.employeejob.employee
                                    .lastname + `</span>` + work_email);
                                $(".work_email").html(row.employeejob.work_email);
                                $(".date").html(dateStringWithTime);
                                
                                if (row.attachment != null) {
                                    $(".view_attachment").html(
                                        `<a href='{{ asset('storage/company_email/attachment/${row.attachment}') }}'
                                          target='_blank' download> <i
                                                    class='fa fa-paperclip text-secondary cursor-pointer'></i></a>`
                                    );
                                } else {
                                    $(".view_attachment").html('');
                                }
                            });
                            // $.each(data.email_data, function(index, row) {
                            //     $(".subject").html(row.subject);
                            // });

                            // $("#msg").html(data.msg);
                        },
                    });
                });
            });

            $("#replyAll").click(function() {
                $("#reply_mail_cc").show();
            });

            $("#reply").click(function() {
                $("#reply_mail_cc").hide();
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

            $('.editbtn').on('click', function() {
                $('#email_edit').modal('show');
            })

            //Archive  funtionality
            $('#searchform').on('submit', function(e) {
                e.preventDefault();
                var search = $('#searchvalue').val();
                if(search==''){
                    alert('Enter search term');
                    return false;
                }
                
                var token = $('#token').val();
                console.log(search, "search")
                $(location).prop('href', 'user-email-inbox?keyword=search&value='+search);
            });

            //reply mail
            $('.get_email_data').on('click', function() {
                id = $(this).data('com_email_id');
                from = $(this).data('from_id');
                to_ids = $(this).data('email_to');
                reply_subject = $(this).data('subject')
                edit_cc = $(this).data('email_cc');
                body = $(this).data('email_body');
                attachment = $(this).data('email_attachment');
                console.log(body, "email_body");
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
