<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\JobRoleStoreRequest;
use App\Models\Company;
use App\Models\JobRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    public function index(): Factory|View|Application
    {
        $companies = Company::query()->withCount('users')->paginate(15);
        return view('pages.companies.index', compact('companies'));
    }

    public function create(): Factory|View|Application
    {
        $isEdit = false;
        $route = route('companies.store');
        return view('pages.companies.manage', compact('isEdit', 'route'));
    }

    /**
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CompanyStoreRequest $request): RedirectResponse
    {
        $company = new Company();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->phone_no = $request->input('phone_no');
        $company->notification_type = $request->input('notification_type');
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company Successfully Created');
    }

    public function edit(Company $company): Factory|View|Application
    {
        $isEdit = true;
        $route = route('companies.update', $company->id);

        return view('pages.companies.manage', compact('isEdit', 'route', 'company'));
    }

    /**
     * @param Company $company
     * @param CompanyStoreRequest $request
     * @return RedirectResponse
     */
    public function update(Company $company, CompanyStoreRequest $request): RedirectResponse
    {
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->phone_no = $request->input('phone_no');
        $company->notification_type = $request->input('notification_type');
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company Successfully Updated');
    }

    public function destroy(Company $company): RedirectResponse
    {
        if (!isAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company Successfully Deleted');
    }
}
