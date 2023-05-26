<div class="row align-items-center mb-2">
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_project"><i class="fa fa-plus"></i> Add Employee Project</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>Project</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>status</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($employee_projects->count()))
                @foreach ($employee_projects as $project)
                <tr>
                    <td>{{$project->id}}</td>
                    <td>{{!empty($project->projects->name) ? $project->projects->name:''}}</td>
                    <td>{{$project->start_date}}</td>
                    <td>{{$project->end_date}}</td>
                    @php
                    $status = "";
                    if(!empty($project->projects->status) && $project->projects->status == 1)
                    {
                    $status = "Active";
                    }else{
                    $status = "Inactive";
                    }
                    @endphp
                    <td>{{$status}}</td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$project->id}}" data-employee_id="{{$project->employee_id}}" data-project="{{$project->project_id}}" data-start_date="{{$project->start_date}}" data-end_date="{{$project->end_date}}" class="dropdown-item edit_btn" data-target="edit_employee_project" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <a data-id="{{$project->id}}" class="dropdown-item deletebtn" data-resource_data="Employee Project" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
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
                <form action="{{route('employee-project.store')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project<span class="text-danger">*</span></label>
                                <select name="project" id="project" class="select form-control">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" name="start_date" id="start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input class="form-control" name="end_date" id="end_date" type="date">
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
                <form method="POST" action="{{route('employee-project.update')}}">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <input type="hidden" id="edit_project_id" name="edit_id">
                        <input type="hidden" id="project_employee_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project<span class="text-danger">*</span></label>
                                <select name="project" id="edit_project" class="select form-control">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" name="start_date" id="pro_edit_start_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input class="form-control" name="end_date" id="edit_end_date" type="date">
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
<script>
    $(document).ready(function() {
        $('.table').on('click', '.edit_btn', function() {
            $('#edit_employee_project').modal('show');
            var id = $(this).data('id');
            var emp_id = $(this).data('employee_id');
            var start_date = $(this).data('start_date');
            var end_date = $(this).data('end_date');
            var project = $(this).data('project');
            $('#edit_project_id').val(id);
            $('#project_employee_id').val(emp_id);
            $('#pro_edit_start_date').val(start_date);
            $('#edit_end_date').val(end_date);
            $('#edit_project').val(project);
        });
    });
</script>