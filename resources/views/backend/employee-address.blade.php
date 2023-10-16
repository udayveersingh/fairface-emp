@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Address</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_emergency_contact"><i class="fa fa-plus"></i> Add Employee Address</a>
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
                        <th>Address Type</th>
                        <th>Home Address Line 1</th>
                        <th>Post Code</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($employee_addresses->count()))
                    @foreach ($employee_addresses as $address)
                    <tr>
                        <td>{{$address->id}}</td>
                        <td>{{$address->address_type}}</td>
                        <td>{{$address->home_address_line_1}}</td>
                        <td>{{$address->post_code}}</td>
                        <td>{{$address->from_date}}</td>
                        <td>{{$address->to_date}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$address->id}}" data-home_address_line_1="{{$address->home_address_line_1}}" data-home_address_line_2="{{$address->home_address_line_2}}" data-post_code="{{$address->post_code}}" data-from_date="{{$address->from_date}}" data-to_date="{{$address->to_date}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$address->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-address.destroy'" :title="'Employee Address'" />
                    <!-- Edit Emergency contact Modal -->
                    <div id="edit_emergency_contact" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Address</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('employee-address.update')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Home Address Line 1<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Home Address Line 2<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Post Code</label>
                                                    <input class="form-control" name="post_code" id="edit_post_code" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>From Date</label>
                                                    <input class="form-control" name="from_date" id="edit_from_date" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <input class="form-control" name="to_date" id="edit_to_date" type="date">
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

<!-- Add Emergency Contact Modal -->
<div id="add_emergency_contact" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-address.store')}}" method="POST">
                    @csrf
                    <div class="row">
                     <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Home Address Line 1<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Home Address Line 2<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Post Code</label>
                                <input class="form-control" name="post_code" id="edit_post_code" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From Date</label>
                                <input class="form-control" name="from_date" id="edit_from_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To Date</label>
                                <input class="form-control" name="to_date" id="edit_to_date" type="date">
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
            $('#edit_emergency_contact').modal('show');
            var id = $(this).data('id');
            var edit_address_line_1 = $(this).data('home_address_line_1');
            var edit_address_line_2 = $(this).data('home_address_line_2');
            var edit_post_code = $(this).data('post_code');
            var edit_from_date = $(this).data('from_date');
            var edit_to_date = $(this).data('to_date');
            $('#edit_id').val(id);
            $('#edit_address_line_1').val(edit_address_line_1);
            $('#edit_address_line_2').val(edit_address_line_2);
            $('#edit_post_code').val(edit_post_code);
            $('#edit_from_date').val(edit_from_date);
            $('#edit_to_date').val(edit_to_date);
        });
    });
</script>
@endsection