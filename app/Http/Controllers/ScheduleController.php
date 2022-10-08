<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('pages.schedules.index');
    }

    public function show(Company $company): JsonResponse
    {
        isAllowedForCompanyOrAbort($company->id);

        $shifts = DB::table('shifts')
            ->select('shifts.id', 'date_time', 'type', 'job_roles.definition as job_role', 'text')
            ->join('job_roles', 'job_role_id', '=', 'job_roles.id')
            ->where('company_id', $company->id)
            ->where('assigned_user_id', '=', Auth::id())
            ->whereRaw('date(date_time) >= date(?)', [now()])
            ->orderByDesc('date_time')
            ->paginate(15);

        return response()->json($shifts);
    }
}
