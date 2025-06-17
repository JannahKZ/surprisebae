<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
    
    $request->validate([
        'amount' => 'required|integer|min:50',  
        'currency' => 'string|size:3',
    ]);
    
    try {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $amount = (int)$request->input('amount'); // amount in cents (e.g., 1000 = $10.00)
        $currency = $request->input('currency', 'myr'); // default to MYR

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
        ]);
    } 

    catch (\Exception $e) {
        Log::error('Stripe PaymentIntent creation failed: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

