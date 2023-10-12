@if (!empty($employee_bank))
    <div class="row">
        <div class="col-md-8">
            <div class="card card-block shadow shadow-sm p-3 h-100">
                <table class="table table-striped">
                    <tr>
                        <th>Bank Account Name</th>
                        <td>{{ !empty($employee_bank->account_name) ? $employee_bank->account_name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Bank Name</th>
                        <td>{{ !empty($employee_bank->bank_name) ? $employee_bank->bank_name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Bank Account Number</th>
                        <td>{{ !empty($employee_bank->bank_account_number) ? $employee_bank->bank_account_number : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Bank Sort Code</th>
                        <td>{{ !empty($employee_bank->bank_sort_code) ? $employee_bank->bank_sort_code : '' }}</td>
                    </tr>
                    <tr>
                        <th>Ifsc Code</th>
                        <td>{{ !empty($employee_bank->ifsc_code) ? $employee_bank->ifsc_code : '' }}</td>
                    </tr>
                </table>
                <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
                    <a class="btn btn-primary w-100 " id="employee_bank_btn" href="javascript:void(0)"
                        data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="btn-group text-center mx-auto mt-auto" style="max-width: 200px;">
        <a class="btn btn-primary w-100 add-btn" id="employee_bank_btn" href="javascript:void(0)" data-toggle="modal"><i
                class="fa fa-plus m-r-5"></i> Add Bank</a>
    </div>
@endif

<div id="edit_bank_detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content ml-5">
            <div class="modal-header">
                <h5 class="modal-title">Employee Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('employee-bank.update') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id"
                                value="{{ !empty($employee_bank->id) ? $employee_bank->id : '' }}" name="id">
                            <input type="hidden" value="{{ !empty($employee->id) ? $employee->id : '' }}"
                                id="emp_id" name="emp_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Account Name<span class="text-danger">*</span></label>
                                        <input class="form-control" name="account_name" required
                                            value="{{ !empty($employee_bank->account_name) ? $employee_bank->account_name : '' }}"
                                            id="edit_account_name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Name<span class="text-danger">*</span></label>
                                        <input class="form-control" name="bank_name" required
                                            value="{{ !empty($employee_bank->bank_name) ? $employee_bank->bank_name : '' }}"
                                            id="edit_bank_name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Account Number <span class="text-danger">*</span></label>
                                        <input class="form-control" name="account_number" required
                                            value="{{ !empty($employee_bank->bank_account_number) ? $employee_bank->bank_account_number : '' }}"
                                            id="edit_account_number" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Sort Code</label>
                                        <input class="form-control" name="bank_sort_code"
                                            value="{{ !empty($employee_bank->bank_sort_code) ? $employee_bank->bank_sort_code : '' }}"
                                            id="edit_sort_code" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Ifsc Code</label>
                                        <input class="form-control" name="ifsc_code"
                                            id="edit_ifsc_code"value="{{ !empty($employee_bank->ifsc_code) ? $employee_bank->ifsc_code : '' }}"
                                            type="text">
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
