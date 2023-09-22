<?php

namespace App\Http\Resources\V1\Jobseeker;

use App\Http\Resources\V1\ImageFile\ImageFileResource;
use App\Http\Resources\V1\User\UserDetailsResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobseekerDetailsResource extends JsonResource
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
            'user' => new UserDetailsResources($this->user),
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'image' => ImageFileResource::collection($this->images),
            'birthday' => $this->birthday,
            'gender' => $this->gender, // male = 1 , female = 2, binary = 3
            'country' => $this->country,
            'currentCountry' => $this->current_country,
            'occupation' => $this->occupation,
            'experience' => $this->experience, // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
            'japaneseLevel' => $this->japanese_level, // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
            'about' => $this->about,
            'isLivingInJapan' => $this->living_japan ? true : false,
            'isTOEIC' => $this->ielts_six ? true : false,
            'isVisaObtained' => $this->visa ? true : false,
            'isLookingForLongTerm' => $this->longterm ? true : false,
            'employmentStatus' => $this->employment_status,
            'isVerified' => $this->is_verify ? 1 : 0,
            'profileImg' => $this->profile_img ? url('/').'/storage/'.$this->profile_img : null,
        ];
    }
}
