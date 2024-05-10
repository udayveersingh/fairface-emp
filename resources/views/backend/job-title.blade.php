@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Job Title</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Job Title</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_job_Title"><i
                    class="fa fa-plus"></i> Add Job Title</a>
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
                            <th>Job Title</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($job_titles->count()))
                            @foreach ($job_titles as $index => $job_title)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{ $job_title->title }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a data-id="{{ $job_title->id }}" data-title="{{ $job_title->title }}"
                                                    data-description="{{ $job_title->description }}"
                                                    class="dropdown-item editbtn" href="javascript:void(0);"
                                                    data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a data-id="{{ $job_title->id }}" class="dropdown-item deletebtn"
                                                    href="javascript:void(0);" data-target="#deletebtn"
                                                    data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <x-modals.delete :route="'job-title.destroy'" :title="'JOb Title'" />
                            <!-- Edit Job Title Modal -->
                            <div id="edit_job_title" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Job Title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('job-title') }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="edit_id" name="id">
                                                <div class="form-group">
                                                    <label>Job Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="title" id="job_title"
                                                        required type="text">
                                                </div>
                                                <div class="form-group">
                                                    <label>Job Description <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_job_description" required name="description" rows="4" cols="50"></textarea>
                                                </div>
                                                <div class="submit-section">
                                                    <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Edit Job Title Modal -->
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Job Title Modal -->
    <div id="add_job_Title" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Job Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('job-title') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Job Title <span class="text-danger">*</span></label>
                            <input class="form-control" name="title" id="edit_job_title" type="text">
                        </div>
                        <div class="form-group">
                            <label>Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_job_description" name="description" rows="4" cols="50"></textarea>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Visa Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.table').on('click', '.editbtn', function() {
                $('#edit_job_title').modal('show');
                var id = $(this).data('id');
                var edit_job_title = $(this).data('title');
                var edit_job_description = $(this).data('description');
                $('#edit_id').val(id);
                $('#job_title').val(edit_job_title);
                $('#edit_job_description').val(edit_job_description);
            });
        });
    </script>
@endsection
