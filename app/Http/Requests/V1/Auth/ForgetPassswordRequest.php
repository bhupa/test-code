<?php

namespace App\Http\Requests\V1\Auth;

use App\Http\Requests\V1\CustomFormRequest;

class ForgetPassswordRequest extends CustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (request()->has('email')) {
            $data = [
                'email' => 'required|email|exists:users,email',
            ];
        } else {
            $data = [
                'phone' => 'required|exists:users,phone',
            ];
        }

        return $data;
    }
}
