<?php

use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
