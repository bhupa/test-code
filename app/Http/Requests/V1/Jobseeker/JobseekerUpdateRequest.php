<?php

namespace App\Http\Requests\V1\Jobseeker;

use App\Http\Requests\V1\CustomFormRequest;

class JobseekerUpdateRequest extends CustomFormRequest
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
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'image' => 'nullable|array',
             'birthday' => 'nullable',
            'gender' => 'nullable|integer|min:1|max:3|not_in:4', // male = 1 , female = 2, binary = 3
            'country' => 'nullable',
            'current_country' => 'nullable',
            'occupation' => 'nullable|integer|min:1|max:8|not_in:9',
            'experience' => 'nullable|integer|min:1|max:4|not_in:5', // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
            'japanese_level' => 'nullable|integer|min:1|max:5|not_in:6', // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
            'about' => 'nullable',
            'living_japan' => 'nullable|boolean',
            'ielts_six' => 'nullable|boolean',
            'visa' => 'nullable|boolean',
            'image_ids.*' => 'nullable|integer|exists:image_files,id',
        ];
    }
}
