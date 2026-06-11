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
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Nepareizs payload
            Log::error('Stripe webhook payload kļūda: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Nepareiza paraksta pārbaude
            Log::error('Stripe webhook signatūras kļūda: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Apstrādā checkout sesijas pabeigšanu
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Pārbauda, vai ir metadata ar payment_id
            if (!empty($session->metadata->payment_id)) {
                $paymentId = $session->metadata->payment_id;

                $payment = Payment::find($paymentId);

                if ($payment) {
                    $payment->status = 'paid';
                    $payment->save();

                    Log::info("Maksājums ar ID {$paymentId} atzīmēts kā apmaksāts.");
                } else {
                    Log::warning("Maksājums ar ID {$paymentId} netika atrasts webhook apstrādē.");
                }
            } else {
                Log::warning('Webhook saņēma checkout.session.completed notikumu bez payment_id metadata.');
            }
        }

        return response()->json(['status' => 'success']);
    }
}
