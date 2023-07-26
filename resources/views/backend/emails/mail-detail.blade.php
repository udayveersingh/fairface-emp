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
            @php    
                $from_email = !empty($company_email->employeejob->work_email) ? $company_email->employeejob->work_email : '';
                $firstname = !empty($company_email->employeejob->employee->firstname) ? $company_email->employeejob->employee->firstname : '';
                $lastname = !empty($company_email->employeejob->employee->lastname) ? $company_email->employeejob->employee->lastname : '';
                $from_emp_name = $firstname . ' ' . $lastname;
                $user_first_name = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname:'';
                $user_last_name = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname:'';
                $emp_name = $user_first_name." ".$user_last_name;
            @endphp
            <!-- open reply model -->
            <div id="reply_mail" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('reply-mail') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <h5 class="user-name m-t-0 mb-0">
                                        <span
                                            class="text">From{{ ucfirst($from_emp_name) . ' < ' . $from_email . ' > ' }}</span>
                                    </h5> --}}
                                    {{-- <input type="hidden" name="to_id" value="{{ $company_email->to_id }}"> --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>From</label>
                                            <select name="from_id" id="from_id" class="form-control">
                                                <option value="{{$employee_job->id}}">
                                                    {{ucfirst($emp_name) . ' < ' . $employee_job->work_email . ' > ' }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label select-label">To</label>
                                            <select name="to_id" class="form-control select"
                                                data-mdb-placeholder="Example placeholder">
                                                @foreach (getEmployeeJob() as $employee_job)
                                                    @php
                                                        $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                                        $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                                        $emp_name = $firstname . '  ' . $lastname;
                                                    @endphp
                                                    <option value="{{ $employee_job->id }}"
                                                        {{ !empty($company_email->to_id) && $company_email->to_id == $employee_job->id ? 'selected' : '' }}>
                                                        {{ $emp_name . ' < ' . $employee_job->work_email . ' > ' }}
                                                    </option>
                                                @endforeach
                                                {{-- <option value="{{ $company_email->employeejob->id }}">
                                                {{  ucfirst($emp_name) . ' < ' . $from_email . ' > ' }}
                                            </option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            {{-- <label>Body<span class="text-danger">*</span></label> --}}
                                            <textarea class="form-control" id="" name="email_body" rows="4" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Open reply model -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h3>{{ $company_email->subject }}</h4>
                    </div>
                    <ul class="personal-info">
                        <li>
                            <h5 class="user-name m-t-0 mb-0">
                                <span class="text">{{ ucfirst($from_emp_name) . ' < ' . $from_email . ' > ' }}</span>
                            </h5>
                        </li>
                        <li>
                            {{ !empty($company_email->body) ? $company_email->body : '' }}
                        </li>
                        @if (!empty($company_email->attachment))
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-download" viewBox="0 0 16 16">
                                    <path
                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path
                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                </svg>
                                <a href="{{ asset('storage/company_email/attachment/' . $company_email->attachment) }}"
                                    target="_blank" download>Download</a>
                            </li>
                        @endif
                        <div class="col-auto float-right ml-auto">
                       {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$company_email->created_at)->format('H:i:A');}}
                        </div>
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
            <a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#reply_mail"> Reply</a>
        </div>
    @endif
@endsection

{{-- @section('scripts')
    <script>
        $(document).ready(function() {
            $('.editbtn').on('click', function() {
                $('#edit_employee').modal('show');
                var id = $(this).data('id');
            });
        });
    </script>
@endsection --}}
