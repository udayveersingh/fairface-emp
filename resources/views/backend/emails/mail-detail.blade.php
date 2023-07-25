@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            {{-- <h3 class="page-title">Email</h3> --}}
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Email</li>
            </ul>
        </div>
        {{-- <div class="col-auto float-right ml-auto">
            <a href="{{ route('compose-email') }}" class="btn add-btn"><i class="fa fa-plus"></i> Compose Email</a>
        </div> --}}
    </div>
@endsection

@section('content')
    @if (count($company_emails) > 0)
        @foreach ($company_emails as $company_email)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h3>{{ $company_email->subject }}</h4>
                    </div>
                    @php
                        $from_email = !empty($company_email->employeejob->work_email) ? $company_email->employeejob->work_email : '';
                        $firstname = !empty($company_email->employeejob->employee->firstname) ? $company_email->employeejob->employee->firstname : '';
                        $lastname = !empty($company_email->employeejob->employee->lastname) ? $company_email->employeejob->employee->lastname : '';
                        $emp_name = $firstname . '  ' . $lastname;
                    @endphp
                    <ul class="personal-info">
                        <li>
                            <h4 class="user-name m-t-0 mb-0">
                                </h3><span class="text">{{ ucfirst($emp_name) . ' < ' . $from_email . ' > ' }}</span>
                        </li>
                        <li>
                            {{ !empty($company_email->body) ? $company_email->body : '' }}
                        </li>
                    </ul>
                    {{-- <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <select name="from_id" id="from_id" class="form-control">
                        <option value="{{ !empty($company_email->employeejob->id) ? $company_email->employeejob->id:''}}">
                            {{ucfirst($emp_name) . ' < ' . $from_email . ' > ' }}
                        </option>
                    </select>
                </div>
            </form> --}}
                </div>
            </div>
        @endforeach
        <div class="col-auto float-right ml-auto">
            <a href="" class="btn add-btn"><i class="fa fa-plus"></i> Reply</a>
        </div>
    @endif
@endsection
