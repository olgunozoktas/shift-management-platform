<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRoleStoreRequest;
use App\Http\Requests\ShiftStoreRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\JobRole;
use App\Models\Shift;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShiftController extends Controller
{
    public function index(): Factory|View|Application|JsonResponse
    {
        return view('pages.companies.shifts.index');
    }

    public function create(): Factory|View|Application
    {
        $isEdit = false;
        $route = route('shifts.store');
        $jobRoles = JobRole::all();
        $companies = getMyCompanies();
        return view('pages.companies.shifts.manage', compact('isEdit', 'route', 'jobRoles', 'companies'));
    }

    /**
     * @param ShiftStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ShiftStoreRequest $request): RedirectResponse
    {
        if(!in_array($request->input('company_id'), getMyCompanyIds())) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $shift = new Shift();
        $shift->company_id = $request->input('company_id');
        $shift->date_time = $request->input('date_time');
        $shift->type = $request->input('type');
        $shift->job_role_id = $request->input('job_role_id');
        $shift->text = $request->input('text');
        $shift->save();

        return redirect()->route('shifts.index')->with('success', 'Shift Successfully Created');
    }

    public function edit(Shift $shift): Factory|View|Application
    {
        $isEdit = true;
        $route = route('shifts.update', $shift->id);
        $jobRoles = JobRole::all();
        $companies = getMyCompanies();
        return view('pages.companies.shifts.manage', compact('isEdit', 'route', 'shift', 'jobRoles','companies'));
    }

    /**
     * @param Shift $shift
     * @param ShiftStoreRequest $request
     * @return RedirectResponse
     */
    public function update(Shift $shift, ShiftStoreRequest $request): RedirectResponse
    {
        $myCompanyIds = getMyCompanyIds();

        if(!in_array($shift->company_id, $myCompanyIds)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        if(!in_array($request->input('company_id'), $myCompanyIds)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $shift->company_id = $request->input('company_id');
        $shift->date_time = $request->input('date_time');
        $shift->type = $request->input('type');
        $shift->job_role_id = $request->input('job_role_id');
        $shift->text = $request->input('text');
        $shift->save();

        return redirect()->route('shifts.index')->with('success', 'Shift Successfully Updated');
    }

    public function destroy(Shift $shift): RedirectResponse
    {
        if (!isCompanyAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'Shift Successfully Deleted');
    }
}
