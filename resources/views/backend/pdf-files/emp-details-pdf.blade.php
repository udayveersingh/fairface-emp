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
    {{-- @if (!empty($employee->avatar))
        <img src="{{ asset('storage/employees/'.$employee->avatar) }}" alt="profile" border="0"
            style="height:125px; width:125px; float:right; vertical-align:middle;margin-right:0px; vertical-align:middle;">
    @endif --}}
    <table style="border:none;" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2" align="middle" style="padding:0; font-weight:bold; border:none;">
                <table style="border:none;padding-bottom:10px;" cellpadding="0" cellspacing="0">
                    <tr>
                         <td style="border:none; width:1cm;">
                            <img src="storage/settings/theme/{{app(App\Settings\ThemeSettings::class)->logo }}"
                                alt="profile" border="0"
                                style="height:50px; vertical-align:middle;margin-right:5px; vertical-align:middle;">
                        </td>
                        <td style="border:none;"><span style="color:#4c5860; font-size:22px; font-weight:bold;">
                                {{ ucwords(app(App\Settings\CompanySettings::class)->company_name ?? '') }} <br><span
                                    style="color:#333; font-size:14px; font-weight:normal; display:block; width:100%;">{{ ucwords(app(App\Settings\CompanySettings::class)->address ?? '') }}</span></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="border:none; border-bottom:1px dashed #ddd;">
                <strong>Name:</strong>{{ ucfirst($employee->firstname . ' ' . $employee->lastname) }}
            </td>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Email:</strong>{{ $employee->email }}</td>
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
            <td colspan="2" class="bg_title">
                <h3>Information Sheet</h3>
            </td>
        </tr>
        <tr>
            <th>Employee Id</th>
            <td>{{ $employee->employee_id }}</td>
        </tr>
        <tr>
            <th>Employee First Name</th>
            <td>{{ ucfirst($employee->firstname) }}</td>
        </tr>
        <tr>
            <th>Employee Last Name</th>
            <td>{{ $employee->lastname }}</td>
        </tr>
        <tr>
            <th>Job Title</th>
            <td>{{ $employee_job_title }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $employee->phone }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $employee->email }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $employee->date_of_birth }}</td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td>{{ !empty($employee->country->name) ? $employee->country->name : '' }}</td>
        </tr>
        @if (!empty($employee_address->home_address_line_1))
            <tr>
                <th>Address</th>
                <td>{{ $employee_address->home_address_line_1 . ',' . !empty($employee_address->home_address_line_2) ? $employee_address->home_address_line_2 : '' }}
                </td>
            </tr>
        @endif
        <tr>
            <th>Passport Number</th>
            <td>{{ $employee->passport_number }}</td>
        </tr>
        <tr>
            <th>Passport Issue Date</th>
            <td>{{ $employee->passport_issue_date }}</td>
        </tr>
        <tr>
            <th>Passport Expire Date</th>
            <td>{{ $employee->passport_expiry_date }}</td>
        </tr>
        <tr>
            <th>Visa Type</th>
            <td>{{ !empty($employee_visa->visa_types->visa_type) ? $employee_visa->visa_types->visa_type : '' }}</td>
        </tr>
        <tr>
            <th>Visa Issue Date</th>
            <td>{{ !empty($employee_visa->visa_issue_date) ? date('d-m-Y', strtotime($employee_visa->visa_issue_date)) : '' }}
            </td>
        </tr>
        <tr>
            <th>Visa Expiry Date</th>
            <td>{{ !empty($employee_visa->visa_expiry_date) ? date('d-m-Y', strtotime($employee_visa->visa_expiry_date)) : '' }}
            </td>
        </tr>
        <tr>
            <th>Cos Number</th>
            <td>{{ !empty($employee_visa->cos_number) ? $employee_visa->cos_number : '' }}</td>
        </tr>
        <tr>
            <th>Cos Issue Date</th>
            <td>{{ !empty($employee_visa->cos_issue_date) ? date('d-m-Y', strtotime($employee_visa->cos_issue_date)) : '' }}
            </td>
        </tr>
        <tr>
            <th>Cos Expire Date</th>
            <td>{{ !empty($employee_visa->cos_expiry_date) ? date('d-m-Y', strtotime($employee_visa->cos_expiry_date)) : '' }}
            </td>
        </tr>
    </table>
</div>
