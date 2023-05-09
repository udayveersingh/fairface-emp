@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Employee Payslip</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('employees-list')}}">Employee</a></li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_payslip"><i class="fa fa-plus"></i> Add Employee Payslip</a>
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
                        <th>Month</th>
                        <th>Year</th>
                        <th>Attachment</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($employee_payslips->count()))
                    @foreach ($employee_payslips as $payslip)
                    <tr>
                        <td>{{$payslip->id}}</td>
                        <td>{{$payslip->month}}</td>
                        <td>{{$payslip->year}}</td>
                        <td><img src="{{ asset('storage/payslips/'.$payslip->attachment)}}" width="100px"></td>
                        <td class="text-right">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$payslip->id}}" data-year="{{$payslip->year}}" data-month="{{$payslip->month}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a data-id="{{$payslip->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <x-modals.delete :route="'employee-payslip.destroy'" :title="'Employee Payslip'" />
                    <!-- Edit Employee Payslip Modal -->
                    <div id="edit_employee_payslip" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Employee Payslip</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('employee-payslip.update')}}" enctype="multipart/form-data">
                                        @csrf
                                        @method("PUT")
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="row">
                                            <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Month<span class="text-danger">*</span></label>
                                                    <select name="month"  id="edit_month" class="select form-control">
                                                        <option value="">Select Month</option>
                                                        @php
                                                        for ($i = 0; $i < 12; $i++) { $date_str=date('M', strtotime("+ $i months")); @endphp <option value={{$date_str}}> {{$date_str}}</option>;
                                                            @php
                                                            }
                                                            @endphp
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Year<span class="text-danger">*</span></label>
                                                    @php
                                                    $years = collect(range(12, 0))->map(function ($item) {
                                                    return (string) date('Y') - $item;
                                                    });
                                                    @endphp
                                                    <select name="year"  id="edit_year" class="select form-control">
                                                        <option value="">Select Year</option>
                                                        @foreach($years as $year)
                                                        <option value="{{$year}}">{{$year}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
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

<!-- Add Employee Payslip -->
<div id="add_employee_payslip" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Payslip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-payslip.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" value="{{$empId}}" id="emp_id" name="emp_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Month<span class="text-danger">*</span></label>
                                <select name="month" class="select form-control">
                                    <option value="">Select Month</option>
                                    @php
                                    for ($i = 0; $i < 12; $i++) { $date_str=date('M', strtotime("+ $i months")); @endphp <option value={{$date_str}}> {{$date_str}}</option>;
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Year<span class="text-danger">*</span></label>
                                @php
                                $years = collect(range(12, 0))->map(function ($item) {
                                return (string) date('Y') - $item;
                                });
                                @endphp
                                <select name="year" class="select  form-control">
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
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
            $('#edit_employee_payslip').modal('show');
            var id = $(this).data('id');
            var edit_month = $(this).data('month');
            var edit_year = $(this).data('year');
            $('#edit_id').val(id);
            $('#edit_month').val(edit_month);
            $('#edit_year').val(edit_year);
        });
    });
</script>
@endsection