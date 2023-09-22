<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Social\SocialLoginRequest;
use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\Jobseeker\JobseekerDetailsResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends BaseController
{
    // this function is used for the social login
    public function login(SocialLoginRequest $request)
    {
        try {
            $provider = $request->provider;
            $parameters = ['access_type' => 'offline'];
            $token = $request->token;
            // this is for google
            if ($provider == 'GOOGLE') {
                $providerID = 'google_id';
                $google = Socialite::driver('google')->with($parameters)->scopes(['email', 'phone'])->stateless()->userFromToken($token);
                $email = $google->getEmail();
                $phone = isset($google->user['phone']) ? $google->user['phone'] : null;
                $id = $google->getId();
            } elseif ($provider == 'FACEBOOK') {
                // this is for facebook
                $providerID = 'facebook_id';
                $facebook = Socialite::driver('facebook')->with($parameters)->scopes(['public_profile'])->stateless()->userFromToken($token);
                $email = $facebook->getEmail();
                $phone = isset($facebook->user['phone']) ? $facebook->user['phone'] : null;
                $id = $facebook->getId();
            } else {
                // this is for apple
                $providerID = 'apple_id';
                $driver = 'apple';
            }

            $user = User::where($providerID, $id)->first();
            if (empty($user)) {
                $input = [
                    'email' => $email,
                    'status' => 1,
                    'phone' => $phone,
                    'user_type' => $request->user_type,
                ];

                $input[$providerID] = $id;
                $us = User::where('email', $email)->first();
                if ($us) {
                    $us->update([$providerID => $id]);
                    $user = $us;
                } else {
                    $user = User::create($input);
                }
            }

            $auth = Auth::login($user);
            $data['user'] = new UserDetailsResources(auth()->user());
            $data['provider'] = $provider;
            $data['token'] = $user->createToken('JobMacthy')->plainTextToken;
            if (auth()->user()->user_type == 1) {
                $data['jobseeker'] = new JobseekerDetailsResource(auth()->user()->jobseeker);
            } else {
                $data['company'] = new CompanyDetailsResource(auth()->user()->company);
            }

            return $this->success($data, 'Login Successful');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }
}
