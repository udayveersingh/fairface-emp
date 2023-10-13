<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #333;
    }

    .content {
        padding: 20px 0;
        margin: 20px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .bg_title{background:#dee6eb; color:#4c5860; padding:8px 12px; margin-bottom:0; font-size:14px;}
</style>

<div class="header">
    <table style="border:none;"  cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2" align="middle" style="padding:0; font-weight:bold; border:none;">
                <table style="border:none;padding-bottom:10px;"  cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="border:none; width:1cm; "><img src="https://i.ibb.co/1ntZs9x/logo2.png" alt="logo2" border="0" style="height:50px; vertical-align:middle;margin-right:5px; vertical-align:middle;"></td>
                        <td style="border:none;"><span style="color:#4c5860; font-size:22px; font-weight:bold;">FAIRFACE EMP <br><span style="color:#333; font-size:14px; font-weight:normal; display:block; width:100%;">{{ ucwords(app(App\Settings\CompanySettings::class)->address ?? '') }}</span></span></td>
                    </tr>
                </table>                
            </td>
        </tr>
        
        <tr>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Name:</strong>{{ucfirst($leave->employee->firstname." ".$leave->employee->lastname)}} </td>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Email:</strong>{{$leave->employee->email}}</td>
        </tr>
        <tr>
            <td style="border:none;"><strong>Emp ID:</strong>{{$leave->employee->employee_id}} </td>
            <td style="border:none;"><strong>Mobile No:{{$leave->employee->phone}}</strong> </td>
        </tr>
    </table>
</div>

@php
    $first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname : '';
    $last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname : '';
    $full_name = $first_name . ' ' . $last_name;
@endphp
<div class="content">
            <table>
            <tr>
                <td colspan="2" class="bg_title"><h3 >Employee Leave Details</h3></td>            
            </tr>
                <tr>
                    <th>Employee Name</th>
                    <td>{{ ucfirst($full_name) }}</td>
                </tr>
                <tr>
                    <th>Supervisor Name</th>
                    <td>{{ucfirst($supervisor_name)}}</td>
                </tr>
                <tr>
                    <th>Leave Type</th>
                    <td>{{ !empty($leave->leaveType->type) ? ucfirst($leave->leaveType->type) : '' }}</td>
                </tr>
                <tr>
                    <th>From Date</th>
                    <td>{{ date_format(date_create($leave->from), 'd M, Y') }}</td>
                </tr>
                <tr>
                    <th>To Date</th>
                    <td>{{ date_format(date_create($leave->to), 'd M, Y') }}</td>
                </tr>
                <tr>
                    <th>No. of Days</th>
                    <td>
                        @php
                            $start = new DateTime($leave->to);
                            $end_date = new DateTime($leave->from);
                        @endphp
                        @if ($start == $end_date)
                            {{ '1 Days' }}
                        @else
                            {{ $start->diff($end_date, '%d')->days . ' ' . Str::plural('Days', $start->diff($end_date, '%d')->days) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Reason</th>
                    <td>{{ $leave->reason }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ !empty($leave->time_sheet_status->status) ? ucfirst($leave->time_sheet_status->status) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Status Reason</th>
                    <td>{{ $leave->status_reason }}</td>
                </tr>
                <tr>
                    <th>Approved Date/Time</th>
                    <td>{{ !empty($leave->approved_date_time) ? date('d-m-Y', strtotime($leave->approved_date_time)) : '' }}
                    </td>
                </tr>
            </table>
        </div>
