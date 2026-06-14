<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Paņem neapstrādātos datus (payload), ko Stripe atsūtīja uz šo adresi
        $payload = $request->getContent();
        // Paņem drošības parakstu no HTTP galvenes
        $sig_header = $request->header('Stripe-Signature');
        // Paņem slepeno webhook atslēgu no .env faila drošības pārbaudei
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // Pārbauda, vai datus tiešām sūtīja Stripe, nevis kāds hakeris, kas mēģina viltot maksājumu
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Ja dati ir bojāti, ieraksta kļūdu log failā un atgriež 400 kļūdu
            Log::error('Stripe webhook payload kļūda: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Ja drošības paraksts nesakrīt (nav sūtījis Stripe), to arī fiksē logā
            Log::error('Stripe webhook signatūras kļūda: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Ja pārbaude iziet un Stripe ziņo, ka lietotājs veiksmīgi pabeidza maksājumu sesiju
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Pārbauda, vai Stripe atsūtītajos datos ir iekšā mūsu sūtītais payment_id
            if (!empty($session->metadata->payment_id)) {
                $paymentId = $session->metadata->payment_id;

                // Atrod šo maksājumu mūsu datubāzē
                $payment = Payment::find($paymentId);

                if ($payment) {
                    // Uzliek statusu, ka rēķins ir apmaksāts, un saglabā datubāzē
                    $payment->status = 'paid';
                    $payment->save();

                    // Ieraksta sistēmas logā ziņu, ka viss kārtībā
                    Log::info("Maksājums ar ID {$paymentId} atzīmēts kā apmaksāts.");
                } else {
                    Log::warning("Maksājums ar ID {$paymentId} netika atrasts webhook apstrādē.");
                }
            } else {
                Log::warning('Webhook saņēma checkout.session.completed notikumu bez payment_id metadata.');
            }
        }

        // Paziņo Stripe serverim, ka ziņa ir veiksmīgi saņemta un apstrādāta
        return response()->json(['status' => 'success']);
    }
}