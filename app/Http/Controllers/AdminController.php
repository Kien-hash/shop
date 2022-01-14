<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getAdminLogin()   {
        return view('admin.login');
    }

    public function showDashboard()
    {
        return view('admin.dashboard.index');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('admin/dashboard');
        } else {
            return redirect('admin')->with('Notice', 'Login failed');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
