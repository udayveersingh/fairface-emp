@if(!empty($employee_address))
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
                    <td>{{ !empty($employee_address->from_date) ? $employee_address->from_date : '' }}</td>
                </tr>
                <tr>
                    <th>To Date</th>
                    <td>{{ !empty($employee_address->to_date) ? $employee_address->to_date : '' }}</td>
                </tr>
            </table>
            <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                <a class="btn btn-primary w-100 " id="employee_address_btn" href="javascript:void(0)" data-toggle="modal"><i
                        class="fa fa-pencil m-r-5"></i> Edit</a>
            </div>
        </div>
    </div>
</div>
@else
<div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
    <a class="btn btn-primary w-100  add-btn " id="employee_address_btn" href="javascript:void(0)" data-toggle="modal"><i
            class="fa fa-plus m-r-5"></i>Add Address</a>
</div>
@endif

<div id="edit_address_detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
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
</div>
