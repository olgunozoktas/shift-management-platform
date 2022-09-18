<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed phone_no
 * @property mixed notification_type
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed deleted_at
 */
class Company extends Model
{
    const EMAIL = 'email';
    const TEXT_MESSAGE = 'text_message';
    const BOTH = 'both';

    use HasFactory;
    use SoftDeletes;

    public function users(): HasMany
    {
        return $this->hasMany(CompanyUser::class, 'company_id');
    }
}
