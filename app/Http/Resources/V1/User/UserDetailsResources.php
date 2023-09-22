<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\Job\JobDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = [1 => 'active', 2 => 'deactive', 3 => 'restricted'];

        return [
            'id' => (string) $this->id,
            'email' => $this->email,
            'countryCode' => $this->country_code,
            'phone' => $this->phone,
            // 'user_type'=>($this->user_type ==1) ? 'Jobseeker' : 'employer',
            'userType' => $this->user_type,
            'status' => $this->status,
            'isProfileComplete' => ($this->user_type == 1) ? (($this->jobseeker) ? true : false) : (($this->company) ? true : false),
            // 'status'=> $status[$this->status],
            'deviceToken' => $this->device_token,
            'googleId' => $this->google_id,
            'facebookId' => $this->facebook_id,
            'appleId' => $this->apple_id,
            // 'company'=> ($this->user_type == 2) ? new CompanyDetailsResource($this->company) : null,
            // 'jobseeker' => ($this->user_type == 1) ? $this->jobseeker : null,
            // 'company' => ($this->user_type == 2) ? $this->company : null,
            // 'jobs' => JobDetailsResource::collection($this->jobs),
        ];
    }
}
