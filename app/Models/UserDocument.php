<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed user_id
 * @property mixed document_type_id
 * @property mixed document_path
 * @property mixed created_at
 * @property mixed updated_at
 */
class UserDocument extends Model
{
    use HasFactory;
}
