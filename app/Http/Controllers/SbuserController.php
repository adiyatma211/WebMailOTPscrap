<?php

namespace App\Http\Controllers;

use App\Models\sbuser;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Request;
// use GuzzleHttp\Psr7\Request;

class SbuserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        return view('sbuser.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show()
    {

        $viewuser = sbuser::all();
        return view('sbuser.view',[
            'viewuser'=> $viewuser
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        sbuser::create([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        // dd($show);
        return redirect('/sbuser')->withSuccess('User Sudah Di buat');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sbuser $sbuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */



     public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);
        // dd($request->file('file'));
        Excel::import(new sbuser, $request->file('file'));

        // dd($request);

        return redirect()->back()->with('success', 'Excel file imported successfully.');
    }

}
