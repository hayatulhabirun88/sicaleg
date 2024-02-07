<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalegController extends Controller
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
        return view('caleg.index');
    }
}
