<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function layout()
    {
        return view('base.app');
    }


    public function dashboard()
    {
        $otps = Otp::all(); // Mengambil semua data OTP dari database
        return view('dashboard.index',compact('otps'));
    }


}
