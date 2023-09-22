<?php

namespace App\Models;

use App\Traits\JobTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    use JobTraits;

    protected $table = 'jobs';

    protected $fillable = [
        'job_title',
        // 'job_category_id',
        'user_id',
        'job_location',
        'salary_from',
        'salary_to',
        'working_hours',
        'break_time',
        'vacation',
        'age_from',
        'age_to',
        'gender',
        'occupation',
        'experience',
        'japanese_level',
        'published',
        'holidays',
        'required_skills',
        'from_when',
        'experience_required',
        'pay_raise',
        'training',
        'education',
        'women_preferred',
        'men_preferred',
        'urgent_recruitment',
        'social_insurance',
        'english_required',
        'accommodation',
        'five_days_working',
        'uniform_provided',
        'station_chika',
        'skill_up',
        'big_company',
        'employeer_status',
        'status',
        // 'part_time',
        // 'full_time',
        // 'ssw',
        // 'internship',
        'temporary_staff',
    ];

    protected $casts = [
        'holidays' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function occupations()
    {
        return $this->belongsTo(JobCategory::class, 'occupation');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
