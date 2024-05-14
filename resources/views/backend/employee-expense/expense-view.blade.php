@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection
<style>
    table,
    th,
    td {
        border: 1px solid;
    }
</style>
@section('content')
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Employee Expenses Details</h1>
            </div>
        </div>
        {{-- @dd($expenses); --}}
        <div class="row">
            @php
                $firstname = !empty($expenses[0]->firstname) ? ucfirst($expenses[0]->firstname) : '';
                $lastname = !empty($expenses[0]->lastname) ? ucfirst($expenses[0]->lastname) : '';
                $fullname = $firstname . ' ' . $lastname;

            @endphp
            <div class="col-md-6 mb-2"><strong>Employee Name:-</strong>{{ $fullname }}
            </div>
            <div class="col-md-6">
                <strong>Expense ID:-</strong>{{ !empty($expenses[0]->expense_id) ? $expenses[0]->expense_id : '' }}
                <a href="{{ route('emp-expenses-print', ['expense_id' => $expense_id, 'emp_id' => $emp_id]) }}"
                    class="btn add-btn" target="_blank"><i class="fa fa-download"></i>Print PDF File</a>
                <a href="{{ route('emp-expenses') }}" class="btn add-btn mr-1">Back</a>
            </div>
        </div>
        <div class="row">
            @php
                $expense_date = str_replace('Exp-', '', !empty($expenses[0]->expense_id) ? $expenses[0]->expense_id : '');
                $year_month = !empty($expense_date) ? date('Y-M', strtotime($expense_date)) : '';
            @endphp
            <div class="col-md-6 mb-2"><strong>Year Month:-</strong>{{ $year_month }}</div>
            <div class="col-md-6 mt-2">
                {{-- <strong>Supervisor:-</strong> --}}
                {{-- <a href="" class="btn add-btn" target="_blank"><i class="fa fa-download"></i>Print PDF File</a> --}}
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-6">
                <p class="mx-0"><strong>Date
                        Starting:-</strong>{{ !empty($start_date) ? date('d-m-Y', strtotime($start_date)) : '' }}</p>
                <p class="mx-0"></p>
            </div>
            <div class="col-md-6">
                <p class="mx-0"><strong>Date
                        Ending:-</strong><span>{{ !empty($end_date) ? date('d-m-Y', strtotime($end_date)) : '' }}</span></p>
                <p class="mx-0"></p>
            </div>
        </div> --}}
        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th>Expense Type</th>
                    {{-- <th>Employee</th> --}}
                    <th>Supervisor</th>
                    <th>Project</th>
                    <th>Occurred Date</th>
                    <th>Status</th>
                    <th>Status Reason</th>
                    <th>Cost</th>
                    @if (
                        (Auth::check() && Auth::user()->role->name == app\models\Role::SUPERADMIN) ||
                            Auth::user()->role->name == app\models\Role::ADMIN)
                        <th></th>
                    @endif
                </tr>

                @php
                    $sum = 0;
                    $total_sum = 0;
                @endphp
                @foreach ($expenses as $expense)
                    {{-- @dd($expense); --}}
                    @php
                        $sum = $expense->cost;
                        $total_sum += $sum;
                    @endphp
                    <tr>
                        <td>{{ $expense->type }}</td>
                        {{-- <td>{{ ucfirst($expense->firstname) . ' ' . $expense->lastname }}</td> --}}
                        @php
                            $fullName = '';
                            $supervisor = App\Models\Employee::find($expense->supervisor_id);
                            if (!empty($supervisor)) {
                                $fullName = $supervisor->firstname . ' ' . $supervisor->lastname;
                            }

                            // dd( $fullName);

                        @endphp
                        <td>{{ ucfirst($fullName) }}</td>
                        <td>{{ $expense->name }}</td>
                        <td>{{ date('d-m-Y', strtotime($expense->expense_occurred_date)) }}</td>
                        @php
                            $status = '';
                            if (!empty($expense->timesheet_status_id)) {
                                $timesheet_status = App\Models\TimesheetStatus::find($expense->timesheet_status_id);
                                $status = ucfirst($timesheet_status->status);
                            }
                        @endphp
                        <td>{{ $status }}</td>
                        <td>{{ !empty($expense->status_reason) ? $expense->status_reason : '' }}</td>
                        <td>{{ app(App\Settings\ThemeSettings::class)->currency_symbol . ' ' . $expense->cost }}</td>
                        @if (Auth::check() && Auth::user()->role->name == app\models\Role::SUPERADMIN || Auth::user()->role->name == app\models\Role::ADMIN)
                            <td class="text-end">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if (Auth::check() && Auth::user()->role->name == app\models\Role::SUPERADMIN)
                                            <a class="dropdown-item editbtn" href="javascript:void(0)"
                                                data-id="{{ $expense->id }}" data-expense_id="{{ $expense->expense_id }}"
                                                data-expense_type_id ="{{ $expense->expense_type_id }}"
                                                data-employee_id="{{ $expense->employee_id }}"
                                                data-project_id="{{ $expense->project_id }}"
                                                data-supervisor_id="{{ $expense->supervisor_id }}"
                                                data-occurred_date="{{ $expense->expense_occurred_date }}"
                                                data-expense_cost="{{ $expense->cost }}"
                                                data-expense_description="{{ $expense->description }}"
                                                data-status_reason="{{ $expense->status_reason }}"
                                                data-timesheet_status_id="{{ $expense->timesheet_status_id }}"
                                                data-approved_date_time="{{ $expense->approved_date_time }}">
                                                <i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item deletebtn" href="javascript:void(0)"
                                                data-id="{{ $expense->id }}"><i class="fa fa-trash-o m-r-5"></i>
                                                Delete</a>
                                        @endif
                                        @if (
                                            (Auth::check() && Auth::user()->role->name == app\models\Role::SUPERADMIN) ||
                                                Auth::user()->role->name == app\models\Role::ADMIN)
                                            <a class="dropdown-item statusChecked" data-id="{{ $expense->id }}"
                                                data-status="approved" href="#" data-toggle="modal"
                                                id="statusChecked"><i class="fa fa-pencil m-r-5"></i>Change
                                                Status</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Total</th>
                    <td>{{ app(App\Settings\ThemeSettings::class)->currency_symbol . ' ' . $total_sum }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Edit Expense Modal -->
    <div id="edit_expense" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('emp-expenses') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" id="edit_id" name="id">
                            <div class="col-lg-4">
                                <input type="hidden" id="token" value="{{ Session::token() }}">
                                <div class="form-group">
                                    <label>Expenses Id</label>
                                    <select name="expenses_id" id="expense_id" class="form-control select expense_id">
                                        <option value="">~Select~</option>
                                        <option value="new">Add new expense</option>
                                        @foreach ($expense_ids as $expense)
                                            <option value="{{ $expense->expense_id }}">{{ $expense->expense_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select name="year" id="year" class="form-control select">
                                        <option value="">Select Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Months</label>
                                    <select name="month" id="year_month" class="form-control month select">
                                        <option value="">Select Month</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expense Type <span class="text-danger">*</span></label>
                                    <select name="expense_type" class="select" id="expense_type_id">
                                        <option value="">~Select~</option>
                                        @foreach (\App\Models\ExpenseType::get() as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expense Occurred date</label>
                                    <input class="form-control occurred_date" name="occurred_date" id="occurred_date"
                                        type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expense cost</label>
                                    <input class="form-control" name="expense_cost" id="expense_cost" type="number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supervisor</label>
                                    <select name="supervisor" class="select" id="supervisor_id">
                                        @foreach (getSupervisor() as $sup)
                                            @php
                                                $supervisor = App\Models\Employee::where('user_id', '=', $sup->id)->first();
                                                $firstname = !empty($supervisor->firstname) ? $supervisor->firstname : '';
                                                $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
                                                $fullname = $firstname . ' ' . $lastname;
                                            @endphp
                                            @if (!empty($supervisor))
                                                <option value="{{ !empty($supervisor->id) ? $supervisor->id : '' }}">
                                                    {{ $fullname }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (
                                (Auth::check() && Auth::user()->role->name == app\models\Role::SUPERADMIN) ||
                                    Auth::user()->role->name == app\models\Role::ADMIN)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Employee</label>
                                        <select name="employee" class="select emp_project" id="employee_id">
                                            <option value="">Select Employee</option>
                                            @foreach (getEmployee() as $emp)
                                                @php
                                                    $fullname = '';
                                                    $employee = App\Models\Employee::where('user_id', '=', $emp->id)
                                                        ->where('record_status', '=', 'active')
                                                        ->first();
                                                    if (!empty($employee)) {
                                                        $firstname = !empty($employee->firstname) ? $employee->firstname : '';
                                                        $lastname = !empty($employee->lastname) ? $employee->lastname : '';
                                                        $fullname = $firstname . ' ' . $lastname;
                                                    }
                                                @endphp
                                                @if (!empty($employee))
                                                    <option value="{{ $employee->id }}">{{ $fullname }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="employee" value="{{ $employee->id }}" id="employee_id">
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Projects</label>
                                    <select name="project" class="select emp_project_id" id="project_id">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option
                                                value="{{ !empty($project->projects->id) ? $project->projects->id : '' }}">
                                                {{ !empty($project->projects->name) ? $project->projects->name : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control description" id="description" name="description" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status Reason <span class="text-danger">*</span></label>
                                    <textarea name="status_reason" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Approved Date/Time<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control datetimepicker" name="approved_date_time" type="text">
                                </div>
                            </div>
                        </div> --}}
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update Employee Expense Model-->
    <div class="modal custom-modal fade" id="update_expense_status" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Update {{ ucfirst($title) }} data</h3>
                        <p>Are you sure want to update status?</p>
                    </div>
                    <form action="{{ route('expense-status-update') }}" method="post" id="expense_status_form">
                        @csrf
                        <input type="hidden" id="expenses_id" name="id">
                        @php
                            $count_errors = '';
                            if (count($errors) > 0) {
                                $count_errors = count($errors);
                            }
                        @endphp
                        <input type="hidden" id="error_id" value=" {{ $count_errors }}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Expense Status<span class="text-danger">*</span></label>
                                    <select name="expense_status" id="expense_status_field"
                                        class="select form-control  {{ $errors->has('expense_status') ? ' is-invalid' : '' }}">
                                        <option value="">Select Status</option>
                                        @foreach (getTimesheetStatus() as $time_status)
                                            <option value="{{ $time_status->id }}">
                                                {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="status_val_error">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status Reason</label>
                                    <textarea name="status_reason" id="status_reason" rows="4"
                                        class="form-control {{ $errors->has('status_reason') ? ' is-invalid' : '' }}"></textarea>
                                    <div class="validation_error">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary continue-btn btn-block" type="submit"
                                        id="update_expense">Update</button>
                                </div>
                                <div class="col-6">
                                    <button data-dismiss="modal"
                                        class="btn btn-primary cancel-btn btn-block">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- update Employee Expense status Model-->
    <!-- /Edit Expense Modal -->
    <x-modals.delete :route="'emp-expenses'" :title="'Expense'" />
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', (function() {
                var id = $(this).data('id');
                var edit_expense_id = $(this).data('expense_id');
                var expense_type = $(this).data('expense_type_id');
                var occurred_date = $(this).data('occurred_date');
                var expense_cost = $(this).data('expense_cost');
                var employee = $(this).data('employee_id');
                var supervisor = $(this).data('supervisor_id');
                var project = $(this).data('project_id');
                console.log(project, "project23");
                var description = $(this).data('expense_description');
                var timesheet_status = $(this).data('timesheet_status_id');
                var status_reason = $(this).data('status_reason');
                var approved_date_time = $(this).data('approved_date_time');
                $('#edit_expense').modal('show');
                $('#edit_id').val(id);
                $('#expense_id').val(edit_expense_id).trigger('change');
                $('#expense_type_id').val(expense_type).trigger('change');
                $('#occurred_date').val(occurred_date);
                $('#expense_cost').val(expense_cost);
                $('#employee_id').val(employee).trigger('change');
                $('#supervisor_id').val(supervisor).trigger('change');
                $('#project_id').val(project).trigger('change');
                $('#description').val(description);
                $('#timesheet_status_id').val(timesheet_status).trigger('change');
                $('#status_reason').val(status_reason).trigger('change');
                $('#approved_date_time').val(approved_date_time).trigger('change');
            }));

            if ($('.occurred_date').length > 0) {
                $('.occurred_date').datetimepicker({
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

            $("#update_expense").on("click", function(event) {
                event.preventDefault()

                var expense_reason = "";
                var status_field_value = $("#expense_status_field").find(":selected").text().trim();
                var expense_reason = $("#status_reason").val();
                if ((status_field_value == "Approved")) {
                    $("#expense_status_form").submit();
                } else if ((status_field_value == "Select Status")) {
                    $(".status_val_error").html("");
                    $(".status_val_error").html(`<span class="text-danger">this field is required</span>`);
                } else if (expense_reason && status_field_value == "Rejected") {
                    $("#expense_status_form").submit();
                } else if (status_field_value == "Rejected") {
                    $(".status_val_error").html("");
                    $(".validation_error").html("");
                    $(".validation_error").html(`<span class="text-danger">this field is required</span>`);
                }
            });

            var currentYear = new Date().getFullYear();
            console.log(currentYear, "currentYear");

            for (var i = currentYear; i <= currentYear + 12; i++) {
                $("#year").append('<option value="' + i.toString() + '">' + i.toString() + '</option>');
            }

            $("#year").change(function() {
                // var currentSelectedYearValue = $(this).val();
                //As Index of Javascript Month is from 0 to 11 therefore totalMonths are 11 NOT 12
                var totalMonths = 11;
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                    "Nov", "Dec"
                ];
                //Appending Current Valid Months
                $("#year_month").html('<option value="">Select Month</option>');
                for (var month = 0; month <= totalMonths; month++) {
                    $("#year_month").append('<option value="' + (month + 1) + '">' + monthNames[month] +
                        '</option>');
                }
            });

            $("#expense_id").change(function() {
                var expense_id = $(".expense_id").val();
                var employee_id = $("#employee_id").val();
                var token = $("#token").val();
                $.ajax({
                    type: 'POST',
                    url: '/get-expense-data',
                    data: {
                        _token: token,
                        expense_id: expense_id,
                        employee_id: employee_id,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data.month);
                        $('#year').val(data.year).trigger('change');
                        $('#year_month').val(data.month).trigger('change');
                        // console.log(data.year);
                        // $.each(data.email_data, function(index, row) {
                        //     // console.log( row.employeejob.work_email)
                        //     var date = new Date(row.created_at);
                        //     dateStringWithTime = moment(date).format('DD-MM-YYYY');
                        // });
                    },
                });
            });

            $(".emp_project ").change(function() {
                // var employeeId = $('#employee_id').find('option:selected').text();
                var selectedEmployee = $(this).val();
                var token = $("#token").val();
                $.ajax({
                    type: 'POST',
                    url: '/get-employee-projects',
                    data: {
                        _token: token,
                        employeeId: selectedEmployee,
                    },
                    dataType: 'JSON',
                    success: function(dataResult) {
                        // console.log(dataResult);
                        // console.log(myArray);
                        $(".emp_project_id").html("<option value=''>select projects</option>");
                        $.each(dataResult.data, function(index, row) {
                            console.log(row.projects, 'row');
                            $(".emp_project_id").append(
                                `<option value="${row.project_id}">${row.projects.name}</option>`
                            );
                        });
                    },
                });
            });

            $('.statusChecked').on('click', function() {
                $('#update_expense_status').modal('show');
                var id = $(this).data('id');
                var status = $(this).data('status');
                var timesheet = $('#expenses_id').val(id);
            });
        });
    </script>
@endsection
