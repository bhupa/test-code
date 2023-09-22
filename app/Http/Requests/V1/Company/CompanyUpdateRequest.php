<?php

namespace App\Http\Requests\V1\Company;

use App\Http\Requests\V1\CustomFormRequest;

class CompanyUpdateRequest extends CustomFormRequest
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
        $company = $this->route('company');

        return [
            'company_name' => 'nullable|unique:company,company_name,'.$company->id,
            'about_company' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable|array',
            'image_ids.*' => 'nullable|integer|exists:image_files,id',
            'logo' => 'nullable',
        ];
    }
}
