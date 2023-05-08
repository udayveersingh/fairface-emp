@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Bank</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_emergency_contact"><i class="fa fa-plus"></i> Add Employee Bank</a>
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
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Ifsc Code</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($employee_banks->count()))
                    @foreach ($employee_banks as $bank)
                    <tr>
                        <td>{{$bank->id}}</td>
                        <td>{{$bank->bank_name}}</td>
                        <td>{{$bank->bank_account_number}}</td>
                        <td>{{$bank->ifsc_code}}</td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$bank->id}}" data-account_name="{{$bank->account_name}}" data-bank_name="{{$bank->bank_name}}" data-bank_account_number="{{$bank->bank_account_number}}" data-bank_sort_code="{{$bank->bank_sort_code}}" data-ifsc_code="{{$bank->ifsc_code}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$bank->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-bank.destroy'" :title="'Employee Bank'" />
                    <!-- Edit Emergency contact Modal -->
                    <div id="edit_emergency_contact" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Bank</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('employee-bank.update')}}">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Bank Account Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="account_name" id="edit_account_name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Bank Name<span class="text-danger">*</span></label>
                                                    <input class="form-control" name="bank_name" id="edit_bank_name" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Bank Account Number</label>
                                                    <input class="form-control" name="account_number" id="edit_account_number" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Bank Sort Code</label>
                                                    <input class="form-control" name="bank_sort_code" id="edit_sort_code" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Ifsc Code</label>
                                                    <input class="form-control" name="ifsc_code" id="edit_ifsc_code" type="text">
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
                <h5 class="modal-title">Add Employee Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-bank.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Account Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="account_name" id="edit_account_name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Name<span class="text-danger">*</span></label>
                                <input class="form-control" name="bank_name" id="edit_bank_name" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Account Number</label>
                                <input class="form-control" name="account_number" id="edit_account_number" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Sort Code</label>
                                <input class="form-control" name="bank_sort_code" id="edit_sort_code" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Ifsc Code</label>
                                <input class="form-control" name="ifsc_code" id="edit_ifsc_code" type="text">
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
            var edit_account_name = $(this).data('account_name');
            var edit_bank_name = $(this).data('bank_name');
            var edit_account_number = $(this).data('bank_account_number');
            var edit_sort_code = $(this).data('bank_sort_code');
            var edit_ifsc_code = $(this).data('ifsc_code');
            $('#edit_id').val(id);
            $('#edit_account_name').val(edit_account_name);
            $('#edit_bank_name').val(edit_bank_name);
            $('#edit_account_number').val(edit_account_number);
            $('#edit_sort_code').val(edit_sort_code);
            $('#edit_ifsc_code').val(edit_ifsc_code);
        });
    });
</script>
@endsection