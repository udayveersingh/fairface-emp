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
                {{-- <h3 class="text-left">Employee Time Sheet</h3> --}}
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-6">Employee Name:- <span>{{ Auth::user()->name }}</span></div> --}}
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
                        weekly and monthly hours and days.</strong></p>
            </div>
        </div> --}}

        <form method="POST" action="{{ route('employee-timesheet') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
            @if ($settings->timesheet_interval == 'weekly')
                <label>Week starting</label>
                <input type="text" name="daterange" class="form-control" style="width:200px" value="" />
                <div class="row">
                    <div class="col-md-12">
                        {{-- <p class="mx-0">Week starting:- <strong>{{ $week_starting->format('d-m-Y') }}</strong></p> --}}
                        <p class="mx-0"></p>
                        <table class="table">
                            <tr>
                                <td>Calender Date</td>
                                <td>Days</td>
                                <td>Start Time</td>
                                <td>Finish Time</td>
                                <td>1/2 or 1 Day</td>
                            </tr>

                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                // $date = $first_day->format('Y-m-d');
                                // $date = new DateTime();
                                //  echo $first_day->modify("+1 days")->format('l d-m-Y');
                            @endphp
                            @foreach ($days as $index => $day)
                                <tr>
                                    {{-- <input type="hidden" name="calender_date[]" value="{{$first_day->modify("+1 days")->format('Y-m-d')}}"> --}}
                                    <td><input type="text" class="form-control" name="calender_date[]"
                                            value="{{ $first_day->modify('+1 days')->format('Y-m-d') }}" readonly></td>
                                    <td><input name="calender_day[]"
                                            value="{{ $day_display->modify('+1 days')->format('l') }}" class="form-control"
                                            type="text" readonly></td>
                                    <td><input name="start_time[]" value="" class="form-control start_time"
                                            type="time"></td>
                                    <td><input name="end_time[]" value="" type="time"
                                            class="form-control end_time"></td>
                                    <td>
                                        <select name="hours[]" id="hours" class="form-control">
                                            <option value="">Select Day</option>
                                            <option value="half_day">Half Day</option>
                                            <option value="full_day">Full Day</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                            <td>Tue</td>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Wed</td>
                            <td>3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Thur</td>
                            <td>4</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Fri</td>
                            <td>5</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Sat</td>
                            <td>6</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Sun</td>
                            <td>7</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr> --}}
                            {{-- <tr>
                            <td colspan="5" align="end">Total</td>
                            <td>4</td>
                        </tr> --}}
                        </table>
                    </div>
                    {{-- <div class="col-md-6">
				<p class="mx-0">Week starting:- <strong>5/8/2023	</strong></p>
				<table class="table">
					<tr>						
						<td></td>
						<td>#</td>
						<td>Start Time</td>
						<td>Finish Time</td>
						<td>Break</td>
						<td>1/2 or 1 Day</td>
					</tr>
					<tr>						
						<td>Mon</td>
						<td>8</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td>Tue</td>
						<td>9</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Wed</td>
						<td>10</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Thur</td>
						<td>11</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Fri</td>
						<td>12</td>
						<td></td>
						<td></td>
						<td></td>
						<td>1</td>
					</tr>
					<tr>						
						<td>Sat</td>
						<td>13</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td>Sun</td>
						<td>14</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>						
						<td colspan="5" align="end">Total</td>
						<td>4</td>
					</tr>
				</table>
			</div> --}}
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
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
                var teststart = start.format('YYYY-MM-DD');
                console.log(teststart, "teststart");
            });
        });
    </script>
@endsection
