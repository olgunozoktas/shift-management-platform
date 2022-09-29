<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): View|Factory|RedirectResponse|Application
    {
        if(isAdmin()) {
            return view('dashboard');
        } else if(isCompanyAdmin()) {
            return view('company_dashboard');
        }

        return redirect()->route('applications.create');
    }
}
