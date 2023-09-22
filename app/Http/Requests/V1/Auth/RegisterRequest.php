<?php

namespace App\Http\Requests\V1\Auth;

use App\Http\Requests\V1\CustomFormRequest;

class RegisterRequest extends CustomFormRequest
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
        return [
            'email' => ['required', 'string', 'max:255', 'unique:users', 'email'],
            'country_code' => ['required'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'user_type' => ['required', 'integer', 'in:1,2'],
        ];
    }
}
