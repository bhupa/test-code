<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Matching\MatchingPaymentRequest;
use App\Http\Resources\V1\Matching\MatchingResource;
use App\Services\MatchingPaymentService;
use App\Services\MatchingService;

class StripeController extends BaseController
{
    protected $matchingPayment;
    protected $matchingService;

    public function __construct(MatchingPaymentService $matchingPayment, MatchingService $matchingService)
    {
        $this->matchingPayment = $matchingPayment;
        $this->matchingService = $matchingService;
    }

    // this function is used for
    public function paymentProcess(MatchingPaymentRequest $request)
    {
        try {
            $matching = $this->matchingService->find($request->matching_id);
            if (empty($matching->payment)) {
                $output = $this->matchingPayment->create($request);
                $message = 'Payment done successfully';
            } else {
                $output = $matching->payment['stripe_response'];
                $message = 'Already paid ';
            }
            $data['matching'] = new MatchingResource($matching);
            $data['stripeResponse'] = $matching->payment;

            return $this->success($data, $message);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }
}
