<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }

        return view('report.index');
    }

    public function pertps()
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }
        
        return view('report.pertps');
    }

    public function percaleg()
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }
        
        return view('report.percaleg');
    }
}
