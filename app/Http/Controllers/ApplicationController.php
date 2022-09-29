<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\UserDocument;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function create(): Factory|View|Application|RedirectResponse
    {
        if (hasApplication()) {
            return redirect()->route('dashboard');
        }

        $route = route('applications.store');
        $documentTypes = DocumentType::query()->get();

        return view('pages.applications.manage', compact('route', 'documentTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $documentTypes = DocumentType::query()->pluck('id')->toArray();
        $uploadedDocuments = $request->documents;

        foreach (array_keys($uploadedDocuments) as $array_key) {
            if (!in_array($array_key, $documentTypes)) {
                return redirect()->back();
            }
        }

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $application = new \App\Models\Application();
            $application->user_id = $user->id;
            $application->save();

            foreach ($uploadedDocuments as $key => $uploadedDocument) {
                $fileExtension = $uploadedDocument->getClientOriginalExtension();
                $uuid = Str::uuid();
                $path = $uuid . '.' . $fileExtension;

                $userPath = 'user-' . $user->id;

                $uploadedDocument->storeAs($userPath, $path, '');
                $userDocument = new UserDocument();
                $userDocument->uuid = $uuid;
                $userDocument->user_id = $user->id;
                $userDocument->document_type_id = $key;
                $userDocument->document_path = $userPath . '/' . $path;
                $userDocument->save();
            }
            DB::commit();
        } catch (\Exception $exception) {
            Log::alert("Application Submit Error: ", [$exception->getMessage(), $exception->getLine()]);
            DB::rollBack();
            return redirect()->back();
        }

        return redirect()->route('dashboard');
    }
}
