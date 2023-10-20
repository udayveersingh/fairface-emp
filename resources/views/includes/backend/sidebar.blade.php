<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @if (Auth::check() && Auth::user()->role->name != App\Models\Role::SUPERADMIN)
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="{{ route_is('employee-dashboard') ? 'active' : '' }}">
                        <a href="{{ route('employee-dashboard') }}"><i class="la la-dashboard"></i> <span>
                                Dashboard</span></a>
                    </li>
                    <li class="{{ route_is('profile') ? 'active' : '' }}">
                        <a href="{{ route('profile') }}"><i class="la la-user"></i> <span>My Info</span></a>
                    </li>
                    <li class="">
                        <a href="{{ route('employee-timesheet-list') }}"><i class="la la-calendar"></i>
                            <span>Timesheets</span></a>
                    </li>
                    <li class="{{ route_is('employee-leave') ? 'active' : '' }}">
                        <a href="{{ route('employee-leave') }}"><i class="la la-files-o"></i> <span>Leaves</span></a>
                    </li>
                    @php
                        $employee = App\Models\Employee::where('user_id', '=', Auth::user()->id)->first();
                        $employee_job = App\Models\EmployeeJob::where('employee_id', '=', $employee->id)->first();
                    @endphp
                    <li><a class="{{ route_is('user-email-inbox') ? 'active' : '' }}"
                            href="{{ route('user-email-inbox') }}" target=_blank><i class="la la-envelope-o"></i>
                            <span>Company Email </span></a></li>
                    {{-- <li class="submenu">
                        <a href="#"><i class="la la-envelope-o"></i> <span> Emails </span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display:none;">
                            @if (!empty($employee_job))
                                <li><a class="{{ route_is('sent-email') ? 'active' : '' }}"
                                        href="{{ route('sent-email') }}">Sent Mail</a></li>
                                <li><a class="{{ route_is('compose-email') ? 'active' : '' }}"
                                        href="{{ route('compose-email') }}">Compose Email</a></li>
                            @endif
                        </ul>
                    </li> --}}
                @else
                    <li class="{{ route_is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}"><i class="la la-dashboard"></i> <span>Home</span></a>
                    </li>
                    <!-- <li class="submenu">
                    <a href="#"><i class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        
                        <li><a class="{{ route_is('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Contacts</a></li>
                    </ul>
                </li> -->
                    <li class="menu-title">
                        <span>Configurations</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class="{{ route_is('settings.theme') ? 'active' : '' }} noti-dot"><i
                                class="la la-cog"></i> <span> Master DataSet</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ route_is('branches') ? 'active' : '' }}"
                                    href="{{ route('branches') }}">Branch</a></li>
                            <li><a class="{{ route_is('holidays') ? 'active' : '' }}"
                                    href="{{ route('holidays') }}">Public Holidays</a></li>
                            <li><a class="{{ route_is('leave-type') ? 'active' : '' }}"
                                    href="{{ route('leave-type') }}">Leave Type</a></li>
                            <li><a class="{{ route_is('departments') ? 'active' : '' }}"
                                    href="{{ route('departments') }}">Departments</a></li>
                            <li><a class="{{ route_is('expense-type') ? 'active' : '' }}"
                                    href="{{ route('expense-type') }}">Expense Type</a></li>
                            <li><a class="{{ route_is('visa') ? 'active' : '' }}" href="{{ route('visa') }}">Visa
                                    Type</a></li>
                            <li><a class="{{ route_is(['projects', 'project-list']) ? 'active' : '' }}"
                                    href="{{ route('project-list') }}">Projects</a></li>
                            <li><a class="{{ route_is('project-phase') ? 'active' : '' }}"
                                    href="{{ route('project-phase') }}">Project Phase</a></li>
                            <li><a class="{{ route_is('timesheet-status') ? 'active' : '' }}"
                                    href="{{ route('timesheet-status') }}">Timesheet Status</a></li>
                            <li><a class="{{ route_is('designations') ? 'active' : '' }}"
                                    href="{{ route('designations') }}">Designations</a></li>
                            <li><a class="{{ route_is('job-title') ? 'active' : '' }}"
                                    href="{{ route('job-title') }}">Job Title</a></li>

                            {{-- <li><a class="{{ route_is('employees.attendance') ? 'active' : '' }}" href="{{route('employees.attendance')}}">Attendance</a></li> --}}
                            {{-- <li><a class="{{ route_is('employee-leave') ? 'active' : '' }}" href="{{route('employee-leave')}}">Leaves (Employee)</a></li> --}}
                            {{-- <li><a class="{{ route_is('overtime') ? 'active' : '' }}" href="{{route('overtime')}}">Overtime</a></li> --}}

                        </ul>
                    </li>
                    {{-- <li class="{{ route_is('employees-list') ? 'active' : '' }}">
                        <a href="{{ route('employees-list') }}"><i class="la la-user"></i> <span>All Employees</span></a>
                        
                    </li> --}}
                    <li class="submenu">
                        <a href="#" class="{{ route_is('settings.theme') ? 'active' : '' }} noti-dot"><i
                                class="la la-user"></i><span> All Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ route_is('employee-detail') ? 'active' : '' }}"
                                    href="{{ route('employee-detail') }}">Add New Employee</a>
                            </li>
                            <li>
                                @php
                                    $status = implode(',', request()->route()->parameters);
                                    $active_class = '';
                                    $archeive_class = '';
                                    if ($status == 'active') {
                                        $active_class = 'active';
                                    } elseif ($status == 'archieve') {
                                        $archeive_class = 'active';
                                    }
                                @endphp
                                <a class="{{ !empty($active_class) ? $active_class : '' }} "
                                    href="{{ route('employees-list', ['status' => 'active']) }}">Active Employee</a>
                            </li>
                            <li><a class="{{ !empty($archeive_class) ? $archeive_class : '' }}"
                                    href="{{ route('employees-list', ['status' => 'archieve']) }}">Archived
                                    Employee</a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#" class="{{ route_is('settings.theme') ? 'active' : '' }} noti-dot"><i
                                class="la la-calendar"></i><span>Timesheet</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li>
                                <a class="{{ route_is('timesheet-view') ? 'active' : '' }}"
                                    href="{{ route('timesheet-view') }}">Add New Timesheet</a>
                            </li>
                            <li>
                                <a class="{{ route_is('employee-timesheet') ? 'active' : '' }}"
                                    href="{{ route('employee-timesheet') }}">Employee Timesheet List</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="{{ route_is('tickets') ? 'active' : '' }}">
                    <a href="{{ route('tickets') }}"><i class="la la-files-o"></i> <span>Timesheet</span></a>
                </li> -->
                    <!-- <li class="{{ route_is('tickets') ? 'active' : '' }}">
                    <a href="{{ route('tickets') }}"><i class="la la-bell"></i> <span>Leaves</span></a>
                </li> -->
                    <li class="{{ route_is('employee-leave') ? 'active' : '' }}">
                        <a href="{{ route('employee-leave') }}"><i class="la la-files-o"></i> <span>Employee
                                leaves</span></a>
                    </li>
                    <li>
                        <a class="{{ route_is('company-email') ? 'active' : '' }}" href="{{ route('company-email') }}"
                            target="_blank"><i class="la la-envelope-o"></i><span>Company Email</span></a>
                    </li>
                    {{-- <span class="badge badge-pill">{{ count(getEmailCounts()) }}</span> --}}
                    <li class="{{ route_is('announcement') ? 'active' : '' }}">
                        <a href="{{ route('announcement') }}"><i class="fa fa-bullhorn"></i>
                            <span>Announcement</span></a>
                    </li>
                    <li><a class="{{ route_is('expenses') ? 'active' : '' }}" href="{{ route('expenses') }}"><i class="fa fa-money"></i><span>Expenses</span></a></li>
                    {{-- <li class="{{route_is('tickets') ? 'active' : '' }}">
                    <a href="{{route('tickets')}}"><i class="la la-bullhorn"></i> <span>Email</span></a>
                </li> --}}
                    <!-- <li class="{{ route_is('clients') ? 'active' : '' }}">
                    <a href="{{ route('clients') }}"><i class="la la-users"></i> <span>Clients</span></a>
                </li> -->
                    <!--
                <li class="{{ route_is('leads') ? 'active' : '' }}">
                    <a href="{{ route('leads') }}"><i class="la la-user-secret"></i> <span>Leads</span></a>
                </li>
                
                <li class="{{ route_is('tickets') ? 'active' : '' }}">
                    <a href="{{ route('tickets') }}"><i class="la la-ticket"></i> <span>Tickets</span></a>
                </li>
                -->
                    <li class="menu-title">
                        <span>Admin Settings</span>
                    </li>
                    <!-- <li class="submenu">
                    <a href="#"><i class="la la-files-o"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">Invoices</a></li>
                        <li><a class="{{ route_is('provident-fund') ? 'active' : '' }}" href="{{ route('provident-fund') }}">Provident Fund</a></li>
                        <li><a class="{{ route_is('taxes') ? 'active' : '' }}" href="{{ route('taxes') }}">Taxes</a></li>
                    </ul>
                </li>
                
                <li class="{{ route_is('policies') ? 'active' : '' }}">
                    <a href="{{ route('policies') }}"><i class="la la-file-pdf-o"></i> <span>Policies</span></a>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-briefcase"></i> <span> Jobs </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('jobs') ? 'active' : '' }}" href="{{ route('jobs') }}"> Manage Jobs </a></li>
                        <li><a class="{{ route_is('job-applicants') ? 'active' : '' }}" href="{{ route('job-applicants') }}"> Applied Candidates </a></li>
                    </ul>
                </li>
                 <li class="submenu">
                    <a href="#"><i class="la la-crosshairs"></i> <span> Goals </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('goal-tracking') ? 'active' : '' }}" href="{{ route('goal-tracking') }}"> Goal List </a></li>
                        <li><a class="{{ route_is('goal-type') ? 'active' : '' }}" href="{{ route('goal-type') }}"> Goal Type </a></li>
                    </ul>
                </li>
                <li class="{{ route_is('assets') ? 'active' : '' }}">
                    <a href="{{ route('assets') }}"><i class="la la-object-ungroup"></i> <span>Assets</span></a>
                </li> -->
                    <!-- <li>
                    <a class="{{ route_is('activity') ? 'active' : '' }}" href="{{ route('activity') }}"><i class="la la-bell"></i> <span>Activities</span></a>
                </li> -->
                    <li class="{{ route_is('users') ? 'active' : '' }}">
                        <a href="{{ route('users') }}"><i class="la la-user-plus"></i> <span>Users</span></a>
                    </li>

                    <li>
                        <a class="{{ route_is('settings.theme') ? 'active' : '' }}"
                            href="{{ route('settings.theme') }}"><i class="la la-cog"></i> <span>Settings</span></a>
                    </li>
                    <li>
                        <a class="{{ route_is('logs') ? 'active' : '' }}" href="{{ route('logs') }}"><i
                                class="la la-cog"></i> <span>Logs</span></a>
                    </li>
                    <!-- <li class="{{ Request::is('backups') ? 'active' : '' }}">
                    <a href="{{ route('backups') }}"
                        ><i class="la la-cloud-upload"></i> <span>Backups </span>
                    </a>
                </li> -->
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
