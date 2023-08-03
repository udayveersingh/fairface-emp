@extends('layouts.backend')

@section('styles')
	
@endsection

@section('page-header')
<div class="row">
	<div class="col-sm-12">
		<h3 class="page-title">Activities</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item active">Activities</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="activity">
			<div class="activity-box">

				<ul class="activity-list">
                    {{-- @dd(getNewLeaveNotifiaction()); --}}
					@if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
					@foreach(getNewLeaveNotifiaction() as $notification)
					@php
						$leave = App\Models\Leave::with('leaveType','employee', 'time_sheet_status')->find($notification->leave);
						$emp_first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname:'';
						$emp_last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname:'';
						$emp_full_name = $emp_first_name." ".$emp_last_name;
					@endphp
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
								<img src="{{!empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="" class="name">{{ucfirst($emp_full_name)}}</a> added new {{!empty($leave->leaveType->type) ? $leave->leaveType->type:''}} on date from {{$notification->from_date}} to {{$notification->to_date}}
								<span class="time">{{$leave->created_at->diffForHumans()}}</span>
							</div>
						</div>
					</li>
					@endforeach
					@endif
					{{-- <li>
						<div class="activity-user">
							<a href="profile.html" class="avatar" title="Jeffery Lalor" data-toggle="tooltip">
								<img src="assets/img/profiles/avatar-16.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">Jeffery Lalor</a> added <a href="profile.html" class="name">Loren Gatlin</a> and <a href="profile.html" class="name">Tarah Shropshire</a> to project <a href="#">Patient appointment booking</a>
								<span class="time">6 mins ago</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Catherine Manseau" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-08.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">Catherine Manseau</a> completed task <a href="#">Appointment booking with payment gateway</a>
								<span class="time">12 mins ago</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="#" title="Bernardo Galaviz" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-13.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">Bernardo Galaviz</a> changed the task name <a href="#">Doctor available module</a>
								<span class="time">1 day ago</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Mike Litorus" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-05.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">Mike Litorus</a> added new task <a href="#">Patient and Doctor video conferencing</a>
								<span class="time">2 days ago</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Jeffery Lalor" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-16.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">Jeffery Lalor</a> added <a href="profile.html" class="name">Jeffrey Warden</a> and <a href="profile.html" class="name">Bernardo Galaviz</a> to the task of <a href="#">Private chat module</a>
								<span class="time">7 days ago</span>
							</div>
						</div>
					</li> --}}
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection


@section('scripts')
	
@endsection