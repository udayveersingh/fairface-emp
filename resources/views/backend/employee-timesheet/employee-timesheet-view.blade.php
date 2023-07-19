@extends('layouts.backend')

@section('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    {{-- @endsection --}}
@section('content')
    <div class="container my-4">
        <div class="row mb-3">
            <div class="col-md-2"><img src="" alt="" /></div>
            <div class="col-md-10">
                <h1 class="text-left">Indus Services Limited</h1>
            </div>
        </div>
        @php
            $date = new DateTime('now');
            $date->modify('last day of this month');
            
            //calender date store
            $first_day = new DateTime('now');
            $first_day->modify('first day of this month');
            $first_day->modify('-1 days')->format('l d-m-Y');
            
            //display day this week
            $day_display = new DateTime('now');
            $day_display->modify('first day of this month');
            $day_display->modify('-1 days')->format('l');
            
            // //display week starting date
            // $week_starting = new DateTime('now');
            // $week_starting->modify('first day of this month');
            
        @endphp
        {{-- <div class="col-md-6">Month Ending:- <span>{{ $date->format('d-m-Y') }}</span></div>
            <div class="col-md-6">Designation:- <span>Business Analyst </span></div>
            <div class="col-md-12">
                <p class="mb-0 mx-0">This form must be signed by your manager</p>
                <p class="mt-0 mx-0"><strong>Record start and finish times as well as total daily hours worked. Record
                        weekly and monthly hours and days.</strong></p> --}}
        {{-- </div> --}}
        {{-- </div> --}}

        <form method="POST" action="{{ route('employee-timesheet') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
            @if ($settings->timesheet_interval == 'weekly')
                <div class="row">
                    @php
                        // $test = date("F, d-M-Y", strtotime("last friday of this month"));
                        // dd($test);
                        // $now =\carbon\Carbon::now();
                        // $start = $now->startOfWeek(\carbon\Carbon::MONDAY);
                        // $end = $now->endOfWeek(\carbon\Carbon::SUNDAY);
                        $weeks = [];
                        $get_week_dates = function ($position) {
                            $start = date('d-m-Y', strtotime("{$position} Monday of this month"));
                            $time = strtotime($start);
                            $end = strtotime('next sunday, 12:00am', $time);
                            $format = 'l, F j, Y g:i A';
                            $end_day = date($format, $end);
                        
                            return [\carbon\Carbon::parse($start)->format('m-d-Y'), \carbon\Carbon::parse($end_day)->format('m-d-Y')];
                        };
                        
                        $weeks += [
                            'w1' => $get_week_dates('first'),
                            'w2' => $get_week_dates('second'),
                            'w3' => $get_week_dates('third'),
                            'w4' => $get_week_dates('fourth'),
                        ];
                        
                        // dd($weeks);
                        // $weeks_merge_data = array_merge($weeks['w1'],$weeks['w2'],$weeks['w3'],$weeks['w4']);
                        // dd($weeks_merge_data);
                        
                        $holidays = [];
                        foreach (getHoliday() as $holiday) {
                            $holidays[] = ['name' => $holiday->name, 'holiday_date' => $holiday->holiday_date];
                        }
                    @endphp
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select name="supervisor_id" id="edit_supervisor_id" class="select form-control">
                                <option value="">Select Supervisor</option>
                                @foreach (getSupervisor() as $supervisor)
                                    @php
                                        $supervisor = App\Models\Employee::where('user_id', '=', $supervisor->id)->first();
                                        $firstname = !empty($supervisor->firstname) ? $supervisor->firstname : '';
                                        $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
                                        $fullname = $firstname . ' ' . $lastname;
                                    @endphp
                                    <option value="{{ !empty($supervisor->id) ? $supervisor->id : '' }}">
                                        {{ $fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                        <div class="form-group">
                            <label>Months</label>
                            <select name="" id="month" class="select month">
                                <option value="">Select Month</option>
                                @foreach (getMonth() as $index => $month)
                                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Weeks</label>
                            <select name="week" id="week" class="select weekdate">
                                <option value="">Select week</option>
                                {{-- <option value="{{ $weeks['w1'][0] . ' , ' . $weeks['w1'][1] }}">Week-1</option>
                                <option value="{{ $weeks['w2'][0] . ' , ' . $weeks['w2'][1] }}">Week-2</option>
                                <option value="{{ $weeks['w3'][0] . ' , ' . $weeks['w3'][1] }}">Week-3</option>
                                <option value="{{ $weeks['w4'][0] . ' , ' . $weeks['w4'][1] }}">Week-4</option> --}}
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 mt-2">
                        <div class="form-group">
                            <label>Week starting</label>
                            <input type="text" name="daterange" class="form-control" id="enter_date" value="" />
                        </div>
                    </div> --}}
                    {{-- <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label">Timesheet ID <span class="text-danger">*</span></label>
                            <input class="form-control" name="timesheet_id" id="timesheet_id" type="text">
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{-- <p class="mx-0">Week starting:- <strong>{{ $week_starting->format('d-m-Y') }}</strong></p> --}}
                        <p class="mx-0"></p>
                        <table class="table">
                            <tr>
                                <td>Calender Date</td>
                                <td style="width:11%">Days</td>
                                <td>Start Time</td>
                                <td>Finish Time</td>
                                <td>1/2 or 1 Day</td>
                                <td>Project</td>
                                <td>Project Phase</td>
                                <td>Notes</td>
                            </tr>
                            <tbody id="bodyData">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($settings->timesheet_interval == 'monthly')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select name="supervisor_id" id="edit_supervisor_id" class="select form-control">
                                <option value="">Select Supervisor</option>
                                @foreach (getSupervisor() as $supervisor)
                                    @php
                                        $supervisor = App\Models\Employee::where('user_id', '=', $supervisor->id)->first();
                                        $firstname = !empty($supervisor->firstname) ? $supervisor->firstname : '';
                                        $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
                                        $fullname = $firstname . ' ' . $lastname;
                                    @endphp
                                    <option value="{{ !empty($supervisor->id) ? $supervisor->id : '' }}">
                                        {{ $fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">Select Year</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 mt-2">
                        <div class="form-group">
                            <label>Week starting</label>
                            <input type="text" name="daterange" class="form-control" id="enter_date" value="" />
                        </div>
                    </div> --}}
                    <div class="col-lg-4">
                        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                        <div class="form-group">
                            <label>Months</label>
                            <select name="month" id="year_month" class="select month">
                                <option value="">Select Month</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="mx-0"></p>
                        <table class="table">
                            <tr>
                                <td>Calender Date</td>
                                <td>Days</td>
                                <td>Start Time</td>
                                <td>Finish Time</td>
                                <td>1/2 or 1 Day</td>
                                <td>Project</td>
                                <td>Project Phase</td>
                                <td>Notes</td>
                            </tr>

                            @php
                                // $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                // $date = $first_day->format('Y-m-d');
                                // $date = new DateTime();
                                //  echo $first_day->modify("+1 days")->format('l d-m-Y');
                                // $start = '27-11-2014';
                                // $end = '1-12-2014';
                                //     function date_difference($start, $end)
                                //     {
                                //         $first_date = strtotime($start);
                                //         $second_date = strtotime($end);
                                //         $offset = $second_date-$first_date;
                                //         $result = array();
                                //         for($i = 0; $i <= floor($offset/24/60/60); $i++) {
                                //             $result[1+$i]['date'] = date('d-m-Y', strtotime($start. ' + '.$i.'  days'));
                                //             $result[1+$i]['day'] = date('l', strtotime($start. ' + '.$i.' days'));
                                //         }
                                //         echo '<pre>';
                                //         print_r($result);
                                //         echo '</pre>';
                                //     }
                                //     date_difference($start, $end);
                            @endphp
                            {{-- @foreach ($days as $index => $day) --}}
                            <tbody id="bodyData">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <input type="submit" class="btn btn-primary">
        </form>
        {{-- <div class="row">
            <div class="col-md-12">
                <p class="mx-0"><strong>Total Days to be paid for Month Ending:- </strong></p>
                <div class="row mb-3">
                    <div class="col-10">
                        Employee Confirmation:<br />
                        <small>
                            I confirm that this is an accurate record of the times I have worked
                        </small>
                    </div>
                    <div class="col-2 text-right"> 20 Days
                        <div>Signature: <strong>Lavanya Kolli</strong></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        Client Manager Confirmation:<br />
                        <small>Client Manager Confirmation:</small>

                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">Name: </div>
                            <div class="col-6">Signature: </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@section('scripts')

    <script>
        $("#month").change(function() {
            var selectedMonth = $(this).children("option:selected").val();
            // console.log("You have selected the month - " + selectedMonth);
            $.ajax({
                type: 'POST',
                url: '/get-week-days',
                data: {
                    _token: $("#csrf").val(),
                    month: selectedMonth,
                },
                success: function(dataResult) {
                    getData = JSON.parse(dataResult);
                    // console.log(myArray);
                    $("#week").html("<option value=''>select week</option>");
                    var count = 1;
                    $.each(getData.data, function(index, row) {
                        $("#week").append(`<option value="${row.week_start_date},${row.week_end_date}">week-${count}-[${row.week_start_date} To ${row.week_end_date}]
                            </option>`);
                        count++;
                    });
                }
            });
        });

        // $(function() {
        // $('input[name="daterange"]').daterangepicker({
        //     opens: 'left'
        // }, function(start, end, label) {

        $("#week").change(function() {
            var selectedWeek = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/get-holiday-days',
                data: {
                    _token: $("#csrf").val(),
                    selectedWeek: selectedWeek,
                },
                dataType: 'JSON',
                success: function(dataResult) {
                    console.log(dataResult)
                    HolidayDataArrayForm = [];
                    $.each(dataResult.data, function(index, row) {
                        HolidayDataArrayForm[index] = [row.type, row.name, row.holiday_date, row
                            .reason
                        ];
                    });

                    // console.log(leavesDataArrayForm, " leavesDataArrayForm");
                    getWeekData(selectedWeek, HolidayDataArrayForm);
                }
            });
        });

        function getWeekData(selectedWeek, HolidayDataArrayForm) {

            selectedWeekDate = selectedWeek.split(',');
            // console.log(selectedWeekDate, "selectedWeekDate");
            $("#bodyData").html("");

            var startDataData = selectedWeekDate[0].split("-");
            var endDateData = selectedWeekDate[1].split("-");
            var start = new Date(startDataData[2], startDataData[1] - 1, startDataData[0])
            var end = new Date(endDateData[2], endDateData[1] - 1, endDateData[0])
            var TimesheetData = '';
            const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            for (daysLoop = 1; daysLoop <= 7; daysLoop++) {
                var mm = ((start.getMonth() + 1) >= 10) ? (start.getMonth() + 1) : '0' + (start
                    .getMonth() + 1);
                var dd = ((start.getDate()) >= 10) ? (start.getDate()) : '0' + (start.getDate());
                var yyyy = start.getFullYear();
                var day = days[start.getDay()];
                var readonly = "";
                var disabled = "";
                if (day == "Sun") {
                    readonly = "readonly";
                    disabled = "disabled";
                }
                // console.log(day, "day 1")
                var date = yyyy + "-" + mm + "-" + dd; //yyyy-mm-dd      
                var dayColSpan = holidayName = heading = "";
                var leaveReason = "";
                var width = "width:67%";
                var renderReasonHolidayHtml = "";
                if (HolidayDataArrayForm !== false && HolidayDataArrayForm != '') {
                    $.each(HolidayDataArrayForm, function(index, holidayData) {
                        // console.log("holidayData" , holidayData);
                        if (holidayData[2] == date && holidayData[0] == "holiday") {
                            dayColSpan = "5";
                            holidayName += holidayData[1] + " ";
                            heading += "Holiday";
                            width = "width:12%";
                            renderReasonHolidayHtml =
                                `<td colspan="2"><input name="start_time[]" value="" class="form-control start_time" type="hidden">
                                <input name="end_time[]" value="" type="hidden" class="form-control"><input name="hours[]" value="" type="hidden" class="form-control">
                                <input name="project_id[]" value="" type="hidden" class="form-control"> <input name="project_phase_id[]" value="" type="hidden" class="form-control">
                                <input name="notes[]" value="" type="hidden" class="form-control">${heading}:${holidayName}</td>`;
                        } else if (holidayData[2] == date && holidayData[0] == "leave") {
                            dayColSpan = "5";
                            holidayName += holidayData[1] + " ";
                            leaveReason += holidayData[3] + " ";
                            heading += "Leave";
                            width = "width:12%";
                            renderReasonHolidayHtml = `<td colspan="2"><input name="start_time[]" value="" class="form-control start_time" type="hidden">
                                <input name="end_time[]" value="" type="hidden" class="form-control"><input name="hours[]" value="" type="hidden" class="form-control">
                                <input name="project_id[]" value="" type="hidden" class="form-control"> <input name="project_phase_id[]" value="" type="hidden" class="form-control">
                                <input name="notes[]" value="" type="hidden" class="form-control">
                                ${heading}:${holidayName}</br>Leave Reason:${leaveReason}
                                </td>`;
                        }
                    });
                }
                TimesheetData +=
                    '<tr><td><input type="text" style="width:80%" class="form-control" name="calender_date[]" value="' +
                    date + '" readonly></td>' +
                    '<td colspan="' + dayColSpan +
                    '"><input type="text" style="' + width + '"class="form-control" name="calender_day[]" value="' +
                    day +
                    '"></td>';
                if (dayColSpan == "") {
                    TimesheetData +=
                        '<td><input name="start_time[]" value="" class="form-control start_time" type="time" ' +
                        readonly + '></td>' +
                        '<td><input name="end_time[]" value="" type="time" class="form-control end_time" ' +
                        readonly + '></td>' +
                        '<td><select name="hours[]" ' + readonly +
                        ' id="hours" class="form-control hours" ' +
                        ' ><option selected="selected" value="">Select Day</option><option ' + disabled +
                        ' value="half_day">Half Day</option>' +
                        '<option ' + disabled + ' value="full_day">Full Day</option></select></td>' +
                        '<td><select name="project_id[]" ' + readonly +
                        ' id="edit_project_id" class="select form-control">' +
                        '<option value="">Select Project</option>@foreach ($employee_project as $project) <option ' +
                        disabled +
                        ' value="{{ !empty($project->projects->id) ? $project->projects->id : '' }}">{{ !empty($project->projects->name) ? $project->projects->name : '' }}</option>' +
                        '@endforeach</select></td><td><select name="project_phase_id[]"  ' +
                        readonly + ' id="project_phase_id" class="select form-control">' +
                        '<option value="">Select Project Phase</option>@foreach (getProjectPhase() as $phase)<option ' +
                        disabled +
                        ' value="{{ !empty($phase->id) ? $phase->id : '' }}">{{ !empty($phase->name) ? $phase->name : '' }}</option>@endforeach</select></td>' +
                        '<td><textarea class="form-control" id="notes" name="notes[]" rows="3" cols="10" ' +
                        readonly +
                        '></textarea></td>';
                } else {
                    TimesheetData += renderReasonHolidayHtml;
                }
                TimesheetData += "</tr>";
                start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
            }
            $("#bodyData").append(TimesheetData);
        }
        // });
    </script>

    <!-- monthly timesheet script script -->
    <script>
        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth();

        console.log(currentYear, "currentYear");

        for (var i = currentYear; i > currentYear - 10; i--) {
            $("#year").append('<option value="' + i.toString() + '">' + i.toString() + '</option>');
        }

        $("#year").change(function() {
            var currentSelectedYearValue = $(this).val();
            //As Index of Javascript Month is from 0 to 11 therefore totalMonths are 11 NOT 12
            var totalMonths = 11;
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            //Appending Current Valid Months
            $("#year_month").html('<option value="">Select Month</option>');
            for (var month = 0; month <= totalMonths; month++) {
                $("#year_month").append('<option value="' + (month + 1) + '">' + monthNames[month] + '</option>');
            }
        });

        $("#year_month").change(function() {
            var SelectedMonthValue = $(this).val();
            var SelectedYearValue = $("#year").val();
            $.ajax({
                type: 'POST',
                url: '/get-holiday-days',
                data: {
                    _token: $("#csrf").val(),
                    month: SelectedMonthValue,
                    year: SelectedYearValue,
                },
                dataType: 'JSON',
                success: function(dataResult) {
                    HolidayDataArrayForm = [];
                    $.each(dataResult.data, function(index, row) {
                        HolidayDataArrayForm[index] = [row.type, row.name, row.holiday_date, row
                            .reason
                        ];
                    });

                    console.log(HolidayDataArrayForm, "HolidayDataArrayForm");

                    // leavesDataArrayForm = [];
                    // $.each(dataResult.leavesdata, function(index, row) {
                    //     leavesDataArrayForm[index] = [row.from, row.to, row.leave_type,row.reason];
                    // });

                    // console.log(leavesDataArrayForm , "leavesDataArrayForm"); 

                    // getRangeleavedates = [];
                    // $.each(dataResult.leavesdata, function(index, row) {
                    //     getRangeleavedates[index] = [row.from, row.to];
                    // });

                    // console.log(getRangeleavedates[0] ,"getRangeleavedates");

                    renderMonthlyHtml(SelectedMonthValue, SelectedYearValue, HolidayDataArrayForm)
                }
            });
        });

        function renderMonthlyHtml(SelectedMonthValue, SelectedYearValue, HolidayDataArrayForm) {

            var TimesheetData = '';
            $("#bodyData").html(" ");
            //get the last day, so the number of days in that month
            var getdays = new Date(SelectedYearValue, SelectedMonthValue, 0).getDate();
            const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            for (var d = 1; d <= getdays; d++) {
                var yyyy = SelectedYearValue;
                var month = SelectedMonthValue
                var date = yyyy + "-" + month + "-" + d;
                // var day = days[d];
                var startEndDay = new Date(date);
                // console.log(startEndDay, "startEndDay");
                var day = days[startEndDay.getDay()];
                var mm = ((startEndDay.getMonth() + 1) >= 10) ? (startEndDay.getMonth() + 1) : '0' + (startEndDay
                    .getMonth() + 1);
                var yyyy = startEndDay.getFullYear();
                var dd = ((startEndDay.getDate()) >= 10) ? (startEndDay.getDate()) : '0' + (startEndDay.getDate());

                var readonly = "";
                var disabled = "";
                if (day == "Sun") {
                    readonly = "readonly";
                    disabled = "disabled";
                }
                var dateFormat = yyyy + "-" + mm + "-" + dd; //yyyy-mm-dd
                var dayColSpan = holidayName = heading = "";
                var leaveReason = "";
                var width = "width:67%";
                var renderReasonHolidayHtml = "";
                if (HolidayDataArrayForm !== false && HolidayDataArrayForm != '') {
                    $.each(HolidayDataArrayForm, function(index, holidayData) {
                        // console.log(holidayData , "holidayData1");
                        if (holidayData[2] == dateFormat && holidayData[0] == "holiday") {
                            dayColSpan = "5";
                            holidayName += holidayData[1] + " ";
                            heading += "Holiday";
                            width = "width:12%";
                            renderReasonHolidayHtml =`<td colspan="2"><input name="start_time[]" value="" class="form-control start_time" type="hidden">
                                <input name="end_time[]" value="" type="hidden" class="form-control"><input name="hours[]" value="" type="hidden" class="form-control">
                                <input name="project_id[]" value="" type="hidden" class="form-control"> <input name="project_phase_id[]" value="" type="hidden" class="form-control">
                                <input name="notes[]" value="" type="hidden" class="form-control">${heading}:${holidayName}</td>`;
                        } else if (holidayData[2] == dateFormat && holidayData[0] == "leave") {
                            dayColSpan = "5";
                            holidayName += holidayData[1] + " ";
                            leaveReason += holidayData[3] + " ";
                            heading += "Leave";
                            width = "width:12%";
                            renderReasonHolidayHtml = `<td colspan="2"><input name="start_time[]" value="" class="form-control start_time" type="hidden">
                                <input name="end_time[]" value="" type="hidden" class="form-control"><input name="hours[]" value="" type="hidden" class="form-control">
                                <input name="project_id[]" value="" type="hidden" class="form-control"> <input name="project_phase_id[]" value="" type="hidden" class="form-control">
                                <input name="notes[]" value="" type="hidden" class="form-control">${heading}:${holidayName}</br>Leave Reason:${leaveReason}</td>`;
                        }
                    });
                }

                TimesheetData +=
                    '<tr><td><input type="text" style="width:80%" class="form-control" name="calender_date[]" value="' +
                    dateFormat + '" readonly></td>' +
                    '<td colspan="' + dayColSpan +
                    '"><input type="text" style="' + width + '" class="form-control" name="calender_day[]" value="' +
                    day +
                    '"></td>';
                if (dayColSpan == "") {
                    TimesheetData +=
                        '<td><input name="start_time[]" value="" class="form-control start_time" type="time" ' +
                        readonly + '></td>' +
                        '<td><input name="end_time[]" value="" type="time" class="form-control end_time" ' +
                        readonly + '></td>' +
                        '<td><select name="hours[]" ' + readonly +
                        ' id="hours" class="form-control hours" ' +
                        ' ><option selected="selected" value="">Select Day</option><option ' + disabled +
                        ' value="half_day">Half Day</option>' +
                        '<option ' + disabled + ' value="full_day">Full Day</option></select></td>' +
                        '<td><select name="project_id[]" ' + readonly +
                        ' id="edit_project_id" class="select form-control">' +
                        '<option value="">Select Project</option>@foreach ($employee_project as $project) <option ' +
                        disabled +
                        ' value="{{ !empty($project->projects->id) ? $project->projects->id : '' }}">{{ !empty($project->projects->name) ? $project->projects->name : '' }}</option>' +
                        '@endforeach</select></td><td><select name="project_phase_id[]"  ' +
                        readonly + ' id="project_phase_id" class="select form-control">' +
                        '<option value="">Select Project Phase</option>@foreach (getProjectPhase() as $phase)<option ' +
                        disabled +
                        ' value="{{ !empty($phase->id) ? $phase->id : '' }}">{{ !empty($phase->name) ? $phase->name : '' }}</option>@endforeach</select></td>' +
                        '<td><textarea class="form-control" id="notes" name="notes[]" rows="3" cols="10" ' + readonly +
                        '></textarea></td>';
                } else {
                    TimesheetData += renderReasonHolidayHtml;
                }
                TimesheetData += "</tr>";
            }
            $("#bodyData").append(TimesheetData);
        }
    </script>
@endsection
