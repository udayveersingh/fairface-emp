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
    <p>from: {{ $emp_job_detail['from'] }}</p>
    <p>cc_email: {{ $emp_job_detail['cc_email'] }}</p>
    <p>attchment:<img src="{{ $emp_job_detail['attchment'] }}" width="50px"></p>
</body>
</html>