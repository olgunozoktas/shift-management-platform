<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View|Factory|RedirectResponse|Application
    {
        if (isAdmin()) {
            return view('dashboard');
        } else if (isCompanyAdmin()) {
            return view('company_dashboard');
        }

        $application = \App\Models\Application::query()
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->first();

        if (!$application) {
            return redirect()->route('applications.create');
        }

        $company = Company::query()->find(getCompany());
        $jobRole = JobRole::query()->find(getCurrentUser()->job_role_id);
        return view('contract_staff_dashboard', compact('application', 'company', 'jobRole'));
    }
}
