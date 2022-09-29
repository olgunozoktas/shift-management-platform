<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create(): Factory|View|Application
    {
        $route = route('applications.store');
        $documentTypes = DocumentType::query()->get();

        return view('pages.applications.manage', compact('route', 'documentTypes'));
    }

    public function store(Request $request)
    {
        $documentTypes = DocumentType::query()->pluck('id')->toArray();
        $uploadedDocuments = $request->documents;

        foreach(array_keys($uploadedDocuments) as $array_key) {
            if(!in_array($array_key, $documentTypes)) {
                return redirect()->back();
            }
        }

        foreach($uploadedDocuments as $key => $uploadedDocument) {
            //TODO:: Upload file
        }
    }
}
