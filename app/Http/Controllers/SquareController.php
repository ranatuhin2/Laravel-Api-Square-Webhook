<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\Payments\Requests\CreatePaymentRequest;
use Square\SquareClient;
use Square\Types\Money;
use Facades\Hidehalo\Nanoid\Client as NanoClient;
use Square\Environments;
use Square\Types\Currency;

class SquareController extends Controller
{
    public function payment(Request $request)
    {
        /* Square Payment Initiating => Using WebHook */
        $request->validate([
            // 'invoice_id' => 'required|exists:invoices,id', => Build later
            // 'nonce' => 'required|string',
        ]);

        $client = new SquareClient(options: [
            'SQUARE_TOKEN',
            'baseUrl' => Environments::Sandbox->value // Used by default
        ]);

        
        $paymentRequest = new CreatePaymentRequest([
            'idempotencyKey' => NanoClient::generateId($size = 21), 
            'sourceId' => $request->nonce,
            'amountMoney' => new Money([
                'amount' => 100,
                'currency' => Currency::Usd->value
            ]),
            'locationId' => config('services.square.location'),
            'note' => 'Invoice payment #INV-123',
            'customerId'=> '1',
        ]);


        $response = $client->payments->create( $paymentRequest);

        return response()->json([
            'success' => 'Payment Done Successfull!'
        ]);
        
        
    }
}
