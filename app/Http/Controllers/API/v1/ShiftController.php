<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Shift;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function calendar(Request $request): JsonResponse
    {
        $shifts = Shift::query()
            ->whereBetween('date_time', [$request->input('start'), $request->input('end')])
            ->where('company_id', $request->input('company_id'))->get();

        $shifts = $shifts->map(function ($shift) {
            $obj = new \StdClass;
            $obj->title = $shift->text . ' (Available)';
            $obj->start = $shift->date_time;
            $obj->color = $shift->assigned_user_id == null ? 'green' : 'red';
            $obj->backgroundColor = 'red';
            $obj->borderColor = 'red';
            return $obj;
        });

        return response()->json($shifts);
    }

    public function list(Company $company): JsonResponse
    {
        $shifts = Shift::query()->with(['jobRole', 'assignedUser'])->where('company_id', $company->id)->paginate(15);

        return response()->json($shifts);
    }
}
