@if (!empty($emergency_contact))
    <div class="row">
        <div class="col-md-6">
            <div class="card card-block shadow shadow-sm p-3 h-100">
                <table class="table table-striped">
                    <tr>
                        <th>Local Contact Name</th>
                        <td>{{ !empty($emergency_contact->full_name) ? $emergency_contact->full_name : '' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ !empty($emergency_contact->address) ? $emergency_contact->address : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Phone Number 1</th>
                        <td>{{ !empty($emergency_contact->phone_number_1) ? $emergency_contact->phone_number_1 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Phone Number 2</th>
                        <td>{{ !empty($emergency_contact->phone_number_2) ? $emergency_contact->phone_number_2 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Relationship</th>
                        <td>{{ !empty($emergency_contact->relationship) ? $emergency_contact->relationship : '' }}</td>
                    </tr>
                </table>
                {{-- <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                    <a class="btn btn-primary w-100 " id="employee_contact_btn" href="javascript:void(0)"
                        data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                </div> --}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-block shadow shadow-sm p-3 h-100">
                <table class="table table-striped">
                    <tr>
                        <th>Overseas & Local Contact Name</th>
                        <td>{{!empty($emergency_contact->overseas_full_name) ? $emergency_contact->overseas_full_name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Overseas Address</th>
                        <td>{{ !empty($emergency_contact->overseas_address) ? $emergency_contact->overseas_address : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Overseas Phone Number 1</th>
                        <td>{{ !empty($emergency_contact->overseas_phone_number_1) ? $emergency_contact->overseas_phone_number_1 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Overseas Phone Number 2</th>
                        <td>{{ !empty($emergency_contact->overseas_phone_number_2) ? $emergency_contact->overseas_phone_number_2 : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Overseas Relationship</th>
                        <td>{{ !empty($emergency_contact->overseas_relationship) ? $emergency_contact->overseas_relationship : '' }}
                        </td>
                    </tr>
                </table>
                <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                    <a class="btn btn-primary w-100 " id="employee_contact_btn" href="javascript:void(0)"
                        data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="btn-group text-center col-auto" style="max-width: 200px;">
        <a class="btn btn-primary add-btn w-100 " id="employee_contact_btn" href="javascript:void(0)"
            data-toggle="modal"><i class="fa fa-plus m-r-5"></i>Add Emergency Contact</a>
    </div>
@endif
<div id="edit_contact_detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Emergency Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('emergency-contact.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id"
                                value="{{ !empty($emergency_contact->id) ? $emergency_contact->id : '' }}"
                                name="id">
                            <input type="hidden" id="emp_id"
                                value="{{ !empty($employee->id) ? $employee->id : '' }}" name="emp_id">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Local Contact Name</label>
                                        <input class="form-control" name="name"
                                            value="{{ !empty($emergency_contact->full_name) ? $emergency_contact->full_name : '' }}"
                                            id="edit_name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" id="edit_address" name="address" rows="4" cols="50">{{ !empty($emergency_contact->address) ? $emergency_contact->address : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Phone Number 1</label>
                                        <input class="form-control mask_phone_number" name="phone_number_1"
                                            value="{{ !empty($emergency_contact->phone_number_1) ? $emergency_contact->phone_number_1 : '' }}"
                                            id="edit_phone_number_1" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Phone Number 2</label>
                                        <input class="form-control mask_phone_number" name="phone_number_2"
                                            value="{{ !empty($emergency_contact->phone_number_2) ? $emergency_contact->phone_number_2 : '' }}"
                                            id="edit_phone_number_2" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Relationship</label>
                                        <input class="form-control" name="relationship"
                                            value="{{ !empty($emergency_contact->relationship) ? $emergency_contact->relationship : '' }}"
                                            id="relationship" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Overseas & Local Contact Name</label>
                                        <input class="form-control" name="overseas_name"
                                            value="{{ !empty($emergency_contact->overseas_full_name) ? $emergency_contact->overseas_full_name : '' }}"
                                            id="edit_overseas_name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Overseas Address</label>
                                        <textarea class="form-control" id="edit_overseas_address" name="overseas_address" rows="4" cols="50">{{ !empty($emergency_contact->overseas_address) ? $emergency_contact->overseas_address : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Overseas Phone Number 1</label>
                                        <input class="form-control mask_phone_number" name="overseas_phone_number_1"
                                            value="{{ !empty($emergency_contact->overseas_phone_number_1) ? $emergency_contact->overseas_phone_number_1 : '' }}"
                                            id="edit_overseas_phone_number_1" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Overseas Phone Number 2</label>
                                        <input class="form-control mask_phone_number" name="overseas_phone_number_2"
                                            value="{{ !empty($emergency_contact->overseas_phone_number_2) ? $emergency_contact->overseas_phone_number_2 : '' }}"
                                            id="edit_overseas_phone_number_2" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Overseas Relationship</label>
                                        <input class="form-control" name="overseas_relationship"
                                            value="{{ !empty($emergency_contact->overseas_relationship) ? $emergency_contact->overseas_relationship : '' }}"
                                            id="overseas_relationship" type="text">
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
