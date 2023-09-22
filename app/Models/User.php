<?php

namespace App\Models;

use App\Notifications\EmailVerify;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country_code',
        'phone',
        'email',
        'password',
        'user_type',
        'status',
        'verification_token',
        'device_token',
        'google_id',
        'facebook_id',
         'apple_id',
         'otp',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = 'https://jobmatchy.localhost/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function verificationUrl()
    {
        return url(env('APP_FRONTEND_URL').'verify-email/'.$this->id.'/'.$this->verification_token);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerify($this->verificationUrl()));
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function jobseeker()
    {
        return $this->hasOne(Jobseeker::class, 'user_id');
    }

    public function jobs()
    {
        return $this->hasMany(Jobs::class);
    }
}
