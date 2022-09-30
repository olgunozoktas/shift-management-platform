<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    public function index()
    {
        if (!isAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $pendingApplications = \App\Models\Application::query()
            ->with('user')
            ->where('status', 'pending')->get();
        return view('pages.applications.index', compact('pendingApplications'));
    }

    public function create(): Factory|View|Application|RedirectResponse
    {
        if (hasApplication()) {
            return redirect()->route('dashboard');
        }

        $userDocuments = UserDocument::query()->where('user_id', Auth::id())
            ->where('status', '=', 'approved')
            ->pluck('document_type_id')
            ->toArray();

        $route = route('applications.store');
        $documentTypes = DocumentType::query()->whereNotIn('id', $userDocuments)->get();

        return view('pages.applications.manage', compact('route', 'documentTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $userDocuments = UserDocument::query()->where('user_id', Auth::id())
            ->where('status', '=', 'approved')
            ->pluck('document_type_id')
            ->toArray();

        $documentTypes = DocumentType::query()->whereNotIn('id', $userDocuments)->pluck('id')->toArray();
        $uploadedDocuments = $request->documents;

        foreach (array_keys($uploadedDocuments) as $array_key) {
            if (!in_array($array_key, $documentTypes)) {
                Session::put('error', 'Uploaded document is not allowed');
                return redirect()->back();
            }
        }

        foreach ($uploadedDocuments as $key => $uploadedDocument) {
            $fileExtension = $uploadedDocument->getClientOriginalExtension();

            if (!in_array($fileExtension, ['docx', 'doc', 'jpeg', 'jpg', 'png', 'pdf'])) {
                Session::put('error', 'Uploaded document type is not allowed! You can only upload documents in "docx, doc, jpeg, jpg, png or pdf" types.');
                return redirect()->back();
            }
        }

        /** @var User $user */
        $user = User::query()->find(Auth::id());
        $user->userDocuments()->where('document_type_id', array_keys($uploadedDocuments))->delete();

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

    public function show(\App\Models\Application $application): Factory|View
    {
        if (!isAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $application->load('user');

        return view('pages.applications.show', compact('application'));
    }
}
