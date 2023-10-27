<!DOCTYPE html>
<html>

<head>
    <title></title>
    <!--
 You can put your custom CSS if you wish
    -->
</head>

<body>
    <p>From<<{{ $content['from'] }}>></p><br>
    <p>To<<{{ $content['to'] }}>></p><br>
    <p>Date/Time<<{{ $content['date_time'] }}>></p> <br>
    <p>Subject<<{{ $content['subject'] }}>></p><br>
    <p>Body<<{{ $content['message'] }}>></p>
</body>

</html>
