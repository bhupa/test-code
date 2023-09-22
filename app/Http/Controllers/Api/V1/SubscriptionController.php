<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Subscription;
use Stripe\Webhook;

class SubscriptionController extends BaseController
{
    public function webhook(Request $request)
    {
        $webHookSecret = env('STRIPE_WEBOOK_SECRET');
        $plyload = $request->getContent();
        $sigHeader = $request->header('Stripe-Sig');
        $event = null;
        try {
            $event = Webhook::constructEvent(
                $plyload, $sigHeader, $webHookSecret
            );

            if ($event->type === 'customer.subscription.updated') {
                $subscription = Subscription::retrieve($event->data->object->id);

                $planId = $subscription->items->data[0]->plan->id;
                $currentPeriodEnd = $subscription->current_period_end;
                if ($planId == 'prod_Ofk5nTIzOKpiJk') {
                    $currentTimestamp = time();
                    $endTimestamp = strtotime($currentPeriodEnd);
                } else {
                    $endTimestamp = '1';
                }
                // Update the trial end date and current end date as needed
                // $trialEndDate = $subscription->trial_end;

                // $currentEndDate = $subscription->current_period_end;

                // Your logic to update the trial and end dates here

                // Save the updated subscription
                $subscription->update(['ends_at' => $endTimestamp]);
            }
        } catch (SignatureVerificationException $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    public function addPlan(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $token = $request->stripeToken;
        $user = auth()->user();
        try {
            if (is_null(auth()->user()->stripe_id)) {
                $stripeCustomer = $user->createAsStripeCustomer();
            } else {
                $stripeCustomer = $user->asStripeCustomer();
            }

            $result = $user->newSubscription('default', $request->stripe_plan)->create('pm_card_visa');

            return $this->success($result, 200);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }
}
