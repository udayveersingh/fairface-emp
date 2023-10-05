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
    .bg_title{background:#34444c; color:#fff; padding:8px 12px; margin-bottom:0;}
</style>
<div class="header">
    <table style="border:none;" bgcolor="#f8f8f8" cellpadding="0" cellspacing="0">
        <tr>
            <td align="middle" style="font-weight:bold; border:none;"><div style="width: 5cm;"><img src="https://i.ibb.co/1ntZs9x/logo2.png" alt="logo2" border="0" style="height:30px; vertical-align:middle;margin-right:5px; "> Fairface-Emp</div></td>
            <td  style="border:none; background:#34444c; color:#fff; font-size:22px; font-weight:bold;">Employee Details</td>
        </tr>
        
        <tr>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Name:</strong> {{ $employee->firstname . ' ' . $employee->lastname }}</td>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Designation:</strong> </td>
        </tr>
        <tr>
            <td style="border:none;"><strong>Emp ID:</strong> {{ $employee->employee_id }}</td>
            <td style="border:none;"><strong>Department:</strong> </td>
        </tr>
    </table>
</div>

<div class="content">    
    <table>
        <tr>
            <td colspan="2" class="bg_title"><h3 >Basic Information</h3></td>            
        </tr>
        <tr>
            <th>Employee Id</th>
            <td>{{ $employee->employee_id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $employee->firstname . ' ' . $employee->lastname }}</td>
        </tr>
        <tr>
            <th>Mobile</th>
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
    </table>
    
    @foreach ($employee_addresses as $index => $address)
        @php
            if ($index > 0) {
                break;
            }
        @endphp
        <table>
            <tr>
                <td colspan="2" class="bg_title"><h3>Employee Address</h3></td>
            </tr>
            <tr>
                <th>Address Line 1</th>
                <td>{{ !empty($address->home_address_line_1) ? $address->home_address_line_1 : '' }}</td>
            </tr>
            <tr>
                <th>Address Line 2</th>
                <td>{{ !empty($address->home_address_line_2) ? $address->home_address_line_2 : '' }}</td>
            </tr>
        </table>
    @endforeach
    
    @foreach ($employee_visas as $index => $visa)
        @php
            if ($index > 0) {
                break;
            }
        @endphp
        <table style="border-top:20px solid #fff;">
            <tr>
                <td colspan="2" class="bg_title"><h3>Employee Visas</h3></td>
            </tr>
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
