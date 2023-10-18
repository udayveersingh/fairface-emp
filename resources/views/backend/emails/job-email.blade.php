<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Email</title>
</head>
<body>
    <h1>Test EMAIL</h1>
    <p>From: {{ $emp_job_detail['from'] }}</p>
    <p>CC email: {{ $emp_job_detail['cc_email'] }}</p>
    <p>Attchment:<img src="{{asset('storage/company_email/attachment/'.$emp_job_detail['attachment'])}}" width="50px"></p>
</body>
</html>