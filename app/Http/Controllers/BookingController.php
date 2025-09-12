<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function showBookingForm(Request $request)
    {
        // The price will come as query param, no extra logic needed here
        return view('booking');
    }

    public function createCharge(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'crypto_amount' => 'nullable|numeric|min:0.0001',
            'crypto_currency' => 'required|string',
            'amount' => 'required|numeric|min:1',  // USD amount (hidden input)
        ]);

        $data = [
            'name' => 'Booking Payment',
            'description' => 'Payment for booking by ' . $request->name,
            'local_price' => [
                'amount' => number_format($request->amount, 2, '.', ''),
                'currency' => 'USD',
            ],
            'pricing_type' => 'fixed_price',
            'metadata' => [
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'crypto_currency' => $request->crypto_currency,
                'crypto_amount' => $request->crypto_amount,
            ],
            'redirect_url' => route('payment.success'),
            'cancel_url' => url('/'),
        ];

        $response = Http::withHeaders([
            'X-CC-Version' => '2018-03-22',
            'X-CC-Api-Key' => env('COINBASE_COMMERCE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.commerce.coinbase.com/charges', $data);

        if ($response->successful()) {
            $charge = $response->json();
            return redirect($charge['data']['hosted_url']);
        } else {
            return back()->withErrors('Failed to create payment charge: ' . $response->body());
        }
    }

    public function paymentSuccess()
    {
        return "Payment success! Thank you for your booking.";
    }

    public function handleWebhook(Request $request)
    {
        $signature = $request->header('X-CC-Webhook-Signature');
        $payload = $request->getContent();

        $secret = env('COINBASE_COMMERCE_WEBHOOK_SECRET');

        if ($this->verifyWebhook($payload, $signature, $secret)) {
            $event = $request->input('event');

            if ($event['type'] === 'charge:confirmed') {
                $charge = $event['data'];
                // Update your DB if needed here
            }

            return response('Webhook received', 200);
        }

        return response('Invalid signature', 400);
    }

    private function verifyWebhook($payload, $signature, $secret)
    {
        if (!$secret) return false;

        $computedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computedSignature, $signature);
    }
}
