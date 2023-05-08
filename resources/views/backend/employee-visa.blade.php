@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Visa</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_visa"><i class="fa fa-plus"></i> Add Employee Visa</a>
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
                        <th>Visa Type</th>
                        <th>Cos Number</th>
                        <th>Visa Issue Date</th>
                        <th>Visa Expiry Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($employee_visas->count()))
                    @foreach ($employee_visas as $visa)
                    <tr>
                        <td>{{$visa->id}}</td>
                        <td>{{!empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type:''}}</td>
                        <td>{{$visa->cos_number}}</td>
                        <td>{{$visa->visa_issue_date}}</td>
                        <td>{{$visa->visa_expiry_date}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$visa->id}}" data-visa_type="{{$visa->visa_type}}" data-cos_number="{{$visa->cos_number}}" data-cos_issue_date="{{$visa->cos_issue_date}}" data-cos_expiry_date="{{$visa->cos_expiry_date}}" data-visa_issue_date="{{$visa->visa_issue_date}}" data-visa_expiry_date="{{$visa->visa_expiry_date}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$visa->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-visa.destroy'" :title="'Employee Visa'" />
                    <!-- Edit Emergency contact Modal -->
                    <div id="edit_employee_visa" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Visa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('employee-visa.update')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="visa_type" id="visa_type" class="select">
                                                    <option value="">Select Visa Type</option>
                                                    @foreach($visa_types as $type)
                                                    <option value="{{$type->id}}">{{$type->visa_type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Cos Number</label>
                                                    <input class="form-control" name="cos_number" id="edit_cos_number" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Cos Issue Date</label>
                                                    <input class="form-control" name="cos_issue_date" id="edit_cos_issue_date" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Cos Expiry Date</label>
                                                    <input class="form-control" name="cos_expiry_date" id="edit_cos_expiry_date" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Visa Issue Date</label>
                                                    <input class="form-control" name="visa_issue_date" id="edit_visa_issue_date" type="date">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Visa Expiry Date</label>
                                                    <input class="form-control" name="visa_expiry_date" id="edit_visa_expiry_date" type="date">
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
<div id="add_employee_visa" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Visa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-visa.store')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Visa Type<span class="text-danger">*</span></label>
                                <select name="visa_type" id="visa_type" class="select">
                                    <option value="">Select Visa Type</option>
                                    @foreach($visa_types as $type)
                                    <option value="{{$type->id}}">{{$type->visa_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Cos Number</label>
                                <input class="form-control" name="cos_number" id="edit_cos_number" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Cos Issue Date</label>
                                <input class="form-control" name="cos_issue_date" id="edit_cos_issue_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Cos Expiry Date</label>
                                <input class="form-control" name="cos_expiry_date" id="edit_cos_expiry_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Visa Issue Date</label>
                                <input class="form-control" name="visa_issue_date" id="edit_visa_issue_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Visa Expiry Date</label>
                                <input class="form-control" name="visa_expiry_date" id="edit_visa_expiry_date" type="date">
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
            $('#edit_employee_visa').modal('show');
            var id = $(this).data('id');
            var edit_visa_type = $(this).data('visa_type');
            var edit_cos_number = $(this).data('cos_number');
            var edit_cos_issue_date = $(this).data('cos_issue_date');
            var edit_cos_expiry_date = $(this).data('cos_expiry_date');
            var edit_visa_issue_date = $(this).data('visa_issue_date');
            var edit_visa_expiry_date = $(this).data('visa_expiry_date');
            $('#edit_id').val(id);
            $('#visa_type').val(edit_visa_type);
            $('#edit_cos_number').val(edit_cos_number);
            $('#edit_cos_issue_date').val(edit_cos_issue_date);
            $('#edit_cos_expiry_date').val(edit_cos_expiry_date);
            $('#edit_visa_issue_date').val(edit_visa_issue_date);
            $('#edit_visa_expiry_date').val(edit_visa_expiry_date);
        });
    });
</script>
@endsection