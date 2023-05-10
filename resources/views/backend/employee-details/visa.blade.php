@extends('layouts.backend-detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('employee-visa.update')}}">
            @csrf
            @method("PUT")
            <input type="hidden" id="edit_id" value="{{$employee_visa->id}}" name="id">
            <input type="hidden" value="{{$employee->id}}" id="emp_id" name="emp_id">
            <div class="row">
                <div class="col-sm-6">
                    <label>Visa Type</label>
                    <select name="visa_type" id="visa_type" class="select form-control">
                        <option value="">Select Visa Type</option>
                        @foreach($visa_types as $type)
                        <option value="{{$type->id}}"{{$employee_visa->visa_type == $type->id ? 'selected' : ''}}>{{$type->visa_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Cos Number</label>
                        <input class="form-control" value="{{$employee_visa->cos_number}}" name="cos_number" id="edit_cos_number" type="text">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Cos Issue Date</label>
                        <input class="form-control" value="{{$employee_visa->cos_issue_date}}" name="cos_issue_date" id="edit_cos_issue_date" type="date">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Cos Expiry Date</label>
                        <input class="form-control" value="{{$employee_visa->cos_expiry_date}}" name="cos_expiry_date" id="edit_cos_expiry_date" type="date">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Visa Issue Date</label>
                        <input class="form-control" name="visa_issue_date" id="edit_visa_issue_date" value="{{$employee_visa->visa_issue_date}}" type="date">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Visa Expiry Date</label>
                        <input class="form-control" name="visa_expiry_date"  value="{{$employee_visa->visa_expiry_date}}" id="edit_visa_expiry_date" type="date">
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