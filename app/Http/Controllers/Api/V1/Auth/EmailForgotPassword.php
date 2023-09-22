<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\V1\Auth\ForgetPassswordRequest;
use App\Http\Requests\V1\Auth\ResetPasswordRequest;
use App\Http\Requests\V1\Auth\VerifyOtpRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class EmailForgotPassword extends BaseController
{
    public $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

     // this function is used to send the otp for forget password
    public function forgot(ForgetPassswordRequest $request)
    {
        // this function will give the otp toke
        $otp = $this->generateOtp();

        try {
            if ($request->has('email')) {
                $user = User::where('email', $request->email)->first();
                $user->notify(new ResetPasswordNotification($otp));
                tap($user->update(['otp' => $otp]));
                $message = 'Check your email';
            } else {
                $user = User::where('phone', $request->phone)->first();
                $message = 'Phone exists in database';
            }
            $data = [
                'email' => $user->email,
                'phone' => $user->phone,
                'countryCode' => $user->country_code,
                'userId' => $user->id,
            ];

            return $this->success($data, $message);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

   // this function is used for changing
    public function reset(ResetPasswordRequest $request)
    {
        try {
            $this->userservice->resetPassword($request);

            return $this->success([], 'Password reset successfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }

        return $this->error('Invalid otp', 400);
    }

      // this 2 function is used to check and generate
    // public function checkUniqueToken($token){
    //    return DB::table('password_resets')->WHERE('token',$token);
    // }
    // public function generateToken(){
    //     $token  = Str::random(64);
    //     if($this->checkUniqueToken($token)){
    //         return $token;
    //     }
    //     return $this->generateToken();
    // }
// this function will check if opt
    public function checkUniqueOtp($otp)
    {
        return User::where('otp', $otp)->first();
    }

     // this function will generate the otp
    public function generateOtp()
    {
        $otp = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        if ($this->checkUniqueOtp($otp)) {
            return $this->generateOtp();
        }

        return $otp;
    }

    // this function is used for verifying the otp for forget password
    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $user = $this->checkUniqueOtp($request->otp);
            $data = [
                'email' => $user->email,
                'phone' => $user->phone,
                'countryCode' => $user->country_code,
                'userId' => $user->id,
            ];

            return $this->success($data, 'User Details');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }
}
