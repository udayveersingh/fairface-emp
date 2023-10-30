@extends('layouts.backend')

@section('styles')
@endsection
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="welcome-box">
                    <div class="welcome-img">
                        <img alt src="assets/img/profiles/avatar-02.jpg">
                    </div>
                    <div class="welcome-det">
                        <h3>Welcome,{{ Auth::user()->name }}</h3>
                        @php
                            $date = Carbon\Carbon::now();
                            $formatedDate = $date->format('l' . ',' . 'd M Y');
                        @endphp
                        <p>{{ $formatedDate }}</p>
                    </div>
                </div>
            </div>
            @if (count($annoucement_list) > 0)
                <h1 class="dash-sec-title ml-3">Latest Annoucements</h1>
                <div class="col-md-12 mb-4">
                    <div id="carouselExampleFade"
                        class="carousel announcement_slider alert-primary p-3 rounded slide carousel-fade"
                        data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($annoucement_list as $key => $annoucement)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <strong>{{ $annoucement->description }}</strong>
                                </div>
                            @endforeach
                        </div>
                        <ol class="carousel-indicators" style="right:20px; left:auto; margin-right:0;">
                            @foreach ($annoucement_list as $key => $annoucement)
                                <li data-target="#carouselExampleFade" data-slide-to="{{ $key }}" class="">
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @endif
        </div>
        <section>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <h1 class="dash-sec-title">Recent Status</h1>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="request-btn">
                                <div class="dash-stats-list">
                                    @if (!empty($total_annual_leaves) && $total_annual_leaves > 0)
                                        <h4>{{$total_annual_leaves }}</h4>
                                    @else
                                        <h4>0</h4>
                                    @endif
                                    <p>Total Annual Leaves</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="request-btn">
                                <div class="dash-stats-list">
                                    @if (!empty($employee_leaves) && $employee_leaves > 0)
                                        <h4>{{ $employee_leaves }}</h4>
                                    @else
                                        <h4>0</h4>
                                    @endif
                                    <p>Annual Leaves Taken</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="request-btn">
                                <div class="dash-stats-list">
                                    @if (!empty($remaining_leaves) && $remaining_leaves > 0)
                                        <h4>{{ $remaining_leaves }}</h4>
                                    @else
                                        <h4>0</h4>
                                    @endif
                                    <p>Balance Annual Leaves</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="request-btn">
                                <div class="dash-stats-list">
                                    @if (!empty($employee_others_leaves) && $employee_others_leaves > 0)
                                        <h4>{{ $employee_others_leaves }}</h4>
                                    @else
                                        <h4>0</h4>
                                    @endif
                                    <p>Total other Leaves taken</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <h1 class="dash-sec-title">Recent Submission</h1>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Status</th>
                                            <th>Submitted </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves_list as $leave)
                                            <tr>
                                                <td>{{ $leave->type }}</td>
                                                <td>{{ date('d-m-Y', strtotime($leave->from)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($leave->to)) }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $leave->status == 'approved' ? 'bg-success' : 'bg-inverse-warning' }}">{{ $leave->status }}</span>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($leave->created_at)) }}</td>


                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Timesheet ID</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Status</th>
                                            <th>Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timesheet_list as $timesheet)
                                            <tr>
                                                <td>{{ $timesheet->timesheet_id }}</td>
                                                <td>{{ date('d-m-Y', strtotime($timesheet->start_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($timesheet->end_date)) }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $timesheet->status == 'approved' ? 'bg-success' : 'bg-inverse-warning' }}">{{ $timesheet->status }}</span>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($timesheet->created_at)) }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <section class="dash-section">
                    <h1 class="dash-sec-title">Latest Notifications</h1>
                    <div class="dash-sec-content">
                        @if (count(getEmployeeLeaveApprovedNotification()) > 0)
                            @foreach (getEmployeeLeaveApprovedNotification() as $index => $notification)
                                @php
                                    if ($index > 1) {
                                        break;
                                    }
                                @endphp
                                <div class="dash-info-list">
                                    <a href="#" class="dash-card text-danger">
                                        <div class="row">
                                            <div class="col-10">
                                                {{-- @dd( $notification); --}}
                                                <div class="dash-card-content">
                                                    <div class="dash-card-icon">
                                                        <i class="fa fa-hourglass-o"></i>
                                                    </div>
                                                    <p>{{ $notification->message }}</p>
                                                </div>
                                            </div>
                                            <div class="col-2 text-right">
                                                <div class="">
                                                    <span class="badge bg-inverse-danger">Notification</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif

                        {{-- <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>You are working from home today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="assets/img/profiles/avatar-02.jpg" alt></div>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </section>
            </div>
        </div>
    @endsection
