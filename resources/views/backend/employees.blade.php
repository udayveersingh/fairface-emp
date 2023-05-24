@extends('layouts.backend')

@section('styles')

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Employee</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item active">Employee</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
		<div class="view-icons">
			<a href="{{route('employees')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
			<a href="{{route('employees-list')}}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
		</div>
	</div>
</div>
@endsection

@section('content')


<div class="row staff-grid-row">
	@if (!empty($employees->count()))
	@foreach ($employees as $employee)
	<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
		<div class="profile-widget">
			<div class="profile-img">
				<a href="javascript:void(0)" class="avatar"><img alt="avatar" src="@if(!empty($employee->avatar)) {{asset('storage/employees/'.$employee->avatar)}} @else assets/img/profiles/default.jpg @endif"></a>
			</div>
			<div class="dropdown profile-action">
				<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a data-id="{{!empty($employee->id) ? $employee->id:'' }}" data-employee_id="{{$employee->employee_id}}" data-firstname="{{$employee->firstname}}" data-lastname="{{$employee->lastname}}" data-email="{{$employee->email}}" data-phone="{{$employee->phone}}" data-avatar="{{$employee->avatar}}" data-designation="" data-main_work_loc="{{!empty($employee->branch->id) ? $employee->branch->id:''}}" data-phone_number="{{$employee->alternate_phone_number}}" data-national_insurance_number="{{$employee->national_insurance_number}}" data-nationality="{{$employee->nationality}}" data-passport_number="{{$employee->passport_number}}" data-marital_status="{{$employee->marital_status}}" data-record_status="{{$employee->record_status}}" data-date_of_birth="{{$employee->date_of_birth}}" data-passport_issue_date="{{$employee->passport_issue_date}}" data-passport_expiry_date="{{$employee->passport_expiry_date}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Edit</a>
					<a data-id="{{$employee->id}}" class="dropdown-item deletebtn" data-target="#deletebtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
				</div>
			</div>
			<h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="javascript:void(0)">{{$employee->firstname}} {{$employee->lastname}}</a></h4>
		</div>
	</div>
	@endforeach
	<x-modals.delete :route="'employee.destroy'" :title="'Employee'" />
	@endif
</div>

<!-- Add Employee Modal -->
<div id="add_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Employee</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('employee.add')}}" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
								<input class="form-control" name="employee_id" type="text">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Main Work Location<span class="text-danger">*</span></label>
								<select name="branch_id" class="select form-control">
									<option value="">Select Main Work Location</option>
									@foreach ($branches as $branch)
									<option value="{{$branch->id}}">{{$branch->branch_code}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label">Employee Picture<span class="text-danger">*</span></label>
								<input class="form-control floating" name="avatar" type="file">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">First Name <span class="text-danger">*</span></label>
								<input class="form-control" name="firstname" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Last Name</label>
								<input class="form-control" name="lastname" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Phone Number Main </label>
								<input class="form-control" name="phone" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Alternate Phone Number</label>
								<input class="form-control" name="al_phone_number" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control" name="email" type="email">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Date of Birth</label>
								<input class="form-control edit_date_of_birth" name="date_of_birth" type="date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">National Insurance Number</label>
								<input class="form-control edit_insurance_number" name="nat_insurance_number" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nationality <span class="text-danger">*</span></label>
								<select name="nationality" class="select form-control">
									<option value="">Select Nationality</option>
									<option value="india">India</option>
									<option value="australia">Australia</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Number</label>
								<input class="form-control edit_passport_number" name="passport_number" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Issue Date</label>
								<input class="form-control edit_pass_issue_date" name="pass_issue_date" type="date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Expire Date</label>
								<input class="form-control edit_pass_expire_date" name="pass_expire_date" type="date">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Marital Status <span class="text-danger">*</span></label>
								<select name="marital_status" class="select form-control">
									<option value="">Select Marital Status</option>
									<option value="married">Married</option>
									<option value="unmarried">Unmarried</option>
									<option value="divorced">Divorced</option>
									<option value="widowed">Widowed</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Record Status <span class="text-danger">*</span></label>
								<select name="record_status" class="select form-control">
									<option value="">Select Record Status</option>
									<option value="active">Active</option>
									<option value="archieve">Archieve</option>
									<option value="delete">Delete</option>
								</select>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Employee Modal -->

<!-- Edit Employee Modal -->
<div id="edit_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Employee</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('employee.update')}}" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="row">
						<input type="hidden" name="id" id="edit_id">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
								<input class="form-control" id="edit_employee_id" name="employee_id" type="text">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Main Work Location<span class="text-danger">*</span></label>
								<select name="branch_id" id="edit_main_work_loc" class="select form-control">
									<option>Select Main Work Location</option>
									@foreach ($branches as $branch)
									<option value="{{$branch->id}}">{{$branch->branch_code}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="col-form-label">Employee Picture<span class="text-danger">*</span></label>
								<input class="form-control floating" name="avatar" type="file">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">First Name <span class="text-danger">*</span></label>
								<input class="form-control edit_firstname" name="firstname" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Last Name</label>
								<input class="form-control edit_lastname" name="lastname" type="text">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Phone Number Main </label>
								<input class="form-control edit_phone" name="phone" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Alternate Phone Number</label>
								<input class="form-control edit_al_phone_number" name="al_phone_number" type="text">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control edit_email" name="email" type="email">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Date of Birth</label>
								<input class="form-control edit_date_of_birth" name="date_of_birth" type="date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">National Insurance Number</label>
								<input class="form-control edit_insurance_number" name="nat_insurance_number" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nationality <span class="text-danger">*</span></label>
								<select name="nationality" id="nationality" class="select form-control">
									<option value="">Select Nationality</option>
									<option value="india">India</option>
									<option value="australia">Australia</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Number</label>
								<input class="form-control edit_passport_number" name="passport_number" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Issue Date</label>
								<input class="form-control edit_pass_issue_date" name="pass_issue_date" type="date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Passport Expire Date</label>
								<input class="form-control edit_pass_expire_date" name="pass_expire_date" type="date">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Marital Status <span class="text-danger">*</span></label>
								<select name="marital_status" id="marital_status" class="select form-control">
									<option value="">Select Marital Status</option>
									<option value="married">Married</option>
									<option value="unmarried">Unmarried</option>
									<option value="divorced">Divorced</option>
									<option value="widowed">Widowed</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Record Status <span class="text-danger">*</span></label>
								<select name="record_status" selected="selected" id="record_status" class="select form-control">
									<option value="">Select Record Status</option>
									<option value="active">Active</option>
									<option value="archieve">Archieve</option>
									<option value="delete">Delete</option>
								</select>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Employee Modal -->
@endsection

@section('scripts')
<script>
	$(document).ready(function() {
		$('.editbtn').on('click', function() {
			$('#edit_employee').modal('show');
			var id = $(this).data('id');
			var employee_id = $(this).data('employee_id');
			var main_work_loc = $(this).data('main_work_loc');
			var firstname = $(this).data('firstname');
			var lastname = $(this).data('lastname');
			var email = $(this).data('email');
			var phone = $(this).data('phone');
			var avatar = $(this).data('avatar');
			var company = $(this).data('company');
			// var designation = $(this).data('designation');
			var department = $(this).data('department');
			var al_phone_number = $(this).data('alternate_phone_number');
			var national_insurance_number = $(this).data('national_insurance_number');
			var nationality = $(this).data('nationality');
			var passport_number = $(this).data('passport_number');
			var marital_status = $(this).data('marital_status');
			var record_status = $(this).data('record_status');
			var date_of_birth = $(this).data('date_of_birth');
			var passport_issue_date = $(this).data('passport_issue_date');
			var passport_expiry_date = $(this).data('passport_expiry_date');
			$('#edit_id').val(id);
			$('#edit_employee_id').val(employee_id);
			$('#edit_main_work_loc').val(main_work_loc);
			$('.edit_firstname').val(firstname);
			$('.edit_lastname').val(lastname);
			$('.edit_email').val(email);
			$('.edit_phone').val(phone);
			$('.edit_company').val(company);
			// $('.edit_designation').val(designation);
			$('#edit_department').val(department).attr('selected');
			$('.edit_avatar').attr('src', avatar);
			$('.edit_al_phone_number').val(al_phone_number);
			$('.edit_insurance_number').val(national_insurance_number);
			$('.edit_passport_number').val(passport_number);
			$('.edit_pass_issue_date').val(passport_issue_date);
			$('.edit_pass_expire_date').val(passport_expiry_date);
			$('#nationality').val(nationality);
			$('#marital_status').val(marital_status);
			$('#record_status').val(record_status);
			$('.edit_date_of_birth').val(date_of_birth);
		})
	})
</script>
@endsection