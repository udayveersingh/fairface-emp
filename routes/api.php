<?php

use App\Http\Controllers\Api\EmpExpenseController;
use App\Http\Controllers\Api\FcmController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']); 
Route::post('/user-login',[LoginController::class, 'userLogin']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/save-data', [LoginController::class, 'save']);

Route::resource('/user-profile', UserController::class);
Route::get('/user-address', [UserController::class,'Address']);
Route::get('/user-document',[UserController::class,'Document']);
Route::get('/user-job',[UserController::class,'Job']);
Route::get('/user-visa',[UserController::class,'Visa']);
Route::get('/user-project',[UserController::class,'Project']);
Route::get('/user-payslip',[UserController::class,'Payslip']);
Route::get('/get-data-leaves',[LeaveController::class,'getDataLeaves']);
Route::post('leaves',[LeaveController::class,'store']);
Route::get('leave-details',[LeaveController::class,'leaveDetails']);
Route::post('expenses',[EmpExpenseController::class,'store']);
Route::resource('/employee-timesheet', TimesheetController::class);
Route::get('timesheet-details',[TimesheetController::class,'timesheetDetails']);


Route::post('/send-message', [MessageController::class, 'sendMessage']);
Route::get('/messages', [MessageController::class, 'getMessages']);

Route::post('update-device-token', [FcmController::class, 'updateDeviceToken']);
Route::post('send-fcm-notification', [FcmController::class, 'sendFcmNotification']);
