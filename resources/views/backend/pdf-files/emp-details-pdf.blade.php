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
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Name:</strong>{{ucfirst($employee->firstname."".$employee->lastname)}} </td>
            <td style="border:none; border-bottom:1px dashed #ddd;"><strong>Email:</strong>{{$employee->email}}</td>
        </tr>
        <tr>
            <td style="border:none;"><strong>Emp ID:</strong>{{$employee->employee_id}} </td>
            <td style="border:none;"><strong>Mobile No:{{$employee->phone}}</strong> </td>
        </tr>
    </table>
</div>

<div class="content">    
    <table>
        <tr>
            <td colspan="2" class="bg_title"><h3 >Basic Information</h3></td>            
        </tr>
        <tr>
            <th>Profile Picture</th>
            <td><img src="https://img.freepik.com/premium-photo/man-with-orange-shirt-is-circle-with-man-orange_745528-3525.jpg" alt="profile" border="0" style="height:40px; vertical-align:middle;margin-right:5px; vertical-align:middle;"></td>
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
    @endforeach
    <div>
