<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dummyid',
        'company_type_id',
        'job_type_id',
        'annual_income_id',
        'occupation_id',
        'religion_id',
        'caste_id',
        'education_id',
        'profile_for',
        'name',
        'email',
        'mobile',
        'password',
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
    ];

    public function profileFor()
    {
        return $this->belongsTo(ProfileType::class, 'profile_for', 'ptid')
                    ->select('ptid', 'name');
    }
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id', 'eid')
                    ->select('eid', 'name');
    }
    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id', 'oid')
                    ->select('oid', 'name');
    }
    public function annualIncome()
    {
        return $this->belongsTo(AnnualIncome::class, 'annual_income_id', 'aid')
                    ->select('aid', 'range');
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'jtid')
                    ->select('jtid', 'name');
    }
    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id', 'ctid')
                    ->select('ctid', 'name');
    }
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'rid')
                    ->select('rid', 'name');
    }
    public function caste()
    {
        return $this->belongsTo(Caste::class, 'caste_id', 'cid')
                    ->select('cid', 'name');
    }

}
