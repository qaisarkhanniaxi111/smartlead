<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function editAccount()
    {
        $user = auth()->user();

        if (! $user) {
            abort(404, 'Unable to locate the user, please go back and refreshe the webpage and try again, if problem still persists contact with administrator');
        }

        return view('auth.accounts.edit', compact('user'));
    }
}
