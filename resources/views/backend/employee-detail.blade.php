@extends('layouts.backend-detail')

@section('content')
<?php
$tabs = [
    'document' => "Document",
    'job'      => 'job',
    'visa'     => "Visa",
    'project'  => "Project",
    'contact'  => 'Contact',
    'address'  => "Address",
    'bank'     => "Bank",
    'payslip'  => "Payslip",
];
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="basic_info-tab" data-toggle="tab" href="#basic_info" role="tab" aria-controls="basic_info" aria-selected="true">Basic Info</a>
    </li>
    @foreach($tabs as $index=>$tab)
    <li class="nav-item">
        <a class="nav-link" id="{{$index}}-tab" data-toggle="tab" href="#{{$index}}" role="tab" aria-controls="{{$index}}" aria-selected="true">{{$tab}}</a>
    </li>
    @endforeach
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="basic_info" role="tabpanel" aria-labelledby="basic_info-tab">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{route('employee.update')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" value="{{$employee->id}}" id="edit_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                <input class="form-control edit_firstname" name="firstname" value="{{$employee->firstname}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Last Name</label>
                                <input class="form-control edit_lastname" name="lastname" value="{{$employee->lastname}}" type="text">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input class="form-control edit_email" value="{{$employee->email}}" name="email" type="email">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Phone </label>
                                <input class="form-control edit_phone" name="phone" value="{{$employee->phone}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Alternate Phone Number</label>
                                <input class="form-control edit_al_phone_number" name="al_phone_number" value="{{$employee->alternate_phone_number}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Date of Birth</label>
                                <input class="form-control edit_date_of_birth" name="date_of_birth" value="{{$employee->date_of_birth}}" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Company</label>
                                <input type="text" class="form-control edit_company" value="{{$employee->company}}" name="company">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">National Insurance Number</label>
                                <input class="form-control edit_insurance_number" name="nat_insurance_number" value="{{$employee->national_insurance_number}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Passport Number</label>
                                <input class="form-control edit_passport_number" name="passport_number" value="{{$employee->passport_number}}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Passport Issue Date</label>
                                <input class="form-control edit_pass_issue_date" name="pass_issue_date" value="{{$employee->passport_issue_date}}" type="date">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="col-form-label">Passport Expire Date</label>
                                <input class="form-control edit_pass_expire_date" name="pass_expire_date" value="{{$employee->passport_expiry_date}}" type="date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nationality <span class="text-danger">*</span></label>
                                <select name="nationality" id="nationality" class="select form-control">
                                    <option value="">Select Nationality</option>
                                    <option value="india" {{ $employee->nationality == "india"  ? 'selected' : ''}}>India</option>
                                    <option value="australia" {{ $employee->nationality == "australia"  ? 'selected' : ''}}>Australia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Marital Status <span class="text-danger">*</span></label>
                                <select name="marital_status" id="marital_status" class="select form-control">
                                    <option value="">Select Marital Status</option>
                                    <option value="married" {{ $employee->marital_status == "married"  ? 'selected' : ''}}>Married</option>
                                    <option value="unmarried" {{ $employee->marital_status == "unmarried"  ? 'selected' : ''}}>Unmarried</option>
                                    <option value="divorced" {{ $employee->marital_status == "divorced"  ? 'selected' : ''}}>Divorced</option>
                                    <option value="widowed" {{ $employee->marital_status == "widowed"  ? 'selected' : ''}}>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Record Status <span class="text-danger">*</span></label>
                                <select name="record_status" id="record_status" class="select form-control">
                                    <option>Select Record Status</option>
                                    <option value="active" {{ $employee->record_status == "active"  ? 'selected' : ''}}>Active</option>
                                    <option value="inactive" {{ $employee->record_status == "inactive"  ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Designation <span class="text-danger">*</span></label>
                                <select name="designation" selected="selected" class="select edit_designation form-control">
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                    <option value="{{$designation->id}}" {{ $employee->designation_id == $designation->id ? 'selected' : ''}}>{{$designation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Employee Picture<span class="text-danger">*</span></label>
                                <input class="form-control floating edit_avatar" name="avatar" type="file">
                            </div>
                            <img alt="avatar" src="@if(!empty($employee->avatar)) {{asset('storage/employees/'.$employee->avatar)}} @else assets/img/profiles/default.jpg @endif" width="100px"><br>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($tabs as $index=>$tab)
    <div class="tab-pane fade" id="{{$index}}" role="tabpanel" aria-labelledby="{{$index}}-tab">
        @include("backend.employee-details.{$index}")
    </div>
    @endforeach
</div>
<!-- Delete Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete {{ucfirst($title)}}</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <form action="" method="post">
                    @method("DELETE")
                    @csrf
                    <input type="hidden" id="delete_id" name="id">
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary continue-btn btn-block" type="submit">Delete</button>
                            </div>
                            <div class="col-6">
                                <button data-dismiss="modal" class="btn btn-primary cancel-btn btn-block">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete  Modal -->






@endsection
<script src="http://127.0.0.1:8000/assets/js/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(this).attr('href'));
            test = $(this).attr('href');
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('[href="' + activeTab + '"]').tab('show');
        }
    });
</script>