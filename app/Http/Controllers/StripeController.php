<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'description' => 'required|string|max:255',
    ]);

    Stripe::setApiKey(env('STRIPE_SECRET'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $request->description,
                ],
                'unit_amount' => $request->amount * 100, // cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('payment.success'),
        'cancel_url' => route('payment.cancel'),
    ]);

    return redirect($session->url);
}

    // Success URL handler after successful payment
    public function success()
    {
        return view('dashboard.payment.success');
    }

    // Cancel URL handler if payment is canceled
    public function cancel()
    {
        return view('dashboard.payment.cancel');
    }
}
