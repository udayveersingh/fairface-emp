<?php

namespace App\Console\Commands;

use App\Mail\AutomaticMailReminder;
use App\Models\Employee;
use App\Models\EmployeeVisa;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoMailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:mailreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $nextSixMonth = date('Y-m-d', strtotime('+6 month'));
        $passport_expiry_list = Employee::whereBetween("passport_expiry_date", [date('Y-m-d'), $nextSixMonth])->get();
        if ($passport_expiry_list->count() > 0) {
            foreach ($passport_expiry_list as $user_pass_list) {
                $content = [
                    'subject_type' => 'Your Passport application is going to be expire soon!',
                    'name' => "Dear " . $user_pass_list->firstname . " " .  $user_pass_list->lastname . ",",
                    'subject' => "It's a reminder email to notify you that your Passport is expiring soon. Please contact HR to update your documents.",
                    'regards' => 'Regards,HR Team.'
                ];
                Mail::to($user_pass_list->email)->send(new AutomaticMailReminder($content));
            }
        }

        $visa_expiry_list = EmployeeVisa::join('employees', 'employees.id', '=', 'employee_visas.employee_id')
            ->whereBetween("visa_expiry_date", [date('Y-m-d'), $nextSixMonth])
            ->select(['employees.id', 'employees.employee_id', 'visa_expiry_date', 'employees.firstname', 'employees.lastname', 'employees.email'])
            ->get();
        if ($visa_expiry_list->count() > 0) {
            foreach ($visa_expiry_list as $expiry_list) {
                $content = [
                    'subject_type' => 'Your Visa application is going to be expire soon!',
                    'name' => "Dear " . $expiry_list->firstname . " " .  $expiry_list->lastname . ",",
                    'subject' => "It's a reminder email to notify you that your Passport is expiring soon. Please contact HR to update your documents.",
                    'regards' => 'Regards,HR Team.'
                ];
                Mail::to($expiry_list->email)->send(new AutomaticMailReminder($content));
            }
        }


        $cos_expiry_list = EmployeeVisa::join('employees', 'employees.id', '=', 'employee_visas.employee_id')
            ->whereBetween("cos_expiry_date", [date('Y-m-d'), $nextSixMonth])
            ->select(['employees.id', 'employees.employee_id', 'cos_expiry_date', 'employees.firstname', 'employees.lastname'])
            ->get();

        if ($cos_expiry_list->count() > 0) {
            foreach ($cos_expiry_list as $expiry_list) {
                $content = [
                    'subject_type' => 'Your Cos application is going to be expire soon!',
                    'name' => "Dear " . $expiry_list->firstname . " " .  $expiry_list->lastname . ",",
                    'subject' => "It's a reminder email to notify you that your Passport is expiring soon. Please contact HR to update your documents.",
                    'regards' => 'Regards,HR Team.'
                ];
                Mail::to($expiry_list->email)->send(new AutomaticMailReminder($content));
            }
        }

        return 0;
    }
}
