{{-- @dd($employee_address); --}}
{{-- @if (!empty($employee_address))
    <div class="row">
        <div class="col-md-8">
            <div class="card card-block shadow shadow-sm p-3 h-100">
                <table class="table table-striped">
                    <tr>
                        <th>Address Line 1</th>
                        <td>{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Address Line 2</th>
                        <td>{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Post Code</th>
                        <td>{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}</td>
                    </tr>
                    <tr>
                        <th>From Date</th>
                        <td>{{ !empty($employee_address->from_date) ? date('d-m-Y', strtotime($employee_address->from_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>To Date</th>
                        <td>{{ !empty($employee_address->to_date) ? date('d-m-Y', strtotime($employee_address->to_date)) : '' }}
                        </td>
                    </tr>
                </table>
                <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                    <a class="btn btn-primary w-100 " id="employee_address_btn" href="javascript:void(0)"
                        data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
        <a class="btn btn-primary w-100  add-btn " id="employee_address_btn" href="javascript:void(0)"
            data-toggle="modal"><i class="fa fa-plus m-r-5"></i>Add Address</a>
    </div>
@endif

<div id="edit_address_detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ml-5">
            <div class="modal-header">
                <h5 class="modal-title">Employee Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('employee-address.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id"
                                value="{{ !empty($employee_address->id) ? $employee_address->id : '' }}" name="id">
                            <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address Line 1<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50">{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address Line 2<span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50">{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Post Code</label>
                                        <input class="form-control" name="post_code" id="edit_post_code"
                                            value="{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}"
                                            type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input class="form-control" name="from_date" id="edit_from_date"
                                            value="{{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}"
                                            type="date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input class="form-control" name="to_date" id="edit_to_date"
                                            value="{{ !empty($employee_address->to_date) ? $employee_address->to_date : '' }}"
                                            type="date">
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
    </div>
</div> --}}
{{-- <div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ route('employee-address.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" value="{{ !empty($employee_address->id) ? $employee_address->id : '' }}"
                name="id">
            <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Address Line 1<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50">{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Address Line 2</label>
                        <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50">{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Post Code</label>
                        <input class="form-control" name="post_code" id="edit_post_code"
                            value="{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}"
                            type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>From Date<span class="text-danger">*</span></label>
                        <input class="form-control" name="from_date" id="edit_from_date"
                            value="{{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}"
                            type="date">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>To Date</label>
                        <input class="form-control" name="to_date" id="edit_to_date"
                            value="{{ !empty($employee_address->to_date) ? $employee_address->to_date : '' }}"
                            type="date">
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>
<hr />

{{-- @dd($employee_address); --}}
{{-- <div class="row">
    <div class="col-md-12">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th style="width: 30px;">Sr No.</th>
                    <th>Address Line 1</th>
                    <th>Address Line 2</th>
                    <th>Post Code</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody id="bodyData">

                <tr>
                    <td></td>
                    <td>{{!empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                    </td>
                    <td class="text-right">
                        <div class="dropdown dropdown-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{ $employee_address->id }}" class="dropdown-item detail_delete"
                                    href="javascript:void(0);" data-resource_data="Employee Payslip"
                                    data-target="data_delete_modal" data-toggle="modal"><i
                                        class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}
@if (!empty($employee_address->count()))
    <div class="row align-items-center mb-2">
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_address"><i
                    class="fa fa-plus"></i>
                Add Employee Address</a>
        </div>
    </div>
@else
    <div class="row align-items-center mb-2">
        <div class="">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_address"><i
                    class="fa fa-plus"></i>
                Add Employee Address</a>
        </div>
    </div>
@endif
@if (!empty($employee_address->count()))
    <div class="row">
        @foreach ($employee_address as $address)
            <div class="col-md-12 mb-4">
                <div class="card card-block shadow shadow-sm p-3 h-100 w-50">
                    <table class="table table-striped">
                        <tr>
                            <th>Address Line 1</th>
                            <td>{{ !empty($address->home_address_line_1) ? $address->home_address_line_1 : '' }}</td>
                        </tr>
                        <tr>
                            <th>Address Line 2</th>
                            <td>{{ !empty($address->home_address_line_2) ? $address->home_address_line_2 : '' }}</td>
                        </tr>
                        <tr>
                            <th>Post Code</th>
                            <td>{{ !empty($address->post_code) ? $address->post_code : '' }}</td>
                        </tr>
                        <tr>
                            <th>From Date</th>
                            <td>{{ !empty($address->from_date) ? date('d-m-Y', strtotime($address->from_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>To Date</th>
                            <td>{{ !empty($address->to_date) ? date('d-m-Y', strtotime($address->to_date)) : '' }}</td>
                        </tr>
                    </table>
                    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                        <a data-id="{{ $address->id }}" data-employee_id="{{ $address->employee_id }}"
                            data-home_address_line_1="{{ $address->home_address_line_1 }}"
                            data-home_address_line_2="{{ $address->home_address_line_2 }}"
                            data-post_code="{{ $address->post_code }}" data-from_date="{{ $address->from_date }}"
                            data-to_date="{{ $address->to_date }}" data-target="edit_employee_address"
                            class="btn btn-primary" id="edit_btn_employee_address" href="javascript:void(0);"
                            data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a data-id="{{ $address->id }}" class="btn btn-danger detail_delete"
                            data-resource_data="Employee Address" href="javascript:void(0);" data-toggle="modal"><i
                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Add Employee address Modal -->
<div id="add_employee_address" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('employee-address.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id"
                        value="{{ !empty($employee_address->id) ? $employee_address->id : '' }}" name="id">
                    <input type="hidden" value="{{ $employee->id }}" id="emp_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address Line 1<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50">{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50">{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Post Code</label>
                                <input class="form-control" name="post_code" id="edit_post_code"
                                    value="{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="from_date" id="edit_from_date"
                                    value="{{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To Date</label>
                                <input class="form-control" name="to_date" id="edit_to_date"
                                    value="{{ !empty($employee_address->to_date) ? $employee_address->to_date : '' }}"
                                    type="date">
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
<!--  Add Employee Address Modal -->
<!--  Edit Employee Address Modal -->
<div id="edit_employee_address" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('employee-address.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_emp_address_id" value="{{ !empty($employee_address->id) ? $employee_address->id : '' }}" name="id">
                    <input type="hidden" value="{{ $employee->id }}" id="address_employee_id" name="emp_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address Line 1<span class="text-danger">*</span></label>
                                <textarea class="form-control edit_address_line_1" id="edit_address_line_1" name="address_line_1" rows="4" cols="50">{{ !empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1 : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <textarea class="form-control edit_address_line_2" id="edit_address_line_2" name="address_line_2" rows="4" cols="50">{{ !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Post Code</label>
                                <input class="form-control edit_post_code" name="post_code" id="edit_post_code"
                                    value="{{ !empty($employee_address->post_code) ? $employee_address->post_code : '' }}"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From Date<span class="text-danger">*</span></label>
                                <input class="form-control edit_from_date" name="from_date" id="edit_from_date"
                                    value="{{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}"
                                    type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>To Date</label>
                                <input class="form-control edit_to_date" name="to_date" id="edit_to_date"
                                    value=""
                                    type="date">
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
<!-- Edit Employee address Modal -->
