@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Logs</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a
                        @if (
                            (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
                                Auth::user()->role->name == App\Models\Role::ADMIN) href="{{ route('dashboard') }}" @else href="{{ route('employee-dashboard') }}" @endif>Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Logs</li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped custom-table mb-0 datatable" id="logtable">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee Location</th>
                        <th>IP Address</th>
                        <th>Login Date</th>
                        <th>Logout Time</th>
                        <th>Logged Time</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td> <div class="online-dot-icon">
                                {{ $log->username }}@if (!empty($log->status == '1'))
                                <div class="noti-dot text-success"></div>
                               
                                @else
                                <div class="noti-dot text-danger"></div>
                            </div>
                                @endif
                            </td>
                            <td>
                                <?php
                                try {
                                    $location = \Location::get($log->location_ip); // or specific IP
                                    echo $location->cityName . ',' . $location->countryCode . ' (' . $location->zipCode . ')';
                                } catch (\Exception $e) {
                                }
                                ?>
                            </td>
                            <td>{{ $log->location_ip }}</td>
                            <td>{{ date('d-m-Y  H:i', strtotime($log->date_time)) }}</td>
                            <td>{{ !empty($log->out_time) ? date('d-m-Y  H:i', strtotime($log->out_time)) : '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->date_time)->diffForHumans() }}</td>
                            <td>
                                <a class="btn-sm btn-primary edit_log_btn" data-id="{{$log->id}}" data-user_id="{{$log->user_id}}" data-date_time="{{$log->date_time}}" data-time_out="{{$log->out_time}}" data-location_ip="{{$log->location_ip}}" data-location_name="{{$log->location_name}}"  href="#"><i class="fa fa-pencil m-r-5"
                                        aria-hidden="true"></i>Edit</a> <button type="button"
                                    class="btn btn-sm btn-primary Pingbtn" data-id="{{ $log->user_id }}"><i class="fa fa-comments m-r-5"></i> PING</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                                @foreach (getUsers() as  $user)
                                <option value="{{$user->id}}">{{$user->username}}</option>
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
            $('#user_id').val(id);
        });

        $('.table').on('click', '.edit_log_btn', function() {
            $('#edit_logs').modal('show');
            var id = $(this).data('id');
            var user_id = $(this).data('user_id');
            var date_time = $(this).data('date_time');
            var time_out= $(this).data('time_out');
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
