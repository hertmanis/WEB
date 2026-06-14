<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        // Pārbauda, vai atsūtītā summa un apraksts ir pareizi ievadīti
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
        ]);

        // Uzstāda slepeno Stripe atslēgu, ko paņem no .env faila
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Izveido jaunu Stripe maksājuma sesiju ar padotajiem datiem
        $session = Session::create([
            'payment_method_types' => ['card'], // Atļauj tikai bankas kartes
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur', 
                    'product_data' => [
                        'name' => $request->description, // Maksājuma apraksts
                    ],
                    'unit_amount' => $request->amount * 100,
                ],
                'quantity' => 1, // Daudzums - viena reize
            ]],
            'mode' => 'payment', // Parastais vienreizējais maksājuma režīms
            // Adreses, kur lietotāju pārmest atpakaļ pēc sistēmas darbības
            'success_url' => route('payment.success'), // Ja viss veiksmīgi
            'cancel_url' => route('payment.cancel'),   // Ja lietotājs atceļ
        ]);

        // Pārvirza lietotāju uz ģenerēto Stripe maksājumu lapu internetā
        return redirect($session->url);
    }

    // Atver skatu, kad maksājums ir veiksmīgi pabeigts
    public function success()
    {
        return view('dashboard.payment.success');
    }

    // Atver skatu, ja maksājums tika pārtraukts vai atcelts
    public function cancel()
    {
        return view('dashboard.payment.cancel');
    }
}