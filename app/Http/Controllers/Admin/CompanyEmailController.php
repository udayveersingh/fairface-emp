<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmail;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;

class CompanyEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Company Email";
        $employee_jobs = EmployeeJob::with('employee')->get();
        $company_emails = CompanyEmail::with('employeejob')->get();
        return view('backend.company-email', compact('title', 'company_emails','employee_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'from_id' => 'required',
            'to_id' => 'required',
        ]);
        $imageName = Null;
        if ($request->hasFile('email_attachment')) {
            $imageName = time() . '.' . $request->email_attachment->extension();
            $request->email_attachment->move(public_path('storage/company_email/attachment'), $imageName);
        }
         if(!empty($request->id))
         {
            $company_email = CompanyEmail::find($request->id); 
            $message = "Company Email data has been updated";
         }else{
             $company_email = new CompanyEmail();
             $message = "Company Email data has been added";
         }
         $company_email->from_id = $request->from_id;
         $company_email->to_id  = $request->to_id;
         $company_email->cc  = $request->cc;
         $company_email->date = $request->email_date;
         $company_email->time = $request->email_time;
         $company_email->subject = $request->email_subject;
         $company_email->body = $request->email_body;
         $company_email->attachment = $imageName;
         $to_email = EmployeeJob::where('id', '=', $company_email->to_id)->value('work_email');
         $form_email =  EmployeeJob::where('id', '=', $company_email->from_id)->value('work_email');
         $cc_email =  EmployeeJob::where('id', '=', $request->cc)->value('work_email');
         $emp_job_detail = ([
             'to'   =>  $to_email,
             'from' => $form_email,
             'cc_email' => $cc_email,
             'subject' => $request->email_subject,
             'attachment' => $imageName
            ]);
           Mail::to($to_email)->send(new WelcomeMail($emp_job_detail));
           $company_email->save();

        //    dd("Mail Sent Successfully!");
           return back()->with('success',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $company_email = CompanyEmail::find($request->id);
        $company_email->delete();
        return back()->with('success', "Company Email has been deleted successfully!!.");
    }
}
