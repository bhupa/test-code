<?php

namespace App\Http\Resources\V1\Matching;

use App\Http\Resources\V1\Company\CompanyDetailsResource;
use App\Http\Resources\V1\Jobseeker\JobseekerDetailsResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = (auth()->user()->user_type == 1) ? $this->jobseeker->user : $this->company->user;

        return [
            'id' => (string) $this->id,
            'company' => new CompanyDetailsResource($this->company),
            'jobseeker' => new JobseekerDetailsResource($this->jobseeker),
            // 'user' => new UserDetailsResources($user),
       ];
    }
}
