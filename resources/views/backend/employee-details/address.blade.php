
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('employee-address.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id" value="{{!empty($employee_address->id) ? $employee_address->id:'' }}" name="id">
            <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address Line 1<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_address_line_1" name="address_line_1" rows="4" cols="50">{{!empty($employee_address->home_address_line_1) ? $employee_address->home_address_line_1:'' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address Line 2<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_address_line_2" name="address_line_2" rows="4" cols="50">{{!empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2:''}}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Post Code</label>
                        <input class="form-control" name="post_code" id="edit_post_code" value="{{!empty($employee_address->post_code) ? $employee_address->post_code:'' }}" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>From Date</label>
                        <input class="form-control" name="from_date" id="edit_from_date" value="{{!empty($employee_address->from_date) ? $employee_address->from_date:''}}" type="date">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>To Date</label>
                        <input class="form-control" name="to_date" id="edit_to_date" value="{{!empty($employee_address->to_date) ? $employee_address->to_date:'' }}" type="date">
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>