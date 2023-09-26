@if (!empty($employee_visas->count()))
<div class="row align-items-center mb-2">
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_visa"><i class="fa fa-plus"></i>
            Add Visa</a>
    </div>
</div>
@else
<div class="row align-items-center mb-2">
    <div class="">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_visa"><i class="fa fa-plus"></i>
            Add Visa</a>
    </div>
</div>
@endif
@if (!empty($employee_visas->count()))
    <div class="row">
        @foreach ($employee_visas as $visa)
            <div class="col-md-12 mb-4">
                <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                    <table class="table table-striped">
                        <tr>
                            <th>Visa Type</th>
                            <td>{{ !empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type : '' }}</td>
                        </tr>
                        <tr>
                            <th>Cos Number</th>
                            <td>{{ $visa->cos_number }}</td>
                        </tr>
                        <tr>
                            <th>Cos Issue Date</th>
                            <td>{{ !empty($visa->cos_issue_date) ? date('d-m-Y',strtotime($visa->cos_issue_date)):''}}</td>
                        </tr>
                        <tr>
                            <th>Cos Expire Date</th>
                            <td>{{ !empty($visa->cos_expiry_date) ? date('d-m-Y',strtotime($visa->cos_expiry_date)):''}}</td>
                        </tr>
                        <tr>
                            <th>Visa Issue Date</th>
                            <td>{{ !empty($visa->visa_issue_date) ? date('d-m-Y',strtotime($visa->visa_issue_date)):''}}</td>
                        </tr>
                        <tr>
                            <th>Visa Expiry Date</th>
                            <td>{{ !empty($visa->visa_expiry_date) ? date('d-m-Y',strtotime($visa->visa_expiry_date)):''}}</td>
                        </tr>
                    </table>
                    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                        <a data-id="{{ $visa->id }}" data-employee_id="{{ $visa->employee_id }}"
                            data-visa_type="{{ $visa->visa_type }}" data-cos_number="{{ $visa->cos_number }}"
                            data-cos_issue_date="{{ $visa->cos_issue_date }}"
                            data-cos_expiry_date="{{ $visa->cos_expiry_date }}"
                            data-visa_issue_date="{{ $visa->visa_issue_date }}"
                            data-visa_expiry_date="{{ $visa->visa_expiry_date }}" data-target="edit_employee_visa"
                            class="btn btn-primary" id="edit_btn_visa" href="javascript:void(0);" data-toggle="modal"><i
                                class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a data-id="{{ $visa->id }}" class="btn btn-danger detail_delete"
                            data-resource_data="Employee Visa" href="javascript:void(0);" data-toggle="modal"><i
                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Add Employee Visa Modal -->
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
                <form action="{{ route('employee-visa.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Employee Id<span class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $employee->employee_id }}" name="employee_id"
                                    id="" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Type<span class="text-danger">*</span></label>
                                <select name="visa_type" id="visa_type" class="form-control select">
                                    <option value="">Select Visa Type</option>
                                    @foreach ($visa_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->visa_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Number</label>
                                <input class="form-control mask_phone_number" name="cos_number" id="cos_number"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Issue Date</label>
                                <input class="form-control" name="cos_issue_date" id="cos_issue_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Expiry Date</label>
                                <input class="form-control" name="cos_expiry_date" id="cos_expiry_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Issue Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="visa_issue_date" id="visa_issue_date" type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Expiry Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="visa_expiry_date" id="visa_expiry_date"
                                    type="date">
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
<!--  Add Employee visa Modal -->
<!--  Edit Employee Visa Modal -->
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
                <form action="{{ route('employee-visa.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_visa_id" name="edit_id">
                    <input type="hidden" id="visa_employee_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Type<span class="text-danger">*</span></label>
                                <select name="visa_type" id="edit_visa_type" class="form-control select">
                                    <option value="">Select Visa Type</option>
                                    @foreach ($visa_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->visa_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Number</label>
                                <input class="form-control mask_phone_number" name="cos_number" id="edit_cos_number"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Issue Date</label>
                                <input class="form-control" name="cos_issue_date" id="edit_cos_issue_date"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Cos Expiry Date</label>
                                <input class="form-control" name="cos_expiry_date" id="edit_cos_expiry_date"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Issue Date</label>
                                <input class="form-control" name="visa_issue_date" id="edit_visa_issue_date"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Expiry Date</label>
                                <input class="form-control" name="visa_expiry_date" id="edit_visa_expiry_date"
                                    type="date">
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
<!-- Edit Employee Visa Modal -->
