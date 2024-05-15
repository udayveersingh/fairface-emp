@if (!empty($employee_projects->count()) && $employee_projects->count() > 0 )
<div class="row align-items-center mb-2">
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_project"><i
                class="fa fa-plus"></i> Add Project</a>
    </div>
</div>
@else
<div class="row align-items-center mb-2">
    <div class="">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_project"><i
                class="fa fa-plus"></i> Add Project</a>
    </div>
</div>
@endif
@if (!empty($employee_projects->count()) && $employee_projects->count() > 0)
    <div class="row">
        @foreach ($employee_projects as $project)
            <div class="col-md-12 mb-4">
                <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                    <table class="table table-striped">
                        <tr>
                            <th>Project</th>
                            <td>{{ !empty($project->projects->name) ? $project->projects->name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ !empty($project->start_date) ? date('d-m-Y',strtotime($project->start_date)):'' }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ !empty($project->end_date) ? date('d-m-Y',strtotime($project->end_date)):''}}</td>
                        </tr>
                        <tr>
                            <th>status</th>
                            @php
                                $status = '';
                                if (!empty($project->projects->status) && $project->projects->status == 1) {
                                    $status = 'Active';
                                } else {
                                    $status = 'Inactive';
                                }
                            @endphp
                            <td>{{ $status }}</td>
                        </tr>
                    </table>
                    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                        <a data-id="{{ $project->id }}" data-employee_id="{{ $project->employee_id }}"
                            data-project="{{ $project->project_id }}" data-start_date="{{ $project->start_date }}"
                            data-end_date="{{ $project->end_date }}" class="btn btn-primary edit_btn"
                            data-target="edit_employee_project" href="javascript:void(0);" data-toggle="modal"><i
                                class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a data-id="{{ $project->id }}" class="btn btn-danger detail_delete"
                            data-resource_data="Employee Project" href="javascript:void(0);" data-toggle="modal"><i
                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
<!-- Add Employee Project Modal -->
<div id="add_employee_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee-project.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee Id<span class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $employee->employee_id }}" name="employee_id"
                                    id="" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project<span class="text-danger">*</span></label>
                                <select name="project" id="project" required class="form-control select">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="start_date" required id="start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="end_date" required id="end_date" type="date">
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
<!--Add Employee Project Modal-->
<!-- Edit Employee Project Modal -->
<div id="edit_employee_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('employee-project.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" id="edit_project_id" name="edit_id">
                        <input type="hidden" id="project_employee_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project<span class="text-danger">*</span></label>
                                <select name="project" id="edit_project" class="form-control select">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input class="form-control" name="start_date" required id="pro_edit_start_date"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date <span class="text-danger">*</span></label>
                                <input class="form-control" name="end_date" required id="pro_edit_end_date" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Employee Project Modal -->
