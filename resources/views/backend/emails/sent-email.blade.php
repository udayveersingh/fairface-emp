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
        <div class="col-auto float-right ml-auto">
            <a href="{{route('compose-email')}}" class="btn add-btn"><i
                    class="fa fa-plus"></i> Compose Email</a>
        </div>
    </div>
@endsection

@section('content')
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
                                $from = App\Models\EmployeeJob::where('id', '=', $company_email->from_id)->value('work_email');
                                $to = App\Models\EmployeeJob::where('id', '=', $company_email->to_id)->value('work_email');
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
                                <td>{{ $from }}</td>
                                <td>{{ $to }}</td>
                                <td>{{ $cc }}</td>
                                <td>{{ $company_email->date }}</td>
                                <td>{{ $company_email->subject }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            {{-- <a data-id="{{ $company_email->id }}"
                                                data-email_from="{{ $company_email->from_id }}"
                                                data-email_to="{{ $company_email->to_id }}"
                                                data-email_cc="{{ $company_email->company_cc }}"
                                                data-email_date="{{ $company_email->date }}"
                                                data-email_time="{{ $company_email->time }}"
                                                data-email_subject="{{ $company_email->subject }}"
                                                data-email_body="{{ $company_email->body }}"
                                                data-email_attachment="{{ $company_email->attachment }}"
                                                class="dropdown-item editbtn" href="javascript:void(0);"
                                                data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a> --}}
                                            <a data-id="{{ $company_email->id }}" class="dropdown-item deletebtn"
                                                href="javascript:void(0);" data-target="#deletebtn"
                                                data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <x-modals.delete :route="'company-email.destroy'" :title="'Company Email'" />
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection