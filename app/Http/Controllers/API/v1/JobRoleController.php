<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\JobRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobRoleController extends Controller
{
    public function index(): JsonResponse
    {
        $jobRoles = JobRole::query()->get();
        return response()->json($jobRoles);
    }
}
