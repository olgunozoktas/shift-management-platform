<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed definition
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class JobRole extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'job_role_id');
    }
}
