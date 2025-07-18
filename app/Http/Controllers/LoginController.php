<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {   
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('afdeling/dashboard');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('pimpinan/dashboard');
            }
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('admin/dashboard');
            } elseif (Auth::user()->role == 'atasan') {
                return redirect()->intended('atasan/dashboard');
            } elseif (Auth::user()->role == 'karyawan') {
                return redirect()->intended('karyawan/dashboard');
            }
        }
        return back()->withErrors([
            'username' => 'Username tidak terdaftar atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
