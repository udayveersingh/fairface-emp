@extends('layouts.backend-detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('employee-project.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id" value="{{$employee_project->id}}" name="id">
            <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input class="form-control" value="{{$employee_project->start_date}}" name="start_date" id="edit_start_date" type="date">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>End Date</label>
                        <input class="form-control" name="end_date" value="{{$employee_project->end_date}}" id="edit_end_date" type="date">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Project<span class="text-danger">*</span></label>
                        <select name="project" id="project" class="select form-control">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                            <option value="{{$project->id}}" {{$employee_project->project_id == $project->id ? 'selected' : ''}}>{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection