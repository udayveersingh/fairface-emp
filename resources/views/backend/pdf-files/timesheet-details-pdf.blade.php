<div>
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
    <div class="content">
        <h3>Employee TimeSheet Details</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Project</th>
            <th>Start Time</th>
            <th>Finish Time</th>
            <th>1/2 or 1 Day</th>
            <th>Comments</th>
        </tr>
        @foreach ($employee_timesheets as $index => $timesheet)
            <tr>
                @php
                    $timesheet_hours = '';
                    if (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '8 hours') {
                        $timesheet_hours = 'Full day';
                    } elseif (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '4 hours') {
                        $timesheet_hours = 'Half day';
                    } else {
                        $timesheet_hours = '______';
                    }
                    $from_time = date('H:i', strtotime($timesheet->from_time));
                    $to_time = date('H:i', strtotime($timesheet->to_time));
                @endphp
                <td>{{ !empty($timesheet->calender_date) ? date('d-m-Y', strtotime($timesheet->calender_date)) : '' }}
                </td>
                <td>{{ $timesheet->calender_day }}</td>
                <td>{{ !empty($timesheet->project->name) ? ucfirst($timesheet->project->name) : '______' }}</td>
                <td>{{ !empty($from_time) ? $from_time : '' }}</td>
                <td>{{ !empty($to_time) ? $to_time : '' }}</td>
                <td>{{ $timesheet_hours }}</td>
                <td>
                    {{ $timesheet->notes }}
                </td>
            </tr>
        @endforeach
    </table>
</div>
