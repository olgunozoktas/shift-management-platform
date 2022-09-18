<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRoleStoreRequest;
use App\Http\Requests\ShiftStoreRequest;
use App\Models\CompanyUser;
use App\Models\JobRole;
use App\Models\Shift;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShiftController extends Controller
{
    public function index(): Factory|View|Application|JsonResponse
    {
        $shifts = Shift::query()->where('company_id', getCompany())->paginate(15);
        return view('pages.companies.shifts.index', compact('shifts'));
    }

    public function create(): Factory|View|Application
    {
        $isEdit = false;
        $route = route('shifts.store');
        $jobRoles = JobRole::all();
        return view('pages.companies.shifts.manage', compact('isEdit', 'route', 'jobRoles'));
    }

    /**
     * @param ShiftStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ShiftStoreRequest $request): RedirectResponse
    {
        $shift = new Shift();
        $shift->company_id = getCompany();
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

        return view('pages.companies.shifts.manage', compact('isEdit', 'route', 'shift', 'jobRoles'));
    }

    /**
     * @param Shift $shift
     * @param ShiftStoreRequest $request
     * @return RedirectResponse
     */
    public function update(Shift $shift, ShiftStoreRequest $request): RedirectResponse
    {
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

    public function list(Request $request): JsonResponse
    {
        $shifts = Shift::query()
            ->whereBetween('date_time', [$request->input('start'), $request->input('end')])
            ->where('company_id', getCompany())->get();

        $shifts = $shifts->map(function($shift) {
            $obj = new \StdClass;
            $obj->title = $shift->text;
            $obj->start = $shift->date_time;
            $obj->color = $shift->assigned_user_id == null ? 'green' : 'red';
            $obj->backgroundColor = 'red';
            $obj->borderColor = 'red';
            return $obj;
        });

        return response()->json($shifts);
    }
}
