<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class StripePaymentController extends Controller
{
    
    public function stripe(): View
    {
        return view('stripe');
    }

    public function stripePost(Request $request): RedirectResponse{
        Stripe::setApiKey(config('services.stripe.secret'));

        $charge = Charge::create([
            'amount' => 10 * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Test payment from Biswajit Bala',
        ]);
                
        return back()
                ->with('success', 'Payment successful!');
    }
      
}
