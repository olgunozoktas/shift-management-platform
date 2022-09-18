<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRoleStoreRequest;
use App\Models\Company;
use App\Models\JobRole;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class JobRoleController extends Controller
{
    public function index(): Factory|View|Application
    {
        $jobRoles = JobRole::query()->withCount('users')->paginate(15);
        return view('pages.job-roles.index', compact('jobRoles'));
    }

    public function create(): Factory|View|Application
    {
        $isEdit = false;
        $route = route('job-roles.store');
        return view('pages.job-roles.manage', compact('isEdit', 'route'));
    }

    /**
     * @param JobRoleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobRoleStoreRequest $request): RedirectResponse
    {
        $jobRole = new JobRole();
        $jobRole->definition = $request->input('definition');
        $jobRole->save();

        return redirect()->route('job-roles.index')->with('success', 'Job Role Successfully Created');
    }

    public function edit(JobRole $jobRole): Factory|View|Application
    {
        $isEdit = true;
        $route = route('job-roles.update', $jobRole->id);

        return view('pages.job-roles.manage', compact('isEdit', 'route', 'jobRole'));
    }

    /**
     * @param JobRole $jobRole
     * @param JobRoleStoreRequest $request
     * @return RedirectResponse
     */
    public function update(JobRole $jobRole, JobRoleStoreRequest $request): RedirectResponse
    {
        $jobRole->definition = $request->input('definition');
        $jobRole->save();

        return redirect()->route('job-roles.index')->with('success', 'Job Role Successfully Updated');
    }

    public function destroy(JobRole $jobRole): RedirectResponse
    {
        if (!isAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $jobRole->delete();
        return redirect()->route('job-roles.index')->with('success', 'Job Role Successfully Deleted');
    }
}
