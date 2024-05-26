<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class JobController extends Controller
{
    public function runOtpJob(Request $request)
    {
        // Menjalankan job secara langsung
        \App\Jobs\ReadOtpEmail::dispatch();

        return response()->json(['success' => 'Job dijalankan']);
    }
    public function sendOtpJob(Request $request)
    {
        // Menjalankan job secara langsung
        Artisan::call('telegram:send-messages');

        return response()->json(['success' => 'Telegram message sent!']);
    }
}
