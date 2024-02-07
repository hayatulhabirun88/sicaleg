<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaksiController extends Controller
{
    public $saksi;

    public function index()
    {

        return view('saksi.index');
    }
}
