<?php

namespace App\Http\Requests\V1\Company;

use App\Http\Requests\V1\CustomFormRequest;

class CompanyStoreRequest extends CustomFormRequest
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
            'company_name' => 'required|unique:company,company_name',
            'about_company' => 'required',
            'address' => 'required',
            'image' => 'nullable|array',
            'logo' => 'required',
            'job' => 'required|array',
            'job.job_title' => 'required',
            'job.occupation' => 'required|exists:job_category,id',
            'job.job_location' => 'required',
            'job.salary_from' => 'required',
            'job.salary_to' => 'required',
            'job.working_hours' => 'nullable',
            'job.break_time' => 'nullable',
            'job.holidays' => 'nullable|array',
            'job.vacation' => 'nullable',
            'job.age_from' => 'nullable|integer',
            'job.age_to' => 'nullable|integer',
            'job.gender' => 'required|integer|min:1|max:3|not_in:4', // male = 1 , female = 2, binary = 3
            // 'job.occupation' => 'nullable|integer|min:1|max:8|not_in:9',
            'job.experience' => 'nullable|integer|min:1|max:4|not_in:5', // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
            'job.japanese_level' => 'nullable|integer|min:1|max:5|not_in:6', // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
            'job.required_skills' => 'required',
            // 'job.published' => 'nullable',
            'job.from_when' => 'nullable',
            'job.experience_required' => 'nullable|boolean',
            'job.pay_raise' => 'nullable|boolean',
            'job.training' => 'nullable|boolean',
            'job.education' => 'nullable|boolean',
            'job.women_preferred' => 'nullable|boolean',
            'job.men_preferred' => 'nullable|boolean',
            'job.urgent_recruitment' => 'nullable|boolean',
            'job.social_insurance' => 'nullable|boolean',
            'job.english_required' => 'nullable|boolean',
            'job.accomodation' => 'nullable|boolean',
            'job.five_days_working' => 'nullable|boolean',
            'job.uniform_provided' => 'nullable|boolean',
            'job.station_chika' => 'nullable|boolean',
            'job.skill_up' => 'nullable|boolean',
            // 'job.big_company' => 'nullable|boolean',
            // 'job.part_time' => 'nullable|boolean',
            // 'job.full_time' => 'nullable|boolean',
            'job.temporary_staff' => 'nullable|boolean',
            'job.employer_status' => 'nullable|integer|min:1|max:4|not_in:5',
            ];
    }
}
