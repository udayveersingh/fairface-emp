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
                                <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Post Code</label>
                                <input class="form-control" name="post_code" id="edit_post_code"
                                    value=""
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>From Date<span class="text-danger">*</span></label>
                                <input class="form-control" name="from_date" id="edit_from_date"
                                    value="" type="date">
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