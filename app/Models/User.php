<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed email_verified_at
 * @property mixed password
 * @property mixed role
 * @property mixed status
 * @property mixed phone_no
 * @property mixed job_role_id
 * @property mixed remember_token
 * @property mixed created_at
 * @property mixed updated_at
 * @property Company company
 * @property CompanyUser[] companyUser
 * @property JobRole jobRole
 * @property UserDocument[] userDocuments
 * @property ShiftRequest[] shiftRequests
 */
class User extends Authenticatable
{
    const ADMIN = 'admin';
    const USER = 'user';

    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    const PENDING = 'pending';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    public function companies(): HasMany
    {
        return $this->hasMany(CompanyUser::class, 'user_id');
    }

    public function company(): HasOneThrough
    {
        /**
         * $firstKey = `company_users`.`user_id` in (?)
         * $secondKey = inner join `company_users` on '' = `companies`.`id`
         * $secondLocalKey = inner join `company_users` on `company_users`.`company_id` = ''
         */
        return $this->hasOneThrough(Company::class, CompanyUser::class, 'user_id', 'id', 'id', 'company_id');
    }

    public function companyUser(): HasOne
    {
        return $this->hasOne(CompanyUser::class, 'user_id');
    }

    public function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class, 'job_role_id');
    }

    public function userDocuments(): HasMany
    {
        return $this->hasMany(UserDocument::class);
    }

    public function shiftRequests(): HasMany
    {
        return $this->hasMany(ShiftRequest::class);
    }
}
