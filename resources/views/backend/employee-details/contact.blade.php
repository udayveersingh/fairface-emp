<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('emergency-contact.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id"  value="{{!empty($emergency_contact->id) ? $emergency_contact->id:''}}" name="id">
            <input type="hidden" id="emp_id"  value="{{!empty($employee->id) ? $employee->id:'' }}" name="emp_id">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Full Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="name" value="{{!empty($emergency_contact->full_name) ? $emergency_contact->full_name:''}}" id="edit_name" type="text">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_address" name="address" rows="4" cols="50">{{!empty($emergency_contact->address)? $emergency_contact->address:''}}</textarea>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Phone Number 1</label>
                        <input class="form-control" name="phone_number_1" value="{{!empty($emergency_contact->phone_number_1)? $emergency_contact->phone_number_1:''}}" id="edit_phone_number_1" type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Phone Number 2</label>
                        <input class="form-control" name="phone_number_2" value="{{!empty($emergency_contact->phone_number_2) ? $emergency_contact->phone_number_2:''}}" id="edit_phone_number_2" type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Relationship</label>
                        <input class="form-control" name="relationship" value="{{!empty($emergency_contact->relationship)?$emergency_contact->relationship:'' }}" id="relationship" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Overseas Full Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="overseas_name" value="{{!empty($emergency_contact->overseas_full_name) ? $emergency_contact->overseas_full_name:''}}" id="edit_overseas_name" type="text">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Overseas Address<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_overseas_address" name="overseas_address" rows="4" cols="50">{{!empty($emergency_contact->overseas_address)?$emergency_contact->overseas_address:''}}</textarea>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Overseas Phone Number 1</label>
                        <input class="form-control" name="overseas_phone_number_1" value="{{!empty($emergency_contact->overseas_phone_number_1) ? $emergency_contact->overseas_phone_number_1:''}}" id="edit_overseas_phone_number_1" type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Overseas Phone Number 2</label>
                        <input class="form-control" name="overseas_phone_number_2" value="{{!empty($emergency_contact->overseas_phone_number_2)? $emergency_contact->overseas_phone_number_2:''}}" id="edit_overseas_phone_number_2" type="text">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Overseas Relationship</label>
                        <input class="form-control" name="overseas_relationship" value="{{!empty($emergency_contact->overseas_relationship) ? $emergency_contact->overseas_relationship:''}}" id="overseas_relationship" type="text">
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>