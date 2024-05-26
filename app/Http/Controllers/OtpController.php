<?php

// app/Http/Controllers/OtpController.php

namespace App\Http\Controllers;

use App\Models\Otp;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function index()
    {
        $otps = Otp::all(); // Mengambil semua data OTP dari database

        return view('otp', compact('otps')); // Melewatkan data OTP ke dalam view
    }
}


