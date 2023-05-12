@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Document</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_document"><i class="fa fa-plus"></i> Add Employee Document</a>
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
                        <th style="width: 30px;">#</th>
                        <th>Document Name</th>
                        <th>Attachment</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($employee_documents->count()))
                    @foreach ($employee_documents as $document)
                    <tr>
                        <td>{{$document->id}}</td>
                        <td>{{$document->name}}</td>
                        <td><img src="{{asset('storage/documents/employee/'.$document->employee_id.'/'.$document->attachment)}}" width="100px"></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$document->id}}" data-name="{{$document->name}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$document->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-document.destroy'" :title="'Employee Document'" />
                    <!-- Edit Employee Document Modal -->
                    <div id="edit_employee_document" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Document</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('employee-document.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="row">
                                            <div class="row">
                                                <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Document Name</label>
                                                        <input class="form-control edit_name" name="name" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Attachment</label>
                                                        <input class="form-control" name="attachment" type="file">
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
                    <!-- / Edit Emergency Contact Modal -->
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Employee Document -->
<div id="add_employee_document" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-document.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Document Name</label>
                                <input class="form-control edit_name" name="name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Attachment</label>
                                <input class="form-control" name="attachment" type="file">
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
<!--  Add Emergency Contact Modal -->
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.table').on('click', '.editbtn', function() {
            $('#edit_employee_document').modal('show');
            var id = $(this).data('id');
            var edit_name = $(this).data('name');
            $('#edit_id').val(id);
            $('.edit_name').val(edit_name);
        });
    });
</script>
@endsection