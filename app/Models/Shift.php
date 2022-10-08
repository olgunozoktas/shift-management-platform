<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed id
 * @property mixed company_id
 * @property mixed date_time
 * @property mixed type
 * @property mixed job_role_id
 * @property mixed text
 * @property mixed assigned_user_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property Company company
 */
class Shift extends Model
{
    const PICK_UP_REQUEST = 'Shift Pick Up Request';
    const PICK_UP_APPROVED = 'Shift Request Approval';
    const PICK_UP_REJECTED = 'Shift Request Reject';

    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function sendApprovalEmailToCompany()
    {

    }
}
