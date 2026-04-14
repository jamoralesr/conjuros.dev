<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function start(Request $request, Plan $plan, string $interval): RedirectResponse
    {
        abort_unless(in_array($interval, ['monthly', 'yearly']), 404);

        $user = Auth::user();
        abort_unless($user, 401);

        if ($user->subscribed('default')) {
            return redirect()->route('billing.edit')
                ->with('status', 'Ya tienes una suscripción activa.');
        }

        $priceId = $plan->stripePriceIdFor($interval);
        abort_unless($priceId, 422, 'Plan sin precio configurado en Stripe.');

        $checkout = $user->newSubscription('default', $priceId)->checkout([
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'allow_promotion_codes' => true,
            'customer_update' => ['name' => 'auto', 'address' => 'auto'],
            'billing_address_collection' => 'auto',
        ]);

        return redirect($checkout->url);
    }

    public function success(Request $request): View
    {
        return view('front.checkout.success');
    }

    public function cancel(Request $request): View
    {
        return view('front.checkout.cancel');
    }
}
