<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CompanySettings extends Settings{

    public string $company_name,$contact_person,$address,$country,
            $city,$province,$postal_code,$email,$phone,$mobile,
            $fax,$website_url,$timesheet_interval;

    public static function group(): string
    {
        return 'company';
    }

}