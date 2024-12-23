@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@section('content')
<?php
$tabs = [
    'History_last_three' => 'History',
];
?>
@if (session('danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> {{ session('danger') }}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="basic_info-tab" data-toggle="tab" href="#basic_info" role="tab"
            aria-controls="basic_info" aria-selected="true">Today</a>
    </li>
    @foreach ($tabs as $index => $tab)
    <li class="nav-item">
        <a class="nav-link" id="{{ $index }}-tab" data-toggle="tab" href="#{{ $index }}"
            role="tab" aria-controls="{{ $index }}" aria-selected="true">{{ $tab }}</a>
    </li>
    @endforeach
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="basic_info" role="tabpanel" aria-labelledby="basic_info-tab">
        <div class="row">
            <div class="col-md-12">
                <h2>Today</h2>
                <table class="table table-striped custom-table mb-0 datatable" id="logtable">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee Location</th>
                            <th>IP Address</th>
                            <th>Login Time</th>
                            <th>Logout Time</th>
                            @if (
                            (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
                            Auth::user()->role->name == App\Models\Role::ADMIN)
                            <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($today_logs as $log)
                        @php
                        $login_date = '';
                        $current_date = date('Y-m-d');
                        $login_date = date('Y-m-d', strtotime($log->date_time));
                        @endphp
                        <tr>
                            <td>
                                <div class="online-dot-icon">
                                    {{ $log->username }}@if (!empty($log->status == '1') && !empty($login_date) && $login_date == $current_date)
                                    <div class="noti-dot text-success"></div>
                                    @else
                                    <div class="noti-dot text-danger"></div>
                                </div>
                                @endif
                            </td>
                            <td>
                                <?php
                                // try {
                                //     $response = file_get_contents('http://ip-api.com/json/49.43.98.25');
                                //     $data = json_decode($response, true);
                                //     if ($data && $data['status'] === 'success') {
                                //         echo $data['city'] . ', ' . $data['country'] . ' (' . $data['zip'] . ')';
                                //     } else {
                                //         echo 'Location not found.';
                                //     }
                                // } catch (\Exception $e) {
                                //     echo 'Error: ' . $e->getMessage();
                                // }
                                ?>
                                {{ $log->location_name }}
                            </td>
                            <td>{{ $log->location_ip }}</td>
                            <td>{{ date('d-m-Y  H:i', strtotime($log->date_time)) }}</td>
                            <td>{{ !empty($log->out_time) ? date('d-m-Y  H:i', strtotime($log->out_time)) : '' }}</td>
                            <td>
                                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                                <a class="btn-sm btn-primary edit_log_btn" data-id="{{ $log->id }}"
                                    data-user_id="{{ $log->user_id }}" data-date_time="{{ $log->date_time }}"
                                    data-time_out="{{ $log->out_time }}" data-location_ip="{{ $log->location_ip }}"
                                    data-location_name="{{ $log->location_name }}" href="#"><i
                                        class="fa fa-pencil m-r-5" aria-hidden="true"></i>Edit</a>
                                @endif
                                @if ((Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
                                Auth::user()->role->name == App\Models\Role::ADMIN)
                                @if (!empty($log->status == '1') && !empty($login_date) && $login_date == $current_date)
                                <button type="button" class="btn btn-sm btn-success Pingbtn"
                                    data-id="{{ $log->user_id }}" data-email="{{ $log->email }}"><i
                                        class="fa fa-comments m-r-5"></i> PING</button>
                                <a href="{{route('chat-view',$log->user_id)}}" class="btn btn-sm btn-success" target="_blank"><i
                                        class="fa fa-comments m-r-5"></i>Chat</a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach ($tabs as $index => $tab)
    <div class="tab-pane fade" id="{{ $index }}" role="tabpanel" aria-labelledby="{{ $index }}-tab">
        <h2>History</h2>
        <table class="table table-striped custom-table mb-0 datatable" id="logtable">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee Location</th>
                    <th>IP Address</th>
                    <th>Login Time</th>
                    <th>Logout Time</th>
                    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                @php
                $login_date = '';
                $current_date = date('Y-m-d');
                $login_date = date('Y-m-d', strtotime($log->date_time));
                @endphp
                <tr>
                    <td>
                        {{ $log->username }}
                    </td>
                    <td>
                        <?php
                        // try {
                        //     $location = \Location::get($log->location_ip); // or specific IP
                        //     echo $location->cityName . ',' . $location->countryCode . ' (' . $location->zipCode . ')';
                        // } catch (\Exception $e) {
                        // }
                        ?>
                         {{ $log->location_name }}
                    </td>
                    <td>{{ $log->location_ip }}</td>
                    <td>{{ date('d-m-Y  H:i', strtotime($log->date_time)) }}</td>
                    <td>{{ !empty($log->out_time) ? date('d-m-Y  H:i', strtotime($log->out_time)) : '' }}</td>
                    @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                    <td>
                        <a class="btn-sm btn-primary edit_log_btn" data-id="{{ $log->id }}"
                            data-user_id="{{ $log->user_id }}" data-date_time="{{ $log->date_time }}"
                            data-time_out="{{ $log->out_time }}"
                            data-location_ip="{{ $log->location_ip }}"
                            data-location_name="{{ $log->location_name }}" href="#"><i
                                class="fa fa-pencil m-r-5" aria-hidden="true"></i>Edit</a>
                        {{-- @if (!empty($log->status == '1') && !empty($login_date) && $login_date == $current_date)
                                            <button type="button" class="btn btn-sm btn-success Pingbtn"
                                                data-id="{{ $log->user_id }}" data-email="{{ $log->email }}"><i
                            class="fa fa-comments m-r-5"></i> PING</button>
                        @endif --}}
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</div>
{{-- @section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Employee Activity</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a
                        @if ((Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) || Auth::user()->role->name == App\Models\Role::ADMIN) href="{{ route('dashboard') }}" @else href="{{ route('employee-dashboard') }}" @endif>Dashboard</a>
</li>
<li class="breadcrumb-item active">Employee Activity</li>
</ul>
</div>
</div>
@endsection --}}

<!--ping Model message -->
<div id="ping_model" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title">Message</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('send-message') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="form-group">
                        <label>From<span class="text-danger"></span></label>
                        <input name="from" class="form-control" value="{{ Auth::user()->email }}" type="text"
                            id="from" readonly>
                    </div>
                    <div class="form-group">
                        <label>To<span class="text-danger"></span></label>
                        <input name="to" class="form-control" value="" id="to_user" type="text"
                            readonly>
                        <input type="hidden" name="to_email_id" value="" id="to_email_id">
                    </div>
                    <div class="form-group">
                        <label>Date/Time<span class="text-danger"></span></label>
                        <input name="date_time" class="form-control" value="{{ date('d-m-Y H:i') }}" id="date_time"
                            type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label>Subject<span class="text-danger"></span></label>
                        <input name="subject" class="form-control" value="Urgent message" id="subject"
                            type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label>Message<span class="text-danger"></span></label>
                        <textarea class="form-control" id="" name="email_message" rows="4" cols="50"></textarea>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn mb-2">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- ping model message --- >

                                                        <--logs Edit Model -->
<div id="edit_logs" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('logs') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="logs_edit_id">
                    <div class="form-group">
                        <label>User Name<span class="text-danger">*</span></label>
                        <select name="name" class="select" id="edit_user_id">
                            @foreach (getUsers() as $user)
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Login Date Time <span class="text-danger">*</span></label>
                        <input name="date_time" class="form-control" type="datetime" id="edit_date_time">
                    </div>
                    <div class="form-group">
                        <label>Logout Date Time <span class="text-danger"></span></label>
                        <input name="out_time" class="form-control" type="text" id="edit_out_time">
                    </div>
                    <div class="form-group">
                        <label>Employee Location</label>
                        <textarea name="employee_location" rows="4" class="form-control" id="edit_employee_location"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Employee IP Address</label>
                        <textarea name="ip_address" rows="4" class="form-control" id="edit_ip_address"></textarea>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- logs edit Model -->
@endsection
@section('scripts')
<script>
    $('.table').on('click', '.Pingbtn', function() {
        $('#ping_model').modal('show');
        var id = $(this).data('id');
        var to_user_email = $(this).data('email');
        $('#user_id').val(id);
        $('#to_user').val(to_user_email);
    });

    $('.table').on('click', '.edit_log_btn', function() {
        $('#edit_logs').modal('show');
        var id = $(this).data('id');
        var user_id = $(this).data('user_id');
        var date_time = $(this).data('date_time');
        var time_out = $(this).data('time_out');
        var location_ip = $(this).data('location_ip');
        var location_address = $(this).data('location_name');
        $('#logs_edit_id').val(id);
        $('#edit_user_id').val(user_id).trigger('change');
        $('#edit_date_time').val(date_time);
        $('#edit_out_time').val(time_out);
        $('#edit_ip_address').val(location_ip);
        $('#edit_employee_location').val(location_address);
    });

    if ($('.dateTime').length > 0) {
        $('.dateTime').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: new Date(),
            icons: {
                up: "fa fa-angle-up",
                down: "fa fa-angle-down",
                next: 'fa fa-angle-right',
                previous: 'fa fa-angle-left'
            }
        });
    }
</script>
@endsection