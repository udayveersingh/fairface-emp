<?php

namespace Database\Seeders;

use App\Models\JobTitle;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = ['Software Engineer', 'Business Analyst', 'Test Analyst', 'Project Manager', 'HR Manager', 'Office Administrator', 'Graphic Desiner', 'Director', 'CEO'];
        $descriptions = ['Design, Develop and test applications.', 'Analyst', '', 'Manage the project and lead the team.', 'Human Resource Manager', 'Office Administrator', '', ''];

        foreach ($titles as $key => $title) {
            $job_title = JobTitle::where('title', '=', $title)->first();
            if (!empty($job_title)) {
                $job_titles = JobTitle::find($job_title->id);
            } else {
                $job_titles = new JobTitle();
            }

            $job_titles->title = $title;
            $job_titles->description = !empty($descriptions[$key]) ? $descriptions[$key]:'';
            $job_titles->save();
        }
    }
}
