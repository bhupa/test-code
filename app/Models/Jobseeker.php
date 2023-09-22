<?php

namespace App\Models;

use App\Traits\JobTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseeker extends Model
{
    use HasFactory;
    use JobTraits;

    protected $table = 'jobseekers';

    protected $fillable = [
            'user_id',
            'first_name',
            'last_name',
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
            'visa',
            'is_verify',
            'profile_img',
            'employment_status',
    ];
    protected $dates = ['birthday'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ImageFiles::class, 'model_id')->where('model', self::class);
    }
}
