@extends('layouts.backend-detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('employee-bank.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id" value="{{!empty($employee_bank->id) ? $employee_bank->id:''}}" name="id">
            <input type="hidden" value="{{!empty($employee->id) ? $employee->id:''}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Bank Account Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="account_name"  value="{{!empty($employee_bank->account_name) ? $employee_bank->account_name:''}}" id="edit_account_name" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Bank Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="bank_name"  value="{{!empty($employee_bank->bank_name) ? $employee_bank->bank_name:''}}" id="edit_bank_name" type="text">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Bank Account Number</label>
                        <input class="form-control" name="account_number" value="{{!empty($employee_bank->bank_account_number) ? $employee_bank->bank_account_number:'' }}" id="edit_account_number"  type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Bank Sort Code</label>
                        <input class="form-control" name="bank_sort_code" value="{{!empty($employee_bank->bank_sort_code) ? $employee_bank->bank_sort_code:''}}" id="edit_sort_code" type="text">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Ifsc Code</label>
                        <input class="form-control" name="ifsc_code" id="edit_ifsc_code"value="{{!empty($employee_bank->ifsc_code) ? $employee_bank->ifsc_code:'' }}" type="text">
                    </div>
                </div>
            </div>
            <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection