<?php

namespace App\Http\Resources\V1\Job;

use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => (string) $this->id,
        'occupation' => new JobCategoryResource($this->occupations),
        'jobLocations' => $this->job_location,
        'salaryFrom' => $this->salary_from,
        'salaryTo' => $this->salary_to,
        'workingHours' => $this->working_hours,
        'breakTime' => $this->break_time,
        'holidays' => $this->holidays,
        'vacation' => $this->vacation,
        'ageFrom' => $this->age_from,
        'ageTo' => $this->age_to,
        'gender' => $this->gender,
        // 'occupation' => $this->occupation,
        'experience' => $this->experince,
        'japaneseLevel' => $this->japanese_level,
        // 'published' => $this->published,
        'requiredSkills' => $this->required_skills,
        'fromWhen' => $this->from_when,
        'experienceRequired' => $this->experience_required ? 1 : 0,
        'payRaise' => $this->pay_raise ? 1 : 0,
        'training' => $this->training ? 1 : 0,
        'education' => $this->education ? 1 : 0,
        'womenPreferred' => $this->women_preferred ? 1 : 0,
        'menPreferred' => $this->men_preferred ? 1 : 0,
        'urgentRecruitment' => $this->urgent_recruitment ? 1 : 0,
        'socialInsurance' => $this->social_insurance ? 1 : 0,
        'englishRequired' => $this->english_required ? 1 : 0,
        'accommodation' => $this->accommodation ? 1 : 0,
        'fiveDaysWorking' => $this->five_days_working ? 1 : 0,
        'uniformProvided' => $this->uniform_provided ? 1 : 0,
        'stationChika' => $this->station_chika ? 1 : 0,
        'skillUp' => $this->skill_up ? 1 : 0,
        'bigCompany' => $this->big_company ? 1 : 0,
        'status' => $this->status ? 1 : 0,
        'employerStatus' => $this->employer_status ? 1 : 0,
        'bigCompany' => $this->big_company ? 1 : 0,
        // 'partTime' => $this->part_time ? 1 : 0,
        // 'fullTime' => $this->full_time ? 1 : 0,
        // 'ssw' => $this->ssw ? 1 : 0,
        'internship' => $this->internship ? 1 : 0,
        'temporaryStaff' => $this->temporary_staff ? 1 : 0,
        'user' => new UserDetailsResources($this->user),
        'company' => $this->user->company ? new CompanyDetailsResource($this->user->company) : null,
    ];
    }
}
