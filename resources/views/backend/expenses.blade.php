@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Expenses</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Expenses</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense"><i class="fa fa-plus"></i>
                Add Modal</a>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>Expense Type</th>
                            <th>Employee</th>
                            <th>Supervisor</th>
                            <th>Project</th>
                            <th>Project phase</th>
                            <th>Status</th>
                            <th>status reason</th>
                            <th>Approved Date Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            @php
                                $firstName = !empty($expense->employee->firstname) ? $expense->employee->firstname : '';
                                $lastName = !empty($expense->employee->lastname) ? $expense->employee->lastname : '';
                                $emp_full_name = $firstName . ' ' . $lastName;

                                $supervisor_id = $expense->supervisor_id;
                                $get_suepervisor = app\models\Employee::find($expense->supervisor_id);
                                $sup_firstname = !empty($get_suepervisor->firstname) ? $get_suepervisor->firstname : '';
                                $sup_lastname = !empty($get_suepervisor->lastname) ? $get_suepervisor->lastname : '';
                                $sup_fullname = $sup_firstname . ' ' . $sup_lastname;
                            @endphp
                            <tr>
                                <td>{{ !empty($expense->expensetype->type) ? $expense->expensetype->type : '' }}</td>
                                <td>{{ ucfirst($emp_full_name) }}</td>
                                <td>{{ ucfirst($sup_fullname) }}</td>
                                <td>{{ !empty($expense->project->name) ? $expense->project->name : '' }}</td>
                                <td>{{ !empty($expense->projectphase->name) ? $expense->projectphase->name : '' }}</td>
                                <td>{{ !empty($expense->time_sheet_status->status) ? ucfirst($expense->time_sheet_status->status) : '' }}
                                </td>
                                <td>{{ $expense->status_reason }}</td>
                                <td>{{ $expense->approved_date_time }}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item editbtn" href="javascript:void(0)"
                                                data-id="{{ $expense->id }}"
                                                data-expense_type_id ="{{$expense->expense_type_id}}"
                                                data-employee_id="{{ $expense->employee_id }}"
                                                data-supervisor_id="{{ $expense->supervisor_id }}"
                                                data-project_id="{{ $expense->project_id }}"
                                                data-project_phase_id="{{ $expense->project_phase_id }}"
                                                data-timesheet_status_id="{{ $expense->timesheet_status_id }}"
                                                data-status_reason="{{ $expense->status_reason }}"
                                                data-approved_date_time="{{ $expense->approved_date_time }}">
                                                <i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item deletebtn" href="javascript:void(0)"
                                                data-id="{{ $expense->id }}"><i class="fa fa-trash-o m-r-5"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div id="add_expense" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('expenses') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expense Type <span class="text-danger">*</span></label>
                                    <select name="expense_type" class="select">
                                        @foreach (\App\Models\ExpenseType::get() as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select name="employee" class="select">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->firstname }}
                                                {{ $employee->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supervisor</label>
                                    <select name="supervisor" class="select">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projects</label>
                                    <select name="project" class="select">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Phase</label>
                                    <select name="project_phase_id" class="select form-control">
                                        <option value="">Select Project Phase</option>
                                        @foreach ($project_phases as $project_phase)
                                            <option value="{{ $project_phase->id }}">
                                                {{ str_replace('_', ' ', ucfirst($project_phase->name)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="timesheet_status" class="select form-control">
                                        <option value="">Select TimeSheet Status</option>
                                        @foreach ($timesheet_statuses as $time_status)
                                            <option value="{{ $time_status->id }}">
                                                {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Expense Modal -->

    <!-- Edit Expense Modal -->
    <div id="edit_expense" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Expense</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('expenses') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expense Type <span class="text-danger">*</span></label>
                                    <select name="expense_type" class="select" id="expense_type_id">
                                        @foreach ($expensive_type as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select name="employee" class="select" id="employee_id">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->firstname }}
                                                {{ $employee->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supervisor</label>
                                    <select name="supervisor" class="select form-control" id="supervisor_id">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Projects</label>
                                    <select name="project" id="project_id" class="select form-control">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Phase</label>
                                    <select name="project_phase_id" id="project_phase_id" class="select form-control">
                                        <option value="">Select Project</option>
                                        @foreach ($project_phases as $project_phase)
                                            <option value="{{ $project_phase->id }}">
                                                {{ str_replace('_', ' ', ucfirst($project_phase->name)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="timesheet_status" class="select form-control" id="timesheet_status_id">
                                        <option value="">Select Status</option>
                                        @foreach ($timesheet_statuses as $time_status)
                                            <option value="{{ $time_status->id }}">
                                                {{ str_replace('_', ' ', ucfirst($time_status->status)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status Reason <span class="text-danger">*</span></label>
                                    <textarea name="status_reason" rows="4" class="form-control" id="status_reason"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Approved Date/Time<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control datetimepicker" name="approved_date_time" id="approved_date_time" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Expense Modal -->

    <x-modals.delete :route="'expenses'" :title="'Expense'" />
@endsection


@section('scripts')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', (function() {
                var id = $(this).data('id');
                var expense_type = $(this).data('expense_type_id');
                var employee = $(this).data('employee_id');
                var supervisor = $(this).data('supervisor_id');
                var project = $(this).data('project_id');
                var project_phase = $(this).data('project_phase_id');
                var timesheet_status = $(this).data('timesheet_status_id');
                var status_reason = $(this).data('status_reason');
                var approved_date_time = $(this).data('approved_date_time');

                $('#edit_expense').modal('show');
                $('#edit_id').val(id);
                $('#expense_type_id').val(expense_type).trigger('change');
                $('#employee_id').val(employee).trigger('change');
                $('#supervisor_id').val(supervisor).trigger('change');
                $('#project_id').val(project).trigger('change');
                $('#project_phase_id').val(project_phase).trigger('change');
                $('#timesheet_status_id').val(timesheet_status).trigger('change');
                $('#status_reason').val(status_reason).trigger('change');
                $('#approved_date_time').val(approved_date_time).trigger('change');
            }));
        });
    </script>
@endsection
