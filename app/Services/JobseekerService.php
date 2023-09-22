<?php

namespace App\Services;

use App\Models\Jobseeker;

class JobseekerService extends BaseService
{
    public function __construct(Jobseeker $jobseeker)
    {
        $this->model = $jobseeker;
    }
     // this function is used to filter jobseeker

     public function filter($request)
     {
         $jobseekers = Jobseeker::query();

         $data = $request->only(
             'first_name',
             'last_name',
             'image',
             'birthday',
             'gender', // male = 1 , female = 2, binary = 3
             'country',
             'current_country',
             'occupation',
             'experience', // less than 1 year = 1, less than 2 year =2, less than 3 year = 3, 3 or more = 4
             'japanese_level', // N1 = 1 , N2 = 2, N3 = 3, N4 = 4 , N5 =5
             'about',
             'living_japan',
             'ielts_six',
             'visa'
         );
         foreach ($data as $key => $val) {
             if ($val !== null && $val !== '') {
                 if ($key === 'first_name') {
                     $jobseekers->where('first_name', 'like', '%'.$request->first_name.'%');
                 } elseif ($key === 'last_name') {
                     $jobseekers->where('last_name', 'like', '%'.$request->last_name.'%');
                 } else {
                     $jobseekers->where($key, $val);
                 }
             }
         }

         $perPage = $request->has('per_page') ? $request->get('per_page') : '30';

         return $jobseekers->paginate($perPage);
     }

    public function create($request)
    {
        $data = $request->except('_token', 'image', 'birthday', 'profile_img');
        $data['user_id'] = auth()->id();
        $data['status'] = 1;
        $data['birthday'] = $this->datetoTimeString($request->birthday);
        if ($request->hasFile('profile_img')) {
            $data['profile_img'] = $this->uploadImg($request->profile_img, 'jobseeker/ProfileImg');
        }

        return $this->model->create($data);
    }

    public function update($request, $jobseeker)
    {
        $data = $request->except('_token', 'image', 'birthday', 'image_ids');
        if ($request->birthday) {
            $data['birthday'] = $this->datetoTimeString($request->birthday);
        }
        if ($request->hasFile('profile_img')) {
            $data['profile_img'] = $this->uploadImg($request->profile_img, 'jobseeker/ProfileImg');
            $this->deleteImage($jobseeker->profile_img);
        }

        return $jobseeker->update($data);
    }
}
