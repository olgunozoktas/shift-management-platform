<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Shift;
use App\Models\ShiftRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ShiftRequestController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('pages.companies.shift-requests.index');
    }

    public function show(Company $company): JsonResponse
    {
        isAllowedForCompanyOrAbort($company->id);

        $shifts = Shift::query()->where('company_id', $company->id)
            ->whereNull('assigned_user_id')->pluck('id')->toArray();

        $shiftRequests = ShiftRequest::query()
            ->with(['user','shift.jobRole'])
            ->whereIn('shift_id', $shifts)->paginate(15);

        return response()->json($shiftRequests);
    }

    public function details(ShiftRequest $shiftRequest): Factory|View|Application
    {
        $shiftRequest->load(['user.userDocuments.documentType','shift.jobRole']);

        isAllowedForCompanyOrAbort($shiftRequest->shift->company_id);

        return view('pages.companies.shift-requests.details', compact('shiftRequest'));
    }

    public function process(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $shiftRequest = ShiftRequest::query()->with('shift')->find($request->input('application_id'));
            $shiftRequest->status = $request->input('status');
            $shiftRequest->save();

            if($shiftRequest->status == 'approved') {
                $shiftRequest->shift->assigned_user_id = $shiftRequest->user_id;
                $shiftRequest->save();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::alert('An error occurred while processing shift request', [$exception->getMessage(), $exception->getLine()]);

            Session::put('error', 'An Error Occurred While Processing Shift Request');
            return redirect()->back();
        }

        Session::put('success', 'Shift Request Successfully ' . ucfirst($request->input('status')));
        return redirect()->route('shift-requests.index');
    }
}
