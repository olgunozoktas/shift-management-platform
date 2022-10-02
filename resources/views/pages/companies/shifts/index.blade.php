@extends('layouts.app')

@section('content')

    @if($success = getDataFromSession('success'))
        <section>
            <div class="py-2 px-4 bg-green-600 text-white font-bold rounded-lg mb-4">{{ $success }}</div>
        </section>
    @elseif($error = getDataFromSession('error'))
        <section>
            <div class="py-2 px-4 bg-red-600 text-white font-bold rounded-lg mb-4">{{ $error }}</div>
        </section>
    @endif

    <section class="flex flex-col gap-2">
        <header class="flex flex-row items-center justify-between border-b border-gray-200 pb-4">
            <h1 class="text-black font-black text-lg">Company Shifts</h1>
            <a href="{{ route('shifts.create') }}"
               class="border-2 border-gray-600 bg-gray-800 hover:bg-gray-900 text-white font-black py-2 px-4 rounded-full">
                Create New Shift
            </a>
        </header>

        <div id="shifts"></div>
{{--                <section class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">--}}
{{--                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="table">--}}
{{--                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">--}}
{{--                        <tr class="text-center bg-gray-100">--}}
{{--                            <th scope="col" class="px-6 py-3">Date & Time</th>--}}
{{--                            <th scope="col" class="px-6 py-3">Type</th>--}}
{{--                            <th scope="col" class="px-6 py-3">Job Role</th>--}}
{{--                            <th scope="col" class="px-6 py-3">Assigned User</th>--}}
{{--                            <th scope="col" class="px-6 py-3">Actions</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if(count($shifts) > 0)--}}
{{--                            @foreach($shifts as $shift)--}}
{{--                                <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">--}}
{{--                                    <th scope="row" class="w-1/4 px-6 py-4 font-medium text-gray-900 dark:text-white">--}}
{{--                                        {{ $shift->date_time }}--}}
{{--                                    </th>--}}
{{--                                    <td class="py-2">{{ ucfirst($shift->type) }}</td>--}}
{{--                                    <td class="py-2">{{ $shift->jobRole->definition ?? '-' }}</td>--}}
{{--                                    <td class="py-2">{{ $shift->assignedUser?->name ?? '-' }}</td>--}}
{{--                                    <td class="flex flex-row items-center justify-center gap-2 py-2">--}}
{{--                                        <a href="{{ route('shifts.edit', $shift->id) }}"--}}
{{--                                           class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg">Edit</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr class="text-center">--}}
{{--                                <td colspan="5" class="py-4">No Shifts For Your Company</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </section>--}}
    </section>
@endsection

@push('js')
    @if(config('app.env') == 'production')
        @php
            $manifest = json_decode(file_get_contents(asset('build/manifest.json')), true);
        @endphp
        <script type="module" src="{{ asset("build/{$manifest['resources/js/shifts.jsx']['file']}") }}"></script>
    @else
        @vitereactrefresh
        @vite('resources/js/shifts')
    @endif
@endpush
