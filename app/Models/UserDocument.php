<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

/**
 * @property mixed id
 * @property mixed uuid
 * @property mixed user_id
 * @property mixed document_type_id
 * @property mixed document_path
 * @property mixed status
 * @property mixed notes
 * @property mixed created_at
 * @property mixed updated_at
 */
class UserDocument extends Model
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    public const DOCUMENT = ['doc', 'docx'];
    public const IMAGE = ['jpg', 'jpeg', 'png'];
    public const PDF = ['pdf'];

    use HasFactory;

    protected $appends = ['is_document', 'is_image', 'is_pdf'];

    public function getIsDocumentAttribute(): bool
    {
        return self::isDocument();
    }

    public function getIsImageAttribute(): bool
    {
        return self::isImage();
    }

    public function getIsPdfAttribute(): bool
    {
        return self::isPdf();
    }

    public function isDocument(): bool
    {
        $type = explode('.', $this->document_path)[1];
        return in_array($type, self::DOCUMENT);
    }

    public function isImage(): bool
    {
        $type = explode('.', $this->document_path)[1];
        return in_array($type, self::IMAGE);
    }

    public function isPdf(): bool
    {
        $type = explode('.', $this->document_path)[1];
        return in_array($type, self::PDF);
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleted(function ($document) {
            if (File::exists(storage_path('app/' . $document->document_path))) {
                File::delete(storage_path('app/' . $document->document_path));
            }
        });
    }
}
