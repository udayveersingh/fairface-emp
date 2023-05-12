@extends('layouts.backend-detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form id="payslipform" method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" id="edit_id" value="{{!empty($employee_payslip->id) ? $employee_payslip->id:'' }}" name="id">
            <div class="row">
                <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Month<span class="text-danger">*</span></label>
                        <select name="month" id="edit_month" class="select form-control">
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
                        <select name="year" id="edit_year" class="select form-control">
                            <option value="">Select Year</option>
                            @foreach($years as $year)
                            <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Attachment<span class="text-danger">*</span></label>
                        <input class="form-control" id="attachment" name="attachment" multiple type="file">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="submit-section mt-0">
                        <label>&nbsp;</label>
                        <button type="submit" id="submit" class="btn w-100 btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Created</th>
                    <th>Attachment</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody id="bodyData">
                @foreach ($employee_payslips as $employee_payslip)
                <tr>
                    <td>{{!empty($employee_payslip->id)? $employee_payslip->id:''}}</td>
                    <td>{{!empty($employee_payslip->month) ? $employee_payslip->month:'' }}</td>
                    <td>{{!empty($employee_payslip->year)? $employee_payslip->year:''}}</td>
                    <td>{{!empty(date("Y-m-d", strtotime($employee_payslip->created_at) ))? date("Y-m-d", strtotime($employee_payslip->created_at)):''}}</td>
                    <td><img src="{{ asset('storage/payslips/'.$employee_payslip->attachment)}}" width="100px"></td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$employee_payslip->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                <x-modals.delete :route="'employee-payslip.destroy'" :title="'Employee Payslip'"/>

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#payslipform').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('employee-payslip-update') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(dataResult) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection