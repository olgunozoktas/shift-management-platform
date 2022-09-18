<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = ['user_id', 'company_id'];
}
