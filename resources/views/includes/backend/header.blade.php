<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ !empty(app(App\Settings\ThemeSettings::class)->logo) ? asset('storage/settings/theme/' . app(App\Settings\ThemeSettings::class)->logo) : asset('assets/img/logo.png') }}"
                alt="logo" width="40" height="40">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    <!-- Header Title -->
    <div class="page-title-box">
        <h3>{{ ucwords(app(App\Settings\CompanySettings::class)->company_name ?? 'Smart HR') }}</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        {{-- @dd(getExpiredNotification()); --}}
        {{-- @dd(getNewLeaveNotifiaction()); --}}
        {{-- @dd(getNewNotification()); --}}
        {{-- @dd(getRejectedLeaveByAdminNotification()); --}}
        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                    <i class="fa fa-bell-o"></i><span class="badge badge-pill">{{ count(getNewNotification()) }}</span>
                    {{-- @dd(getNewNotification()) --}}
                @else
                    <i class="fa fa-bell-o"></i><span
                        class="badge badge-pill">{{ count(getEmployeeNewNotification()) }}</span>
                @endif
                {{-- {{auth()->user()->notifications->count()}} --}}
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    {{-- <form action="{{route('clear-all')}}" method="POST" enctype="multipart/form-data">
                    @csrf  
                    <input type="hidden" name="notification" id="notifiactions" value="{{getNewNotification()}}">
                    <button type="submit" class="clear-noti" style="line-height:none">Clear All</button>
                    </form> --}}
                    <a href="{{ route('clear-all') }}" class="clear-noti"> Clear All</a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        {{-- @foreach (auth()->user()->unreadNotifications as $notification)
                            <li class="notification-message">
                                <a href="{{route('activity')}}">
                                    <div class="media">
                                        <span class="avatar">
                                            <img alt="user" src="{{asset('storage/users/'.auth()->user()->avatar)}}">
                                        </span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title">{{auth()->user()->name}}</span> {{$notification->type}}
                                                 <span class="noti-title">This is the notification body</span></p>
                                            <p class="noti-time"><span class="notification-time">{{$notification->created_at->diffForHumans()}}</span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach --}}
                        @if (Auth::check() && Auth::user()->role->name == App\Models\Role::SUPERADMIN)
                            @foreach (getNewLeaveNotifiaction() as $notification)
                                @php
                                    $leave = App\Models\Leave::with('leaveType', 'employee', 'time_sheet_status')->find($notification->leave);
                                    $emp_first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname : '';
                                    $emp_last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname : '';
                                    $emp_full_name = $emp_first_name . ' ' . $emp_last_name;
                                @endphp
                                @if (!empty($leave))
                                    <li class="notification-message">
                                        <a href="{{ route('activity') }}">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img
                                                        src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span
                                                            class="noti-title">{{ ucfirst($emp_full_name) }}</span>
                                                        <span class="noti-title">added new
                                                            {{ !empty($leave->leaveType->type) ? $leave->leaveType->type : '' }}.</span>
                                                    </p>
                                                    <p class="noti-time">
                                                        <span
                                                            class="notification-time">{{ $leave->created_at->diffForHumans() }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            @foreach (sendNewTimeSheetNotifiaction() as $notification)
                                @php
                                    $employee = App\Models\Employee::find($notification->from);
                                    $emp_first_name = !empty($employee->firstname) ? $employee->firstname : '';
                                    $emp_last_name = !empty($employee->lastname) ? $employee->lastname : '';
                                    $emp_full_name = $emp_first_name . ' ' . $emp_last_name;
                                @endphp
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img
                                                    src="{{ !empty($employee->avatar) ? asset('storage/employees/' . $employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">{{ Ucfirst($emp_full_name) }}</span>
                                                    <span class="noti-title">added new TimeSheet.</span>
                                                </p>
                                                <p class="noti-time">
                                                    {{-- @php
                                                        $created_at=""
                                                        if(!empty($notification->created_at)){
                                                            $created_at = Carbon\Carbon::parse($notification->created_at)->diffForHumans();
                                                        }else{
                                                            $created_at="";
                                                        }
                                                    @endphp --}}
                                                    <span class="notification-time"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @foreach (getExpiredNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img src="{{ asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">'{{ $notification->message }}' By
                                                        Admin.</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            @foreach (getEmployeeLeaveApprovedNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img
                                                    src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">{{ $notification->message }}</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            @foreach (getRejectedLeaveByAdminNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img
                                                    src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">{{ $notification->message }}</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                            @foreach (getEmployeeTimesheetApprovedNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img
                                                    src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">{{ $notification->message }}</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            @foreach (getEmployeeTimesheetRejectedNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img
                                                    src="{{ !empty($leave->employee->avatar) ? asset('storage/employees/' . $leave->employee->avatar) : asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">{{ $notification->message }}</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach()
                            @foreach (getNewAnnouncementNotification() as $notification)
                                <li class="notification-message">
                                    <a href="{{ route('activity') }}">
                                        <div class="media">
                                            <span class="avatar">
                                                <img src="{{ asset('assets/img/user.jpg') }}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span
                                                        class="noti-title">'{{ $notification->message }}' By
                                                        Admin.</span>
                                                    <span class="noti-title"></span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{ route('activity') }}">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img
                        src="{{ !empty(auth()->user()->avatar) ? asset('storage/employees/' . auth()->user()->avatar) : asset('assets/img/user.jpg') }}"
                        alt="user">
                    <span class="status online"></span></span>
                <span>{{ auth()->user()->username }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
                @if (Auth::check() && Auth::user()->role->name != App\Models\Role::EMPLOYEE)
                    <a class="dropdown-item" href="{{ route('settings.theme') }}">Settings</a>
                @endif
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" id="logout" class="dropdown-item">Logout</button>
                </form>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('settings.theme') }}">Settings</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" id="logout" class="dropdown-item">Logout</button>
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
