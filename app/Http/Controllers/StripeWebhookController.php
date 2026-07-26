<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload    = $request->getContent();
        $sigHeader  = $request->header('Stripe-Signature');
        $secret     = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            // Signature verify nahi hui — matlab ye request Stripe se nahi aayi
            return response('Invalid signature', 400);
        }

        // ✅ Event type ke hisaab se handle karo
        switch ($event->type) {

            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionCancelled($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe event: ' . $event->type);
        }

        return response('Webhook handled', 200);
    }

    // ✅ Checkout complete hua — subscription ID save karo
    protected function handleCheckoutCompleted($session)
    {
        $tenantId = $session->metadata->tenant_id ?? null;

        if (!$tenantId) {
            Log::warning('Stripe webhook: tenant_id missing in checkout session metadata');
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            Log::warning("Stripe webhook: tenant #{$tenantId} not found");
            return;
        }

        $tenant->update([
            'stripe_subscription_id' => $session->subscription,
            'subscription_status'    => 'trialing',
            'is_active'              => true,
        ]);

        Log::info("Tenant #{$tenantId} subscription activated via checkout.");
    }

    // ✅ Renewal payment successful hui
    protected function handlePaymentSucceeded($invoice)
    {
        $subscriptionId = $invoice->subscription ?? null;
        if (!$subscriptionId) return;

        $tenant = Tenant::where('stripe_subscription_id', $subscriptionId)->first();
        if (!$tenant) return;

        $tenant->update([
            'subscription_status' => 'active',
            'is_active'           => true,
        ]);

        Log::info("Tenant #{$tenant->id} payment succeeded, subscription active.");
    }

    // ✅ Payment fail hui (card decline, insufficient funds, etc.)
    protected function handlePaymentFailed($invoice)
    {
        $subscriptionId = $invoice->subscription ?? null;
        if (!$subscriptionId) return;

        $tenant = Tenant::where('stripe_subscription_id', $subscriptionId)->first();
        if (!$tenant) return;

        $tenant->update([
            'subscription_status' => 'past_due',
        ]);

        Log::warning("Tenant #{$tenant->id} payment failed. Marked as past_due.");

        // Note: is_active abhi false nahi kar rahe — Stripe khud kai retries karta hai
        // Agar chaho toh yahan email bhi bhej sakte ho tenant ko warning ke liye
    }

    // ✅ Subscription cancel ho gayi
    protected function handleSubscriptionCancelled($subscription)
    {
        $tenant = Tenant::where('stripe_subscription_id', $subscription->id)->first();
        if (!$tenant) return;

        $tenant->update([
            'subscription_status' => 'canceled',
            'is_active'           => false,
        ]);

        Log::info("Tenant #{$tenant->id} subscription cancelled. Tenant deactivated.");
    }
}