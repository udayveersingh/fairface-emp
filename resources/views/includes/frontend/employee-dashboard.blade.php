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
        </div>
        <section>
            @if (!empty($employee_projects))
                <div class="row">
                    <div class="col-lg-3">
                        <h5 class="dash-title">Projects</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        <h4>{{ count($employee_projects) }}</h4>
                                        <p>Total Projects</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h5 class="dash-title" style="margin-bottom:4px">Your Leave</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        @if (!empty($employee_leaves) && count($employee_leaves) > 0)
                                            <h4>{{ count($employee_leaves) }}</h4>
                                        @else
                                            <h4>0</h4>
                                        @endif
                                        <p>Leave Taken</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <h5 class="dash-title">Timesheet</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        <h4>{{ $timesheet_submitted_count}}</h4>
                                        <p>Timesheet submmited this Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <section class="dash-section">
                    <h1 class="dash-sec-title">ANNOUNCEMENTS</h1>
                    <div class="dash-sec-content">
                        <div class="dash-info-list">
                            <a href="#" class="dash-card text-danger">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="dash-card-content">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-hourglass-o"></i>
                                            </div>
                                            <p>{{ Auth::user()->name }} is off sick today</p>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <div class="">
                                            <span class="badge bg-inverse-danger">Notification</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @if(count(getAnnouncement()) > 0)
                        @foreach (getAnnouncement() as $announcement)
                        <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="dash-card-content">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-suitcase"></i>
                                            </div>
                                            <p>{{$announcement->description}}</p>
                                        </div>
                                    </div> 
                                    <div class="col-3 text-right">
                                        <div class="">
                                            <span class="badge bg-inverse-success">Annoucement</span>
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
