<?php

namespace App\Http\Controllers;

use App\Models\Pendukung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendukungController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
            
        $pendukungs = Pendukung::all();

        return view('pendukung.index', compact(['pendukungs']));
    }
}
