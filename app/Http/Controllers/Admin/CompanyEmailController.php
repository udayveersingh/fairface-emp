<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmail;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\newMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;

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
        // $company_emails = CompanyEmail::with('employeejob')->get();

        $company_emails = CompanyEmail::with('employeejob.employee')->select('*', DB::raw("GROUP_CONCAT(from_id SEPARATOR ',') as `from_id`"), DB::raw("GROUP_CONCAT(to_id SEPARATOR ',') as `to_id`"))->groupBy('to_id')->latest()->get();
        $notifications = DB::table('notifications')->where('type','=','App\Notifications\newMailNotification')->get();
        $array_data = [];
        foreach($notifications as $index=>$notification)
        {
           $array_data[$index] = json_decode($notification->data);
        }

        foreach($array_data as $value){
        } 
       // Notification::send($company_emails, new newMailNotification($company_emails));
        return view('backend.company-email', compact('title', 'company_emails', 'employee_jobs','array_data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function emailInbox()
    {
        $title = "User Email";
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee_jobs = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            // $company_emails = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_jobs->id)->orwhere('to_id', '=', $employee_jobs->id)->latest()->get();
            if(empty($employee_jobs))
            {
                $errorMessageDuration = 'Please add job information from admin side Or contact admin.';
                return view('backend.emails.email-inbox',compact('title','errorMessageDuration'));
                // return redirect()->route('user-email-inbox')->with('success', 'please add job information');
            }
            $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_jobs->id)->orwhere('to_id', '=', $employee_jobs->id)->select('*', DB::raw("GROUP_CONCAT(from_id SEPARATOR ',') as `from_id`"), DB::raw("GROUP_CONCAT(to_id SEPARATOR ',') as `to_id`"))->groupBy('to_id')->latest()->get();
            return view('backend.emails.email-inbox', compact('title', 'company_emails', 'employee_jobs'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function composeEmail()
    {
        $title = "User Email";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $employee_jobs = EmployeeJob::with('employee')->get();
        }
        return view('backend.emails.compose-email', compact('title', 'employee', 'employee_jobs'));
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
        $cc =Null;
        if(!empty($request->cc)){
            $cc = implode(",", $request->cc);
        }
        $imageName = Null;
        if ($request->hasFile('email_attachment')) {
            $imageName = time() . '.' . $request->email_attachment->extension();
            $request->email_attachment->move(public_path('storage/company_email/attachment'), $imageName);
        }
        if (!empty($request->id)) {
            $company_email = CompanyEmail::find($request->id);
            $message = "Company Email data has been updated";
        } else {
            $company_email = new CompanyEmail();
            $message = "Company Email data has been added";
        }
        $company_email->from_id = $request->from_id;
        $company_email->to_id  = $request->to_id;
        $company_email->company_cc  = $cc;
        $company_email->date = $request->email_date;
        $company_email->time = $request->email_time;
        $company_email->subject = $request->email_subject;
        $company_email->body = $request->email_body;
        $company_email->attachment = $imageName;
        //  $to_email = EmployeeJob::where('id', '=', $company_email->to_id)->value('work_email');
        //  $form_email =  EmployeeJob::where('id', '=', $company_email->from_id)->value('work_email');


        // $cc_ids = explode(',', $cc);
        // $cc_value = [];
        // foreach ($cc_ids as $cc_id) {
        //     $cc_email =  EmployeeJob::where('id', '=',  $cc_id)->value('work_email');
        //     $cc_value[] = "'" . $cc_email . "'";
        // }

        //  $multi_cc_value = implode(',', $cc_value);

        //  $emp_job_detail = ([
        //      'to'   =>  $to_email,
        //      'from' => $form_email,
        //      'cc_email' => $multi_cc_value,
        //      'subject' => $request->email_subject,
        //      'attachment' => $imageName
        //     ]);
        //    Mail::to($to_email)->send(new WelcomeMail($emp_job_detail));
        $company_email->save();
        $company_email->notify(new newMailNotification($company_email));

        //    dd("Mail Sent Successfully!");
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
        return redirect()->route('user-email-inbox')->with('success', $message);
        }else{
            return redirect()->route('company-email')->with('success', $message);
        }
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

    /**
     * sent emails
     */
    public function sentEmail()
    {
        $title = "User Email";
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee_jobs = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            $company_emails = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_jobs->id)->latest()->get();
            return view('backend.emails.sent-email', compact('title', 'company_emails', 'employee_jobs'));
        }
    }

    /**
     * check mail detail 
     */
    public function mailDetail($from_id, $to_id)
    {
        $title = "mail";
        $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', decrypt($from_id))->orwhere('from_id', '=', $to_id)->get();
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {    
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            //   $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id','=',decrypt($from_id))->orwhere('to_id','=',$to_id)->get();
            return view('backend.emails.mail-detail', compact('company_emails', 'title', 'employee_job'));
        }else{
            $employee_job = EmployeeJob::find(decrypt($from_id));
            return view('backend.emails.mail-detail', compact('company_emails', 'title','employee_job'));
        }
    }

    /**
     * reply store function
     */
    public function replyStore(Request $request)
    {
        $imageName = Null;
        if ($request->hasFile('email_attachment')) {
            $imageName = time() . '.' . $request->email_attachment->extension();
            $request->email_attachment->move(public_path('storage/company_email/attachment'), $imageName);
        }
        $company_email = new CompanyEmail();
        $company_email->from_id = $request->from_id;
        $company_email->to_id  = $request->to_id;
        $company_email->body = $request->email_body;
        $company_email->subject = $request->subject;
        $company_email->attachment = $imageName;
        // $to_email = EmployeeJob::where('id', '=', $company_email->to_id)->value('work_email');
        // $form_email =  EmployeeJob::where('id', '=', $company_email->from_id)->value('work_email');
        // $emp_job_detail = ([
        //          'to'   =>  $to_email,
        //          'from' => $form_email,
        //          'cc_email' => "",
        //          'subject' => $request->email_subject,
        //          'attachment' => $imageName
        //         ]);
        // Mail::to($to_email)->send(new WelcomeMail($emp_job_detail));
        $company_email->save();
        $company_email->notify(new newMailNotification($company_email)); 
        // return $company_email;
        // dd($company_email->notifications);

        // Notification::send($company_email, new newMailNotification($company_email));
        return back();
    }
}
