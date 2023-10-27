<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    public function logout()
    {
        auth()->logout();

        return to_route('login');
    }

}
