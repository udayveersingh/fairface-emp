<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li> 
                    <a href="{{route('dashboard')}}"><i class="la la-home"></i> <span>Back to Home</span></a>
                </li>
                <li class="menu-title">Employee Detail</li>

                <li class="{{ Request::routeIs('employee-contact',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-contact',$employee->id)}}"><span>Emergency Contact</span></a>
                </li>
                <li class="{{ Request::routeIs('employee-address',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-address',$employee->id)}}"><span>Employee Address</span></a>
                </li>
                <li class="{{ Request::routeIs('employee-bank',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-bank',$employee->id)}}"><span>Employee Bank</span></a>
                </li>
                <li class="{{ Request::routeIs('settings.theme') ? 'active' : '' }}"> 
                    <a href="#"><span>Employee Payslip</span></a>
                </li>
                <li class="{{ Request::routeIs('settings.theme') ? 'active' : '' }}"> 
                    <a href="#"><span>Employee Document</span></a>
                </li>
                <li class="{{ Request::routeIs('employee-visa',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-visa',$employee->id)}}"><span>Employee Visa</span></a>
                </li>
                <li class="{{ Request::routeIs('employee-project-detail',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-project-detail',$employee->id)}}"><span>Employee Project</span></a>
                </li>
                <li class="{{ Request::routeIs('employee-job-detail',$employee->id) ? 'active' : '' }}"> 
                    <a href="{{route('employee-job-detail',$employee->id)}}"><span>Employee Job</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar -->