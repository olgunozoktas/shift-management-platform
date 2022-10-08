<?php

use App\Models\Application;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('getCurrentUser')) {
    function getCurrentUser(): ?Authenticatable
    {
        return Auth::user();
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        /** @var User $user */
        if ($user = getCurrentUser()) {
            return $user->role == 'admin';
        }

        return false;
    }
}

if (!function_exists('getCurrentRouteName')) {
    function getCurrentRouteName(): ?string
    {
        return Route::currentRouteName();
    }
}

if (!function_exists('getDataFromSession')) {
    function getDataFromSession($key): ?string
    {
        return Session::remove($key);
    }
}

if (!function_exists('isCompanyAdmin')) {
    function isCompanyAdmin(): bool
    {
        $hasCompany = CompanyUser::where('user_id', Auth::id())->first();

        if ($hasCompany) {
            return $hasCompany->company_role == 'admin';
        }

        return false;
    }
}

if (!function_exists('getCompany')) {
    function getCompany(): ?int
    {
        $companyUser = CompanyUser::where('user_id', Auth::id())->first();

        if ($companyUser) {
            return $companyUser->company_id;
        }

        return null;
    }
}

if (!function_exists('hasApplication')) {
    function hasApplication(): bool
    {
        $hasActiveApplication = Application::query()->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])->count();

        return $hasActiveApplication > 0;
    }
}

if (!function_exists('getMyCompanyIds')) {
    function getMyCompanyIds(): array
    {
        return CompanyUser::query()->where('user_id', Auth::id())->pluck('company_id')->toArray();
    }
}

if (!function_exists('getMyCompanies')) {
    function getMyCompanies(): Collection|array
    {
        return Company::query()
            ->select('name', 'companies.id', 'company_role')
            ->join('company_users', 'companies.id', '=', 'company_id')
            ->where('company_users.user_id', Auth::id())->get();;
    }
}

if (!function_exists('isApplicationApproved')) {
    function isApplicationApproved(): bool
    {
        return Application::query()->where('user_id', Auth::id())
                ->where('status', 'approved')->first() != null;
    }
}

if (!function_exists('isAllowedForCompanyOrAbort')) {
    function isAllowedForCompanyOrAbort($companyId): bool
    {
        if (!in_array($companyId, getMyCompanyIds())) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return true;
    }
}

if (!function_exists('sendRawMail')) {
    function sendRawMail($emails, $subject, $message): void
    {
        Mail::raw($message, function ($mail) use ($emails, $subject) {
            $mail->to($emails);
            $mail->subject($subject);
        });
    }
}
