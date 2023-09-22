<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Matching\MatchingAcceptRequest;
use App\Http\Requests\V1\Matching\MatchingFavouriteRequest;
use App\Http\Requests\V1\Matching\MatchingStoreRequest;
use App\Http\Resources\V1\Matching\MatchingResource;
use App\Models\Matching;
use App\Services\FireBaseService;
use App\Services\MatchingService;

class MatchingController extends BaseController
{
    protected $matchingservice;

    protected $firebaseservice;

    // in this controller we have call the Matchingservice where all the model working will be perfrom on this service
    public function __construct(MatchingService $matchingservice, FireBaseService $firebaseservice)
    {
        $this->matchingservice = $matchingservice;
        $this->firebaseservice = $firebaseservice;
    }

// this function is used to fetch the received,sent,favourit and matching lists of user
    public function index()
    {
        $type = '';
        $message = '';
        if (request()->has('type')) {
            if (request()->get('type') === 'sent') {
                $type = 'created_by';
                $message = 'Sent request';
            } elseif (request()->get('type') === 'received') {
                $type = 'received';
                $message = 'Received request';
            } elseif (request()->get('type') === 'match') {
                $type = 'match';
                $message = 'Matching lists';
            } elseif (request()->get('type') === 'favourite') {
                $type = 'favourite_by';
                $message = 'Favourite lists';
            }

            $matching = $this->matchingservice->getAllsentRequest($type);

            return $this->success($matching, $message);
        }

        return $this->errors('Type field is required to fetch matching listss', 404);
    }

// this function wil send the matching request
    public function store(MatchingStoreRequest $request)
    {
        try {
            $output = $this->matchingservice->create($request);

            if (is_array($output)) {
                if (array_key_exists('message', $output)) {
                    return $this->success(new MatchingResource($output['check']), $output['message']);
                }
            }
            // $this->firebaseservice->sendNotification($output, 'request');

            return $this->success(new MatchingResource($output), 'Matching done succesfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), '400');
        }
    }

    // this function is used to add the favourite lists to user
    public function favourite(MatchingFavouriteRequest $request)
    {
        try {
            $output = $this->matchingservice->favourite($request);
            $outRes = $output['data'] ? new MatchingResource($output['data']) : [];

            return $this->success($outRes, $output['message']);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), '400');
        }
    }

// this function is used to get the accept and refusethe mathing
    public function accept(MatchingAcceptRequest $request, Matching $matching)
    {
        try {
            $output = $this->matchingservice->accept($request, $matching);

            $message = ($request->type == 'accept') ? 'Request accepted succesfully' : 'Request refuse succesfully';

            return $this->success(new MatchingResource($output), $message);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), '400');
        }
    }
}
