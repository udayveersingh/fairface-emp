<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\ExpenseType;
use App\Models\Holiday;
use App\Models\LeaveType;
use App\Models\ProjectPhase;
use App\Models\Visa;
use Illuminate\Database\Seeder;

class HolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = [
            "New Year's Day",
            "Good Friday",
            "Easter Monday",
            "May Day",
            "King’s Coronation Day (The Extra Bank Holiday in 2023)",
            "Spring Bank Holiday",
            "Summer Bank Holiday",
            "Christmas Day",
            "Boxing Day",
            "New Year's Day",
            "Good Friday",
            "Easter Monday",
            "May Day",
            "Spring Bank Holiday",
            "Summer Bank Holiday",
            "Christmas Day",
            "Boxing Day",
        ];
        $holiday_date = [
            "2023-01-02",
            "2023-04-07",
            "2023-04-10",
            "2023-05-01",
            "2023-05-08",
            "2023-05-29",
            "2023-08-28",
            "2023-12-25",
            "2023-12-26",
            "2024-01-01",
            "2024-03-29",
            "2024-04-01",
            "2024-05-06",
            "2024-05-27",
            "2024-08-26",
            "2024-12-25",
            "2024-12-26",
        ];


        foreach ($name as $key => $value) {
            $holiday = Holiday::where('name', '=', $value)->where('holiday_date', '=', $holiday_date[$key])->first();
            if (!empty($holiday)) {
                $holidays = Holiday::find($holiday->id);
            } else {
                $holidays = new Holiday();
            }

            $holidays->name = $value;
            $holidays->holiday_date = $holiday_date[$key];
            $holidays->save();
        }

        $branches = ['branch_code' => 'Main Office', 'branch_address' => 'London, W5 6JQ'];
        $branch = Branch::where('branch_code', '=', $branches['branch_code'])->where('branch_address', '=', $branches['branch_address'])->first();
        if (!empty($branch)) {
            $branchs = Branch::find($branch->id);
        } else {
            $branchs = new Branch();
        }
        $branchs->branch_code = $branches['branch_code'];
        $branchs->branch_address = $branches['branch_address'];
        $branchs->save();


        $types = ['Annual Leave', 'Sick Leave', 'Unpaid Leave', 'Maternity Leave', 'Paternity Leave'];
        $days = ['21', '5', '25', '20', '20'];

        foreach ($types as $key => $value) {
            $leave_type = LeaveType::where('type', '=', $value)->where('days', '=', $days[$key])->first();
            if (!empty($leave_type)) {
                $leave_types = LeaveType::find($leave_type->id);
            } else {
                $leave_types = new LeaveType();
            }

            $leave_types->type = $value;
            $leave_types->days = $days[$key];
            $leave_types->save();
        }

        $departments = ['Information Technology', 'Sales and Marketing', 'HR', 'Management'];

        foreach ($departments as $value) {
            $depart = Department::where('name', '=', $value)->first();
            if (!empty($depart)) {
                $department = Department::find($depart->id);
            } else {
                $department = new Department();
            }
            $department->name = $value;
            $department->save();
        }

        $expense_types = ['Train/Bus Travel', 'Mileage', 'Subsistance'];

        foreach ($expense_types as $value) {
            $expense_type = ExpenseType::where('type', '=', $value)->first();
            if (!empty($expense_type)) {
                $expens_type = ExpenseType::find($expense_type->id);
            } else {
                $expens_type = new ExpenseType();
            }
            $expens_type->type = $value;
            $expens_type->save();
        }

        $visas = ['Skilled Worker Visa', 'Indefinite Leave to Remain', 'Student Visa', 'Post Study Work'];
        foreach ($visas as $value) {
            $visas = Visa::where('visa_type', '=', $value)->first();
            if (!empty($visas)) {
                $visa_type = Visa::find($visas->id);
            } else {
                $visa_type = new Visa();
            }
            $visa_type->visa_type = $value;
            $visa_type->save();
        }

        $project_phases = ['Application Development', 'Quality Analysis', 'Design', 'UAT'];
        foreach ($project_phases as $value) {
            $projectPhase = ProjectPhase::where('name', '=', $value)->first();
            if (!empty($projectPhase)) {
                $projectPhases = ProjectPhase::find($projectPhase->id);
            } else {
                $projectPhases = new ProjectPhase();
            }
            $projectPhases->name = $value;
            $projectPhases->save();
        }
    }
}
