<?php

namespace Database\Seeders;

use App\Models\TimesheetStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesheetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['submitted', 'pending approval', 'approved', 'rejected'];

        foreach ($statuses as $value) {
            $timesheet_status = TimesheetStatus::where('status', '=', $value)->first();
            if (!empty($timesheet_status)) {
                $status = TimesheetStatus::find($timesheet_status->id);
            }else{
                $status = new TimesheetStatus();
            }
            $status->status = $value;
            $status->save();
        }
    }
}
