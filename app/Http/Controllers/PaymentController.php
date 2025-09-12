<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use LocalTools\CoinbaseCommerce\CoinbaseCommerceCharges;

class PaymentController extends Controller
{
    protected $chargesClient;

    public function __construct()
    {
        // Initialize the Charges client with your API key
        $this->chargesClient = new CoinbaseCommerceCharges(env('COINBASE_COMMERCE_API_KEY'));
    }

    public function index()
    {
        return view('payment');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.5',
            'currency' => 'required|string|size:3',
        ]);

        // Create charge using the SDK
        $charge = $this->chargesClient->create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => $request->amount,
                'currency' => strtoupper($request->currency),
            ],
        ]);

        // Save payment info in database
        Payment::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'charge_id' => $charge['id'],         // Note: returned as array
            'status' => 'pending',
            'hosted_url' => $charge['hosted_url'],
        ]);

        // Redirect user to hosted payment page
        return redirect($charge['hosted_url']);
    }

    public function webhook(Request $request)
    {
        $signature = $request->header('X-CC-Webhook-Signature');
        $payload = $request->getContent();

        $computed = hash_hmac('sha256', $payload, env('COINBASE_COMMERCE_WEBHOOK_SECRET'));

        if (!hash_equals($computed, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload, true);
        $type = $event['type'] ?? '';
        $chargeId = $event['data']['id'] ?? null;

        $payment = Payment::where('charge_id', $chargeId)->first();

        if ($payment && in_array($type, ['charge:confirmed', 'charge:failed', 'charge:pending'])) {
            $status = explode(':', $type)[1]; // e.g. confirmed
            $payment->update(['status' => $status]);
        }

        return response()->json(['status' => 'received']);
    }

    public function status()
    {
        $payments = Payment::latest()->get();
        return view('status', compact('payments'));
    }
}
