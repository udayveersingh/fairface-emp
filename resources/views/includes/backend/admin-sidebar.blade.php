<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ route_is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="la la-dashboard"></i> <span>Home</span></a>
                </li>
                <li class="submenu">
                    <a href="#" class="{{ route_is('settings.theme') ? 'active' : '' }} noti-dot"><i
                            class="la la-user"></i><span>Employees</span> <span class="menu-arrow"></span></a>
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
                            <a class="{{ route_is('employee-timesheet') ? 'active' : '' }}"
                                href="{{ route('employee-timesheet') }}">Employee Timesheet List</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ route_is('employee-leave') ? 'active' : '' }}">
                    <a href="{{ route('employee-leave') }}"><i class="la la-files-o"></i> <span>Employee
                            leaves</span></a>
                </li>
                <li>
                    <a class="{{ route_is('company-email') ? 'active' : '' }}"
                        href="{{ route('company-email') }}" target="_blank"><i class="la la-envelope-o"></i><span>Company Email</span></a>
                </li>
                <li class="{{ route_is('announcement') ? 'active' : '' }}">
                    <a href="{{ route('announcement') }}"><i class="fa fa-bullhorn"></i>
                        <span>Announcement</span></a>
                </li>
                <li>
                    <a class="{{ route_is('logs') ? 'active' : '' }}" href="{{ route('logs') }}"><i
                            class="la la-cog"></i> <span>Employee Activity</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
