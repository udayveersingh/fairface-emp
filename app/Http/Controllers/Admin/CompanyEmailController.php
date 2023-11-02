<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmail;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\Annoucement;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\newMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

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
        $todayDate = Carbon::now()->toDateString();
        $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)
            ->where('end_date', '>=', $todayDate)
            ->where('status', '=', 'active')->get();
        $company_emails = CompanyEmail::with('employeejob.employee')->latest()->get();
        $count_emails = CompanyEmail::count();
        $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
        $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
        $notifications = DB::table('notifications')->where('type', '=', 'App\Notifications\newMailNotification')->get();
        $array_data = [];
        foreach ($notifications as $index => $notification) {
            $array_data[$index] = json_decode($notification->data);
        }

        foreach ($array_data as $value) {
        }
        // Notification::send($company_emails, new newMailNotification($company_emails));
        return view('backend.company-email', compact('title', 'company_emails', 'employee_jobs', 'array_data', 'count_emails', 'count_unread_emails', 'annoucement_list', 'sent_email_count'));
    }


    public function unreadMails()
    {

        $title = "Company Email";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $todayDate = Carbon::now()->toDateString();
            $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)
                ->where('end_date', '>=', $todayDate)
                ->where('status', '=', 'active')->get();
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            $total_mail_count = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->count();
            $count_unread_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->whereNotNull('read_at')->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->count();
            $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->whereNotNull('read_at')->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->get();
            $company_emails_count = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_job->id)->latest()->count();
            $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
            return view('backend.emails.email-inbox', compact('title', 'company_emails', 'company_emails_count', 'annoucement_list', 'employee_job', 'sent_email_count', 'count_unread_emails','total_mail_count'));
        } else {
            $employee_jobs = EmployeeJob::with('employee')->get();
            $todayDate = Carbon::now()->toDateString();
            $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)->where('end_date', '>=', $todayDate)
                ->where('status', '=', 'active')->get();
            $company_emails = CompanyEmail::with('employeejob.employee')->whereNotNull('read_at')->latest()->get();
            $count_emails = CompanyEmail::count();
            $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
            $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
            return view('backend.company-email', compact('title', 'company_emails', 'employee_jobs', 'count_emails', 'count_unread_emails', 'annoucement_list', 'sent_email_count'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailInbox()
    {
        $title = "User Email";
        $todayDate = Carbon::now()->toDateString();
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $annoucement_list = Annoucement::where('start_date', '<=', $todayDate)
                ->where('end_date', '>=', $todayDate)
                ->where('status', '=', 'active')->get();
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
            // $company_emails = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_jobs->id)->orwhere('to_id', '=', $employee_jobs->id)->latest()->get();
            if (empty($employee_job)) {
                $errorMessageDuration = 'Please add job information from admin side Or contact admin.';
                return view('backend.emails.email-inbox', compact('title', 'errorMessageDuration'));
                // return redirect()->route('user-email-inbox')->with('success', 'please add job information');
            }

            $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->get();
            $total_mail_count = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->count();
            $company_emails_count = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_job->id)->latest()->count();
            $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
            return view('backend.emails.email-inbox', compact('title', 'company_emails', 'company_emails_count', 'annoucement_list', 'employee_job', 'sent_email_count', 'count_unread_emails','total_mail_count'));
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
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            $company_emails_count = CompanyEmail::with('employeejob')->where('from_id', '=', $employee_job->id)->latest()->count();
            $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
            $count_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->count();
            $company_emails = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get();
            $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
            return view('backend.emails.compose-email', compact('title', 'employee', 'employee_jobs','company_emails_count','sent_email_count','count_emails','company_emails','count_unread_emails'));
        } else if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN || Auth::user()->role->name == Role::ADMIN) {
            $employee_jobs = EmployeeJob::with('employee')->whereHas('employee', function ($q) {
                $q->where('record_status', '=', 'active');
            })->get();
            $count_emails = CompanyEmail::count();
            $sent_email_count = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get()->count();
            $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
            $company_emails = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get();
            return view('backend.emails.compose-email', compact('title', 'employee_jobs','count_emails','sent_email_count','count_unread_emails','company_emails'));
        }
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
        $cc = Null;
        $to_mail_ids = "";
        if (!empty($request->cc)) {
            $cc = implode(",", $request->cc);
        }

        $to_ids = array_unique($request->to_id);
        if (!empty($to_ids)) {
            $to_mail_ids = implode(",",  $to_ids);
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
        $company_email->to_id  = $to_mail_ids;
        $company_email->company_cc  = $cc;
        $company_email->date = $request->email_date;
        $company_email->time = $request->email_time;
        $company_email->subject = $request->email_subject;
        $company_email->body = $request->email_body;
        $company_email->attachment = $imageName;
        $company_email->read_at = Carbon::now();
        $company_email->sent_by_user_id = Auth::user()->id;
        // $company_email->to_mails = $request->to_others_mail;
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
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            return redirect()->route('user-email-inbox')->with('success', $message);
        } else {
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
        // dd($request->all());
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
        $employee = "";
        if (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE || Auth::user()->role->name == Role::SUPERVISOR) {
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();
            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();
            $count_emails = CompanyEmail::with('employeejob.employee')->where('from_id', '=', $employee_job->id)->orwhereRaw("FIND_IN_SET(?, to_id)", [$employee_job->id])->latest()->count();
        } else {
            $count_emails = CompanyEmail::count();
        }
        $count_unread_emails = CompanyEmail::whereNotNull('read_at')->latest()->count();
        $company_emails = CompanyEmail::with('employeejob')->where('sent_by_user_id', '=', Auth::user()->id)->latest()->get();
        return view('backend.emails.sent-email', compact('title', 'company_emails', 'count_emails', 'count_unread_emails', 'employee'));
        // }
    }

    /**
     * check mail detail 
     */
    public function mailDetail($from_id, Request $request)
    {
        $title = "mail";
        $read_at_update = CompanyEmail::find($request->id);
        $read_at_update->read_at = Null;
        $read_at_update->save();
        $company_emails = CompanyEmail::with('employeejob.employee')->where('id', '=', $request->id)->where('from_id', '=', $from_id)->latest()->get();
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee_job = EmployeeJob::with('employee')->whereHas('employee', function (Builder $query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->first();

            return json_encode(array('employee_data' => $employee_job, 'email_data' => $company_emails));

            //   $company_emails = CompanyEmail::with('employeejob.employee')->where('from_id','=',decrypt($from_id))->orwhere('to_id','=',$to_id)->get();
            // return view('backend.emails.mail-detail', compact('company_emails', 'title', 'employee_job'));
        } else {
            $employee_job = EmployeeJob::find($from_id);
            // dd($company_emails);
            return json_encode(array('employee_data' => $employee_job, 'email_data' => $company_emails));
            // return view('backend.emails.mail-detail', compact('company_emails', 'title','employee_job'));
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
        $to_ids = "";
        if (!empty($request->to_id)) {
            $to_ids = implode(',', $request->to_id);
        }
        $company_email = new CompanyEmail();
        $company_email->from_id = $request->from_id;
        $company_email->to_id  = $to_ids;
        $company_email->body = $request->email_body;
        $company_email->subject = $request->subject;
        $company_email->attachment = $imageName;
        $company_email->date = $request->email_date;
        $company_email->time = $request->email_time;
        $company_email->read_at = Carbon::now();
        $company_email->sent_by_user_id = Auth::user()->id;
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
        return back()->with('success', "Reply Message has been sent successfully.");
    }

    public function emailRead(Request $request)
    {
        $data = $request->all();
        // $company_emails = CompanyEmail::with('employeejob.employee')->select('*', DB::raw("GROUP_CONCAT(from_id SEPARATOR ',') as `from_id`"), DB::raw("GROUP_CONCAT(to_id SEPARATOR ',') as `to_id`"))->groupBy('to_id')->where('id','=',$request['id'])->latest()->first();

        // dd($company_emails);

        return json_encode(array('data' => $data));
    }

    public function defaultEmails()
    {
        $title = "Default Email";
        return view('backend.default-emails', compact('title'));
    }
}
