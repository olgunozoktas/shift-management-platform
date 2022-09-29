<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed status
 * @property mixed updated_by_id
 * @property mixed notes
 * @property mixed created_at
 * @property mixed updated_at
 */
class Application extends Model
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    use HasFactory;

    public function isRejected(): bool
    {
        return $this->status == self::REJECTED;
    }

    public function isApproved(): bool
    {
        return $this->status == self::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status == self::PENDING;
    }
}
