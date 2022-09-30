<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUserUpdateRequest;
use App\Models\CompanyUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyUserController extends Controller
{
    public function index(): Factory|View|Application
    {
        $users = DB::table('company_users')
            ->select('company_users.id', 'name', 'email', 'company_phone_no', 'company_role', 'definition as role')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('job_roles', 'users.job_role_id', '=', 'job_roles.id')
            ->where('company_id', getCurrentUser()->company->id)
            ->where('user_id', '<>', Auth::id())
            ->paginate(15);

        return view('pages.companies.users.index', compact('users'));
    }

    public function edit(CompanyUser $companyUser): Factory|View|Application
    {
        return view('pages.companies.users.manage', compact('companyUser'));
    }

    /**
     * @param CompanyUserUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(CompanyUser $companyUser, CompanyUserUpdateRequest $request): RedirectResponse
    {
        $companyUser->company_phone_no = $request->input('phone_no');
        $companyUser->save();

        return redirect()->route('company-users.index')->with('success', 'Company User Successfully Updated');
    }
}
