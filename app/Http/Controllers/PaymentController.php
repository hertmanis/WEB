<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    // Parāda visus maksājumus trenerim (atļauts tikai lomu skaitam 0)
    public function coachIndex()
    {
        if (auth()->user()->role != 0) {
            abort(403, 'Unauthorized');
        }

        // Paņem visus maksājumus no datubāzes un aizsūta uz skatu
        $payments = Payment::all(); 
        return view('dashboard.payment.coach-payment', compact('payments'));
    }

    // Saglabā jauno trenera izveidoto maksājumu datubāzē
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);

        // Ieraksta jauno rindu datubāzes tabulā
        $payment = Payment::create([
            'amount' => $request->amount,
            'description' => $request->description,
            'created_by' => auth()->user()->id, // Saglabā, kurš treneris to uztaisīja
        ]);

        return redirect()->route('coach.payments')->with('success', 'Maksājums izveidots veiksmīgi.');
    }

    // Parāda maksājumus spēlētājam (atļauts tikai lomu skaitam 1)
    public function playerIndex()
    {
        $player = auth()->user();

        if ($player->role != 1) {
            abort(403, 'Unauthorized');
        }

        // Atrod treneru ID, kas ir tajā pašā komandā, kur spēlētājs
        $coachIds = \App\Models\User::where('team_id', $player->team_id)
            ->where('role', 0)
            ->pluck('id');

        // Atlasa tikai tos maksājumus, kurus izveidojuši paša spēlētāja komandas treneri
        $payments = \App\Models\Payment::whereIn('created_by', $coachIds)->get();

        return view('dashboard.payment.player-payment', compact('payments'));
    }

    // Atver konkrētā maksājuma lapu pirms maksāšanas
    public function showPaymentPage($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $user = auth()->user();

        // Atrod to treneri, kurš šo maksājumu palaida
        $creator = \App\Models\User::find($payment->created_by);

        // Drošības pārbaude - neļauj spēlētājam redzēt svešu komandu maksājumus
        if (!$creator || $user->team_id !== $creator->team_id) {
            abort(403, 'Jums nav piekļuves šim maksājumam.');
        }

        return view('dashboard.payment.pay', compact('payment'));
    }

    // Iniciē Stripe Checkout sesiju un pārmed uz viņu lapu
    public function checkout($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        // Uzstāda slepeno Stripe atslēgu no konfigurācijas faila
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Izveido jaunu maksājumu sesiju Stripe pusē
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'], // Atļauj maksāt ar karti
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $payment->description, // Produkta nosaukums lapā
                        ],
                        'unit_amount' => $payment->amount, // Summa centos (Stripe prasa centus)
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                // Norāda adreses, kur sūtīt atpakaļ pēc maksājuma procesa
                'success_url' => route('payment.success', ['paymentId' => $payment->id]),
                'cancel_url' => route('payment.cancel'),
            ]);

            // Pārvirza lietotāju uz ārējo Stripe maksājumu lapu
            return redirect()->away($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Kļūda: ' . $e->getMessage());
        }
    }

    // Nostrādā, kad klients veiksmīgi samaksājis un Stripe atsūta viņu atpakaļ
    public function success(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        // Ja Stripe ir atgriezis sesijas ID, pārbauda tās statusu
        if ($request->has('session_id')) {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));

                // Ja statuss tiešām ir "paid" (samaksāts), atzīmē to mūsu datubāzē
                if ($session && $session->payment_status === 'paid') {
                    $payment->paid = 1; 
                    $payment->save();
                }
            } catch (\Exception $e) {
                // Kļūdas gadījumā nekas netiek darīts, lai neapstādinātu lapas ielādi
            }
        }

        return view('dashboard.payment.success', compact('payment'));
    }

    // Atver lapu, ja lietotājs Stripe logā nospieda "atcelt"
    public function cancel()
    {
        return view('payment.cancel');
    }
}