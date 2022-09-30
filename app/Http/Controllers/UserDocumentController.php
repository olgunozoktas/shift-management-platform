<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserDocumentController extends Controller
{
    public function show(UserDocument $userDocument): BinaryFileResponse
    {
        $filePath = storage_path('app/' . $userDocument->document_path);
        return response()->file($filePath);
    }
}
