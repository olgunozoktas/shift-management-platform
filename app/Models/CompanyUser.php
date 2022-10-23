<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed id
 * @property mixed company_id
 * @property mixed user_id
 * @property mixed company_role
 * @property mixed company_phone_no
 * @property mixed created_at
 * @property mixed updated_at
 */
class CompanyUser extends Model
{
    const ADMIN = 'admin';
    const CONTRACT_STAFF = 'contract_staff';

    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['user_id', 'company_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
