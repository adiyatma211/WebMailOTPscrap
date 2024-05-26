<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SbuserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// ==========================Dashboard==============================
Route::get('/', [PagesController::class, 'dashboard'])->name('maindb');
// =================================================================


// ============================USER EMAIL===========================
Route::get('/sbuser', [SbuserController::class, 'show'])->name('showuser');
Route::get('/sbuser/show', [SbuserController::class, 'index'])->name('viewuser');
Route::post('/sbuser/simpan', [SbuserController::class, 'store']);
Route::post('/sbuser/import', [SbuserController::class, 'import']);

// =================================================================
Route::get('/otps', [OtpController::class, 'index']);
// routes/web.php
Route::post('/run-otp-job', [jobController::class, 'runOtpJob']);
Route::post('/send-otp-job', [jobController::class, 'sendOtpJob']);


// ===========================================================
