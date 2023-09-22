<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    // this function is used to create user
    public function create($data)
    {
        $data['verification_token'] = Str::random(60);

        return $this->model->create($data);
    }

    // this function is used to  change the status of the user
    public function changeStatus($value)
    {
        tap($this->model->findOrFail(auth()->id())->update(['status' => $value]));

        return $this->model->find(auth()->id());
    }

    // this function is used reset the password
    public function resetPassword($request)
    {
        $user = User::find($request->user_id);
        tap($user->update(['password' => Hash::make($request->password), 'otp' => null]));
        // $result = $this->model->where('email', $token->email)->update(['password' => Hash::make($request->password)]);
        // $token = DB::table('password_resets')->where('email', $request->email)->delete();

        return $user;
    }

    public function checkPhone($request)
    {
        return $this->model->where(['country_code' => $request->country_code, 'phone' => $request->phone])->first();
    }
}
