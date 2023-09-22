<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $fillable = [
        'company_name',
        'about_company',
        'address',
        'status',
        'user_id',
        'logo',
        'is_verify',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ImageFiles::class, 'model_id')->where('model', self::class);
    }

    public function jobs()
    {
        return $this->hasMany(Jobs::class, 'user_id', 'user_id');
    }
}
