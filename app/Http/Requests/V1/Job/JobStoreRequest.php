<?php

namespace App\Http\Requests\V1\Job;

use App\Http\Requests\V1\CustomFormRequest;

class JobStoreRequest extends CustomFormRequest
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
           'job_title' => 'required',
            'occupation' => 'required|exists:job_category,id',
            'job_location' => 'required',
            'salary_from' => 'required',
            'salary_to' => 'required',
            'working_hours' => 'nullable',
            'break_time' => 'nullable',
            'holidays' => 'nullable|array',
            'vacation' => 'nullable',
            'age_from' => 'nullable|integer',
            'age_to' => 'nullable|integer',
            'gender' => 'required|integer|min:1|max:3|not_in:4', // male = 1 , female = 2, binary = 3
            // 'occupation' => 'nullable|integer|min:1|max:8|not_in:9',
            'experience' => 'nullable|integer|min:1|max:4|not_in:5', // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
            'japanese_level' => 'nullable|integer|min:1|max:5|not_in:6', // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
            'required_skills' => 'required',
            // 'published' => 'nullable',
            'from_when' => 'nullable',
            'experience_required' => 'nullable|boolean',
            'pay_raise' => 'nullable|boolean',
            'training' => 'nullable|boolean',
            'education' => 'nullable|boolean',
            'women_preferred' => 'nullable|boolean',
            'men_preferred' => 'nullable|boolean',
            'urgent_recruitment' => 'nullable|boolean',
            'social_insurance' => 'nullable|boolean',
            'english_required' => 'nullable|boolean',
            'accommodation' => 'nullable|boolean',
            'five_days_working' => 'nullable|boolean',
            'uniform_provided' => 'nullable|boolean',
            'station_chika' => 'nullable|boolean',
            'skill_up' => 'nullable|boolean',
            'big_company' => 'nullable|boolean',
            // 'part_time' => 'nullable|boolean',
            // 'full_time' => 'nullable|boolean',
            'employer_status' => 'nullable|integer|min:1|max:4|not_in:5',
            'temporary_staff' => 'nullable|boolean',
        ];
    }
}
