@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    {{-- @endsection --}}
    {{-- @section('page-header')
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Employee TimeSheet</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employee-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employee TimeSheet</li>
            </ul>
        </div>
        {{-- <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee_timesheet"><i
                    class="fa fa-plus"></i>Add Employee TimeSheet</a>
        </div> --}}
    {{-- </div>
@endsection --}}
@section('content')
    {{-- <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Employee Name </label>
                    <input class="form-control" name="employee_name" value="" type="text">
                </div>
            </div>
            <div class="col-sm-6">
                @php
                    $date = new DateTime('now');
                    $date->modify('last day of this month');
                @endphp
                <div class="form-group">
                    <label class="col-form-label">Month Ending</label>
                    <input class="form-control" name="month_ending" value="{{ $date->format('Y-m-d') }}" type="text">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label">Designation</label>
                    <input class="form-control" name="month_ending"
                        value="{{ !empty($employee_timesheets->projectphase->name) ? $employee_timesheets->projectphase->name : '' }}"
                        type="text">
                </div>
            </div>
            <div class="col-lg-6">
                <label>TimeSheet Interval</label>
                <select name="timesheet_interval" class="form-control select">
                    <option value="">Select</option>
                    <option value="weekly"
                        {{ !empty($settings->timesheet_interval) && $settings->timesheet_interval == 'weekly' ? 'checked' : '' }}>
                        weekly</option>
                    <option value="monthly"
                        {{ !empty($settings->timesheet_interval) && $settings->timesheet_interval == 'monthly' ? 'checked' : '' }}>
                        monthly</option>
                </select>
            </div>
        </div>
        </div>
    </form> --}}
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Indus Services Limited</h1>
                <h3 class="text-left">Employee Time Sheet</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Employee Name:- <span>{{ Auth::user()->name }}</span></div>
            @php
                $date = new DateTime('now');
                $date->modify('last day of this month');
                $first_day = new DateTime('now');
                $first_day->modify('first day of this month');
            @endphp
            <div class="col-md-6">Month Ending:- <span>{{ $date->format('d-m-Y') }}</span></div>
            <div class="col-md-6">Designation:- <span>Business Analyst </span></div>
            <div class="col-md-12">
                <p class="mb-0 mx-0">This form must be signed by your manager</p>
                <p class="mt-0 mx-0"><strong>Record start and finish times as well as total daily hours worked. Record
                        weekly and monthly hours and days.</strong></p>
            </div>
        </div>

        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <p class="mx-0">Week starting:- <strong>{{ $first_day->format('d-m-Y') }}</strong></p>
                    <table class="table">
                        <tr>
                            <td></td>
                            <td>#</td>
                            <td>Start Time</td>
                            <td>Finish Time</td>
                            <td>Break</td>
                            <td>1/2 or 1 Day</td>
                        </tr>

                        @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        @endphp
                        @foreach ($days as $index => $day )
                        <tr>
                            <td>{{$day}}</td>
                            <td>{{$index + 1}}</td>
                            <td><input name="start_time" value="" type="time"></td>
                            <td><input name="end_time" value="" type="time"></td>
                            <td><input name="break_time" value="" type="time"></td>
                            <td>
                                <select name="half_full_day" id="half_full_day">
                                    <option value="">Select Day</option>
                                    <option value="half_day">Half day</option>
                                    <option value="full_day">Full day</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                        {{-- <tr>
                            <td>Tue</td>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Wed</td>
                            <td>3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Thur</td>
                            <td>4</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Fri</td>
                            <td>5</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Sat</td>
                            <td>6</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Sun</td>
                            <td>7</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> --}}
                        <tr>
                            <td colspan="5" align="end">Total</td>
                            <td>4</td>
                        </tr>
                    </table>
                </div>
                {{-- <div class="col-md-6">
				<p class="mx-0">Week starting:- <strong>5/8/2023	</strong></p>
				<table class="table">
					<tr>						
						<td></td>
						<td>#</td>
						<td>Start Time</td>
						<td>Finish Time</td>
						<td>Break</td>
						<td>1/2 or 1 Day</td>
					</tr>
					<tr>						
						<td>Mon</td>
						<td>8</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td>Tue</td>
						<td>9</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Wed</td>
						<td>10</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Thur</td>
						<td>11</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Fri</td>
						<td>12</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Sat</td>
						<td>13</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td>Sun</td>
						<td>14</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td colspan="5" align="end">Total</td>
						<td>4</td>
					</tr>
				</table>
			</div> --}}
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <p class="mx-0"><strong>Total Days to be paid for Month Ending:- </strong></p>
                <div class="row mb-3">
                    <div class="col-10">
                        Employee Confirmation:<br />
                        <small>I confirm that this is an accurate record of the times I have worked </small>

                    </div>
                    <div class="col-2 text-right"> 20 Days
                        <div>Signature: <strong>Lavanya Kolli</strong></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        Client Manager Confirmation:<br />
                        <small>Client Manager Confirmation:</small>

                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">Name: </div>
                            <div class="col-6">Signature: </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
