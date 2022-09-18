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
 */
class Shift extends Model
{
    use HasFactory;

    public function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
