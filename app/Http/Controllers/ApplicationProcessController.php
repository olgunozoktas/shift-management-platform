<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApplicationProcessController extends Controller
{
    /**
     * @param Application $application
     * @return RedirectResponse
     */
    public function approve(Application $application): RedirectResponse
    {
        $application->approve();
        Session::put('success', 'Application Successfully Approved');
        return redirect()->back();
    }

    /**
     * @param Application $application
     * @param Request $request
     * @return RedirectResponse
     */
    public function reject(Application $application, Request $request): RedirectResponse
    {
        $application->reject($request->input('reason'));
        Session::put('success', 'Application Successfully Rejected');
        return redirect()->back();
    }
}
