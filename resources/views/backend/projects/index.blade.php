@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/dist/summernote-bs4.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Projects</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">projects</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> Add Modal</a>
        <div class="view-icons">
            <a href="{{route('projects')}}" class="grid-view btn btn-link {{route_is('projects') ? 'active' : '' }}"><i class="fa fa-th"></i></a>
            <a href="{{route('project-list')}}" class="list-view btn btn-link {{route_is('project-list') ? 'active' : '' }}" class=><i class="fa fa-bars"></i></a>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    @foreach ($projects as $project)
    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="dropdown dropdown-action profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item editbtn" href="javascript:void(0)" data-id="{{$project->id}}" data-name="{{$project->name}}" data-project_type="{{$project->project_type}}" data-client_name="{{$project->client_name}}" data-client_address="{{$project->client_address}}" data-work_location="{{$project->work_location}}" data-start_date="{{$project->client_cont_start_date}}" data-end_date="{{$project->client_cont_end_date}}" data-contract_id="{{$project->contract_id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item deletebtn" href="javascript:void(0)" data-id="{{$project->id}}" data-target="#deletebtn"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
                <h4 class="project-title"><a href="#">{{$project->name}}</a></h4>
                <div class="pro-deadline m-b-15">
                    <div class="text-muted">
                        {{date_format(date_create($project->client_cont_start_date),"D M, Y")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
<!-- /Page Content -->
<x-modals.popup/>
<x-modals.delete route="projects" title="Project" />
@endsection


@section('scripts')
<!-- summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.card').on('click', '.editbtn', (function() {
            var id = $(this).data('id');
            var edit_name = $(this).data('name');
            var project_type = $(this).data('project_type');
            console.log(project_type,"edit_enddate");
            var edit_client_name = $(this).data('client_name');
            var edit_client_address = $(this).data('client_address');
            var edit_work_location = $(this).data('work_location');
            var edit_startdate = $(this).data('start_date');
            var edit_enddate = $(this).data('end_date');
            console.log(edit_enddate,"edit_enddate");
            var edit_contract_id = $(this).data('contract_id');
            $('#edit_project').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(edit_name);
            $('#edit_project_type').val(project_type);
            $('#client_name').val(edit_client_name);
            $('#work_location').val(edit_work_location);
            $('#client_address').val(edit_client_address);
            $('#edit_startdate').val(edit_startdate);
            $('#edit_enddate').val(edit_enddate);
            $('#client_address').val(edit_client_address);
            $('#contract_id').val(edit_contract_id);
        }));
    });
</script>
@endsection