@extends('layouts.app')

@section('content')

    <section class="flex flex-col gap-2">
        <header class="flex flex-row items-center justify-between border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">Time Cards for {{ $job->job_title }} / {{ $job->formatted_job_number }}</h1>
            <a href="{{ route('jobs.index') }}"
               class="flex items-center gap-2 text-black font-black py-2 px-4 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back To All Jobs
            </a>
        </header>

        <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-center bg-gray-100">
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Employee Name</th>
                    <th scope="col" class="px-6 py-3">Total Hours Worked</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(count($job->employeeTimeCards) > 0)
                    @foreach($job->employeeTimeCards as $timeCard)
                        <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="w-2/5 px-6 py-4 font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($timeCard->created_at)->format('Y-m-d') }}</th>
                            <td class="py-2">{{ $timeCard->employee->name }}</td>
                            <td class="py-2">{{ $timeCard->total_hours_worked }}</td>
                            <td class="flex flex-row items-center justify-center gap-2 py-2">
                                <a href="{{ route('employee.time-card.show', $timeCard->id) }}" target="_blank"
                                   class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Download</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="4" class="py-4">No Time Cards Found For This Job In System</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </section>
    </section>
@endsection
