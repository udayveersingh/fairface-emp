@extends('layouts.backend')

@section('styles')
    <!-- Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
@endsection

@section('page-header')
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Welcome {{ auth()->user()->username }}!</h3>     
                <!-- <li class="breadcrumb-item active">Dashboard</li> -->
                @if(count($annoucement_list)>0)
                    <div id="carouselExampleFade" class="carousel announcement_slider alert-primary p-3 rounded slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($annoucement_list as $key=>$annoucement)
                        <div class="carousel-item {{ $key==0?'active':'' }}"> 
                            <strong>{{ $annoucement->description }}</strong>
                        </div>
                        @endforeach
                    </div>  
                    <ol class="carousel-indicators" style="right:20px; left:auto; margin-right:0;">
                        @foreach($annoucement_list as $key=>$annoucement)
                            <li data-target="#carouselExampleFade" data-slide-to="{{ $key }}" class=""></li>
                        @endforeach
                    </ol>
                    </div>
                @endif        
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ !empty($employee_count) ? $employee_count : '0' }}</h3>
                        <span>Active Employee</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{ $passport_expiry_six_month }}</h3>
                        <span>Passport Expiry in next 6 months.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                    <div class="dash-widget-info">
                        <h3>
                            {{ $visa_expiry_six_month }}
                        </h3>
                        <span>Visa Expiry in next 6 months.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>
                            {{ $cos_expiry_six_month }}
                        </h3>
                        <span>Cos Expiry in next 6 months.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Total Revenue</h3>
                        <div id="bar-charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Sales Overview</h3>
                        <div id="line-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    {{-- <div class="row">
    <div class="col-md-12">
        <div class="card-group m-b-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">New Employees</span>
                        </div>
                        <div>
                            <span class="text-success">+10%</span>
                        </div>
                    </div>
                    <h3 class="mb-3">10</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Overall Employees 218</p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Earnings</span>
                        </div>
                        <div>
                            <span class="text-success">+12.5%</span>
                        </div>
                    </div>
                    <h3 class="mb-3">$1,42,300</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Expenses</span>
                        </div>
                        <div>
                            <span class="text-danger">-2.8%</span>
                        </div>
                    </div>
                    <h3 class="mb-3">$8,500</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Profit</span>
                        </div>
                        <div>
                            <span class="text-danger">-75%</span>
                        </div>
                    </div>
                    <h3 class="mb-3">$1,12,000</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                </div>
            </div>
        </div>
    </div>	
</div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card-group m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Total Timesheets Past Month</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $timesheet_submitted_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Approved Timesheets</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $timesheet_approval_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Pending Approval</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $timesheet_pending_app_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Rejected Timesheets</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $timesheet_rejected_count }}</h4>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-group m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Total Leave Applications Past Month</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $leaves_submitted_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Approved Leaves</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $leaves_approval_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Pending Approval Leaves</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $leaves_pending_app_count }}</h4>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <span class="d-block">Rejected Leaves</span>
                            </div>
                        </div>
                        <p class="mb-0">
                        <h4>{{ $leaves_rejected_count }}</h4>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Statistics Widget -->
   {{-- <div class="row">
         <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
        <div class="card flex-fill dash-statistics">
            <div class="card-body">
                <h5 class="card-title">Statistics</h5>
                <div class="stats-list">
                    <div class="stats-info">
                        <p>Today Leave <strong>4 <small>/ 65</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

        {{-- <div class="col-md-12 col-lg-6 col-xl-4 d-flex"> --}}
        {{-- <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Task Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Total Tasks</p>
                                <h3>385</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Overdue Tasks</p>
                                <h3>19</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-4">
                    <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                    <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                </div>
                <div>
                    <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right">166</span></p>
                    <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">115</span></p>
                    <p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Tasks <span class="float-right">31</span></p>
                    <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>
                    <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p>
                </div>
            </div>
        </div> --}}
        {{-- </div> --}}

        {{-- <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <h4 class="card-title">Recent Timesheet<span class="badge bg-inverse-danger ml-2"></span></h4>
                    <div class="card-scroll p-1">
                        @if (count(sendNewTimeSheetNotifiaction()) > 0)
                            @foreach (sendNewTimeSheetNotifiaction() as $notification)
                                @php
                                    $employee = App\Models\Employee::find($notification->from);
                                    $emp_first_name = !empty($employee->firstname) ? $employee->firstname : '';
                                    $emp_last_name = !empty($employee->lastname) ? $employee->lastname : '';
                                    $emp_fullname = $emp_first_name . ' ' . $emp_last_name;
                                    $timesheet_id = '';
                                    if (isset($notification->timesheet_id)) {
                                        $timesheet_id = $notification->timesheet_id;
                                    } else {
                                        $timesheet_id = '';
                                    }
                                    $created_at='';
                                    if (isset($notification->created_at)) {
                                        $created_at = date_format(date_create($notification->created_at), 'd M,Y');
                                    } else {
                                        $created_at = '';
                                    }
                                @endphp
                                <div class="leave-info-box">
                                    <div class="media align-items-center">
                                        <a href="profile.html" class="avatar">
                                            <img
                                                src="{{ !empty($employee->avatar) ? asset('storage/employees/' . $employee->avatar) : asset('assets/img/user.jpg') }}"></a>
                                        <div class="media-body">
                                            <div class="text-sm my-0">{{ ucfirst($emp_fullname) }} submitted new
                                                timesheet <a
                                                    href="{{ route('employee-timesheet-detail', ['id' => $notification->from, 'start_date' => $notification->from_date, 'end_date' => $notification->to_date]) }}">{{ '<' . $timesheet_id . '>' }}</a>
                                                on date:
                                                {{$created_at }}</div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6>
                                    <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="badge bg-inverse-danger">Notification</span>
                                </div>
                            </div>
                                </div>
                            @endforeach
                        @else
                            <div class="media align-items-center">
                                <div class="text-sm my-0">No record</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
        <div class="col-md-7 col-lg-7 col-xl-7 d-flex">
            <div class="card card-table flex-fill">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap custom-table mb-0">
                            <thead>
                            <tr>
                                <th>Emp. ID</th>
                                <th>Employee</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($passport_expiry_list as $user_pass_list)
                                <tr>
                                    <td>{{ $user_pass_list->employee_id }}</td>
                                    <td> <h2><a href='/employee-detail/{{$user_pass_list->id }}'>{{ $user_pass_list->firstname.' '.$user_pass_list->lastname }}</a></h2></td>
                                    <td>{{  date('d-m-Y',strtotime($user_pass_list->passport_expiry_date)) }}</td>
                                    <td>
                                    <span class="badge bg-inverse-warning">Paasport Expiry</span>
                                    </td>
                                    <td><a href="{{route('send-reminder-mail',[$user_pass_list->id,'type' =>'Passport'])}}" class="btn-sm btn-primary editbtn">Send Reminder</a></td>
                                </tr>
                                @endforeach
                                @foreach($visa_expiry_list as $user_visa_list)
                                <tr>
                                    <td>{{ $user_visa_list->employee_id }}</td>
                                    <td> <h2><a href='/employee-detail/{{$user_visa_list->id }}'>{{ $user_visa_list->firstname.' '.$user_visa_list->lastname }}</a></h2></td>
                                    <td>{{ date('d-m-Y',strtotime($user_visa_list->visa_expiry_date)) }}</td>
                                    <td>
                                    <span class="badge bg-inverse-danger">Visa Expiry</span>
                                    </td>
                                    <td> <a href="{{route('send-reminder-mail',[$user_visa_list->id,'type' =>'visa'])}}" class="btn-sm btn-primary editbtn">Send Reminder</a></td>
                                </tr>
                                @endforeach
                                @foreach($cos_expiry_list as $user_cos_list)
                                <tr>
                                    <td>{{ $user_cos_list->employee_id }}</td>
                                    <td> <h2><a href='/employee-detail/{{$user_cos_list->id }}'>{{ $user_cos_list->firstname.' '.$user_cos_list->lastname }}</a></h2></td>
                                    <td>{{ date('d-m-Y',strtotime($user_cos_list->cos_expiry_date)) }}</td>
                                    <td>
                                    <span class="badge bg-inverse-success">COS Expiry</span>
                                    </td>
                                    <td> <a href="{{route('send-reminder-mail',[$user_cos_list->id,'type'=>'cos'])}}" class="btn-sm btn-primary editbtn">Send Reminder</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-5 col-xl-5 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <h4 class="card-title">Employee Notifications<span class="badge bg-inverse-danger ml-2"></span></h4>
                    <div class="card-scroll p-1">
                        @if (count(sendNewTimeSheetNotifiaction()) > 0)
                            @foreach (sendNewTimeSheetNotifiaction() as $notification)
                                @php
                                    $employee = App\Models\Employee::find($notification->from);
                                    $emp_first_name = !empty($employee->firstname) ? $employee->firstname : '';
                                    $emp_last_name = !empty($employee->lastname) ? $employee->lastname : '';
                                    $emp_fullname = $emp_first_name . ' ' . $emp_last_name;
                                @endphp
                                <div class="leave-info-box">
                                    <div class="media align-items-center">
                                        <a href="" class="avatar">
                                            <img
                                                src="{{ !empty($employee->avatar) ? asset('storage/employees/' . $employee->avatar) : asset('assets/img/user.jpg') }}"></a>
                                        <div class="media-body">
                                            <p class="noti-details"><span
                                                    class="noti-title">{{ Ucfirst($emp_fullname) }}</span>
                                                <span class="noti-title">added new TimeSheet.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @foreach (getNewLeaveNotifiaction() as $notification)
                            @php
                                $leave = App\Models\Leave::with('leaveType', 'employee', 'time_sheet_status')->find($notification->leave);
                                $emp_first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname : '';
                                $emp_last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname : '';
                                $emp_full_name = $emp_first_name . ' ' . $emp_last_name;
                            @endphp
                            <div class="leave-info-box">
                                <div class="media align-items-center">
                                    <a href="" class="avatar">
                                        <img
                                            src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}"></a>
                                    <div class="media-body">
                                        <p class="noti-details"><span
                                                class="noti-title">{{ ucfirst($emp_full_name) }}</span>
                                            <span class="noti-title">added new
                                                {{ !empty($leave->leaveType->type) ? $leave->leaveType->type : '' }}.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <h4 class="card-title">Recent Emails <span class="badge bg-inverse-danger ml-2"></span></h4>
                    <div class="card-scroll p-1">
                        @foreach (getEmailCounts() as $company_email)
                            @php
                                $from = App\Models\EmployeeJob::with('employee')
                                    ->where('id', '=', $company_email->from_id)
                                    ->first();
                                $from_first_name = !empty($from->employee->firstname) ? $from->employee->firstname : '';
                                $from_last_name = !empty($from->employee->lastname) ? $from->employee->lastname : '';
                                $fullname = $from_first_name . ' ' . $from_last_name;
                                $to = App\Models\EmployeeJob::with('employee')
                                    ->where('id', '=', $company_email->to_id)
                                    ->first();
                                $to_first_name = !empty($to->employee->firstname) ? $to->employee->firstname : '';
                                $to_last_name = !empty($to->employee->lastname) ? $to->employee->lastname : '';
                                $to_fullname = $to_first_name . ' ' . $to_last_name;
                            @endphp
                            <div class="leave-info-box">
                                <div class="media align-items-center">
                                    <a href="profile.html" class="avatar"><img alt=""
                                            src="assets/img/user.jpg"></a>
                                    <div class="media-body">
                                        <div class="text-sm my-0">{{ ucfirst($fullname) }}</div>
                                    </div>
                                </div>
                                <div class="row align-items-center mt-3">
                                    <div class="col-6">
                                        <h6 class="mb-0">{{ date_format($company_email->created_at, 'Y-m-d') }}</h6>
                                        <span class="text-sm text-muted">Leave Date</span>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a
                                            href="{{ route('mail-detail', ['from' => encrypt($company_email->from_id), 'to' => $company_email->to_id]) }}"><span
                                                class="badge bg-inverse-danger">Read More</span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="leave-info-box">
                        <div class="media align-items-center">
                            <a href="profile.html" class="avatar"><img alt="" src="assets/img/user.jpg"></a>
                            <div class="media-body">
                                <div class="text-sm my-0">Martin Lewis</div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-6">
                                <h6 class="mb-0">4 Sep 2019</h6>
                                <span class="text-sm text-muted">Leave Date</span>
                            </div>
                            <div class="col-6 text-right">
                                <span class="badge bg-inverse-success">Annoucement</span>
                            </div>
                        </div>
                    </div>
                    <div class="load-more text-center">
                        <a class="text-dark" href="javascript:void(0);">Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Statistics Widget -->
@endsection
@section('scripts')
    <!-- Chart JS -->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/js/chart.js"></script>
@endsection
