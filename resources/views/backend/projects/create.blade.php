@extends('layouts.backend')
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            @if (!empty($project))
                <h3 class="page-title">Edit Project</h3>
            @else
                <h3 class="page-title">Create Project</h3>
            @endif
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{ route('project-list') }}" class="btn add-btn"><i class="fa fa-bars"></i>Project List</a>
        </div>
    </div>
@endsection
@section('content')
@if(!empty($project))
    <form action="{{route('projects') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @else
        <form action="{{route('projects') }}" method="post" enctype="multipart/form-data">
        @csrf
        @endif
        <div class="row">
            <div class="col-sm-6">
                <input type="hidden" name="id" id="edit_id" value="{{!empty($project->id) ? $project->id:''}}">
                <div class="form-group">
                    <label>Project Name<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="project_name" value="{{!empty($project->name) ? $project->name:'' }}">
                    @if ($errors->has('project_name'))
                        <span class="text-danger">
                            {{ $errors->first('project_name') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <label>Project Type<span class="text-danger">*</span></label>
                <select name="project_type" class="form-control">
                    <option value="">Select Project Type</option>
                    <option value="internal"{{!empty($project->project_type) && $project->project_type == "internal" ? 'selected':''}}>Internal</option>
                    <option value="external"{{!empty($project->project_type) && $project->project_type == "external" ? 'selected':''}}>External</option>
                </select>
                @if ($errors->has('project_type'))
                    <span class="text-danger">
                        {{ $errors->first('project_type') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Contract Id</label>
                    <input class="form-control" type="text" name="contract_id" value="{{!empty($project->contract_id) ? $project->contract_id:''}}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Client Name</label>
                    <input class="form-control" type="text" name="client_name" value="{{!empty($project->client_name) ? $project->client_name:'' }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Client Address</label>
                    <textarea class="form-control" id="edit_client_address" name="client_address" rows="4" cols="50">
                        {{!empty($project->client_address) ? $project->client_address:''}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Work Location</label>
                    <input class="form-control" type="text" name="work_location" value="{{!empty($project->work_location) ? $project->work_location:'' }}" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Start Date</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" type="text" name="start_date" value="{{!empty($project->client_cont_start_date) ? $project->client_cont_start_date:''}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>End Date</label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="end_date" type="text" value="{{!empty($project->client_cont_end_date) ? $project->client_cont_end_date:''}}">
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group">
                                    <label>Upload Files</label>
                                    <input class="form-control" name="project_files[]" multiple type="file">
                                </div> -->
        <div class="submit-section">
            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
        </div>
    </form>
    <!-- /Create Project Modal -->
@endsection
