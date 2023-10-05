<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #333;
    }

    .content {
        padding: 20px;
        margin: 20px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #333;
        padding: 8px;
        text-align: left;
    }
</style>
@php
    $first_name = !empty($leave->employee->firstname) ? $leave->employee->firstname : '';
    $last_name = !empty($leave->employee->lastname) ? $leave->employee->lastname : '';
    $full_name = $first_name . ' ' . $last_name;
@endphp
<div class="content">
    <h3>Employee Leave Details</h3>
            <table>
                <tr>
                    <th>Employee</th>
                    <td>{{ ucfirst($full_name) }}</td>
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
