<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }else{
            return view('login');
        }
    }

    public function authenticate(Request $request)
    {

        if($request->email != '' && $request->password != ''){
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::Attempt($data)){
                return redirect()->route('home');
            }else{
                return redirect()->to('login')->with('error', 'Email atau Password salah!' );
            }
        }else{
            return redirect()->to('login')->with('error', 'Email atau Password salah!' );
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
