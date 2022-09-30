<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed status
 * @property mixed updated_by_id
 * @property mixed notes
 * @property mixed created_at
 * @property mixed updated_at
 * @property User user
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approve()
    {
        $this->status = self::APPROVED;
        $this->updated_by_id = Auth::id();
        $this->save();
    }

    public function reject($reason)
    {
        $this->status = self::REJECTED;
        $this->notes = $reason;
        $this->updated_by_id = Auth::id();
        $this->save();
    }
}
