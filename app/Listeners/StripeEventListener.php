<?php

namespace App\Listeners;

use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Subscription;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookHandled $event): void
    {
        if (in_array($event->payload['type'], [
            'customer.subscription.created',
            'customer.subscription.updated',
        ])) {
            $this->updateMetadata($event);
        }

        if ($event->payload['type'] === 'customer.subscription.updated') {
            $this->handleChangePlan($event);
        }

        if ($event->payload['type'] === 'customer.subscription.deleted') {
            $this->updateTokenExpiry($event);
        }
    }

    /**
     * Update the subscription with the Product's metadata
     */
    private function updateMetadata(WebhookHandled $event): void
    {
        $productId = Arr::get($event->payload, 'data.object.plan.product');
        $subscriptionId = Arr::get($event->payload, 'data.object.id');

        // We get the product from Stripe so we can access its metadata.
        $product = Cashier::stripe()->products->retrieve($productId);

        // We update the subscription token and request limit
        Subscription::query()
            ->where('stripe_id', $subscriptionId)
            ->update([
                'is_free' => filter_var($product->metadata->is_free, FILTER_VALIDATE_BOOLEAN),
                'tokens_allowed' => (int) $product->metadata->tokens_allowed,
                'requests_per_minute' => (int) $product->metadata->requests_per_minute,
            ]);
    }

    /**
     * A user's token expiry when their subscription has been canceled.
     */
    private function updateTokenExpiry(WebhookHandled $event): void
    {
        $subscriptionId = Arr::get($event->payload, 'data.object.id');

        $user = User::whereHas(
            'subscriptions',
            function (Builder $query) use ($subscriptionId) {
                $query->where('stripe_id', $subscriptionId);
            }
        )->first();

        if (! $user || ! $user->tokens()->exists()) {
            return;
        }

        $user->tokens()->update(['expires_at' => now()]);
    }

    private function handleChangePlan(WebhookHandled $event): void
    {
        $subscriptionId = Arr::get($event->payload, 'data.object.id');

        // We update the subscription token and request limit
        $subscription = Subscription::query()
            ->where('stripe_id', $subscriptionId)
            ->first();

        $tokenQuery = PersonalAccessToken::query()
            ->where('tokenable_id', $subscription->user_id);

        // First, if the token count does not meet the subscription limits,
        // we flag the user's account
        User::query()
            ->where('id', $subscription->user_id)
            ->update([
                'account_warning' => $tokenQuery->count() > $subscription->tokens_allowed,
            ]);

        // Next, we handle sitations where the user has downgraded from
        // a paying plan a free plan
        if (! $subscription->is_free) {
            return;
        }

        $invalidExpiryQuery = $tokenQuery
            ->whereDate('expires_at', '>', now()->endOfDay()->addDays(7))
            ->orWhereNull('expires_at');

        if (! $invalidExpiryQuery->exists()) {
            return;
        }

        // If we got this far, then the user went from a paying plan
        // to a free plan. We force, their tokens to expire within
        // 7 days.
        $invalidExpiryQuery
            ->update(['expires_at' => now()->endOfDay()->addDays(7)]);
    }
}
