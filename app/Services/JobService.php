<?php

namespace App\Services;

use App\Models\Jobs;
use Carbon\Carbon;

class JobService extends BaseService
{
    public function __construct(Jobs $job)
    {
        $this->model = $job;
    }

      // this function is used to create job
    public function create($request)
    {
        if ($request->has('job')) {
            $data = $request->job;
            // if ($request->has('job.published') && !empty($request->job['published'])) {
            //     $data['published'] = $this->datetoTimeString($request->job['published']);
            // }
            if ($request->has('job.from_when') && !empty($request->job['from_when'])) {
                $data['from_when'] = $this->datetoTimeString($request->job['from_when']);
            }
            $data['holidays'] = $request->job['holidays'];
        } else {
            $data = $request->except('_token');
            // if ($request->has('published') && !empty($request->published)) {
            //     $data['published'] = $this->datetoTimeString($request->published);
            // }
            if ($request->has('from_when') && !empty($request->from_when)) {
                $data['from_when'] = $this->datetoTimeString($request->from_when);
            }
            $data['holidays'] = $request->holidays;
            $data['status'] = $request->status ? 1 : 0;
        }
        $data['user_id'] = auth()->id();
        $data['status'] = 1;

        return $this->model->create($data);
    }

    // this function is used to update job
    public function update($request, $jobs)
    {
        $data = $request->except('_token');
        $data['holidays'] = $request->holidays;

        return $jobs->update($data);
    }

    public function match()
    {
        $jobseeker = auth()->user()->jobseeker;

        return $this->model->where('occupation', $jobseeker->occupation)
                            ->where('japanese_level', $jobseeker->japanese_level)
                            ->where('experience', $jobseeker->experience)->get();
    }

    // this function is used for the job filters
    public function filter($request)
    {
        $jobs = Jobs::query();

        $data = $request->only(
            'job_category_id',
            'user_id',
            'job_location',
            'salary_from',
            'salary_to',
            'working_hours_id',
            'breaking_time_id',
            'holidays',
            'vacation',
            'age_from',
            'age_to',
            'gender',
            'occupation',
            'experience',
            'japanese_level',
            'required_skills',
            'published',
            'from_when',
            'experience_required',
            'pay_raise',
            'training',
            'education',
            'women_preffered',
            'men_preffered',
            'urgent_recruitment',
            'social_insurance',
            'english_required',
            'accomodation',
            'five_days_working',
            'unifrom_provided',
            'station_chika',
            'skill_up',
            'big_company',
            'part_time',
            'full_time',
            'temporary_staff',
        );
        foreach ($data as $key => $val) {
            if ($val !== null && $val !== '') {
                if ($key === 'age_from') {
                    $jobs->where('age_from', '>=', $request->age_from);
                } elseif ($key === 'age_to') {
                    $jobs->where('age_to', '<=', $request->age_to);
                } elseif ($key === 'from_when') {
                    $jobs->whereDate('from_when', '=', $request->from_when);
                } else {
                    $jobs->where($key, $val);
                }
            }
        }
        $perPage = $request->has('per_page') ? $request->get('per_page') : '30';

        return $jobs->whereDate('published', '>', Carbon::today())->paginate($perPage);
    }
}
