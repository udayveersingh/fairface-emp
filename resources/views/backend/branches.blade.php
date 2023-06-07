@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Branch</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Branch</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_branch"><i class="fa fa-plus"></i> Add Branch</a>
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
                        <th>Branch Code</th>
                        <th>Branch Address</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($branches->count()))
                    @foreach ($branches as $index => $branch)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$branch->branch_code}}</td>
                        <td>{{$branch->branch_address}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$branch->id}}" data-branch_code="{{$branch->branch_code}}" data-branch_address="{{$branch->branch_address}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$branch->id}}" class="dropdown-item deletebtn" data-target="#deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'branch.destroy'" :title="'branch'" />
                    <!-- Edit Branch Modal -->
                    <div id="edit_branch" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Branch</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('branches')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="form-group">
                                            <label>Branch Code <span class="text-danger">*</span></label>
                                            <input class="form-control" name="branch_code" id="edit_branch_code" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Branch Address <span class="text-danger">*</span></label>
                                            <input class="form-control" name="branch_address" id="edit_branch_address" type="text">
                                        </div>
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
<div id="add_branch" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('branches')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Branch Code <span class="text-danger">*</span></label>
                        <input class="form-control" name="branch_code" id="edit_branch_code" type="text">
                    </div>
                    <div class="form-group">
                        <label>Branch Address <span class="text-danger">*</span></label>
                        <input class="form-control" name="branch_address" id="edit_branch_address" type="text">
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
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
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.table').on('click', '.editbtn', function() {
            $('#edit_branch').modal('show');
            var id = $(this).data('id');
            var edit_branch_code = $(this).data('branch_code');
            var edit_branch_address = $(this).data('branch_address');
            $('#edit_id').val(id);
            $('#edit_branch_code').val(edit_branch_code);
            $('#edit_branch_address').val(edit_branch_address);
        });
    });
</script>
@endsection