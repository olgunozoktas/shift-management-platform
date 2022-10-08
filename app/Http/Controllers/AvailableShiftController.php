<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Shift;
use App\Models\ShiftRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class AvailableShiftController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('pages.shifts.index');
    }

    public function show(Company $company): JsonResponse
    {
        isAllowedForCompanyOrAbort($company->id);

        /** @var User $user */
        $user = Auth::user();
        $previouslyRequestedShifts = $user->shiftRequests()
            ->where('status', 'pending')
            ->pluck('shift_id')->toArray();

        $shifts = DB::table('shifts')
            ->select('shifts.id', 'date_time', 'type', 'job_roles.definition as job_role', 'text')
            ->join('job_roles', 'job_role_id', '=', 'job_roles.id')
            ->where('company_id', $company->id)
            ->where('job_role_id', Auth::user()->job_role_id)
            ->where('date_time', '>=', now())
            ->whereNull('assigned_user_id')
            ->whereNotIn('shifts.id', $previouslyRequestedShifts)
            ->orderBy('date_time')
            ->paginate(15);

        return response()->json($shifts);
    }

    public function apply(Shift $shift): JsonResponse
    {
        $shift->load('company');
        isAllowedForCompanyOrAbort($shift->company_id);

        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = Auth::user();
            $pendingShiftRequests = $user->shiftRequests()
                ->where('status', 'pending')
                ->pluck('shift_id')->toArray();

            if (in_array($shift->id, $pendingShiftRequests)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your request for this shift is already pending for approval'
                ]);
            }

            $shiftRequest = new ShiftRequest();
            $shiftRequest->user_id = Auth::id();
            $shiftRequest->shift_id = $shift->id;
            $shiftRequest->save();

            if(in_array($shift->company->notification_type, ['email','both'])) {
                try {
                    Mail::send(new \App\Mail\ShiftRequest($shift, $user->name));
                } catch (\Exception $exception) {
                    Log::alert("Shift Request Send Email Error: ", [$exception->getMessage(), $exception->getLine()]);
                }
            }

            if(in_array($shift->company->notification_type, ['text_message','both'])) {
                try {
                    $date = Carbon::parse($shift->date_time)->format('Y-m-d');
                    $time = Carbon::parse($shift->date_time)->format('H:i A');

                    $message = "$user->name requested to pick up your shift which scheduled on date $date and at $time.";
                    $account_sid = getenv("TWILIO_SID");
                    $auth_token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio_number = getenv("TWILIO_NUMBER");
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create($shift->company->phone_no,
                        ['from' => $twilio_number, 'body' => $message]
                    );
                } catch (\Exception $exception) {
                    Log::alert("Shift Request Send SMS Error: ", [$exception->getMessage(), $exception->getLine()]);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            Log::alert("Shift Request Error: ", [$exception->getMessage(), $exception->getLine()]);
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while applying to shift'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your application for shift send for approval'
        ]);
    }
}
