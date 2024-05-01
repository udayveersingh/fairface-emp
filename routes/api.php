<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
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
Route::post('/logout', [LoginController::class, 'logout']);



Route::resource('/user-profile', UserController::class);
Route::get('/user-address', [UserController::class,'Address']);
Route::get('/user-document',[UserController::class,'Document']);
Route::get('/user-job',[UserController::class,'Job']);
Route::get('/user-visa',[UserController::class,'Visa']);
Route::get('/user-project',[UserController::class,'Project']);
Route::get('/user-payslip',[UserController::class,'Payslip']);
