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
                                    style="color:#4c5860; font-size:22px; font-weight:bold;">{{ ucwords(app(App\Settings\CompanySettings::class)->company_name ?? '') }} <br><span
                                        style="color:#333; font-size:14px; font-weight:normal; display:block; width:100%;">{{ ucwords(app(App\Settings\CompanySettings::class)->address ?? '') }}</span></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                @php
                    $firstname = !empty($expenses[0]->firstname) ? ucfirst($expenses[0]->firstname) : '';
                    $lastname = !empty($expenses[0]->lastname) ? ucfirst($expenses[0]->lastname) : '';
                    $fullname = $firstname . ' ' . $lastname;
                @endphp
                <td style="border:none; border-bottom:1px dashed #ddd;">
                    <strong>Employee Name:</strong> {{!empty($fullname) ? $fullname:'' }}
                </td>
                <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Expense
                        ID:</strong>{{ !empty($expenses[0]->expense_id) ? $expenses[0]->expense_id : '' }}</td>
            </tr>
            <tr>
                @php
                    $expense_date = str_replace('Exp-', '', !empty($expenses[0]->expense_id) ? $expenses[0]->expense_id : '');
                    $year_month = date('Y-M', strtotime($expense_date));
                @endphp
                <td style="border:none;"><strong>Year Month:</strong>{{ $year_month }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table>
            <tr>
                <td colspan="7" class="bg_title">
                    <h3>Employee Expense Details</h3>
                </td>
            </tr>
            <tr>
                <th>Expense Type</th>
                <th>Supervisor</th>
                <th>Project</th>
                <th>Occurred Date</th>
                <th>Status</th>
                <th>Cost</th>
            </tr>
            @php
                $sum = 0;
                $total_sum = 0;
            @endphp
            @foreach ($expenses as $expense)
                @php
                    $sum = $expense->cost;
                    $total_sum += $sum;
                @endphp
                <tr>
                    <td>{{ $expense->type }}</td>
                    @php
                            $supervisor = App\Models\Employee::find($expense->supervisor_id);
                            if (!empty($supervisor)) {
                            $fullName = $supervisor->firstname . ' ' . $supervisor->lastname;
                        }
                    @endphp
                    <td>{{!empty($fullName) ? ucfirst($fullName) :''}}</td>
                    <td>{{ $expense->name }}</td>
                    <td>{{ date('d-m-Y', strtotime($expense->expense_occurred_date)) }}</td>
                    @php
                        $status = '';
                        if (!empty($expense->timesheet_status_id)) {
                            $timesheet_status = App\Models\TimesheetStatus::find($expense->timesheet_status_id);
                            $status = ucfirst($timesheet_status->status);
                        }
                    @endphp
                    <td>{{ $status }}</td>
                    <td>{{ app(App\Settings\ThemeSettings::class)->currency_symbol . ' ' . $expense->cost }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th>Total</th>
                <td>{{ app(App\Settings\ThemeSettings::class)->currency_symbol . ' ' . $total_sum }}</td>
            </tr>
        </table>
    </div>
