<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed shift_id
 * @property mixed status
 * @property mixed created_at
 * @property mixed updated_at
 */
class ShiftRequest extends Model
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    use HasFactory;
}
