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
    <h3>Employee Basic Info</h3>
    <table>
        <tr>
            <th>Employee pic</th>
            <td>
                <img style="height: auto; width:80px;" src="storage/employees/{{ $employee->avatar }}" />
            </td>
        </tr>
        <tr>
            <th>Employee Id</th>
            <td>{{ $employee->employee_id }}</td>
        </tr>
        {{-- <tr>
            <th>Main Branch Location</th>
            <td>{{ !empty($employee->branch->branch_code) ? $employee->branch->branch_code : '' }}
            </td>
        </tr> --}}
        <tr>
            <th>Name</th>
            <td>{{ $employee->firstname . ' ' . $employee->lastname }}</td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td>{{ $employee->phone }}</td>
        </tr>
        {{-- <tr>
            <th>Alternate Phone Number</th>
            <td>{{ $employee->alternate_phone_number }}</td>
        </tr> --}}
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
        {{-- <tr>
            <th>National Insurance Number</th>
            <td>{{ $employee->national_insurance_number }}</td>
        </tr> --}}
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
        {{-- <tr>
            <th>Marital Status</th>
            <td>{{ $employee->marital_status }}</td>
        </tr>
        <tr>
            <th>Record Status</th>
            <td>{{ $employee->record_status }}</td>
        </tr> --}}
    </table>
    <h3>Employee Address</h3>
    @foreach ($employee_addresses as $index => $address)
        @php
            if ($index > 0) {
                break;
            }
        @endphp
        <table>
            <tr>
                <th>Address Line 1</th>
                <td>{{ !empty($address->home_address_line_1) ? $address->home_address_line_1 : '' }}</td>
            </tr>
            <tr>
                <th>Address Line 2</th>
                <td>{{ !empty($address->home_address_line_2) ? $address->home_address_line_2 : '' }}</td>
            </tr>
            {{-- <tr>
                <th>Post Code</th>
                <td>{{ !empty($address->post_code) ? $address->post_code : '' }}</td>
            </tr> --}}
            {{-- <tr>
                <th>From Date</th>
                <td>{{ !empty($address->from_date) ? date('d-m-Y', strtotime($address->from_date)) : '' }}
                </td>
            </tr> --}}
            {{-- <tr>
                <th>To Date</th>
                <td>{{ !empty($address->to_date) ? date('d-m-Y', strtotime($address->to_date)) : '' }}</td>
            </tr> --}}
        </table>
    @endforeach
    <h3>Employee Visas</h3>
    @foreach ($employee_visas as $index => $visa)
        @php
            if ($index > 0) {
                break;
            }
        @endphp
        <table>
            <tr>
                <th>Visa Type</th>
                <td>{{ !empty($visa->visa_types->visa_type) ? $visa->visa_types->visa_type : '' }}</td>
            </tr>
            <tr>
                <th>Cos Number</th>
                <td>{{ $visa->cos_number }}</td>
            </tr>
            <tr>
                <th>Cos Issue Date</th>
                <td>{{ !empty($visa->cos_issue_date) ? date('d-m-Y', strtotime($visa->cos_issue_date)) : '' }}
                </td>
            </tr>
            <tr>
                <th>Cos Expire Date</th>
                <td>{{ !empty($visa->cos_expiry_date) ? date('d-m-Y', strtotime($visa->cos_expiry_date)) : '' }}
                </td>
            </tr>
            <tr>
                <th>Visa Issue Date</th>
                <td>{{ !empty($visa->visa_issue_date) ? date('d-m-Y', strtotime($visa->visa_issue_date)) : '' }}
                </td>
            </tr>
            <tr>
                <th>Visa Expiry Date</th>
                <td>{{ !empty($visa->visa_expiry_date) ? date('d-m-Y', strtotime($visa->visa_expiry_date)) : '' }}
                </td>
            </tr>
        </table>
        <p>Need to add reminder as well</p>
        __________________________________
        <p>Also, we need to send Auto reminder emails for the Passport & Visa expiration.. to Candidates also to the admin in an email. monthly remainders from 6 months.</p>
    @endforeach

    <div>
