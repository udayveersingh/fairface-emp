@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Annocements</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Announcement</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_announcement"><i
                    class="fa fa-plus"></i> Add Annoucement</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable mb-0">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Annoucement</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($announcements->count()))
                            @foreach ($announcements as $index => $announce)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td calss="announcement-scroll p-1">{{ $announce->description }}</td>
                                    <td>{{ $announce->status }}</td>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a data-id="{{ $announce->id }}"
                                                    data-description="{{ $announce->description }}"
                                                    data-status="{{ $announce->status }}" data-start_date= {{$announce->start_date}}  data-end_date="{{$announce->end_date}}" class="dropdown-item editbtn"
                                                    href="#" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i>
                                                    Edit</a>
                                                <a data-id="{{ $announce->id }}" class="dropdown-item deletebtn"
                                                    data-target="#deletebtn" href="#" data-toggle="modal"><i
                                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <x-modals.delete :route="'announcement.destroy'" :title="'Announcement'" />
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Annoucement Modal -->
    <div id="add_announcement" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Announcement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('announcement') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="">
                        <div class="form-group">
                            <label>Announcement<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="" name="announcement" rows="4" cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" name="start_date" id="" type="date">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" name="end_date" id="" type="date">
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" selected="selected" id="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Announcement Modal -->

    <!-- Edit Annoucement Modal -->
    <div id="edit_announcement" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Announcement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('announcement') }}">
                        @csrf
                        @method('PUT')
                        <input id="edit_id" type="hidden" name="id">
                        <div class="form-group">
                            <label>Announcement<span class="text-danger">*</span></label>
                            <textarea class="form-control edit_description" id="edit_description" name="announcement" rows="4"
                                cols="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" selected="selected" id="edit_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" name="start_date" id="start_date" type="date">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" name="end_date" id="end_date" type="date">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Annoucement Modal -->
@endsection

@section('scripts')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.editbtn').on('click', function() {
                $('#edit_announcement').modal('show');
                var id = $(this).data('id');
                var description = $(this).data('description');
                var status = $(this).data('status');
                var startDate = $(this).data('start_date');
                var endDate = $(this).data('end_date'); 
                $('#edit_id').val(id);
                $('.edit_description').val(description);
                $('#edit_status').val(status);
                $('#start_date').val(startDate);
                $('#end_date').val(endDate);
                
            });
        });
    </script>
@endsection
