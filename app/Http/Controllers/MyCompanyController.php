<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MyCompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::query()
            ->select('name', 'companies.id', 'company_role')
            ->join('company_users', 'companies.id', '=', 'company_id')
            ->where('company_users.user_id', Auth::id())->get();
        return response()->json($companies);
    }
}
