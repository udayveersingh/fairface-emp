@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .no-border td{ border:none;}
        .table-box a{ color:#333;}
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
    <h5 class="mt-0"><b>Hi Bro, How are you?</b></h5>

    <hr>

    <div class="media mb-4">
        <a href="#" class="float-left mr-2">
            <img alt="" src="assets/images/users/avatar-2.jpg" class="media-object avatar-sm rounded-circle">
        </a>
        <div class="media-body">
            <span class="media-meta float-right">07:23 AM</span>
            <h5 class="text-primary font-16 m-0">Jonathan Smith</h5>
            <small class="text-muted">From: jonathan@domain.com</small>
        </div>
    </div>
    <!-- media -->

    <p><b>Hi Bro...</b></p>
    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
    <p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
    <p>Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>

</div>

</div>
            </div>
        </div>
    </div>
<!---->

<div class="table-box bg-white row">
    <div class="table-detail col-md-3">
        <div class="p-4">
            <a href="email-compose.html" class="text-white btn btn-danger btn-rounded btn-primary width-lg waves-effect waves-light">Compose</a>

            <div class="list-group mail-list mt-3">
                <a href="#" class="list-group-item border-0 text-success"><i class="fas fa-download font-13 mr-2"></i>Inbox <b>(8)</b></a>
                <a href="#" class="list-group-item border-0"><i class="far fa-star font-13 mr-2"></i>Starred</a>
                <a href="#" class="list-group-item border-0"><i class="far fa-file-alt font-13 mr-2"></i>Draft <b>(20)</b></a>
                <a href="#" class="list-group-item border-0"><i class="far fa-paper-plane font-13 mr-2"></i>Sent Mail</a>
                <a href="#" class="list-group-item border-0"><i class="far fa-trash-alt font-13 mr-2"></i>Trash <b>(354)</b></a>
            </div>

            <h5 class="mt-4 text-uppercase hidden-xxs">Labels</h5>

            <div class="list-group border-0 mail-list hidden-xxs">
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-info mr-2"></span>Web App</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-warning mr-2"></span>Project 1</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-purple mr-2"></span>Project 2</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-pink mr-2"></span>Friends</a>
                <a href="#" class="list-group-item border-0"><span class="fa fa-circle text-success mr-2"></span>Family</a>
            </div>


        </div>
    </div>

    <div class="table-detail mail-right col-md-9">
        <div class="row">
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
        </div>
        <!-- End row -->

        <div class="table-responsive mt-3">
            <table class="table table-hover mails m-0 no-border" style="border:none;">
                <tbody>
                    <tr class="unread">
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-warning"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            07:23 AM
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox2" type="checkbox">
                                <label for="checkbox2"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-pink"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            07:23 AM
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox3" type="checkbox">
                                <label for="checkbox3"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-success"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            03:00 AM
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox4" type="checkbox">
                                <label for="checkbox4"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-purple"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            01:23 AM
                        </td>
                    </tr>

                    <tr class="unread">
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox5" type="checkbox">
                                <label for="checkbox5"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-info"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            11 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox6" type="checkbox">
                                <label for="checkbox6"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            11 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox7" type="checkbox">
                                <label for="checkbox7"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            11 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox8" type="checkbox">
                                <label for="checkbox8"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            10 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox9" type="checkbox">
                                <label for="checkbox9"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-info"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            10 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox10" type="checkbox">
                                <label for="checkbox10"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-warning"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            10 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox11" type="checkbox">
                                <label for="checkbox11"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            9 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox12" type="checkbox">
                                <label for="checkbox12"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-purple"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            9 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox13" type="checkbox">
                                <label for="checkbox13"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-pink"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                        </td>
                        <td class="text-right mail-time">
                            9 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox14" type="checkbox">
                                <label for="checkbox14"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-info"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            9 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox15" type="checkbox">
                                <label for="checkbox15"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">

                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox16" type="checkbox">
                                <label for="checkbox16"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox17" type="checkbox">
                                <label for="checkbox17"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-white"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox18" type="checkbox">
                                <label for="checkbox18"></label>
                            </div>

                            <i class="fa fa-star text-warning mr-4"></i>

                            <i class="fa fa-circle mr-1 text-info"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Manager</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Dolor sit amet, consectetuer adipiscing</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox19" type="checkbox">
                                <label for="checkbox19"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-pink"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">Google Inc</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                    <tr>
                        <td class="mail-select"><div class="d-flex">
                            <div class="checkbox checkbox-primary mr-4">
                                <input id="checkbox20" type="checkbox">
                                <label for="checkbox20"></label>
                            </div>

                            <i class="fa fa-star mr-4 text-muted"></i>

                            <i class="fa fa-circle mr-1 text-success"></i>
</div></td>

                        <td>
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-name">John Deo</a>
                        </td>

                        <td class="d-none d-lg-inline-block">
                            <a  data-toggle="modal" data-target="#email_read" href="email-read.html" class="email-msg">Hi Bro, How are you?</a>
                        </td>
                        <td style="width: 20px;" class=" d-none d-lg-display-inline">
                            <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right mail-time">
                            7 Oct
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-7 mt-3">
                Showing 1 - 20 of 289
            </div>
            <div class="col-5 mt-3">
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-secondary waves-effect" fdprocessedid="1gxuds"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-secondary waves-effect" fdprocessedid="6i5q7q"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- New layout ends-->



    <div class="row">
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
                                    $from = App\Models\EmployeeJob::with('employee')->where('id', '=', $company_email->from_id)->first();
                                    $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname:'';
                                    $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname:'';
                                    $fullname = $from_first_name." ".$from_last_name;
                                    $to = App\Models\EmployeeJob::with('employee')->where('id', '=', $company_email->to_id)->first();
                                    $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname:'';
                                    $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname:'';
                                    $to_fullname = $to_first_name." ".$to_last_name;
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
                                    <td>{{"<".$fullname.">"}}<a href="{{route('mail-detail',['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id])}}">{{$from->work_email }}</a></td>
                                    <td>{{"<". $to_last_name.">".$to->work_email}}</td>
                                    <td>{{ $cc }}</td>
                                    <td>{{ !empty($company_email->date) ? date('d-m-Y',strtotime($company_email->date)):''}}</td>
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
    </div>
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
