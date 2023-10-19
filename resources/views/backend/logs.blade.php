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
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee Location</th>
                        <th>IP Address</th>
                        <th>Login Date</th>
                        <th>Logout Time</th>
                        <th>Logged Time</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    {{-- @dd( $log); --}}
                        <tr>
                            <td>{{ $log->name }}@if(!empty($log->status == "1")) <button type="button" class="btn btn-success btn-sm">Online</button> @else <button type="button" class="btn btn-danger btn-sm">Offline</button> @endif</td>
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
                            <td>{{ date('d-m-Y  H:i:sa', strtotime($log->date_time)) }}</td>
                            <td>{{ !empty($log->out_time) ? date('d-m-Y  H:i:sa', strtotime($log->out_time)):''}}</td>
                            <td>{{ \Carbon\Carbon::parse($log->date_time)->diffForHumans() }}</td>
                            <td>
                                <a class="btn-sm btn-primary Pingbtn" data-id="{{$log->user_id}}"><i class="fa fa-comments m-r-5"></i> PING</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
@endsection
@section('scripts')
    <script>
        $('.table').on('click', '.Pingbtn', function() {
            $('#ping_model').modal('show');
            var id = $(this).data('id');
            $('#user_id').val(id);
        });
    </script>
@endsection
