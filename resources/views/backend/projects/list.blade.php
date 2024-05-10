@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote-bs4.css') }}">
@endsection

@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Projects</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">projects</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            {{-- <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i
                    class="fa fa-plus"></i> Add Project</a> --}}
            <a href="{{route('projects.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Project</a>
            <div class="view-icons">
                {{-- <a href="{{ route('project-list') }}"
                    class="list-view btn btn-link {{ route_is('project-list') ? 'active' : '' }}" class=""><i
                        class="fa fa-bars"></i></a> --}}
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Project Name</th>
                            <th>Project Type</th>
                            <th>Contract Id</th>
                            <th>Client Name</th>
                            {{-- <th>Project Type</th> --}}
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>
                                    <a href="#">{{ $project->name }}</a>
                                </td>
                                <td>{{$project->project_type}}</td>
                                <td>{{ $project->contract_id}}</td>
                                <td>{{ $project->client_name }}</td>
                                {{-- <td>{{ $project->project_type }}</td> --}}
                                <td>{{!empty($project->client_cont_start_date) ? date_format(date_create($project->client_cont_start_date), 'D M, Y'):'' }}</td>
                                <td>{{ !empty($project->client_cont_end_date) ? date_format(date_create($project->client_cont_end_date), 'D M, Y'):'' }}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('projects.create', $project->id)}}"
                                                data-id="{{ $project->id }}" data-name="{{ $project->name }}"
                                                data-project_type="{{ $project->project_type }}"
                                                data-client_name="{{ $project->client_name }}"
                                                data-client_address="{{ $project->client_address }}"
                                                data-work_location="{{ $project->work_location }}"
                                                data-start_date="{{ $project->client_cont_start_date }}"
                                                data-end_date="{{ $project->client_cont_end_date }}"
                                                data-contract_id="{{ $project->contract_id }}"><i
                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item deletebtn" href="javascript:void(0)"
                                                data-id="{{ $project->id }}" data-target="#deletebtn"><i
                                                    class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <x-modals.delete route="projects" title="Project" />
@endsection


@section('scripts')
    <!-- Summernote JS -->
    <script src="{{ asset('assets/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', (function() {
                var id = $(this).data('id');
                var edit_name = $(this).data('name');
                var edit_project_type = $(this).data('project_type');
                var edit_client_name = $(this).data('client_name');
                var edit_client_address = $(this).data('client_address');
                var edit_work_location = $(this).data('work_location')
                var edit_startdate = $(this).data('start_date');
                var edit_enddate = $(this).data('end_date');
                var edit_contract_id = $(this).data('contract_id');
                $('#edit_project').modal('show');
                $('#edit_id').val(id);
                $('#edit_name').val(edit_name);
                $('#edit_project_type').val(edit_project_type);
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
