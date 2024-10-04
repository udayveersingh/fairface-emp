<div>
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

        .bg_title {
            background: #dee6eb;
            color: #4c5860;
            padding: 8px 12px;
            margin-bottom: 0;
            font-size: 14px;
        }
    </style>

    <div class="header">
        <table style="border:none;" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" align="middle" style="padding:0; font-weight:bold; border:none;">
                    <table style="border:none;padding-bottom:10px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="border:none; width:1cm; "><img src="{{ !empty(app(App\Settings\ThemeSettings::class)->logo) ? asset('storage/settings/theme/' . app(App\Settings\ThemeSettings::class)->logo) : asset('assets/img/logo.png') }}"
                                    alt="logo2" border="0"
                                    style="height:50px; vertical-align:middle;margin-right:5px; vertical-align:middle;">
                            </td>
                            <td style="border:none;"><span
                                    style="color:#4c5860; font-size:22px; font-weight:bold;"> {{ ucwords(app(App\Settings\CompanySettings::class)->company_name ?? '') }} <br><span
                                        style="color:#333; font-size:14px; font-weight:normal; display:block; width:100%;">{{ ucwords(app(App\Settings\CompanySettings::class)->address ?? '') }}</span></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="border:none; border-bottom:1px dashed #ddd;">
                    <strong>Name:</strong>{{ ucfirst($employee->firstname . ' ' . $employee->lastname) }} </td>
                <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Email:</strong>{{ $employee->email }}
                </td>
            </tr>
            <tr>
                <td style="border:none;"><strong>Emp ID:</strong>{{ $employee->employee_id }} </td>
                <td style="border:none;"><strong>Mobile No:{{ $employee->phone }}</strong> </td>
            </tr>
        </table>
    </div>
    <div class="content">
        <table>
            <tr>
                <td colspan="7" class="bg_title">
                    <h3>Employee TimeSheet Details</h3>
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Project</th>
                <th>Start Time</th>
                <th>Finish Time</th>
                <th>1/2 or 1 Day</th>
                <th>Comments</th>
            </tr>
            @php
              $count = 0;
              $total_days_worked = 0;
            @endphp
            @foreach ($employee_timesheets as $index => $timesheet)
                <tr>
                    @php
                        $timesheet_hours = '';
                        if (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '8 hours') {
                            $timesheet_hours = 'Full day';
                            $count = 1;
                        } elseif (!empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '4 hours') {
                            $timesheet_hours = 'Half day';
                            $count =.5;
                        } else {
                            $timesheet_hours = '______';
                        }
                        $from_time = date('H:i', strtotime($timesheet->from_time));
                        $to_time = date('H:i', strtotime($timesheet->to_time));
                        $total_days_worked +=$count; 
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
        <h4>Total days Worked:{{" ".$total_days_worked ."days"}}</h4>

        <table style="border:none; border-top:30px solid #fff;">
            <tr>
                <td style="border:none;"><strong>Employee Confirmation:</strong><br />I confirm that this is an accurate
                    record of the times I have worked</td>
                <td style="border:none; text-align:right;" align="right">{{ $employee->firstname . ' ' . $employee->lastname }}<br><strong>Signature:</strong></td>
            </tr>
            <tr>
                <td style="border:none;"><strong>Client Manager Confirmation:</strong><br />I confirm that the total
                    days shown here shall be payable.</td>
                <td style="border:none; text-align:right;" align="right">{{$supervisor->firstname .' '. $supervisor->lastname }}<br><strong>Signature:</strong> <br /></td>
            </tr>
            <tr>
                {{-- <td style="border:none;"><strong>Name:</strong> _______</td> --}}

            </tr>

        </table>


    </div>
