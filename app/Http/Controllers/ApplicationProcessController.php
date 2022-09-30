<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;

class ApplicationProcessController extends Controller
{
    /**
     * @param Application $application
     * @return JsonResponse
     */
    public function show(Application $application): JsonResponse
    {
        $application->load('user.userDocuments.documentType');
        return response()->json($application);
    }


    public function approve(Application $application, Request $request): JsonResponse
    {
        $application->load('user.userDocuments');
        $user = $application->user;

        DB::beginTransaction();
        try {
            $application->status = Application::APPROVED;
            $application->updated_by_id = Auth::id();
            $application->save();

            $user->status = User::APPROVED;
            $user->job_role_id = $request->input('selected_job_role_id');
            $user->phone_no = $request->input('phone_no');
            $user->save();

            $companyUser = new CompanyUser();
            $companyUser->company_id = $request->input('selected_company_id');
            $companyUser->user_id = $user->id;
            $companyUser->company_role = CompanyUser::CONTRACT_STAFF;
            $companyUser->company_phone_no = $request->input('company_phone_no');
            $companyUser->save();

            foreach ($user->userDocuments as $userDocument) {
                /** @var UserDocument $userDocument */
                $userDocument->status = UserDocument::APPROVED;
                $userDocument->save();
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while approving application'
            ]);
        }

        Session::put('success', 'Application successfully approved');
        return response()->json([
            'status' => 'success',
            'message' => 'Application successfully approved'
        ]);
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return JsonResponse
     */
    public function reject(Application $application, Request $request): JsonResponse
    {
        $application->load('user.userDocuments');
        $user = $application->user;

        $rejectedDocuments = collect($request->input('rejected_documents'))->pluck('id')->toArray();

        DB::beginTransaction();
        try {
            $application->status = Application::REJECTED;
            $application->updated_by_id = Auth::id();
            $application->notes = $request->input('reject_reason');
            $application->save();

            foreach ($user->userDocuments as $userDocument) {
                /** @var UserDocument $userDocument */
                $userDocument->status = in_array($userDocument->id, $rejectedDocuments) ? UserDocument::REJECTED : UserDocument::APPROVED;
                $userDocument->save();
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while rejecting application'
            ]);
        }

        Session::put('success', 'Application successfully rejected');
        return response()->json([
            'status' => 'success',
            'message' => 'Application successfully rejected'
        ]);
    }
}
