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
                    {{-- <form action="{{ route('company-email') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label>From<span class="text-danger">*</span></label>
                            <select name="from_id" id="from_id" class="form-control">
                                <option value="">Select from</option>
                                @foreach ($employee_jobs as $employee_job)
                                    @php
                                        $from_email = App\Models\EmployeeJOb::with('employee')->where('employee_id','=',$employee->id)->first(); 
                                        $firstname = !empty($employee_job->employee->firstname) ? $employee_job->employee->firstname : '';
                                        $lastname = !empty($employee_job->employee->lastname) ? $employee_job->employee->lastname : '';
                                        $emp_name = $firstname . '  ' . $lastname;
                                    @endphp
                                    <option value="{{ $employee_job->id }}">
                                        {{ 'From' . ' ' . $emp_name . ' < ' . $from_email->work_email . ' > ' }}
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
                    </form> --}}
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
