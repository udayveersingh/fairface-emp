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
                        @if((Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN) ||
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
                        <th>User Name</th>
                        <th>IP Address</th>
                        <th>Logged Time</th>
                        {{-- <th class="text-right">Action</th> --}}
                    </tr>
                </thead>
                <tbody> 
                    @foreach ($logs as $log)
                    <tr>
                        <td>{{$log->name}}</td>
                        <td>{{$log->location_ip}}</td>
                        <td>{{\Carbon\Carbon::parse($log->date_time)->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
