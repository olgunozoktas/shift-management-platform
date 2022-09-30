<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\JobRole;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): Factory|View|Application
    {
        $users = User::with(['company', 'companyUser', 'jobRole'])
            ->where('id', '<>', Auth::id())
            ->whereNotIn('status', ['pending', 'rejected'])
            ->paginate(15);
        return view('pages.users.index', compact('users'));
    }

    public function create(): Factory|View|Application
    {
        $isEdit = false;
        $route = route('users.store');
        $roles = JobRole::all();
        $companies = Company::all();
        return view('pages.users.manage', compact('isEdit', 'route', 'roles', 'companies'));
    }

    /**
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');
//            $user->status = $request->input('status');
            $user->status = User::APPROVED;
            $user->phone_no = $request->input('phone_no');
            $user->job_role_id = $request->input('job_role');
            $user->save();

            $companyUser = new CompanyUser();
            $companyUser->user_id = $user->id;
            $companyUser->company_id = $request->input('company');
            $companyUser->company_role = $request->input('company_role');
            $companyUser->save();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Account Successfully Created');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info("User Create Error: ", [$exception->getMessage(), $exception->getLine()]);
        }

        return redirect()->back()->with('error', 'An Error Occurred While Creating A User Account');
    }

    public function edit(User $user): Factory|View|Application
    {
        $isEdit = true;
        $route = route('users.update', $user->id);

        /** @var User $user */
        $userCompanies = $user->companies()->pluck('company_id')->toArray();
        $roles = JobRole::all();
        $companies = Company::all();
        $userCompany = CompanyUser::query()->where('user_id', $user->id)->first();
        return view('pages.users.manage', compact('isEdit', 'route', 'user', 'userCompanies', 'roles', 'companies', 'userCompany'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $checkUser = User::where('email', $request->input('email'))->where('id', '<>', $user->id)->first();

        if ($checkUser) {
            return redirect()->back()->with('email', 'Email is already assigned to another user');
        }

        DB::beginTransaction();
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            if ($request->input('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->role = $request->input('role');
//            $user->status = $request->input('status');
            $user->phone_no = $request->input('phone_no');
            $user->job_role_id = $request->input('job_role');

            /** @var CompanyUser $companyUser */
            $companyUser = CompanyUser::query()->firstOrNew([
                'user_id' => $user->id,
                'company_id' => $request->input('company')
            ]);

            $companyUser->company_role = $request->input('company_role');
            $companyUser->save();

            DB::commit();
            $user->save();
            return redirect()->route('users.index')->with('success', 'User Account Successfully Updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info("User Create Error: ", [$exception->getMessage(), $exception->getLine()]);
        }

        return redirect()->back()->with('error', 'An Error Occurred While Updating User Account');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (!isAdmin()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        $user->email = 'deleted_' . uniqid() . '@gmail.com';
        $user->save();
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Account Successfully Deleted');
    }
}
