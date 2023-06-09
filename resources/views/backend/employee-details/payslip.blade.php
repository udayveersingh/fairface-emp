<div class="row">
    <div class="col-md-12">
        <form id="payslipform" method="POST" action="{{route('employee-payslip-update')}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
            <input type="hidden" id="edit_id" value="{{!empty($employee_payslip->id) ? $employee_payslip->id:'' }}" name="id">
            <div class="row">
                <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Month<span class="text-danger">*</span></label>
                        <select name="month" id="edit_month" class="form-control select">
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
                        <select name="year" id="edit_year" class="form-control select">
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
                    <th style="width: 30px;">Sr No.</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Created</th>
                    <th>Attachment</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody id="bodyData">
                @foreach ($employee_payslips as $index=>$employee_payslip)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{!empty($employee_payslip->month) ? $employee_payslip->month:'' }}</td>
                    <td>{{!empty($employee_payslip->year)? $employee_payslip->year:''}}</td>
                    <td>{{!empty(date("Y-m-d", strtotime($employee_payslip->created_at) ))? date("Y-m-d", strtotime($employee_payslip->created_at)):''}}</td>
                    @php
                        $extension = pathinfo(storage_path('storage/payslips/'.$employee_payslip->attachment), PATHINFO_EXTENSION);
                    @endphp
                    <td>@if($extension == "pdf")
                        <a href="{{asset('storage/payslips/'.$employee_payslip->attachment)}}" target="_blank"><img src="{{ asset('assets/img/profiles/photopdf.png')}}" width="100px"></a>
                        @else
                        <a href="{{asset('storage/payslips/'.$employee_payslip->attachment)}}" target="_blank"><img src="{{ asset('storage/payslips/'.$employee_payslip->attachment)}}" width="100px"></a>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$employee_payslip->id}}" class="dropdown-item detail_delete" href="javascript:void(0);" data-resource_data="Employee Payslip" data-target="data_delete_modal" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>