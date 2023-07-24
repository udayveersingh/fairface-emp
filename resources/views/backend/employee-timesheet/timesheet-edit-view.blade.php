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
            
            //use for selected dropdown value
            $get_month = strtotime($start_date);
            $month_value = date('n', $get_month);
        @endphp
        <form method="POST" action="{{ route('employee-timesheet') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$employee_timesheets[0]->employee_id}}">
            {{-- @if ($settings->timesheet_interval == 'weekly') --}}
                <div class="row">
                    {{-- <div class="col-lg-4">
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
                                    <option
                                        value="{{ !empty($supervisor->id) ? $supervisor->id : '' }}"{{ !empty($supervisor->id) && $supervisor->id == $employee_timesheets[0]->supervisor_id ? 'selected' : '' }}>
                                        {{ $fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <input type="hidden" value="{{$employee_timesheets[0]->supervisor_id}}" name="supervisor_id">
                    {{-- <div class="col-lg-4">
                        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
                        <div class="form-group">
                            <label>Months</label>
                            <select name="" id="month" class="select month">
                                <option value="">Select Month</option>
                                @foreach (getMonth() as $index => $month)
                                    <option value="{{ $index + 1 }}"{{ !empty($month_value) && $month_value == $index + 1 ? 'selected' : '' }}>
                                        {{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="week"
                                                value="{{$employee_timesheets[0]->start_date .",". $employee_timesheets[0]->end_date}}">
                            {{-- <label>Weeks</label>
                            <select name="week" id="week" class="select weekdate">
                                <option value="">Select week</option>
                                @if($employee_timesheets[0]->start_date != null && $employee_timesheets[0]->end_date != null)
                                <option value="{{$employee_timesheets[0]->start_date .",". $employee_timesheets[0]->end_date}}">{{"[week-".$employee_timesheets[0]->start_date." "."To"." ".$employee_timesheets[0]->end_date."]"}}</option>
                                @endif
                            </select> --}}
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
                            <tbody id="bodyData">
                                @foreach ($employee_timesheets as $timesheet)
                                    @php
                                        $readonly = '';
                                        if (!empty($timesheet->calender_day) && $timesheet->calender_day == 'Sun') {
                                            $readonly = 'readonly';
                                            $disabled = 'disabled';
                                        } else {
                                            $readonly = ' ';
                                            $disabled = ' ';
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td width="12%"><input type="text" class="form-control" name="calender_date[]"
                                                value="{{ $timesheet->calender_date }}" readonly></td>
                                        <td><input type="text" style="" class="form-control" name="calender_day[]"
                                                value="{{ $timesheet->calender_day }}" readonly></td>
                                        <td>
                                            <input name="start_time[]" class="form-control start_time" type="time"
                                                value="{{ !empty($timesheet->from_time) ? $timesheet->from_time : '' }}"
                                                {{ $readonly }}>
                                        </td>
                                        <td><input name="end_time[]"
                                                value="{{ !empty($timesheet->to_time) ? $timesheet->to_time : '' }}"
                                                type="time" class="form-control end_time" {{ $readonly }}></td>
                                        <td width="10%"><select name="hours[]" id="hours" class="form-control hours"
                                                {{ $readonly }}>
                                                <option selected="selected" value="">Select Day</option>
                                                <option
                                                    value="half_day"{{ !empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '4 hours' ? 'selected' : '' }}
                                                    {{ $disabled }}>Half Day</option>
                                                <option
                                                    value="full_day"{{ !empty($timesheet->total_hours_worked) && $timesheet->total_hours_worked == '8 hours' ? 'selected' : '' }}
                                                    {{ $disabled }}>Full Day</option>
                                            </select></td>
                                        <td><select name="project_id[]" id="edit_project_id" class="form-control"
                                                {{ $readonly }}>
                                                <option value="">Select Project</option>
                                                @foreach ($employee_project as $project)
                                                    <option
                                                        value="{{ !empty($project->projects->id) ? $project->projects->id : '' }}"
                                                        {{ !empty($timesheet->project_id) && $timesheet->project_id == $project->projects->id ? 'selected' : '' }}
                                                        {{ $disabled }}>
                                                        {{ !empty($project->projects->name) ? $project->projects->name : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><select name="project_phase_id[]" id="project_phase_id" class="form-control"
                                                {{ $readonly }}>
                                                <option value="">Select Project Phase</option>
                                                @foreach (getProjectPhase() as $phase)
                                                    <option value="{{ !empty($phase->id) ? $phase->id : '' }}"
                                                        {{ !empty($timesheet->projectphase->id) && $timesheet->projectphase->id == $phase->id ? 'selected' : '' }}
                                                        {{ $disabled }}>
                                                        {{ !empty($phase->name) ? $phase->name : '' }}</option>
                                                @endforeach
                                            </select></td>
                                        <td>
                                            <textarea class="form-control" id="notes" name="notes[]" rows="3" cols="10" {{ $readonly }}>{{ $timesheet->notes }}</textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            {{-- @elseif ($settings->timesheet_interval == 'monthly') --}}
                {{-- <div class="row">
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
                            @endphp
                            <tbody id="bodyData">
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            {{-- @endif --}}
            <input type="submit" class="btn btn-primary">
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        // $("#month").change(function() {
        //     var selectedMonth = $(this).children("option:selected").val();
        //     // console.log("You have selected the month - " + selectedMonth);
        //     $.ajax({
        //         type: 'POST',
        //         url: '/get-week-days',
        //         data: {
        //             _token: $("#csrf").val(),
        //             month: selectedMonth,
        //         },
        //         success: function(dataResult) {
        //             getData = JSON.parse(dataResult);
        //             // console.log(myArray);
        //             $("#week").html("<option value=''>select week</option>");
        //             var count = 1;
        //             $.each(getData.data, function(index, row) {
        //                 $("#week").append(`<option value="${row.week_start_date},${row.week_end_date}">week-${count}-[${row.week_start_date} To ${row.week_end_date}]
        //                     </option>`);
        //                 count++;
        //             });
        //         }
        //     });
        // });
    </script>
@endsection
