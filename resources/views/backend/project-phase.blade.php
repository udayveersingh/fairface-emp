@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Project Phase</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Project Phase</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_project_phase"><i
                    class="fa fa-plus"></i> Add Project Phase</a>
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
                            <th>Project Phase</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($project_phases->count()))
                            @foreach ($project_phases as $index => $project_phase)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ str_replace('_', ' ', ucfirst($project_phase->name)) }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a data-id="{{ $project_phase->id }}"
                                                    data-project_phase="{{ $project_phase->name }}"
                                                    class="dropdown-item editbtn" href="javascript:void(0);"
                                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a data-id="{{ $project_phase->id }}" class="dropdown-item deletebtn"
                                                    href="javascript:void(0);" data-resource_data="Project"
                                                    data-target="#deletebtn" data-toggle="modal"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <x-modals.delete :route="'project-phase.destroy'" :title="'Project Phase'" />
                            <!-- Edit Branch Modal -->
                            <div id="edit_project_phase" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Project Phase</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('project-phase') }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="edit_id" name="id">
                                                <label>Project Phase<span class="text-danger">*</span></label>
                                                <input class="form-control" name="project_phase" required id="project_phase"
                                                    type="text">
                                                <div class="submit-section">
                                                    <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Edit Branch Modal -->
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Branch Modal -->
    <div id="add_project_phase" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Project Phase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('project-phase') }}" method="POST">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <label>Project Phase<span class="text-danger">*</span></label>
                        <input class="form-control" name="project_phase" required type="text">
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Branch Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', function() {
                $('#edit_project_phase').modal('show');
                var id = $(this).data('id');
                var edit_project_phase = $(this).data('project_phase');
                $('#edit_id').val(id);
                $('#project_phase').val(edit_project_phase);
            });
        });
    </script>
@endsection
