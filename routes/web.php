<?php

use App\Events\Message;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\Admin\GoalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\TaxesController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Frontend\JobController;
use App\Http\Controllers\Admin\BackupsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GoalTypeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\EmployeeLeaveController;
use App\Http\Controllers\Admin\ProvidentFundController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Frontend\JobApplicationController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\JobController as BackendJobController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CompanyDocumentController;
use App\Http\Controllers\Admin\CompanyEmailController;
use App\Http\Controllers\Admin\EmployeeAddressController;
use App\Http\Controllers\Admin\EmployeeBankController;
use App\Http\Controllers\Admin\EmployeeDetailController;
use App\Http\Controllers\Admin\EmployeeDocumentController;
use App\Http\Controllers\Admin\EmployeeEmergencyContactController;
use App\Http\Controllers\Admin\EmployeeJobController;
use App\Http\Controllers\Admin\EmployeePayslipController;
use App\Http\Controllers\Admin\EmployeeProjectController;
use App\Http\Controllers\Admin\EmployeeTimeSheetController;
use App\Http\Controllers\Admin\EmployeeVisaController;
use App\Http\Controllers\Admin\JobTitleController;
use App\Http\Controllers\Admin\ProjectPhaseController;
use App\Http\Controllers\Admin\TimeSheetController;
use App\Http\Controllers\Admin\VisaController;
use App\Http\Controllers\AnnoucementController;
use App\Http\Controllers\EmployeeExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PusherController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::get('reload-captcha', [LoginController::class, 'reloadCaptcha'])->name('reload-captcha');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'reset']);
});

Route::get('job-list', [JobController::class, 'index'])->name('job-list');
Route::get('job-view/{job}', [JobController::class, 'show'])->name('job-view');
Route::post('apply', [JobApplicationController::class, 'store'])->name('apply-job');


Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('employee-dashboard', [DashboardController::class, 'EmployeeDashboard'])->name('employee-dashboard');
    Route::get('send-reminder-mail/{type}/{expiry_date}/{emp_id}', [DashboardController::class, 'sendReminderMail'])->name('send-reminder-mail');
    Route::post('logout', [LogoutController::class, 'index'])->name('logout');

    //apps routes
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts');
    Route::post('contacts', [ContactController::class, 'store']);
    Route::put('contacts', [ContactController::class, 'update']);
    Route::delete('contacts', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::get('file-manager', [FileManagerController::class, 'index'])->name('filemanager');

    Route::get('holidays', [HolidayController::class, 'index'])->name('holidays');
    Route::post('holidays', [HolidayController::class, 'store']);
    Route::post('holidays/{holiday}', [HolidayController::class, 'completed'])->name('completed');
    Route::put('holidays', [HolidayController::class, 'update']);
    Route::delete('holidays', [HolidayController::class, 'destroy'])->name('holiday.destroy');


    Route::get('departments', [DepartmentController::class, 'index'])->name('departments');
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::put('departments', [DepartmentController::class, 'update']);
    Route::delete('departments', [DepartmentController::class, 'destroy'])->name('department.destroy');


    Route::get('branches', [BranchController::class, 'index'])->name('branches');
    Route::post('branches', [BranchController::class, 'store']);
    Route::put('branches', [BranchController::class, 'update']);
    Route::delete('branches', [BranchController::class, 'destroy'])->name('branch.destroy');


    Route::get('timesheet-status', [TimeSheetController::class, 'index'])->name('timesheet-status');
    Route::post('timesheet-status', [TimeSheetController::class, 'store']);
    Route::put('timesheet-status', [TimeSheetController::class, 'update']);
    Route::delete('timesheet-status', [TimeSheetController::class, 'destroy'])->name('timesheet-status.destroy');

    Route::get('employee-timesheet-detail/{id}/{start_date}/{end_date}', [EmployeeTimeSheetController::class, 'employeeTimeSheetDetail'])->name('employee-timesheet-detail');
    Route::get('employee-timesheet-view', [EmployeeTimeSheetController::class, 'employeeTimesheetView'])->name('employee-timesheet-view');
    Route::get('timesheet-view', [EmployeeTimeSheetController::class, 'TimesheetView'])->name('timesheet-view');
    Route::get('employee-timesheet-edit/{id}/{start_date}/{end_date}', [EmployeeTimeSheetController::class, 'empTimesheetEditView'])->name('employee-timesheet-edit');
    Route::get('employee-timesheet-list', [EmployeeTimeSheetController::class, 'employeeTimesheetList'])->name('employee-timesheet-list');
    Route::get('employee-timesheet', [EmployeeTimeSheetController::class, 'index'])->name('employee-timesheet');
    Route::post('/get-week-days', [EmployeeTimeSheetController::class, 'getWeekDays'])->name('get-week-days');
    Route::post('/get-holiday-days', [EmployeeTimeSheetController::class, 'getHolidayDays'])->name('get-holiday-days');
    Route::post('/get-employee-projects', [EmployeeTimeSheetController::class, 'getEmployeeProjects'])->name('get-employee-projects');
    Route::post('employee-timesheet', [EmployeeTimeSheetController::class, 'store']);
    Route::put('employee-timesheet', [EmployeeTimeSheetController::class, 'update'])->name('employee-timesheet-update');
    Route::post('timesheet-status-update', [EmployeeTimeSheetController::class, 'TimesheetStatusUpdate'])->name('timesheet-status-update');
    Route::delete('employee-timesheet', [EmployeeTimeSheetController::class, 'destroy'])->name('employee-timesheet.destroy');


    Route::get('project-phase', [ProjectPhaseController::class, 'index'])->name('project-phase');
    Route::post('project-phase', [ProjectPhaseController::class, 'store']);
    Route::put('project-phase', [ProjectPhaseController::class, 'update']);
    Route::delete('project-phase', [ProjectPhaseController::class, 'destroy'])->name('project-phase.destroy');

    Route::get('visa-type', [VisaController::class, 'index'])->name('visa');
    Route::post('visa-type', [VisaController::class, 'store']);
    Route::put('visa-type', [VisaController::class, 'update']);
    Route::delete('visa-type', [VisaController::class, 'destroy'])->name('visa.destroy');

    Route::get('announcement', [AnnoucementController::class, 'index'])->name('announcement');
    Route::post('announcement', [AnnoucementController::class, 'store']);
    Route::put('announcement', [AnnoucementController::class, 'update']);
    Route::delete('announcement', [AnnoucementController::class, 'destroy'])->name('announcement.destroy');

    Route::get('employee/emergency-contact/{id}', [EmployeeEmergencyContactController::class, 'index'])->name('emergency-contact');
    Route::post('employee/emergency-contact', [EmployeeEmergencyContactController::class, 'store'])->name('emergency-contact.store');
    Route::put('employee/emergency-contact', [EmployeeEmergencyContactController::class, 'update'])->name('emergency-contact.update');
    Route::delete('employee/emergency-contact/', [EmployeeEmergencyContactController::class, 'destroy'])->name('emergency-contact.destroy');

    Route::get('employee-address/{id}', [EmployeeAddressController::class, 'index'])->name('employee-address');
    Route::post('employee-address', [EmployeeAddressController::class, 'store'])->name('employee-address.store');
    Route::put('employee-address', [EmployeeAddressController::class, 'update'])->name('employee-address.update');
    Route::delete('employee-address/', [EmployeeAddressController::class, 'destroy'])->name('employee-address.destroy');

    Route::get('employee-bank/{id}', [EmployeeBankController::class, 'index'])->name('employee-bank');
    Route::post('employee-bank', [EmployeeBankController::class, 'store'])->name('employee-bank.store');
    Route::put('employee-bank', [EmployeeBankController::class, 'update'])->name('employee-bank.update');
    Route::delete('employee-bank', [EmployeeBankController::class, 'destroy'])->name('employee-bank.destroy');

    Route::get('employee-payslip/{id}', [EmployeePayslipController::class, 'index'])->name('employee-payslip');
    Route::post('employee-payslip', [EmployeePayslipController::class, 'store'])->name('employee-payslip.store');
    Route::put('employee-payslip', [EmployeePayslipController::class, 'update'])->name('employee-payslip.update');
    Route::delete('employee-payslip', [EmployeePayslipController::class, 'destroy'])->name('employee-payslip.destroy');

    Route::get('employee-document/{id}', [EmployeeDocumentController::class, 'index'])->name('employee-document');
    Route::post('employee-document', [EmployeeDocumentController::class, 'store'])->name('employee-document.store');
    Route::put('employee-document', [EmployeeDocumentController::class, 'update'])->name('employee-document.update');
    Route::delete('employee-document', [EmployeeDocumentController::class, 'destroy'])->name('employee-document.destroy');


    Route::get('employee-visa/{id}', [EmployeeVisaController::class, 'index'])->name('employee-visa');
    Route::post('employee-visa', [EmployeeVisaController::class, 'store'])->name('employee-visa.store');
    Route::put('employee-visa', [EmployeeVisaController::class, 'update'])->name('employee-visa.update');
    Route::delete('employee-visa', [EmployeeVisaController::class, 'destroy'])->name('employee-visa.destroy');


    Route::get('employee-project/{id}', [EmployeeProjectController::class, 'index'])->name('employee-project');
    Route::post('employee-project', [EmployeeProjectController::class, 'store'])->name('employee-project.store');
    Route::put('employee-project', [EmployeeProjectController::class, 'update'])->name('employee-project.update');
    Route::delete('employee-project', [EmployeeProjectController::class, 'destroy'])->name('employee-project.destroy');

    Route::get('employee-job/{id}', [EmployeeJobController::class, 'index'])->name('employee-job');
    Route::post('employee-job', [EmployeeJobController::class, 'store'])->name('employee-job.store');
    Route::put('employee-job', [EmployeeJobController::class, 'update'])->name('employee-job.update');
    Route::delete('employee-job', [EmployeeJobController::class, 'destroy'])->name('employee-job.destroy');


    Route::get('job-title', [JobTitleController::class, 'index'])->name('job-title');
    Route::post('job-title', [JobTitleController::class, 'store']);
    Route::put('job-title', [JobTitleController::class, 'update']);
    Route::delete('job-title', [JobTitleController::class, 'destroy'])->name('job-title.destroy');


    Route::get('designations', [DesignationController::class, 'index'])->name('designations');
    Route::put('designations', [DesignationController::class, 'update']);
    Route::post('designations', [DesignationController::class, 'store']);
    Route::delete('designations', [DesignationController::class, 'destroy'])->name('designation.destroy');


    // settings routes 
    Route::get('settings/theme', [SettingsController::class, 'index'])->name('settings.theme');
    Route::post('settings/theme', [SettingsController::class, 'updateTheme']);
    Route::get('settings/company', [SettingsController::class, 'company'])->name('settings.company');
    Route::post('settings/company', [SettingsController::class, 'updateCompany']);
    Route::get('settings/invoice', [SettingsController::class, 'invoice'])->name('settings.invoice');
    Route::post('settings/invoice', [SettingsController::class, 'updateInvoice']);
    Route::get('settings/attendance', [SettingsController::class, 'attendance'])->name('settings.attendance');
    Route::post('settings/attendance', [SettingsController::class, 'updateAttendance']);
    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change-password');
    Route::post('change-password', [ChangePasswordController::class, 'update']);

    Route::get('leave-type', [LeaveTypeController::class, 'index'])->name('leave-type');
    Route::post('leave-type', [LeaveTypeController::class, 'store']);
    Route::delete('leave-type', [LeaveTypeController::class, 'destroy'])->name('leave-type.destroy');
    Route::put('leave-type', [LeaveTypeController::class, 'update']);

    Route::get('company-document', [CompanyDocumentController::class, 'index'])->name('company-document');
    // Route::get('company-document/create',[CompanyDocumentController::class, 'create'])->name('company-document.create');
    Route::post('company-document', [CompanyDocumentController::class, 'store']);
    Route::put('company-document', [CompanyDocumentController::class, 'update']);
    Route::delete('company-document', [CompanyDocumentController::class, 'destroy'])->name('company-document.destroy');

    Route::get('expense-type', [ExpenseTypeController::class, 'index'])->name('expense-type');
    Route::post('expense-type', [ExpenseTypeController::class, 'store']);
    Route::delete('expense-type', [ExpenseTypeController::class, 'destroy'])->name('expense-type.destroy');
    Route::put('expense-type', [ExpenseTypeController::class, 'update']);

    Route::get('policies', [PolicyController::class, 'index'])->name('policies');
    Route::post('policies', [PolicyController::class, 'store']);
    Route::delete('policies', [PolicyController::class, 'destroy'])->name('policy.destroy');

    Route::resource('invoices', InvoiceController::class)->except('destroy');
    Route::delete('invoices', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('emp-expenses', [EmployeeExpenseController::class, 'index'])->name('emp-expenses');
    Route::get('emp-expenses-view/{expense_id}/{emp_id}', [EmployeeExpenseController::class, 'show'])->name('emp-expenses-view');
    Route::get('emp-expenses-print/{expense_id}/{emp_id}', [EmployeeExpenseController::class, 'ExpensePdf'])->name('emp-expenses-print');
    Route::post('get-expense-data', [EmployeeExpenseController::class, 'getExpenseId'])->name('get-expense-data');
    Route::post('get-projects-data', [EmployeeExpenseController::class, 'getProjects'])->name('get-projects-data');
    Route::post('/expenses-employee-projects', [EmployeeExpenseController::class, 'getEmployeeProjects'])->name('expenses-employee-projects');
    Route::post('emp-expenses', [EmployeeExpenseController::class, 'store']);
    Route::post('expense-status-update', [EmployeeExpenseController::class, 'ExpenseStatusUpdate'])->name('expense-status-update');
    Route::put('emp-expenses', [EmployeeExpenseController::class, 'update']);
    Route::delete('emp-expenses', [EmployeeExpenseController::class, 'destroy']);

    Route::get('provident-fund', [ProvidentFundController::class, 'index'])->name('provident-fund');
    Route::post('provident-fund', [ProvidentFundController::class, 'store']);
    Route::put('provident-fund', [ProvidentFundController::class, 'update']);
    Route::delete('provident-fund', [ProvidentFundController::class, 'destroy']);

    Route::get('taxes', [TaxesController::class, 'index'])->name('taxes');
    Route::post('taxes', [TaxesController::class, 'store']);
    Route::put('taxes', [TaxesController::class, 'update']);
    Route::delete('taxes', [TaxesController::class, 'destroy']);

    Route::get('clients', [ClientController::class, 'index'])->name('clients');
    Route::post('clients', [ClientController::class, 'store'])->name('client.add');
    Route::put('clients', [ClientController::class, 'update'])->name('client.update');
    Route::delete('clients', [ClientController::class, 'destroy'])->name('client.destroy');
    Route::get('clients-list', [ClientController::class, 'lists'])->name('clients-list');

    // Route::get('employee-view-details/{id}',[EmployeeDetailController::class,'employeeViewDetail'])->name('employee-view-details');
    Route::match(['get', 'post'], 'employee-detail/{id?}', [EmployeeDetailController::class, 'index'])->name('employee-detail');
    Route::post('employee-document-detail', [EmployeeDetailController::class, 'EmployeeDocumentUpload'])->name('employee-document-update');
    Route::post('employee-rlmt-detail', [EmployeeDetailController::class, 'RLMTDocumentUpload'])->name('rlmt-document-update');
    Route::post('employee-payslip-detail', [EmployeeDetailController::class, 'EmployeePayslipUpload'])->name('employee-payslip-update');
    Route::delete('employee-detail-delete', [EmployeeDetailController::class, 'DeleteResource'])->name('employee.detail.delete');


    //generate pdf
    Route::get('print-employee-detail/{id}', [PdfController::class, 'employeeDetailPdf'])->name('print-employee-detail');
    Route::get('print-employee-leave/{id}', [PdfController::class, 'employeeLeavePdf'])->name('print-employee-leave');
    Route::get('print-timesheet-detail/{id}/{start_date}/{end_date}', [PdfController::class, 'employeeTimeSheetDetailPdf'])->name('print-timesheet-detail');

    // Route::get('employees',[EmployeeController::class,'index'])->name('employees');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employee.add');
    // Route::get('employees-list',[EmployeeController::class,'list'])->name('employees-list');
    Route::get('{status}/employees', [EmployeeController::class, 'list'])->name('employees-list');
    Route::put('employees', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('employees', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    // Route::get('employees/attendance',[EmployeeAttendanceController::class,'index'])->name('employees.attendance');
    // Route::post('employees/attendance',[EmployeeAttendanceController::class,'store']);
    // Route::put('employees/attendance',[EmployeeAttendanceController::class,'update']);
    // Route::delete('employees/attendance',[EmployeeAttendanceController::class,'destroy']);

    Route::get('tickets', [TicketController::class, 'index'])->name('tickets');
    Route::get('tickets/show/{subject}', [TicketController::class, 'show'])->name('ticket-view');
    Route::post('tickets', [TicketController::class, 'store']);
    Route::put('tickets', [TicketController::class, 'update']);
    Route::delete('tickets', [TicketController::class, 'destroy']);

    Route::get('overtime', [OvertimeController::class, 'index'])->name('overtime');
    Route::post('overtime', [OvertimeController::class, 'store']);
    Route::put('overtime', [OvertimeController::class, 'update']);
    Route::delete('overtime', [OvertimeController::class, 'destroy']);

    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('projects/create/{id?}',[ProjectController::class, 'create'])->name('projects.create');
    Route::get('projects/show/{name}', [ProjectController::class, 'show'])->name('project.show');
    Route::post('projects', [ProjectController::class, 'store']);
    Route::put('projects', [ProjectController::class, 'update']);
    Route::delete('projects', [ProjectController::class, 'destroy']);
    Route::get('project-list', [ProjectController::class, 'list'])->name('project-list');
    Route::get('leads', [ProjectController::class, 'leads'])->name('leads');

    Route::get('employee-leave', [EmployeeLeaveController::class, 'index'])->name('employee-leave');
    Route::get('employee-leave-view/{id}', [EmployeeLeaveController::class, 'LeaveView'])->name('employee-leave-view');
    Route::post('/get-projects', [EmployeeLeaveController::class, 'getProjects'])->name('get-projects');
    // Route::get('print-leave-detail',[EmployeeLeaveController::class,'leavePdf'])->name('print-leave-detail');
    Route::post('employee-leave', [EmployeeLeaveController::class, 'store']);
    Route::put('employee-leave', [EmployeeLeaveController::class, 'update']);
    Route::post('leave-status-update', [EmployeeLeaveController::class, 'LeaveStatusUpdate'])->name('leave-status-update');
    Route::delete('employee-leave', [EmployeeLeaveController::class, 'destroy'])->name('leave.destroy');

    Route::get('unread-email', [CompanyEmailController::class, 'unreadMails'])->name('unread-email');
    Route::get('user-email-inbox', [CompanyEmailController::class, 'emailInbox'])->name('user-email-inbox');
    Route::get('compose-email', [CompanyEmailController::class, 'composeEmail'])->name('compose-email');
    Route::get('sent-email', [CompanyEmailController::class, 'sentEmail'])->name('sent-email');
    Route::post('mail-detail/{from}', [CompanyEmailController::class, 'mailDetail'])->name('mail-detail');
    Route::get('company-email', [CompanyEmailController::class, 'index'])->name('company-email');
    Route::get('company-email/{status?}', [CompanyEmailController::class, 'index'])->name('company-email');
    Route::get('restore/{id?}', [CompanyEmailController::class, 'restoreArchive'])->name('restore');
    Route::get('archive/{id}', [CompanyEmailController::class, 'archive'])->name('archive');
    Route::post('company-email', [CompanyEmailController::class, 'store']);
    Route::post('reply-mail', [CompanyEmailController::class, 'replyStore'])->name('reply-mail');
    Route::post('/email-read', [CompanyEmailController::class, 'emailRead'])->name('email-read');
    // Route::get('/search-mail', [CompanyEmailController::class,'SearchMail'])->name('search-mail');
    Route::post('/find-search', [CompanyEmailController::class, 'FindSearch'])->name('find-search');
    // Route::put('company-email',[CompanyEmailController::class,'update']);
    Route::delete('company-email', [CompanyEmailController::class, 'destroy'])->name('company-email.destroy');

    Route::get('jobs', [BackendJobController::class, 'index'])->name('jobs');
    Route::post('jobs', [BackendJobController::class, 'store']);
    Route::get('job-applicants', [BackendJobController::class, 'applicants'])->name('job-applicants');
    Route::post('download-cv', [BackendJobController::class, 'downloadCv'])->name('download-cv');

    Route::get('goal-type', [GoalTypeController::class, 'index'])->name('goal-type');
    Route::post('goal-type', [GoalTypeController::class, 'store']);
    Route::put('goal-type', [GoalTypeController::class, 'update']);
    Route::delete('goal-type', [GoalTypeController::class, 'destroy']);

    Route::get('goal-tracking', [GoalController::class, 'index'])->name('goal-tracking');
    Route::post('goal-tracking', [GoalController::class, 'store']);
    Route::put('goal-tracking', [GoalController::class, 'update']);
    Route::delete('goal-tracking', [GoalController::class, 'destroy']);

    Route::get('asset', [AssetController::class, 'index'])->name('assets');
    Route::post('asset', [AssetController::class, 'store']);
    Route::put('asset', [AssetController::class, 'update']);
    Route::delete('asset', [AssetController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index'])->name("users");
    Route::post('users', [UserController::class, 'store']);
    Route::put('users', [UserController::class, 'update']);
    Route::delete('users', [UserController::class, 'destroy']);

    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('profile', [UserProfileController::class, 'update']);
    Route::post('employee-profile', [UserProfileController::class, 'empProfileUpdate'])->name('employee-profile');

    Route::get('activity', [ActivityController::class, 'index'])->name('activity');
    Route::get('clear-activity', [ActivityController::class, 'markAsRead'])->name('clear-all');

    Route::get('logs', [ActivityController::class, 'logs'])->name('logs');
    Route::put('logs', [ActivityController::class, 'update'])->name('logs');
    Route::post('send-message', [ActivityController::class, 'sendMessage'])->name('send-message');

    Route::get('backups', [BackupsController::class, 'index'])->name('backups');

    Route::get('default-emails', [CompanyEmailController::class, 'defaultEmails'])->name('default-emails');

    // Route::post('admin-send-message',function (Request $request){
    //     event(new Message($request->username, $request->message));
    //     return ['success' => true];
    // });
    // Route::post('admin-send-message',[ChatsController::class, 'sendMessage'])->name('admin-send-message');

});

Route::get('chat-view/{id?}', [PusherController::class, 'index'])->name('chat-view');
Route::get('chat/{id?}', [PusherController::class, 'chatView'])->name('chat');
Route::post('broadcast', [PusherController::class, 'broadCast'])->name('broadcast');
Route::post('receive', [PusherController::class, 'receive'])->name('receive');
Route::post('chat-message-counter', [PusherController::class, 'chatMessageCounter'])->name('chat-message-counter');

Route::get('show-chat-message/', [PusherController::class, 'showChatMessage'])->name('show-chat-message');

Route::get('', function () {
    return redirect()->route('dashboard');
});
