<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function openBillingPage()
    {
        return view('auth.billings.index');
    }

    public function storeBillingInformation(Request $request)
    {
        $user = auth()->user();
        $amount = $request->amount;
        $paymentLabel = 'SmartLead Automation Payment';

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([

            'line_items' => [[
                'price_data' => [
                  'currency' => 'usd',
                  'unit_amount' => $amount * 100,
                  'product_data' => [
                    'name' => $paymentLabel,
                  ],
                ],
                'quantity' => 1,
              ]],

            // 'customer' => $user,
            // 'payment_intent_data'=> [
            //     'setup_future_usage'=> 'on_session',
            // ],

            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/auth/billings/success',
            'cancel_url' => env('APP_URL') . '/auth/billings',

        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'payment_id' => $session->id,
            'amount' => $amount,
            'currency' => config('custom.payment.currency')
        ]);

        if ($payment){
            session()->put('payment_id', $payment->id);
        }

        if ($session->url) {
            return redirect($session->url);
        }
    }

    public function openBillingSuccessPage()
    {
        $paymentId = null;
        $message = null;

        if (session()->has('payment_id')) {
            $paymentId = session()->get('payment_id');
        }

        $payment = Payment::find($paymentId);

        if (! $payment) {
            $message = '<p class="text-danger">Payment is paid but due to some technical issue, its unable to save into the system, please ask the administrator to take the action on this matter</p>';
        }
        else {
            $payment->update([
                'status' => Payment::PAID
            ]);

            $message = 'Your payment has been processed successfully!';

            session()->forget('payment_id');

        }

        return view('auth.billings.success', compact('message'));
    }
}
