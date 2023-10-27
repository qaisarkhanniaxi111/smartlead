<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function openInbox()
    {
        return view('auth.inbox.index');
    }

    public function openMailDetails()
    {
        return view('auth.inbox.details');
    }
}
