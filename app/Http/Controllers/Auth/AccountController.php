<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Account\UpdateRequest;
use App\Models\User;
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

    public function updateAccount(UpdateRequest $request, $userId)
    {
        $user = User::find($userId);

        if (! $user) {
            return back()->withErrors('Unable to find the user, please retry again');
        }

        $user->update([
            'webhook_url' => $request->webhook_url,
            'smartlead_key' => $request->smartlead_key
        ]);

        session()->flash('alert-success', 'Account updated successfully');

        return to_route('auth.accounts.edit');

    }
}
