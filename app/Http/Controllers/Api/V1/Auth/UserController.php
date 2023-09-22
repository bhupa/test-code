<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Requests\V1\DeviceToken\DeviceTokenRequest;
use App\Http\Requests\V1\Phone\CheckPhoneRequest;
use App\Http\Requests\V1\UserChangeStatusRequest;
use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\Jobseeker\JobseekerDetailsResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use App\Models\Company;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    protected $userservice;

    public function __construct(UserService $userservice)
    {
        $this->userservice = $userservice;
    }

     // this function is used for the login
    public function login(LoginRequest $request)
    {
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password]) || \Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $data['user'] = new UserDetailsResources(auth()->user());
            $data['provider'] = null;
            $data['token'] = auth()->user()->createToken('JobMacthy')->plainTextToken;
            if (auth()->user()->user_type == 1) {
                $data['jobseeker'] = new JobseekerDetailsResource(auth()->user()->jobseeker);
            } else {
                $data['company'] = new CompanyDetailsResource(auth()->user()->company);
            }

            return $this->success($data, 'Login Successful');
        }
        $message = ($request->has('email')) ? 'Email or password invalid' : 'Phone, country_code or password invalid';

        return $this->errors($message, 400);
    }

    // this function is used for user registration
    public function register(RegisterRequest $request)
    {
        $data = $request->except('_token', 'password_confirmation');
        $data['password'] = \Hash::make($request->password);
        $data['status'] = 1;
        try {
            $user = $this->userservice->create($data);

            // event(new Registered($user)); this is used to send the email after succcess registration
            return $this->success([
                'user' => new UserDetailsResources($user),
                'provider' => null,
                'token' => $user->createToken('JobMacthy'.$user->email)->plainTextToken,
            ], 'User register sucessfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    // this function  is used for logout
    public function logout(Request $request)
    {
        // $request->user()->tokens()->delete();
        Auth::guard('web')->logout();

        return $this->success([], 'Logout successfully');
    }

     // this function is used for thechange user status
    public function changeStatus(UserChangeStatusRequest $request)
    {
        try {
            $user = $this->userservice->changeStatus($request->status);

            return $this->success([
              'user' => new UserDetailsResources($user),
         ], 'User status updated sucessfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

// this function is used to delete user
    public function delete()
    {
        $user = $this->userservice->getDetails($id);
        if ($user) {
            return $this->success([
                'user' => new UserDetailsResources($user),
             ], 'User details');
        }
    }

    public function getUserDetails($id)
    {
        $user = $this->userservice->getDetails($id);
        if ($user) {
            return $this->success([
                'user' => new UserDetailsResources($user),
             ], 'User details');
        }

        return $this->errors('User not found', 400);
    }

    public function addingDeviceToke(DeviceTokenRequest $request)
    {
        try {
            $user = auth()->user();
            $user->update(['device_token' => $request->device_token]);

            return $this->success([
              'user' => new UserDetailsResources(auth()->user()->refresh()),
           ], 'User device token updated sucessfully');
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), 400);
        }
    }

    public function checkPhone(CheckPhoneRequest $request)
    {
        $phone = $this->userservice->checkPhone($request);

        if ($phone) {
            return $this->errors('Phone number already exists', 201);
        }

        return $this->success([], 'Phone number not exists');
    }
}
