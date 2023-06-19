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
                        <h3>Welcome,{{ Auth::user()->name}}</h3>
                        @php
                            $date = Carbon\Carbon::now();
                            $formatedDate = $date->format('l'.','.'d M Y');
                        @endphp
                        <p>{{$formatedDate}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <section class="dash-section">
                    <h1 class="dash-sec-title">Today</h1>
                    <div class="dash-sec-content">
                        <div class="dash-info-list">
                            <a href="#" class="dash-card text-danger">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-hourglass-o"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>{{ Auth::user()->name}} is off sick today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="assets/img/profiles/avatar-09.jpg" alt></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-suitcase"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>You are away today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="assets/img/profiles/avatar-02.jpg" alt></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="dash-info-list">
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
                        </div>
                    </div>
                </section>
            </div>
            <section>
                @if(!empty($employee_projects))
                <h5 class="dash-title">Projects</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="request-btn">
                            <div class="dash-stats-list">
                                <h4>{{count($employee_projects)}}</h4>
                                <p>Total Projects</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <h5 class="dash-title">Your Leave</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="time-list">
                            <div class="dash-stats-list">
                                <h4>4.5</h4>
                                <p>Leave Taken</p>
                            </div>
                            <div class="dash-stats-list">
                                <h4>12</h4>
                                <p>Remaining</p>
                            </div>
                        </div>
                        <div class="request-btn">
                            <a class="btn btn-primary" href="#">Apply Leave</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
